<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "선택 재고이동 " 에서 호출
 *   : loc_cd,jg_gb 기준으로 재고 추출
 */


$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$locCd = clean_xss_tags(get_text($_REQUEST['loc_cd']));
$jgGb = clean_xss_tags(get_text($_REQUEST['jg_gb']));


// for debugging ______________________________________
//$locCd = "B13007";
//$jgGb = "A";


if(empty($locCd) || empty($jgGb)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}


//유효한 로케이션 체크
$res = existLocCheck($locCd);
if(!$res){
    ajaxExitJson("존재하지 않는 로케이션입니다.");
}



$sql = "begin PKGMHPDA.PROC_SCHBKBYLOC(:p_loc,:p_jg_gb,:cur_bk); end; ";  //loc_cd is null 조회
$stmt = sql_query_parse($sql);

//oci_bind_by_name($stmt, ':p_bk_cd', '') ;
oci_bind_by_name($stmt, ':p_loc', $locCd) ;
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


$totJgQty = 0;
while ($row = oci_fetch_array($cursor, OCI_RETURN_LOBS )) {
    $row = array_map_deep('iconv_utf8', $row);
    $row = array_change_key_case($row,CASE_LOWER);

    $list[$i] = $row;

    $totJgQty+=$row['jg_qty'];



    $i++;

} //end while ___-------------------------


//마지막 row 합계 추가
if(count($list) > 0){
    $list[$i]['bk_nm'] =  "합계";
    $list[$i]['jg_gb'] =  "";
    $list[$i]['tax_no'] =  "";
    $list[$i]['out_danga'] =  "0";
    $list[$i]['basicloc'] =  "";
    $list[$i]['jg_qty'] = $totJgQty;
}


echo json_encode($list);


/**
[
{
    0: "498800101",
1: "Love Love 분유 이야기",
2: "0370",
3: "(주)알에이치코리아",
4: "10000",
5: "B13007",
6: "450",
7: "A",
8: "A32655",
bk_cd: "498800101",
bk_nm: "Love Love 분유 이야기",
tax_no: "0370",
cust_nm: "(주)알에이치코리아",
out_danga: "10000",
loc_cd: "B13007",
jg_qty: "450",
jg_gb: "A",
basicloc: "A32655"
},
 */