<secion class="d-block d-md-none py-2 my-2">
<?php if($is_school_member) {?>

    <p class="regist-title" style="font-size: 0.9em;"><i class="fas fa-external-link-square-alt"></i> 바로가기</p>
    
    <div  class="row mb-4">
        <div class="col-4" style="padding-left:2px; padding-right:2px;">
            <button type="button" class="btn btn-primary btn-block" style="font-size:40px !important;" onclick="location.href='<?php echo G5_BBS_URL ?>/gmember_list.php'">
                <i class="fas fa-users"></i>
                <br>
                <span style="font-size:14px !important;">교원관리</span>
            </button>



        </div>
        <div class="col-4" style="padding-left:2px; padding-right:2px;">
            <button type="button" class="btn btn-info btn-block" style="font-size:40px !important;" onclick="location.href='<?php echo G5_BBS_URL ?>/sms_statics_daily.php'">
                <i class="fas fa-calendar-day"></i>
                <br>
                <span style="font-size:13px !important;">일.전송내역</span>
            </button>
        </div>
        <div class="col-4" style="padding-left:2px; padding-right:2px;">
            <button type="button" class="btn btn-warning btn-block" style="font-size:40px !important;" onclick="location.href='<?php echo G5_BBS_URL ?>/sms_statics_monthly.php'">
                <i class="fas fa-calendar-alt"></i>
                <br>
                <span style="font-size:13px !important;">월.전송내역</span>
            </button>
        </div>


    </div>
<? } ?>

<?php if($is_teacher_member) {?>
    <p class="regist-title" style="font-size: 0.9em;"><i class="fas fa-external-link-square-alt"></i> 바로가기</p>

    <div  class="row" style="padding-right: 5px; padding-left: 5px">

        <div class="col-4" style="padding-left:2px; padding-right:2px;">
            <button type="button" class="btn btn-primary btn-block" style="font-size:40px !important;" onclick="location.href='<?php echo G5_BBS_URL ?>/sms_write.php'">
                <i class="fas fa-sms"></i>
                <br>
               <span style="font-size:14px !important;">문자보내기</span>
            </button>
        </div>
        <div class="col-4" style="padding-left:2px; padding-right:2px;">
            <button type="button" class="btn btn-info btn-block" style="font-size:40px !important;" onclick="location.href='<?php echo G5_BBS_URL ?>/sms_history_list.php'">
                <i class="fas fa-list-ol"></i>
                <br>
                <span style="font-size:13px !important;">전송내역</span>
            </button>
        </div>
        <div class="col-4" style="padding-left:2px; padding-right:2px;">
            <button type="button" class="btn btn-warning btn-block" style="font-size:40px !important;" onclick="location.href='<?php echo G5_BBS_URL ?>/call_cdr_list.php'">
                <i class="fas fa-list-alt"></i>
                <br>
                <span style="font-size:13px !important;">(안)수신내역</span>
            </button>
        </div>

    </div>
<? } ?>
</secion>
