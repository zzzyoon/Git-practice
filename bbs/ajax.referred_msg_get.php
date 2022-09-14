<?php
@header('Content-Type: application/json');
include_once('./_common.php');

if(!$is_member){
    ajaxExitJson("로그인 정보가 존재하지 않습니다. ");
}

if(!$is_teacher_member){
    ajaxExitJson("권한이 없습니다. ");
}

$msg_id = get_text($_REQUEST["msg_id"]);
if(empty($msg_id )){
    ajaxEchoJson(false,"필수 파라미터가 누락되었습니다.");
}


$sql="select * from sms5_referred_msg  where mb_id = '{$member["mb_id"]}' and rm_msg_id = {$msg_id} ";
$data = sql_fetch($sql);

$data = stripSlashesData($data);


if(!$data){
    ajaxExitJson("SMS 문자내용을 찾을 수 없습니다. ");
}


$sql = "select * from {$g5['sms5_book_table']}   where  mb_id = '{$member["mb_id"]}' and bk_hp = '{$data["rm_sender"]}' ";
$bookData = sql_fetch($sql);

$data['rm_sender_name']="";
if($bookData)
    $data['rm_sender_name']=$bookData["bk_name"];

ajaxEchoJson(true,$data);
?>