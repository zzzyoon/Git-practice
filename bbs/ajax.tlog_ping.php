<?php
@header('Content-Type: application/json');
include_once('./_common.php');

if(!$is_member){
    ajaxExitJson("로그인 정보가 존재하지 않습니다. ");
}

if(!$is_school_member){
    ajaxExitJson("권한이 없습니다. ");
}


$serverIp = G5_TLOG_SERVER_IP;
$serverPort = G5_TLOG_SERVER_PORT;


if(ping($serverIp,$serverPort))
    ajaxEchoJson(true,"");
else
    ajaxEchoJson(false,"");

?>