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

///$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$_REQUEST = array_map_deep('filteringSpcChr', $_REQUEST);


$bkCode = $_REQUEST['bk_cd'];
$taxNo = $_REQUEST['tax_no'];
$locCode = filteringSpcChr($_REQUEST['loc_cd']);


if(empty($bkCode) || empty($taxNo) || empty($locCode))
    ajaxExitJson("필수 인자가 누락되었습니다. ");


if(strlen($locCode) != 6){
    ajaxExitJson("로케이션 정보를 바르게 입력하세요.");
}

if(substr($locCode,0,1) != "A"){
    ajaxExitJson("서가로만 로케이션을 변경가능합니다. ");
}



$sql = "select * from bkloca   where loc_cd = '{$locCode}'    and cell_gb !=  '3' ";
$ldata = sql_fetch($sql);
if(!$ldata){
    ajaxExitJson("해당 로케이션 [{$locCode}] 정보를 찾을 수 없습니다.");
}



$sql = "select * from bookcd   where bk_cd = '{$bkCode}'    and tax_no =  '{$taxNo}' ";
$cdata = sql_fetch($sql);
if(!$cdata){
    ajaxExitJson("해당 도서가 존재하지 않습니다.");
}


$sql = " update  bookcd  set
        loc_cd = '{$locCode}'
    where bk_cd = '{$bkCode}'
    and tax_no =  '{$taxNo}' ";
/**
 * 수정일자, 수정자 등과같은 컬럼이? 없다.
 */


$res = sql_query($sql);

if($res){

    ajaxEchoJson(true,"도서마스터  기본서가 정보가 변경되었습니다.  ");
} else {
    ajaxEchoJson(false,"기본서가 변경시  오류가 발생했습니다.");
}


