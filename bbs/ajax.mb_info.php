<?php
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    die("<strong>로그인 정보가 존재하지 않습니다. </strong>");
}


$group = get_member_group($member['mb_1']);// group 정보(학교)
$group_use_sms = ($group['mg_use_sms'])?"On":"Off";
$group_sms_quota = $group['mg_sms_quota'];

if ($group_sms_quota == 0) {
    $group_sms_quota = "무제한";
} else {
    $group_sms_quota = number_format($group_sms_quota) . "원";
}

// sms 당월 이용금액
$usedFee = (float)getSmsUsedCharge($member['mb_1'], date("Y-m"));
$group_sms_quota .= " (<strong>현재 : " . number_format($usedFee, 1) . "원 이용</strong>)";


$mb_level = $member['mb_level'];
if($is_school_member)
    $mb_level = "학교 회원";
else if($is_teacher_member)
    $mb_level = "교직원 회원";

//발신 포인트
$mb_call_point = number_format($member['mb_call_point']);

//안심발신 서비스
$tnms_svc_stat = "";
$tnms_svc_info = "";
if($group['mg_use_tnms']){
  $tnms_svc_stat="On";

    $curMonth = date("Y-m");
    $sql = "select sum(cm_amt) from {$g5['tnms_log']} where mg_no = '{$member['mb_1']}' and cm_month = '$curMonth' ";
    $sentAmt = sql_result($sql);
    if (!$sentAmt)
        $sentAmt = 0;

    if($group['mg_tnms_quota'] > 0) {
        $tnms_svc_info="안심발신 월 한도금액 : ".number_format($group['mg_tnms_quota'])."원 (현재 : ".number_format($sentAmt)."원 이용)";
    } else {
        $tnms_svc_info="안심발신 월 한도금액 : 무제한 (현재 : ".number_format($sentAmt)."원 이용)";
    }

} else {
    $tnms_svc_stat="Off";
}




// 학교  > 업무시간
$sql = "select *  FROM {$g5['work_time']} WHERE  mg_no = '{$member['mg_no']}' and mb_level = '".G5_MEMBER_SCHOOL_LV."'   limit 1";
$data = sql_fetch($sql);
$sch_work_time = $data['wt_start_time']."-".$data['wt_end_time'];
$sch_work_days = wellKnownDaysName($data['wt_work_days']);


// 교직원 > 업무시간
if($is_teacher_member){
    unset($data);
    $sql = "select *  FROM {$g5['work_time']} WHERE  mb_id = '{$member['mb_id']}' and mb_level = '".G5_MEMBER_TEACHER_LV."'   limit 1";
    //exit($sql);
    $data = sql_fetch($sql);

    if($data) {
        $tch_work_time = $data['wt_start_time'] . "-" . $data['wt_end_time'];
        $tch_work_days = wellKnownDaysName($data['wt_work_days']);
        $haveTchTime=true;
        //$tch_work_info = "<div class='alert alert-danger'> *개인 / 시간 : $tch_work_time / 요일 : $tch_work_days </div>";
        $sch_work_time=" <p class='card-text text-danger'><del>학교 - 시간 : {$sch_work_time} / 요일 : {$sch_work_days}</del></p>";

        $workTimeMsg ="       {$sch_work_time}
                <p class='card-text font-weight-bold'>개인 - 시간 : {$tch_work_time} / 요일 : {$tch_work_days}</p>";

    } else {
        $tch_work_time = "미설정";
        $tch_work_days = "미설정";
        $sch_work_time=" <p class='card-text text-danger'>시간 : {$sch_work_time} / 요일 : {$sch_work_days}</p>";

        $workTimeMsg = " {$sch_work_time} ";
    }




}


