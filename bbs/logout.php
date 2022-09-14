<?php
include_once('./_common.php');

if(function_exists('social_provider_logout')){
    social_provider_logout();
}

// 이호경님 제안 코드
@session_unset(); // 모든 세션변수를 언레지스터 시켜줌
@session_destroy(); // 세션해제함

// 자동로그인 해제 --------------------------------
set_cookie('ck_mb_id', '', 0);
set_cookie('ck_auto', '', 0);

//bylee 쿠키 제거 보완코드
remove_cookie('ck_mb_id');
remove_cookie('ck_auto');


//bylee 어플 로그인 해제
//set_pure_cookie('app_user_data', '', 0);
remove_pure_cookie('app_user_data'); //쿠키제거 버그
remove_pure_cookie('app_user_level'); //쿠키제거 버그



$logger = initializeMonoLogger("logout");
$logger->error("logout check", array("called  XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"));

$logger->error("logout session 11 ", array($_SESSION['ss_mb_id']));

$logger->error("logout cookie 22 ", array(get_cookie('ck_mb_id')));

// 자동로그인 해제 end --------------------------------
if ($url) {

    if ( substr($url, 0, 2) == '//' )
        $url = 'http:' . $url;

    $p = @parse_url(urldecode($url));
    /*
        // OpenRediect 취약점관련, PHP 5.3 이하버전에서는 parse_url 버그가 있음 ( Safflower 님 제보 ) 아래 url 예제
        // http://localhost/bbs/logout.php?url=http://sir.kr%23@/
    */
    if (preg_match('/^https?:\/\//i', $url) || $p['scheme'] || $p['host']) {
        alert('url에 도메인을 지정할 수 없습니다.', G5_URL);
    }

    $link = $url;
} else if ($bo_table) {
    $link = G5_BBS_URL.'/board.php?bo_table='.$bo_table;
} else {
    $link = G5_URL;
}

goto_url($link);
?>
