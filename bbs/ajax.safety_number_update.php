<?php
@header('Content-Type: application/json');
include_once('./_common.php');

if(!$is_member){
    ajaxExitJson("로그인 정보가 존재하지 않습니다. ");
}
if(!is_admin && !$is_school_member){
    ajaxExitJson("권한이 없습니다. ");
}
if(!$_POST['upd_number']){
    ajaxExitJson("필수정보에 누락이 있습니다. /  ".$_POST['upd_number']);
}

$updNumber = trim(clean_xss_tags($_POST['upd_number']));
$updState = trim(clean_xss_tags($_POST['upd_state'])); //a active, e expired
$linkedNumber = trim(clean_xss_tags($_POST['linked_number']));



// 실제 처리 프로세스 ____________--------------------------------
$sql="";
if($updState == "a") { // 등록
    $sql = "update   {$g5['safety_number_table']}   set  sn_state  ='a' , sn_linked_number = '{$linkedNumber}', sn_active_datetime = sysdate()   where sn_number = '$updNumber' ";
} else if($updState == "u"){ // 수정
        $sql="update   {$g5['safety_number_table']}   set  sn_state  ='a', sn_linked_number = '{$linkedNumber}', sn_mod_datetime = sysdate()   where sn_number = '$updNumber' ";
} else { //해제
    $sql="update   {$g5['safety_number_table']}   set  sn_state  ='e' , sn_expired_datetime = sysdate()   where sn_number = '$updNumber' ";
}

sql_query($sql);



// 일괄 작업
// 대기 상태 (임시발급) s  -> r 상태로 수정 (관리를 위한 . 상태 일괄 변경)
sql_query("update   {$g5['safety_number_table']}   set  sn_state  ='r'  where sn_state = 's' and sn_standby_datetime < date_add(sysdate(),INTERVAL -10 minute) ");



ajaxEchoJson(true,"처리 완료되었습니다. ");
?>