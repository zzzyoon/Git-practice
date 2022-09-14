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


$sql = "         select sum(a.ju_qty) cnt from chulji a, chulmt b 
                 where a.subl_date = b.subl_date 
                 and a.tax_no = b.tax_no 
                 and a.subl_no = b.subl_no 
          ";

if(strlen($invoice) == 12){ //송장번호  ++++++++++++++++++++++++++++++++++++
    $sql.="  and a.subl_date = '{$sublDate}' and inv_no = '{$invoice}' ";
} else { // 수불번호 4자리 +++++++++++++++++++++++++++
    $sql.="  and a.subl_date = '{$sublDate}' and a.subl_no = '{$invoice}' ";
}


$data = sql_result($sql);
echo $data;
