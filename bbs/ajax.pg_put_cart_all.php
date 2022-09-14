<?php
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}

$chkMembers = $_REQUEST['chk_members'];
$chkStat = clean_xss_tags(get_text($_REQUEST['chk_stat']));

// string booelan  > boolean casting
// boolvar 함수 not working
$chkStat = filter_var ($chkStat, FILTER_VALIDATE_BOOLEAN);


if(empty($chkMembers)){
    ajaxExitJson("*필수 정보가 누락되었습니다. ");
}

$seq=0;
if(!$chkStat){

    foreach($chkMembers as $val) {
        $seq++;
        $sql = "delete from {$g5['pg_cart']} where mb_id = '{$member['mb_id']}' and pc_uid='{$val}' ";
        sql_query($sql);
    }
} else {
    foreach($chkMembers as $val){
        $seq++;
        $sql = " insert into   {$g5['pg_cart']}  set
          mg_no = '{$member['mb_1']}', mb_id = '{$member['mb_id']}', pc_uid='{$val}' ";
        sql_query($sql);
    }

}




$stat = ($chkStat)?"담기":"제거";
ajaxEchoJson(true,"결제 장바구니에  $seq 건이, 일괄 [ $stat ] 되었습니다. ");
