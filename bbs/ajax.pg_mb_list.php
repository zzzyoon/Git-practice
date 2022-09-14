<?php
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    die("<strong>로그인 정보가 존재하지 않습니다. </strong>");
}

$mgNo = clean_xss_tags(get_text($_REQUEST['mg_no']));

if($member['mb_1'] != $mgNo)
    die("잘못된 접근입니다. ");


//$group = get_member_group($mgNo);// group 정보(학교)

$sql = "select * from {$g5['member_table']} where mb_1 = '{$mgNo}' and mb_leave_date = '' and mb_level = '".G5_MEMBER_TEACHER_LV."'";

$sql.=" order by mb_no desc";

$result = sql_query($sql);


ob_start();

/*
echo"<div class='m-2 font-weight-bold'> <i class='fas fa-money-check'></i> 결제 상품명:   {$data['pg_prd_nm']} </div>";
echo"*결제 은행 : {$data['pg_bank_nm']}<br>";
echo" &nbsp; - 입금 계좌 : {$data['pg_bank_no']}<br>";
echo" &nbsp; - 결제 금액 : ".number_format($data['pg_amt'])."<br>";
echo" &nbsp; - 입금자명 : {$data['pg_deposit_nm']}<br>";
echo" &nbsp; - 입금 만료일 : ".date_format(date_create($data['pg_bank_expire']),"Y-m-d H:i분");
*/


while($row = sql_fetch_array($result)){

    $bgColor = "bg-secondary";
    if($row['mb_9'] =="교감")
        $bgColor="bg-info";
    else if($row['mb_9'] =="교감")
        $bgColor="bg-warning";



    echo"<div class='card $bgColor '>";
    echo"<option value='{$row['mb_id']}'>{$row['mb_id']} . {$row['mb_name']}</option>";
    echo"</div>";
}



$content = ob_get_contents();
ob_end_clean();
echo $content;