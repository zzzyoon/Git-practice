<?php
@header('Content-Type: application/json');
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}

$sflDay = date("Y-m-d");
$sflMonth = date("Y-m");


if($is_teacher_member) { // 교직원 회원 /////////////////////////////////////////////////////////////////////////////////////////////

    $sql = "select count(*)  from {$g5['tnms_log']}
     where  mb_id = '{$member['mb_id']}'  and DATE_FORMAT(cm_datetime,'%Y-%m-%d') = '{$sflDay}' and cm_time > 0";

    $dayCnt = sql_result($sql);

    //$dayCnt=21000;

    $sql = "select count(*)  from {$g5['tnms_log']}
     where  mb_id = '{$member['mb_id']}' and cm_month = '{$sflMonth}' and cm_time > 0 ";
    $monthCnt = sql_result($sql);

    $json = new stdClass();
    $json->day_cnt = $dayCnt;
    $json->month_cnt = $monthCnt;
    echo json_encode($json);
    exit;

} else {  //  학교회원 //////////////////////////////////////////////////////////////////////////////////////

    $logger = initializeMonoLogger("DashBoard");

    $sql = "select count(*)  from {$g5['tnms_log']}
     where  mg_no = '{$member['mg_no']}'  and DATE_FORMAT(cm_datetime,'%Y-%m-%d') = '{$sflDay}' and cm_time > 0";
    $dayCnt = sql_result($sql);

    $logger->info("sms query",array($sql));

    $sql = "select count(*)  from {$g5['tnms_log']}
     where  mg_no = '{$member['mg_no']}' and cm_month = '{$sflMonth}' and cm_time > 0 ";
    $monthCnt = sql_result($sql);

    $logger->info("tnms query",array($sql));

    $json = new stdClass();
    $json->day_cnt = $dayCnt;
    $json->month_cnt=$monthCnt;
    echo json_encode($json);
    exit;
}



