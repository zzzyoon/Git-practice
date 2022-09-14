<?php
@header('Content-Type: application/json');
include_once('./_common.php');


if(!$is_member){
    ajaxExitJson("로그인 정보가 존재하지 않습니다. ");
}

if(!$is_school_member){
    ajaxExitJson("권한이 없습니다. ");
}

$sn_grp_no = get_text($_POST["sn_grp_no"]);
$sn_number = get_text($_POST['sn_number']);

if(empty($sn_grp_no) || empty($sn_number)){
    ajaxExitJson("필수 파라미터가 누락되었습니다.");
}



$sql=" select * from  {$g5['safety_number_table']}   where   sn_state  ='s'  and sn_grp_no = '{$sn_grp_no}' and sn_number = '{$sn_number}' ";
$data = sql_fetch($sql);

if($data)
   ajaxEchoJson(true,"*정상적으로 생성된 안심번호입니다. ");
else
    ajaxEchoJson(false,"*비정상적인 안심번호입니다. ");

?>