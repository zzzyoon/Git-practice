<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/***
 *  서가 적치 > 팔레트 번호 - 도서검색
 *
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$pltNo = clean_xss_tags(get_text($_REQUEST['plt_no']));
$jgGb = clean_xss_tags(get_text($_REQUEST['jg_gb']));


//$bookCd = "15002";
//$taxNo = "0037";


if(empty($pltNo) || empty($jgGb)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

/**
 * from plttin a inner join bksbjg b
on a.bk_cd = b.bk_cd and a.tax_no = b.tax_no and b.loc_cd = 'P00000' and b.jg_gb = a.JG_GB
where plt_cd = P_PLT_CD AND A.JG_GB = P_JG_GB
 */

$sql = "begin PKGMHPDA.PROC_SCGPLTBOOK(:p_plt_cd,:p_jg_gb,:cur_bk); end; ";
$stmt = sql_query_parse($sql);

oci_bind_by_name($stmt, ':p_plt_cd', $pltNo) ;
oci_bind_by_name($stmt, ':p_jg_gb', $jgGb) ;


//oci_bind_by_name($result, ':cur_bk', $output) ;
//But BEFORE statement, Create your cursor
$cursor = oci_new_cursor($g5['connect_db']);
// On your code add the latest parameter to bind the cursor resource to the Oracle argument
oci_bind_by_name($stmt,":cur_bk", $cursor,-1,OCI_B_CURSOR);

// Execute the statement as in your first try
sql_query_execute($stmt);

sql_query_execute($cursor);


$list = array();
$i=0;
while ($row = oci_fetch_array($cursor, OCI_RETURN_LOBS )) {
    $row = array_map_deep('iconv_utf8', $row);
    $row = array_change_key_case($row,CASE_LOWER);

    $list[$i] = $row;

    //$hidData = json_encode($row);
} //end while ___-------------------------

echo json_encode($list);
