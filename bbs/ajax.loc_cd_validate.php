<?php
@header('Content-Type: application/json');
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}


$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$locCd = clean_xss_tags(get_text($_REQUEST['loc_cd']));
$locGb = clean_xss_tags(get_text($_REQUEST['loc_gb']));


if(!$locCd || strlen($locGb) == 0){
    ajaxExitJson("필수정보가 누락되었습니다.(v) ");
}


// 적치 로케이션 유효성 체크  (clsLocSch.schREc 함수 75 line) ------------------------------------------------------------
$res = validateLocCode($locCd,$locGb);
if($res !== true){
    ajaxExitJson($res);
}

// 로케이션 존재 체크
$locRes = existLocCheck($locCd);
if(!$locRes)
    ajaxExitJson("존재하지 않는 로케이션[{$locCd}]입니다. ");



ajaxEchoJson(true,"사용가능한 유효한 로케이션입니다. ");