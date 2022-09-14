<?php
@header('Content-Type: application/json');
include_once('./_common.php');

if(!$is_member){
    ajaxExitJson("로그인 정보가 존재하지 않습니다. ");
}

if(!$is_school_member){
    ajaxExitJson("권한이 없습니다. ");
}

if(!$_POST['server_ip']){
    ajaxExitJson("필수정보에 누락이 있습니다. ");
}


$serverIp=clean_xss_tags($_POST['server_ip']);
$serverPort=clean_xss_tags($_POST['server_port']);


//$url = "203.239.40.230";
//$port = 7123;

if(ping($serverIp,$serverPort))
    ajaxEchoJson(true,"");
else
    ajaxEchoJson(false,"");

?>