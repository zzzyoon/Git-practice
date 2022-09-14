<?php
@header('Content-Type: application/json');
include_once('./_common.php');
ini_set("display_errors", 1);
if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}


$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$_REQUEST = array_map_deep('clean_xss_tags', $_REQUEST);
$_REQUEST = array_map_deep('get_text', $_REQUEST);

$sublDate = $_REQUEST['subl_date'];
$sublNo = $_REQUEST['subl_no'];
$taxNo = $_REQUEST['tax_no'];


if(!$sublDate || !$sublNo ||  !$taxNo ){
    ajaxExitJson("필수정보가 누락되었습니다.");
}


$pErrResult = "0"; //output param 0 정상처리, -2 미검수 도서존재


    // 도서 검수 일괄 업뎃 ////////////////////////////////////////////////////////////////////////////

     // 프로시져  > 의심???
    $sql = "begin PKGMHPDA.PROC_OUTCONFIRM_SEJONG_ALL(
                :p_subl_date,:p_tax_no,:p_subl_no,:p_emp_no,:p_err_result); end;";

    $stmt = sql_query_parse($sql);

    oci_bind_by_name($stmt, ':p_subl_date', $sublDate,8);
    oci_bind_by_name($stmt, ':p_tax_no', $taxNo,4);
    oci_bind_by_name($stmt, ':p_subl_no', $sublNo,22);
    oci_bind_by_name($stmt, ':p_emp_no', $member['mb_id'],5) ;
    oci_bind_by_name($stmt, ':p_err_result',$pErrResult,2) ;

    $res = sql_query_execute($stmt);

if($res){

    if($pErrResult == -2){
        ajaxExitJson("검수되지 않은 도서가 있습니다. ");
    } else {
        ajaxEchoJson(true,"전체 검수등록이 완료되었습니다. ");
    }

} else {
    ajaxEchoJson(false,"전체 검수 완료등록시 오류가 발생했습니다.");
}





