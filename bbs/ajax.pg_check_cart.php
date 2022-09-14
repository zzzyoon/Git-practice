<?php
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}


 $sql = "select count(*) as cnt from    {$g5['pg_cart']}  where  mb_id = '{$member['mb_id']}' ";
 $cnt = sql_result($sql);

$resObj = new stdClass();
$resObj->member_cnt = $cnt;
ajaxEchoJsonObject(true,"장바구니 담긴 회원수입니다. ",$resObj);