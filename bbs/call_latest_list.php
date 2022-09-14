<?php
include_once("./_common.php");


//bylee
if($is_guest)
    alert('회원이시라면 로그인 후 이용해 보십시오.', './login.php?url='.urlencode(G5_BBS_URL.'/sms_history_list.php'));

if(!$is_teacher_member)
    alert('이용 회원 권한이 없습니다. ', './login.php?url='.urlencode(G5_BBS_URL.'/sms_history_list.php'));

//bylee
$sconfig = get_call_config();

//$page_size = 20;
$page_size = $sconfig['call_page_rows'];
$colspan = 4;



$g5['title'] = "안심번호 수신내역";

if ($page < 1) $page = 1;

// 최근 3달
$sql_search = " and fcm_datetime >= DATE_ADD(now(), INTERVAL -3 MONTH) ";

if (is_numeric($sv))
    $sql_search .= " and fcm_caller like '%$sv%' ";
else if($sv)
    $sql_search .= " and  exists (select 1 from {$g5['sms5_book_table']} where mb_id = a.mb_id and bk_name like '%$sv%' )   ";


$total_res = sql_fetch("select count(*) as cnt from {$g5['fcm_log']} a where  mb_id = '{$member['mb_id']}' and fcm_caller is not null  $sql_search");
$total_count = $total_res['cnt'];

$total_page = (int)($total_count/$page_size) + ($total_count%$page_size==0 ? 0 : 1);
$page_start = $page_size * ( $page - 1 );
$vnum = $total_count - (($page-1) * $page_size);



//리스트 쿼리 . 배열처리  {    -----------------------------
$sql = "select * from {$g5['fcm_log']}  a  where      mb_id = '{$member['mb_id']}'  and fcm_caller is not null  $sql_search $sql_korean $sql_no_hp order by 1 desc limit $page_start, $page_size";
$stmt = sql_query($sql);


//echoBox($sql);

$list = array();
$num = $total_count - ($page - 1) * $page_rows;
$subject_len = G5_IS_MOBILE ? $sconfig['call_mobile_subject_len'] : $sconfig['call_subject_len'];

for($i=0; $row=sql_fetch_array($stmt); $i++) {

    $list[$i]= $row;
    $list[$i]['num'] = $num - $i;

    $tmp = sql_fetch("select * from {$g5['sms5_book_table']}   where  mb_id = '{$member['mb_id']}' and bk_hp = '{$row['fcm_caller']}' limit 1 ");
    $list[$i]['fcm_caller_name'] = $tmp['bk_name'];

}
//   }    리스트 쿼리 . 배열처리 ------------------------


include_once('./call_head.php');

$skin_file = $call_skin_path.'/call_latest_list.skin.php';

if(is_file($skin_file)) {
    include_once($skin_file);
} else {
    echo '<div>'.str_replace(G5_PATH.'/', '', $skin_file).'이 존재하지 않습니다.</div>';
}

include_once('./call_tail.php');
?>
