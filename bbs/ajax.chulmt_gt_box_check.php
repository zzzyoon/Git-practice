<?php
//@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
*   "출고조회 - gt >  출고 박스번호 검수"
*
*/


$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$boxNo = filteringSpcChr($_REQUEST['box_no']);
if(empty($boxNo)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}


$sql = "select NVL(COUNT(*),0) from gbooks.gt_bjumun where product_no = '{$boxNo}'
                 and goods_code like '1%' and substr(goods_code,4,3) = '000'
          ";


$data = sql_result($sql);
echo $data;
