<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "선택 재고이동 " 에서 호출
 *   : plt_no,jg_gb 기준으로 재고 추출
 */


$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$pltNo = clean_xss_tags(get_text($_REQUEST['plt_no']));
$jgGb = clean_xss_tags(get_text($_REQUEST['jg_gb']));


// for debugging ______________________________________
//$pltNo = "0000000614";
//$jgGb = "A";


if(empty($pltNo)  || empty($jgGb)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}



$res = existPltCode($pltNo);
if(!$res){
    ajaxExitJson("존재하지 않는 파레트 코드입니다. ");
}

$sql = "begin PKGMHPDA.PROC_SCGPLTBOOK(:p_plt_cd,:p_jg_gb,:cur_bk); end; ";  //loc_cd is null 조회
$stmt = sql_query_parse($sql);

//oci_bind_by_name($stmt, ':p_bk_cd', '') ;
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

$totJgQty = 0;

while ($row = oci_fetch_array($cursor, OCI_RETURN_LOBS )) {
    $row = array_map_deep('iconv_utf8', $row);
    $row = array_change_key_case($row,CASE_LOWER);

    $list[$i] = $row;
    $totJgQty+=$row['b_qty'];

    $i++;

} //end while ___-------------------------


//마지막 row 합계 추가
if(count($list) > 0){
    $list[$i]['bk_nm'] =  "합계";
    $list[$i]['jg_gb'] =  "";
    $list[$i]['tax_no'] =  "";
    $list[$i]['out_danga'] =  "0";
    $list[$i]['basicloc'] =  "";
    $list[$i]['b_qty'] = $totJgQty;
}



echo json_encode($list);


/**
{
0: "410500201",
1: "어린이 시사마당 2권 정보와 인터넷편",
2: "0004",
3: "랜덤하우스코리아",
4: "532",
5: "9500",
6: "0000000614",
7: "A",
8: "1",
9: "0",
bk_cd: "410500201",
bk_nm: "어린이 시사마당 2권 정보와 인터넷편",
tax_no: "0004",
cust_nm: "랜덤하우스코리아",
b_qty: "532",
out_danga: "9500",
plt_cd: "0000000614",
jg_gb: "A",
subl_no: "1",
chul_qty: "0"
}
 */