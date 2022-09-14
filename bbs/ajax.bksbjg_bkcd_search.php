<?php
@header('Content-Type: application/json');
ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "선택 재고이동 " 에서 호출
 *   : bkcd, tax_no,jg_gb 기준으로 재고 추출
 */


$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$goodCd = clean_xss_tags(get_text($_REQUEST['good_cd']));
$sizeGb = clean_xss_tags(get_text($_REQUEST['size_gb']));
$locCd = clean_xss_tags(get_text($_REQUEST['loc_cd']));
$jgGb = clean_xss_tags(get_text($_REQUEST['jg_gb']));

// for debugging ______________________________________
//$bookCd = "15002";
//$taxNo = "0037";
//$jgGb = "A";


if(empty($goodCd) || empty($sizeGb) || empty($locCd) || empty($jgGb)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}
//if(empty($locCd)) {
//    $sql = "begin PKGMHPDA.SCHBKBYBCD(null,:p_bk_cd,:p_tax_no,:p_jg_gb,:cur_bk); end; ";  //loc_cd is null 조회
//} else {
//    $sql = "begin PKGMHPDA.SCHBKBYBCD(:p_loc_cd,:p_bk_cd,:p_tax_no,:p_jg_gb,:cur_bk); end; ";
//}
if (substr($jgGb,0,1) == "5") {
    $sql = "begin CAPO.CAPOPDA_CAPO1.SP_SRCHJG_SELECT_CAPO(:p_good_cd,:p_size_gb,:p_loc_cd,:p_jg_gb,:cur_jglst); end; ";
}else {
    $sql = "begin UCAPO.UCAPOPDA_UCAPO1.SP_SRCHJG_SELECT_UCAPO(:p_good_cd,:p_size_gb,:p_loc_cd,:p_jg_gb,:cur_jglst); end; ";
}
$stmt = sql_query_parse($sql);

oci_bind_by_name($stmt, ':p_good_cd', $goodCd);
oci_bind_by_name($stmt, ':p_size_gb', $sizeGb);
oci_bind_by_name($stmt, ':p_loc_cd', $locCd);
oci_bind_by_name($stmt, ':p_jg_gb', $jgGb);

//But BEFORE statement, Create your cursor
$cursor = oci_new_cursor($g5['connect_db']);
// On your code add the latest parameter to bind the cursor resource to the Oracle argument
oci_bind_by_name($stmt,":cur_jglst", $cursor,-1,OCI_B_CURSOR);

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
    //$hidData = json_encode($row);
} //end while ___-------------------------


////마지막 row 합계 추가
//if(count($list) > 0){
//    $list[$i]['bk_nm'] =  "합계";
//    $list[$i]['jg_gb'] =  "";
//    $list[$i]['tax_no'] =  "";
//    $list[$i]['out_danga'] =  "0";
//    $list[$i]['basicloc'] =  "";
//    $list[$i]['jg_qty'] = $totJgQty;
//}




echo json_encode($list);

/***
 * 0: "15002",
1: "탈출기",
2: "0037",
3: "문학과지성사",
4: "11000",
5: "A33422",
6: "28",
7: "A",
8: "A33422",  //cur_loc_cd -> basicloc 기본서가
bk_cd: "15002",
bk_nm: "탈출기",
tax_no: "0037",
cust_nm: "문학과지성사",
out_danga: "11000",
loc_cd: "A33422",
jg_qty: "28",
jg_gb: "A",
basicloc: "A33422"
 */