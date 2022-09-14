<?php
@header('Content-Type: application/json');
include_once('./_common.php');

if(!$is_member){
    ajaxExitJson("로그인 정보가 존재하지 않습니다. ");
}

if(!$is_school_member){
    ajaxExitJson("권한이 없습니다. ");
}




$resetNumber = clean_xss_tags($_POST['reset_number']);

if(!$_POST['reset_number']){
    ajaxExitJson("필수정보에 누락이 있습니다. ");
}



// 대기 상태  s  -> r 상태로 수정
sql_query("update   {$g5['safety_number_table']}   set  sn_state  ='r'   where sn_state = 's' and sn_standby_datetime < date_add(sysdate(),INTERVAL -10 minute) ");



sql_query("update   {$g5['safety_number_table']}   set  sn_state  ='r'   where sn_number = '$resetNumber' ");

ajaxEchoJson(true,"처리 완료되었습니다. ");
?>