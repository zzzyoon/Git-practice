<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   도서마스터 > 기본서가 변경
 *
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$_REQUEST = array_map_deep('filteringSpcChr', $_REQUEST);


$bkCode = $_REQUEST['bk_cd'];
$taxNo = $_REQUEST['tax_no'];
$avgQty = $_REQUEST['avg_qty'];
$maxQty = $_REQUEST['max_qty'];


if(empty($bkCode) || empty($taxNo) || strlen($avgQty) == 0 || strlen($maxQty) == 0)
    ajaxExitJson("필수 인자가 누락되었습니다. ");


$sql = "select * from bookcd   where bk_cd = '{$bkCode}'    and tax_no =  '{$taxNo}' ";
$cdata = sql_fetch($sql);
if(!$cdata){
    ajaxExitJson("해당 도서가 존재하지 않습니다.");
}


$sql = " update  bookcd  set
        avg_qty = {$avgQty},
        max_qty = {$maxQty}
    where bk_cd = '{$bkCode}'
    and tax_no =  '{$taxNo}' ";
/**
 * 수정일자, 수정자 등과같은 컬럼이? 없다.
 */


$res = sql_query($sql);

if($res){

    ajaxEchoJson(true,"안전재고 정보가 변경되었습니다.  ");
} else {
    ajaxEchoJson(false,"안전재고  변경시  오류가 발생했습니다.");
}


