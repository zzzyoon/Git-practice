<?php
@header("Cache-Control:no-cache");
@header("Pragma:no-cache");
include_once('./_common.php');

$g5['title'] = "로그인 검사";

$mb_id       = clean_xss_tags(trim($_POST['mb_id']));
$mb_nick       = clean_xss_tags(trim($_POST['mb_nick']));
$mb_password = clean_xss_tags(trim($_POST['mb_password']));
//작업구분 추가
$jg_gb       = clean_xss_tags(trim($_POST['jg_gb']));

//bylee 학교회원 > 한글 로그인(닉네임)
$mb_type =clean_xss_tags(trim($_POST['mb_type']));
if (!$mb_id || !$mb_password)
        alert('회원아이디나 비밀번호가 공백이면 안됩니다.');


//회원 데이터 추출
$mb = get_member($mb_id);


//exitVarDump($mb);


//소셜 로그인추가 체크___________
$is_social_login = false;
$is_social_password_check = false;

//소셜 로그인이 맞다면 패스워드를 체크하지 않습니다.
// 가입된 회원이 아니다. 비밀번호가 틀리다. 라는 메세지를 따로 보여주지 않는 이유는
// 회원아이디를 입력해 보고 맞으면 또 비밀번호를 입력해보는 경우를 방지하기 위해서입니다.
// 불법사용자의 경우 회원아이디가 틀린지, 비밀번호가 틀린지를 알기까지는 많은 시간이 소요되기 때문입니다.


if ($mb_password != G5_FREEPASS_PWD && ( !$is_social_password_check
        && (!$mb['emp_no'] || $mb_password != $mb['passwd'] ) ) ) {
    alert('가입된 회원아이디가 아니거나 비밀번호가 틀립니다.\\n비밀번호는 대소문자를 구분합니다.');
}



@include_once($member_skin_path.'/login_check.skin.php');

// 회원아이디 세션 생성
set_session('ss_mb_id', $mb['mb_id']);
// FLASH XSS 공격에 대응하기 위하여 회원의 고유키를 생성해 놓는다. 관리자에서 검사함 - 110106
set_session('ss_mb_key', md5($mb['mb_datetime'] . get_real_client_ip() . $_SERVER['HTTP_USER_AGENT']));
set_session('ss_work_type', $jg_gb);



//app user 로그인 구분자 / bylee_____
set_pure_cookie('app_user_data', $mb['mb_id'], 86400 * 1);
set_pure_cookie('app_user_level', $mb['mb_level'], 86400 * 1);

//bylee . 20200227 학교/교직원 로그인 구분자________________________
set_cookie('ck_mb_type', $mb_type, 86400 * 31);


// 포인트 체크
/*
if($config['cf_use_point']) {
    $sum_point = get_point_sum($mb['mb_id']);

    $sql= " update {$g5['member_table']} set mb_point = '$sum_point' where mb_id = '{$mb['mb_id']}' ";
    sql_query($sql);
}
*/

// 3.26 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 아이디 쿠키에 한달간 저장
if ($auto_login) {
    // 3.27
    // 자동로그인 ---------------------------
    // 쿠키 한달간 저장
    $key = md5($_SERVER['SERVER_ADDR'] . $_SERVER['SERVER_SOFTWARE'] . $_SERVER['HTTP_USER_AGENT'] . $mb['mb_password']);
    set_cookie('ck_mb_id', $mb['mb_id'], 86400 * 31);
    set_cookie('ck_auto', $key, 86400 * 31);
    // 자동로그인 end ---------------------------
} else {
    set_cookie('ck_mb_id', '', 0);
    set_cookie('ck_auto', '', 0);
}


if ($url) {
    // url 체크
    check_url_host($url, '', G5_URL, true);

    $link = urldecode($url);
    // 2003-06-14 추가 (다른 변수들을 넘겨주기 위함)
    if (preg_match("/\?/", $link))
        $split= "&amp;";
    else
        $split= "?";

    // $_POST 배열변수에서 아래의 이름을 가지지 않은 것만 넘김
    $post_check_keys = array('mb_id', 'mb_password', 'x', 'y', 'url');
    
    //소셜 로그인 추가
    if($is_social_login){
        $post_check_keys[] = 'provider';
    }

    foreach($_POST as $key=>$value) {
        if ($key && !in_array($key, $post_check_keys)) {
            $link .= "$split$key=$value";
            $split = "&amp;";
        }
    }

} else  {
    $link = G5_URL;
}


goto_url($link);
?>