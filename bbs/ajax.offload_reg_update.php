<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "하차등록 - 전송하기"
 *
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$_REQUEST = array_map_deep('filteringSpcChr', $_REQUEST);



$sublNo = $_REQUEST['old_subl_no'];
$custNm = $_REQUEST['cust_nm'];
$meTaxNo = $_REQUEST['metax_no'];
$meCustNm = $_REQUEST['mecust_nm'];
$jgGb = $_REQUEST['jg_gb'];
$juQty = $_REQUEST['ju_qty'];
$odQty = $_REQUEST['od_qty'];
$outQty = $_REQUEST['tot_qty']; //out_qty


$acceptor = $_REQUEST['acceptor_name'];


//for debugging_____________
//$sublNo = "2021012500191012";

if(empty($sublNo) || empty($custNm) || empty($meCustNm) || empty($meTaxNo) || empty($jgGb)
                        || strlen($juQty) == 0 | strlen($odQty) == 0 || strlen($outQty) == 0 || empty($acceptor)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

if(empty($sublNo)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

if(strlen($sublNo) != 16){
    ajaxExitJson("전표번호를 바르게 입력하세요.");
}

$sublDate = substr($sublNo,0,8);
$taxNo = substr($sublNo,8,4);
$sublNo = substr($sublNo,12,4);


$sql = "select * from bkload   where subl_date = '{$sublDate}'
              and tax_no =  '{$taxNo}'
              and subl_no =  '{$sublNo}' ";

$cdata = sql_fetch($sql);
if(!$cdata){
    ajaxExitJson("전표번호 [".$sublNo."]로 등록된 자료가 없습니다.");
} else {
    if($cdata['alight_date']){
        ajaxExitJson("전표번호 [".$sublNo."]는  이미 하차등록 되었습니다. (*인수자 : {$cdata['acceptor_name']} / ".$cdata['alight_date'].")");
    }
}

$sql = " update  bkload  set
        alight_date = '".G5_TIME_YMD_PURE."',
        alight_time = '".substr(G5_TIME_HIS_PURE,0,4)."',
        alight_emp = '{$member['mb_id']}',
        alight_ip = '{$_SERVER['REMOTE_ADDR']}',
        acceptor_name = '{$acceptor}',
        upd_date = '".G5_TIME_YMDHIS_PURE."',
        upd_emp = '{$member['mb_id']}',
        upd_ip = '{$_SERVER['REMOTE_ADDR']}'
    where subl_date = '{$sublDate}'
    and tax_no =  '{$taxNo}'
    and subl_no =  '{$sublNo}' ";


$res = sql_query($sql);

if($res){

    ajaxEchoJson(true,"하차등록 자료 정상 전송되었습니다. ");
} else {
    ajaxEchoJson(false,"하차등록 자료 전송시 오류가 발생했습니다.");
}


