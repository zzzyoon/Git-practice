<?php

$memberCnt = 0;
if($is_school_member){

    $sql = "select count(*) from {$g5['member_table']}  where mb_1 = '{$member['mg_no']}'";
    $memberCnt = sql_result($sql);

    $gmember = get_member_group($member['mg_no']);
}

// 학교  > 업무시간
$sql = "select *  FROM {$g5['work_time']} WHERE  mg_no = '{$member['mg_no']}' and mb_level = '".G5_MEMBER_SCHOOL_LV."'   limit 1";
$data = sql_fetch($sql);
$sch_work_time = $data['wt_start_time']."-".$data['wt_end_time'];
$sch_work_days = wellKnownDaysName($data['wt_work_days']);

if($data['wt_lunch_start_time']) {
    $sch_lunch_time = $data['wt_lunch_start_time']."-".$data['wt_lunch_end_time'];
} else {
    $sch_lunch_time="미설정";
}
unset($data);


// 교직원 > 업무시간
if($is_teacher_member){


    $sql = "select *  FROM {$g5['work_time']} WHERE  mb_id = '{$member['mb_id']}' and mb_level = '".G5_MEMBER_TEACHER_LV."'   limit 1";
    //echoBox($sql);
    $data = sql_fetch($sql);
    $haveTchTime=false;

    if($data) {
        $haveTchTime=true;
        $tch_work_time = $data['wt_start_time'] . "-" . $data['wt_end_time'];
        $tch_work_days = wellKnownDaysName($data['wt_work_days']);
        if($data['wt_lunch_start_time']) {
            $tch_lunch_time = $data['wt_lunch_start_time']."-".$data['wt_lunch_end_time'];
        } else {
            $tch_lunch_time="미설정";
        }

        $sch_work_time=" <p class='card-text text-danger'><del>학교 / 업무시간 : {$sch_work_time}</del></p>";
    }

}


?>


