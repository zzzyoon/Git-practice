<?php
//@header('Content-Type: application/json');
include_once('./_common.php');
//ini_set("display_errors", 1);


/***
 *   출고검수 - GT > 검수하기
 */

if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}


$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
//$_REQUEST = array_map_deep('filteringSpcChr', $_REQUEST);


$orderNum = $_REQUEST['order_num'];
$sublDate = $_REQUEST['subl_date'];
$besongSeq = substr($_REQUEST['besong_seq'],0,1);
$empId = $member['mb_id'];
$jgGb = $_REQUEST['jgwms_gb'];
$pResult = 0; //result > out parameter

//ajaxExitJson($orderNum);
if(!$sublDate || !$orderNum || !$empId){
    echo "-9";
    exit;
}
// 해당 프로시져 내부에 복수 DML
$isTransaction=true;

    // 도서 검수데이터 업뎃 ////////////////////////////////////////////////////////////////////////////
if (substr($jgGb,0,1) == "5") {
    // BKSUBL table 데이터 입력
    $sql = "begin CAPO.CAPOPDA_CAPO1.SP_SVRELINFO_CAPO(
                :p_order_num,:p_subl_date,:p_besong_seq,
                :p_emp_no); end;";
}else {
    $sql = "begin UCAPO.UCAPOPDA_UCAPO1.SP_SVRELINFO_UCAPO(
                :p_order_num,:p_subl_date,:p_besong_seq,
                :p_emp_no); end;";
}

    $stmt = sql_query_parse($sql);

    oci_bind_by_name($stmt, ':p_order_num', $orderNum);
    oci_bind_by_name($stmt, ':p_subl_date', $sublDate);
    oci_bind_by_name($stmt, ':p_besong_seq', $besongSeq);
    oci_bind_by_name($stmt, ':p_emp_no', $empId) ;
//    oci_bind_by_name($stmt, ':p_err_result',$pResult) ;

    $res = sql_query_execute($stmt,G5_DISPLAY_SQL_ERROR,$isTransaction);

if(!$res){
    sql_rollback();
    $pResult=-99;
} else {
    sql_commit();
}


echo $pResult;
