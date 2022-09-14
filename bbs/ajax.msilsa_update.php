<?php
//@header('Content-Type: application/json');
include_once('./_common.php');
//ini_set("display_errors", 1);


if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}


$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
//$_REQUEST = array_map_deep('filteringSpcChr', $_REQUEST);


$slipNo = $_REQUEST['slip_no'];
$jgGb = $_REQUEST['jgwms_gb'];

$pResult = 1; //result > out parameter
//ajaxExitJson($orderNum);
if(!$slipNo){
    ajaxExitJson("*필수정보가 누락되었습니다. ");
}

// 해당 프로시져 내부에 복수 DML
$isTransaction=true;

    // 도서 검수데이터 업뎃 ////////////////////////////////////////////////////////////////////////////

    // BKSUBL table 데이터 입력
if(substr($jgGb,0,1) == "5") {
    $sql = "begin CAPO.CAPOPDA_CAPO1.SP_SVINVMST_CAPO(:p_slip_no); end;";
} else {
    $sql = "begin UCAPO.UCAPOPDA_UCAPO1.SP_SVINVMST_UCAPO(:p_slip_no); end;";
}

    $stmt = sql_query_parse($sql);

    oci_bind_by_name($stmt, ':p_slip_no', $slipNo);
//    oci_bind_by_name($stmt, ':p_err_result',$pResult) ;

    $res = sql_query_execute($stmt,G5_DISPLAY_SQL_ERROR,$isTransaction);

if(!$res){
    sql_rollback();
    $pResult=-99;
} else {
    sql_commit();
}


echo $pResult;
