<?php
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    die("<strong>로그인 정보가 존재하지 않습니다. </strong>");
}

$orderNo = clean_xss_tags(get_text($_REQUEST['order_no']));

if($is_admin)
    $sql = "select * from {$g5['pg_log']} where  pg_order_no = '{$orderNo}'";
else
    $sql = "select * from {$g5['pg_log']} where mb_id = '{$member['mb_id']}' and pg_order_no = '{$orderNo}'";

$data = sql_fetch($sql);


ob_start();
echo"<div class='m-2 font-weight-bold'> <i class='fas fa-money-check'></i> 결제 상품명:   {$data['pg_prd_nm']} </div>";
echo"*결제 은행 : {$data['pg_bank_nm']}<br>";
echo" &nbsp; - 입금 계좌 : {$data['pg_bank_no']}<br>";
echo" &nbsp; - 결제 금액 : ".number_format($data['pg_amt'])."<br>";
echo" &nbsp; - 입금자명 : {$data['pg_deposit_nm']}<br>";
echo" &nbsp; - 입금 만료일 : ".date_format(date_create($data['pg_bank_expire']),"Y-m-d H:i분");
$content = ob_get_contents();
ob_end_clean();
echo $content;