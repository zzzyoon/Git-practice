<?php
include_once('./_common.php');

// 로그인중인 경우 회원가입 할 수 없습니다.
if ($is_member) {
    goto_url(G5_URL);
}

// 세션을 지웁니다.
set_session("ss_mb_reg", "");

$g5['title'] = '회원가입약관';


alert("* 온라인 회원가입은 불가능 합니다. \\n ->  고객센터 : ".G5_CS_NUMBER."로  전화 문의주세요. ","/");

include_once('./_head.php');
$register_action_url = G5_BBS_URL.'/register_form.php';
include_once($member_skin_path.'/register.skin.php');



include_once('./_tail.php');
?>
