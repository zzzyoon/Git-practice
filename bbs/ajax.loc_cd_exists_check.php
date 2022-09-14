<?php
@header('Content-Type: application/json');
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}

$locCd = filteringSpcChr($_REQUEST['loc_cd']);

if(!$locCd){
    ajaxExitJson("필수정보가 누락되었습니다.(v) ");
}

if(strlen($locCd) != 6){
    ajaxExitJson("로케이션 형식이 아닙니다. ");
}


// 로케이션 존재 체크
$locRes = existLocCheck($barCd);
if(!$locRes)
    ajaxExitJson("존재하지 않는 로케이션[{$locCd}]입니다. ");



//ajaxEchoJson(true,"유효한 로케이션입니다. ");