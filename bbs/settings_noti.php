<?php
//$sub_menu = "900700";
include_once("./_common.php");

//auth_check($auth[$sub_menu], "r");
if($is_guest)
    alert('회원이시라면 로그인 후 이용해 보십시오.', './login.php?url='.urlencode(G5_BBS_URL.'/settings_noti.php'));

if(!$is_teacher_member)
    alert('이용 회원 권한이 없습니다. ');


$sconfig = get_settings_config();


$g5['title'] = "푸쉬 알림 설정";//$sconfig["settings_title"];


//$group = array();
//$qry = sql_query("select * from {$g5['sms5_book_group_table']} where bg_no > 1 order by bg_name");
//while ($res = sql_fetch_array($qry)) array_push($group, $res);


include_once('./settings_head.php');

$skin_file = $settings_skin_path.'/settings_noti.skin.php';
$action_url="./settings_noti_update.php";
$list_href="/";

if(is_file($skin_file)) {
    include_once($skin_file);
} else {
    echo '<div>'.str_replace(G5_PATH.'/', '', $skin_file).'이 존재하지 않습니다.</div>';
}


include_once('./settings_tail.php');
?>