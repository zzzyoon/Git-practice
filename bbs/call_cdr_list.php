<?php
include_once("./_common.php");


//bylee
if($is_guest)
    alert('회원이시라면 로그인 후 이용해 보십시오.', './login.php?url='.urlencode(G5_BBS_URL.'/call_cdr_list.php'));

if(!$is_teacher_member)
    alert('이용 회원 권한이 없습니다. ', './login.php?url='.urlencode(G5_BBS_URL.'/call_cdr_list.php'));


// 학교 . 이용권한체크 (pause 기능)
$grpData = get_member_group($member['mb_1']);
if($grpData['mg_is_pause']){
    alert('회원님께서 속한 단체와 계약이 종료되어 이용할 수 없습니다. \n (*학교명 :  '.$grpData['mg_name'].')',G5_BBS_URL."/logout.php");
}


//bylee
$sconfig = get_call_config();

//$page_size = 20;
$page_size = $sconfig['call_page_rows'];
$colspan = 4;



$g5['title'] = "안심번호 수신내역";


$group = get_member_group($member["mb_1"]);

include_once('./call_head.php');

$skin_file = $call_skin_path.'/call_cdr_list.skin.php';

if(is_file($skin_file)) {
    include_once($skin_file);
} else {
    echo '<div>'.str_replace(G5_PATH.'/', '', $skin_file).'이 존재하지 않습니다.</div>';
}

include_once('./call_tail.php');
?>
