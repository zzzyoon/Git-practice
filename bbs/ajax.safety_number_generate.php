<?php
@header('Content-Type: application/json');
include_once('./_common.php');

if(!$is_member){
    ajaxExitJson("로그인 정보가 존재하지 않습니다. ");
}

if(!$is_school_member){
    ajaxExitJson("권한이 없습니다. ");
}

$mb_grp_no = get_text($_POST["mb_grp_no"]);
if(empty($mb_grp_no )){
    ajaxEchoJson(false,"필수 파라미터가 누락되었습니다.");
}

// 관리 쿼리 >  대기 상태  s  -> r 즉, 초기 상태로 수정
sql_query("update   {$g5['safety_number_table']}   set  sn_state  ='r'    where sn_state = 's' and sn_standby_datetime < date_add(sysdate(),INTERVAL -10 minute) ");


//실제 데이터 처리 코드 시작 ---------------------------------------________________________________________---------------------------------
$sql="select * from {$g5['safety_number_table']}  as a
 where sn_state = 'r'
 and sn_grp_no = {$mb_grp_no}
 and not exists(select 1 from {$g5['member_table']} where mb_id = a.sn_number)
 order by  sn_no asc limit 1  ";
$data = sql_fetch($sql);


//exit($sql);
if(!$data){
    ajaxExitJson("번호를 생성할수 없습니다. (*관리자에게 문의)");
}

sql_query(" update {$g5['safety_number_table']} set   sn_state = 's' , sn_standby_datetime = sysdate()   where sn_no =  ".$data["sn_no"]);

$newNumber = $data["sn_number"];
ajaxEchoJson(true,$newNumber);
?>