<?php
include_once('./_common.php');
ini_set("display_errors", 1);

if($is_guest)
    alert('회원이시라면 로그인 후 이용해 보십시오.', './login.php?url='.urlencode(G5_BBS_URL.'/book_subl.php'));


//bylee
$_config = get_book_config();


$g5['title'] = "입고 등록";
include_once('./book_head.php');

$skin_file = $_skin_path.'/book_subl.skin.php';
$category_option = '';
if(is_file($skin_file)) {

    include_once($skin_file);

} else {
    echo '<div>'.str_replace(G5_PATH.'/', '', $skin_file).'이 존재하지 않습니다.</div>';
}

include_once('./book_tail.php');
?>