// 학교회원 ----------------------------------------------------------------------------------------------
// modal body들어갈 html 형식으로 return (즉,boostrap . card class)
if($is_school_member){
    //    <div class='card-header bg-primary text-light'><i class='fas fa-info-circle'></i> <strong>{$member['mb_name']}</strong>님 정보</div>
    echo "
<div class='card m-1'>
    <div class='card-body'>
        <ul>
        <li> 아이디 : <strong>{$member['mb_nick']}</strong></li>
        <li> 레벨 : {$mb_level}</li>
        <li> 대표번호 : " . phoneNumberFormat($member['mb_tel']) . "</li>
<!--        <li> 가입일 : {$member['mb_datetime']}</li> -->
        </ul>
         <div class='card ml-3 mt-1'>
              <div class='card-header'>
                * 업무시간 정보 &nbsp; <a href='/bbs/gmember_worktime.php'><i class='fas fa-cog'></i></a>
              </div>
              <div class='card-body'>
                <p class='card-text'>시간 : {$sch_work_time}</p>
                <p class='card-text'>요일 : {$sch_work_days}</p>
              </div>
         </div>

    </div>
        <div class='card-footer small text-info'>
            <ul>
             <li class='text-success'>안심발신 서비스 : <span class='bg-success rounded-pill p-1 text-light'>{$group_use_sms}</span></li> ";

            if(!empty($tnms_svc_info)){
                echo "<li class='text-success'>{$tnms_svc_info}</li>";
            }

        echo"
             <li class='mt-2'>문자 서비스 : <span class='bg-info rounded-pill p-1 text-light'>{$group_use_sms}</span></li>
            <li>문자 회신번호 : " . phoneNumberFormat($group['mg_2']) . "</li>
             <li>문자 월 한도 금액 : {$group_sms_quota}</li>
             </ul>
        </div>
    </div>";

    //선생님(개인) 회원 ----------------------------------------------------------
} else if($is_teacher_member) {
    $memberUid = phoneNumberFormat($member['mb_id']);
    echo "

<div class='card m-1'>
    <div class='card-body'>


        <ul>
        <li class='font-weight-bold'>소속학교 :  {$group['mg_name']}</li>
        <li> 아이디 : <strong>{$member['mb_id']} <a href='javascript:alert(\"안심번호가 클립보드로 복사되었습니다.\");' alt='복사' class='btn-cb' data-clipboard-text='{$memberUid}' ><i class='far fa-copy'></i></a></strong></li>
        <li> 레벨 : {$mb_level}</li>
      <!--  <li class='text-primary'> 발신 포인트 : {$mb_call_point} 원</li> -->
        <li> 휴대폰번호 : " . phoneNumberFormat($member['mb_hp']) . "</li>
        <li> 가입일 : {$member['mb_datetime']}</li>
        </ul>

         <div class='card ml-3 mt-1'>
              <div class='card-header'>
                *  업무시간
              </div>
              <div class='card-body text-center'>
                {$workTimeMsg}
              </div>
         </div>

    </div>
    <div class='card-footer small text-info'>
            <ul>

             <li  class='text-success'>안심발신 서비스 : <span class='bg-success rounded-pill p-1 text-light'>{$group_use_sms}</span></li>";

            if(!empty($tnms_svc_info)){
                echo "<li class='text-success'>{$tnms_svc_info}</li>";
            }

             echo"
             <li class='mt-2'>문자 서비스 : <span class='bg-info rounded-pill p-1 text-light'>{$group_use_sms}</span></li>
             <li>문자 회신번호 : " . phoneNumberFormat($group['mg_2']) . "</li>
             <li>문자 월 한도 금액 : {$group_sms_quota}</li>
             </ul>
    </div>
</div>";

} else {
    if($is_cs1_member || $is_cs2_member || $is_admin_member){
        $csButton = '<div class="card-footer text-center"><a href="/bbs/board.php?bo_table=cs_bbs"  class="btn bt-sm btn-warning" >CS 게시판</a></div>';
    }


    if($is_admin || isMgrMember($member['mb_level'])){
        $adminButton = "<div class='d-flex justify-content-center m-2 mb-4'><a class='btn btn-danger text-light' href='".G5_ADMIN_URL."'><i class='fas fa-user-shield'></i> 관리자 페이지</a></div>";
    }


    echo "
<div class='card m-1'>
        <div class='card-body'>
        <ul>
        <li> 아이디 : <strong>{$member['mb_id']}</strong></li>
        <li> 이름 : <strong>{$member['mb_name']}</strong></li>
        <li> 레벨 : {$mb_level}</li>
        <li> 휴대폰번호 : " . phoneNumberFormat($member['mb_hp']) . "</li>
        <li> 가입일 : {$member['mb_datetime']}</li>
        </ul>
    </div>

    $adminButton
    $csButton

</div>";

}

?>

