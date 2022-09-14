<?php
@header('Content-Type: application/json');
include_once('./_common.php');

if(!$is_member){
    ajaxExitJson("로그인 정보가 존재하지 않습니다. ");
}

if(!$is_teacher_member){
    ajaxExitJson("권한이 없습니다. ");
}


if(!$_POST['mb_id']){
    ajaxExitJson("필수정보에 누락이 있습니다. ");
}

$updUserId = $_POST['mb_id'];
$updStat = $_POST['mb_opt_fcm']; //a active, e expired




// 실제 처리 프로세스 ____________--------------------------------
//issue > mb_opt_fcm column is bit (1/0)
$sql="update   {$g5['member_table']}    set    mb_opt_fcm = {$updStat}    where mb_id = '{$updUserId}' ";
sql_query($sql);



ajaxEchoJson(true,$sql);
?>