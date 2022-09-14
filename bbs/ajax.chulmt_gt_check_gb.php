<?php
//@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "출고조회 - gt > 출고완료 체크"
 *
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$invoice = filteringSpcChr($_REQUEST['invc_no']);
$sublDate = filteringSpcChr($_REQUEST['subl_date']);


if(empty($sublDate) || empty($invoice)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

$sql = "         select count(*) cnt from chulmt 
          ";

if(strlen($invoice) == 12){ //송장번호  ++++++++++++++++++++++++++++++++++++
    $sql.="       where subl_date = substr((select ordno from lotte_invoice 
                 where pickreqymd = '{$sublDate}'
                 and invno = '{$invoice}'),1,8)
                 and   tax_no = substr((select ordno from lotte_invoice 
                 where pickreqymd = '{$sublDate}'
                 and invno = '{$invoice}' ),9,4)
                 and   subl_no = to_number(substr((select ordno from lotte_invoice 
                 where pickreqymd = '{$sublDate}'
                 and invno = '{$invoice}' ),13,4))          
                 and chk_gb > 2      
                 ";
} else { // 수불번호 4자리 +++++++++++++++++++++++++++
    $sql.="       where subl_date = '{$sublDate}'
                 and   tax_no =  '0245'
                 and   subl_no =  {$invoice}'
                 ";
}


$data = sql_result($sql);

echo $data;