<?php if($is_school_member) { ?>

<!-- 학교 회원 >  데시 보드    ----------------------------------------------------------------------------------------------->

    <section id="user_dashboard" class="mt-2" >
        <div class="row">
            <div class="col-sm-6">
                <div class="card text-center hover-shadow-lg hover-translate-y-n10">

                    <div class="card-header font-weight-bold">
                        <?php echo $gmember['mg_name']?>
                    </div>

                    <div class="px-4 pt-3 pb-1">

                        <button type="button" onclick="moveUrl('/bbs/gmember_list.php')" class="btn btn-primary py-2">
                            <i class="fas fa-users"></i>  총 교직원 회원 <span class="badge badge-pill badge-light">
                            <?=phoneNumberFormat($memberCnt)?> 명
                            </span>
                        </button>
                    </div>

                    <ul class="list-group list-group-flush mx-4 mt-3 ">
                        <li class="list-group-item">
                            업무 시간 : <?=$sch_work_time?>
                            <a href='/bbs/gmember_worktime.php'><i class='fas fa-cog text-secondary'></i></a>
                        </li>
                        <li class="list-group-item text-size-3 p-1 m-1 font-weight-bold">
                            업무 요일 : <?=$sch_work_days?>
                        </li>
                        <li class="list-group-item p-1 m-1">
                             <span class="badge badge-pill badge-secondary">
                            점심 시간 : <?=$sch_lunch_time?>
                                 </span>
                        </li>
                    </ul>


                </div>
            </div>
            <div class="col-sm-6">

                <div class="row">
                    <div class="col-12">
                        <div class="bd-callout bd-callout-info">
                            <h5>문자 이용 정보 <a href="/bbs/sms_statics_daily.php"><i class="fas fa-link"></i></a></h5>
                            <p class="text-muted">오늘 전송:    <span class="badge badge-danger px-2" id="echoSmsDayCnt">0</span>건 .  이번달 전송 :   <span id="echoSmsMonthCnt" class="badge badge-secondary px-2">0</span>건</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="bd-callout bd-callout-warning">
                            <h5>안심발신 이용 정보 <a href="/bbs/callmapping_list.php"><i class="fas fa-link"></i></a></h5>
                            <p class="text-muted">오늘 통화:    <span id="echoTnmsDayCnt" class="badge badge-primary px-2">0</span>건 . 이번달 통화 :   <span id="echoTnmsMonthCnt" class="badge badge-secondary px-2">0</span>건</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


<?php } else { ?>



    <!-- 교직원 회원 >데시 보드    ----------------------------------------------------------------------------------------------->

    <section id="user_dashboard" class="mt-2" >

        <div class="row">
            <div class="col-sm-6 ">
                <div class="card text-center hover-shadow-lg hover-translate-y-n10">

                    <div class="px-4 pt-3 pb-1">

                        <button type="button" class="btn btn-primary py-2">
                            안심번호 <span class="badge badge-pill badge-light">
                                 <?=phoneNumberFormat($member['mb_id'])?>
                                <i class="fas fa-arrow-circle-right"></i>
                                <?=phoneNumberFormat($member['mb_hp'])?>

                            </span>
                        </button>
                    </div>



                    <?php if(!$haveTchTime) { ?>

                        <ul class="list-group list-group-flush mx-4 mt-3 ">

                            <li class="list-group-item font-weight-bold">
                                업무 시간 : <?=$sch_work_time?>
                                <a href='/bbs/member_worktime.php'><i class='fas fa-cog text-secondary'></i></a>
                            </li>
                            <li class="list-group-item text-size-3">
                                업무 요일 : <?=$sch_work_days?>
                            </li>
                            <li class="list-group-item text-size-3">
                                점심 시간 : <?=$sch_lunch_time?>
                            </li>
                            <li class="list-group-item p-1 m-1">
                             <span class="badge badge-pill badge-info">
                                   <i class="fas fa-exclamation-circle"></i>   개인 업무시간 : 미설정
                                 </span>
                            </li>

                        </ul>

                    <?php } else { ?>

                        <ul class="list-group list-group-flush mx-4 mt-3 ">
                            <li class="list-group-item">
                                <?=$sch_work_time?>
                            </li>
                            <li class="list-group-item font-weight-bold">
                                개인 업무 시간 : <?=$tch_work_time?>
                                <a href='/bbs/member_worktime.php'><i class='fas fa-cog text-secondary'></i></a>
                            </li>
                            <li class="list-group-item text-size-3">
                                개인  업무 요일 : <?=$tch_work_days?>
                            </li>
                            <li class="list-group-item text-size-3">
                                개인  점심 시간 : <?=$tch_lunch_time?>
                            </li>
                        </ul>


                    <?php } ?>



                </div>
            </div>
            <div class="col-sm-6 ">

                <div class="row">
                    <div class="col-12">
                        <div class="bd-callout bd-callout-info">
                            <h5>문자 이용 정보 <a href="/bbs/sms_history_list.php"><i class="fas fa-link"></i></a></h5>
                            <p class="text-muted">오늘 전송 :    <span class="badge badge-info px-2" id="echoSmsDayCnt">0</span>건 . 이번달 전송 :   <span class="badge badge-secondary px-2" id="echoSmsMonthCnt">0</span>건</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="bd-callout bd-callout-warning">
                            <h5>안심발신 이용 정보 <a href="/bbs/callmapping_list.php"><i class="fas fa-link"></i></a></h5>
                            <p class="text-muted">오늘 통화 :    <span class="badge badge-warning px-2" id="echoTnmsDayCnt">0</span>건 . 이번달 통화 :   <span class="badge badge-secondary px-2" id="echoTnmsMonthCnt">0</span>건</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


<?php } ?>

<script>
    $(function() {
        // SMS Current > Stat
        $.get( "/bbs/ajax.sms_stat.php", function( data ) {

            var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
            //$('#echoSmsDayCnt').text(data.day_cnt);
            $('#echoSmsDayCnt').animateNumber({ number: data.day_cnt,numberStep: comma_separator_number_step });
            //$('#echoSmsMonthCnt').text(data.month_cnt);
            $('#echoSmsMonthCnt').animateNumber({ number: data.month_cnt,numberStep: comma_separator_number_step });
        }, "json" );

        // TNMS Current > Stat
        $.get( "/bbs/ajax.tnms_stat.php", function( data ) {



            var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
            //$('#echoTnmsDayCnt').text(data.day_cnt);
            $('#echoTnmsDayCnt').animateNumber({ number: data.day_cnt,numberStep: comma_separator_number_step });
//                $('#echoTnmsMonthCnt').text(data.month_cnt);
            $('#echoTnmsMonthCnt').animateNumber({ number: data.month_cnt,numberStep: comma_separator_number_step });
        }, "json" );

    });
</script>

