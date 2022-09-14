<?php
@header("Cache-Control:no-cache");
@header("Pragma:no-cache");
include_once('./_common.php');

$g5['title'] = "작업도서 타입 선택";

if($is_guest)
    alert('회원이시라면 로그인 후 이용해 보십시오.', './login.php');


$workType =clean_xss_tags(trim($_REQUEST['work_type'])); // A, X
if (!$workType)
    alert('필수정보가 누락되었습니다.');


// jg_gb 세션 생성
set_session('ss_work_type', $workType);
// android > webview전달
set_pure_cookie('app_work_type', $workType, 86400 * 1);


goto_url("/");
?>