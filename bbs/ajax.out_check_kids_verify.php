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
$_REQUEST = array_map_deep('filteringSpcChr', $_REQUEST);


$sublDate = $_REQUEST['subl_date'];
$sublNo = $_REQUEST['subl_no'];
$taxNo = "0443";//그레이트 북스
$jgGb = "A";
$empId = $member['mb_id'];
$pResult = 0; //result > out parameter




if(!$sublDate || !$sublNo){
    echo "-9";
    exit;
}

// 해당 프로시져 내부에 복수 DML
$isTransaction=true;

    // 도서 검수데이터 업뎃 ////////////////////////////////////////////////////////////////////////////

    // BKSUBL table 데이터 입력
    $sql = "begin PKGMHPDA.PROC_OUTCONFIRM_KIDS(
                :p_subl_date,:p_tax_no, :p_subl_no,
                :p_jg_gb,:p_emp_no,:p_err_result
                ); end;";

    $stmt = sql_query_parse($sql);

    oci_bind_by_name($stmt, ':p_subl_date', $sublDate,8);
    oci_bind_by_name($stmt, ':p_tax_no', $taxNo,4);

    oci_bind_by_name($stmt, ':p_subl_no', $sublNo,22);
    oci_bind_by_name($stmt, ':p_jg_gb', $jgGb,2);
    oci_bind_by_name($stmt, ':p_emp_no', $empId,5) ;
    oci_bind_by_name($stmt, ':p_err_result',$pResult,2) ;

    $res = sql_query_execute($stmt,G5_DISPLAY_SQL_ERROR,$isTransaction);

if(!$res){
    sql_rollback();
    $pResult=-99;
} else {
    sql_commit();
}


echo $pResult;
