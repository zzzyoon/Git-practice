<?php
//@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "출고조회 - gt >  송장번호 체크"
 *
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$invoice = filteringSpcChr($_REQUEST['invc_no']);
$sublDate = filteringSpcChr($_REQUEST['subl_date']);


if(empty($sublDate) || empty($invoice)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}


$sql = "         select count(*) cnt from BKV_INVOICE
                 where req_dv_cd = '01'
          ";

if(strlen($invoice) == 12){ //송장번호  ++++++++++++++++++++++++++++++++++++
    $sql.="  and invc_no = '{$invoice}' and cust_use_no like '{$sublDate}'||'0245%' ";
} else { // 수불번호 4자리 +++++++++++++++++++++++++++
    $sql.="  cust_use_no = '{$sublDate}'||'0245'||'{$invNo}' ";
}


$data = sql_result($sql);
echo $data;
