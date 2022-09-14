<?php
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}

$memId = clean_xss_tags(get_text($_REQUEST['mem_id']));
$memStat = clean_xss_tags(get_text($_REQUEST['mem_stat']));

// string booelan  > boolean casting
// boolvar 함수 not working
$memStat = filter_var ($memStat, FILTER_VALIDATE_BOOLEAN);


if(empty($memId)){
    ajaxExitJson("*필수 정보가 누락되었습니다. ");
}

if(!$memStat){
    $sql = "delete from {$g5['pg_cart']} where mb_id = '{$member['mb_id']}' and pc_uid='{$memId}' ";


} else {
    $sql = " insert into   {$g5['pg_cart']}  set
          mg_no = '{$member['mb_1']}', mb_id = '{$member['mb_id']}', pc_uid='{$memId}' ";



}


$res = sql_query($sql);

$stat = ($memStat)?"담기":"제거";
if($res)
    ajaxEchoJson(true,"장바구니 [ $stat ] 되었습니다. ");
else
    ajaxEchoJson(false,"장바구니 [ $stat ] 처리 실패했습니다. ");