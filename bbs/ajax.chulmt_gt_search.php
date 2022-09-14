<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$invNo = filteringSpcChr($_REQUEST['inv_no']);
$jgGb = $_REQUEST['jgGb'];

// 해당 프로시져 내부에 복수 DML
$isTransaction=true;


if(empty($invNo)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

if(strlen($invNo) != 12 && strlen($invNo) != 4){
    ajaxExitJson("송장번호를 바르게 입력하세요.");
}

if (substr($jgGb,0,1) == "5") {
    $sql = "begin CAPO.CAPOPDA_CAPO1.SP_ISINDVOUT_CAPO(:p_inv_no,:p_err_result); end;";
}else {
    $sql = "begin UCAPO.UCAPOPDA_UCAPO1.SP_ISINDVOUT_UCAPO(:p_inv_no,:p_err_result); end;";
}

$stmt = sql_query_parse($sql);

oci_bind_by_name($stmt, ':p_inv_no', $invNo,8);
oci_bind_by_name($stmt, ':p_err_result',$pResult,2) ;

$res = sql_query_execute($stmt,G5_DISPLAY_SQL_ERROR,$isTransaction);

//ajaxExitJson($pResult);

//if($pResult == "2"){
//    ajaxExitJson("* 개별송장 : 삭제된 송장입니다.");
//} else if ($pResult == "3"){
//    ajaxExitJson("* 개별송장 : 이미 출고된 송장입니다.");
//}

echo json_encode($pResult);

//$sql = "begin CAPOPDA_CAPO1.SP_SRCHRELINF_CAPO(:p_inv_no,:cur_bk); end;";
//
//
//
//if(strlen($invNo) == 12){ //송장번호  ++++++++++++++++++++++++++++++++++++
//    $sql.="  and B.INV_NO = '{$invNo}' ";
//} else { // 수불번호 4자리 +++++++++++++++++++++++++++
//    $sql.="  and A.SUBL_NO = '{$invNo}' ";
//}
//
//$data = sql_fetch($sql);
//
//echo json_encode($data);


/**
0: "20210125",
1: "387151023353",
2: "2021012502451293",
3: "1293",
4: "13300021",
5: "도레미곰 2판 1-box",
6: "1",
7: "41",
8: "3",
9: "3",
subl_date: "20210125",
inv_no: "387151023353",
slipno: "2021012502451293",
subl_no: "1293",
bk_cd: "13300021",
bk_nm: "도레미곰 2판 1-box",
ju_qty: "1",
besong_gb: "41",
bita: "3",
bitb: "3"
 */