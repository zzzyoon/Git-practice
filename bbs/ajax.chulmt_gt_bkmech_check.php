<?php
//@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "출고조회 - gt >  출고 등록 체크"
 *
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);

$sublDate = filteringSpcChr($_REQUEST['subl_date']);
$sublNo = filteringSpcChr($_REQUEST['subl_no']);


if(empty($sublDate) || empty($sublNo)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}


$sql = "         Select nvl(count(*),0) cnt from bkmech A where tax_no = '0245'
                 and A.SUBL_DATE = '{$sublDate}'
                 and A.SUBL_NO = '{$sublNo}'
          ";


$data = sql_result($sql);
echo $data;
