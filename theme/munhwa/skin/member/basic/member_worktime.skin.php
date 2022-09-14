<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_path.'/style.css">', 0);

// work time 관련 library___________________________________________________________
add_javascript('<script src="'.G5_JS_URL.'/moment-with-locales.min.js"></script>', 9);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_JS_URL.'/bootstrap-material-datetimepicker.css">', 11);
add_javascript('<script src="'.G5_THEME_JS_URL.'/bootstrap-material-datetimepicker.js"></script>', 11);
?>
<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>

<section id="wtimeSection">
<form id="sfrm" >
    <input type="hidden" id="sch_start_time"  value="<?=$sview['wt_start_time']?>"  >
    <input type="hidden" id="sch_end_time"  value="<?=$sview['wt_end_time']?>"  >
    <input type="hidden" id="sch_work_days"  value="<?=$sview['wt_work_days']?>"  >
    <input type="hidden" id="sch_fwd_ment_idx"  value="<?=$sview['wt_fwd_ment_idx']?>"  >
    <input type="hidden" id="sch_rcv_ment_idx"  value="<?=$sview['wt_rcv_ment_idx']?>"  >
    <input type="hidden" id="sch_end_ment_idx"  value="<?=$sview['wt_end_ment_idx']?>"  >

    <input type="hidden" id="sch_fwd_ment_name"  value="<?=$sview['wt_fwd_ment_name']?>"  >
    <input type="hidden" id="sch_rcv_ment_name"  value="<?=$sview['wt_rcv_ment_name']?>"  >
    <input type="hidden" id="sch_end_ment_name"  value="<?=$sview['wt_end_ment_name']?>"  >

    <!-- 학교 점심시간 -->
    <input type="hidden" id="sch_lunch_start_time"  value="<?=$sview['wt_lunch_start_time']?>"  >
    <input type="hidden" id="sch_lunch_end_time"  value="<?=$sview['wt_lunch_end_time']?>"  >
    <input type="hidden" id="sch_lunch_ment_idx"  value="<?=$sview['wt_lunch_ment_idx']?>"  >
    <input type="hidden" id="sch_lunch_ment_name"  value="<?=$sview['wt_lunch_ment_name']?>"  >

</form>


<form id="wtimeFrm" name="wtimeFrm" method="post" action=""  onsubmit="return formSubmit()" autocomplete="off">
    <input type="hidden" name="wt_no" id="wt_no"  value="<?=$view['wt_no']?>"  >

    <ul class="list-group list-group-flush">
        <li class="list-group-item h4">*학교 설정 정보</li>
        <li class="list-group-item bg-info pt-4 pb-4 text-light">

            <div class="row font-weight-bold">
                <div class="col-auto"><i class="fas fa-clock"></i> 업무시간 :  <span class="badge badge-danger badge-pill text-size-3 p-1"><?=$schWorktime?></span></div>
                <div class="col-auto"><i class="fas fa-calendar-day"></i> 업무 요일 : <?=$schWorkDaysName?></div>
                <div class="col-auto"><i class="fas fa-utensils"></i> 점심 시간 : <span class="badge badge-success badge-pill p-1 text-size-3"><?=$schLunchTime?></span></div>
            </div>


        </li>
        <li class="list-group-item small text-danger">*참고 : 아래화면에서 개인 업무시간 설정 추가시, 학교에서 설정된 시간보다 우선 적용됩니다. </li>
    </ul>

    <div>&nbsp;</div>

    <!-- 개인업무시간 설정   ------------------------------------------------------------------------->
    <ul class="list-group mb-4 mt-4">
        <li class="list-group-item  list-group-item-primary">
            <h4 class="d-inline-block"><i class="fas fa-user-clock"></i> 개인 업무시간 설정</h4>

            <span class="d-block d-md-inline">
            ( <a href="javascript:copyWorkTime()"><i class="fas fa-copy"></i> 학교설정 복사</a> )
            </span>

        </li>

        <li class="list-group-item">
            <div class="row">
                <div class="col-md-6">

                    <label for="wt_start_time">시작 시간</label>

                    <div class="input-group" >
                        <input type="text" name="wt_start_time" id="wt_start_time" class="form-control" required skipped   value="<?=$view['wt_start_time']?>" readonly  >
                        <div class="input-group-append">
                            <button class="btn btn-secondary" id="btn_start_time" type="button">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">

                    <label for="wt_end_time">종료 시간</label>

                    <div class="input-group">
                        <input type="text" name="wt_end_time" id="wt_end_time" class="form-control"  required skipped   value="<?=$view['wt_end_time']?>" readonly   >
                        <div class="input-group-append">
                            <button class="btn btn-secondary"  id="btn_end_time" type="button">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </li>


        <li class="list-group-item">
            <div class="for-row">
                <div class="col-auto">
                    업무 요일 선택
                </div>
                <div class="col-auto">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="work_days[]" id="work_day1"  <?=(in_array("1",$view['work_days']))?"checked":"";?> value="1">
                        <label class="form-check-label" for="work_day1">월</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="work_days[]"  id="work_day2" <?=(in_array("2",$view['work_days']))?"checked":"";?>  value="2">
                        <label class="form-check-label" for="work_day2">화</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="work_days[]"  id="work_day3" <?=(in_array("3",$view['work_days']))?"checked":"";?>  value="3">
                        <label class="form-check-label" for="work_day3">수</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="work_days[]"  id="work_day4"  <?=(in_array("4",$view['work_days']))?"checked":"";?> value="4">
                        <label class="form-check-label" for="work_day4">목</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="work_days[]"  id="work_day5" <?=(in_array("5",$view['work_days']))?"checked":"";?>  value="5">
                        <label class="form-check-label" for="work_day5">금</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="work_days[]"  id="work_day6" <?=(in_array("6",$view['work_days']))?"checked":"";?>  value="6">
                        <label class="form-check-label" for="work_day6">토</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="work_days[]"  id="work_day0" <?=(in_array("0",$view['work_days']))?"checked":"";?>  value="0">
                        <label class="form-check-label" for="work_day0">일</label>
                    </div>


                </div>
            </div>

        </li>


        <li class="list-group-item">
            <div class="row">
                <div class="col-md-6">

                    <label for="wt_fwd_ment_name">통화대기 안내멘트</label>

                    <div class="input-group">
                        <input type="hidden" name="wt_fwd_ment_idx" id="wt_fwd_ment_idx" class="form-control "  value="<?=$view['wt_fwd_ment_idx']?>"  >
                        <input type="text" name="wt_fwd_ment_name" id="wt_fwd_ment_name" class="form-control"  required skipped  value="<?=$view['wt_fwd_ment_name']?>" readonly >
                        <div class="input-group-append">
                            <button class="btn btn-secondary" id="btn_fwd_ment" type="button">
                                <i class="far fa-window-restore"></i>
                            </button>
                        </div>
                    </div>
                    <small class="text-info">*전화를  거는 발신자에게 통화 전(대기중) 안내멘트가 제공됩니다. </small>
                </div>


                <div class="col-md-6">
                    <label for="wt_rcv_ment_name">통화연결 안내멘트</label>

                    <div class="input-group">
                        <input type="hidden" name="wt_rcv_ment_idx" id="wt_rcv_ment_idx" class="form-control "  value="<?=$view['wt_rcv_ment_idx']?>"  >
                        <input type="text" name="wt_rcv_ment_name" id="wt_rcv_ment_name" class="form-control"  required skipped   value="<?=$view['wt_rcv_ment_name']?>" readonly >
                        <div class="input-group-append">
                            <button class="btn btn-secondary" id="btn_rcv_ment" type="button">
                                <i class="far fa-window-restore"></i>
                            </button>
                        </div>
                    </div>
                    <small class="text-info">*전화를  받는 수신자 즉, 교사에게 안내멘트가 제공됩니다. </small>
                </div>

            </div>
        </li>


        <li class="list-group-item">
            <div class="row">
                <div class="col-md-6">

                    <label for="wt_end_ment_name">종료 안내멘트</label>

                    <div class="input-group">
                        <input type="hidden" name="wt_end_ment_idx" id="wt_end_ment_idx" class="form-control "  value="<?=$view['wt_end_ment_idx']?>"  >
                        <input type="text" name="wt_end_ment_name" id="wt_end_ment_name" class="form-control"  required skipped  value="<?=$view['wt_end_ment_name']?>" readonly >
                        <div class="input-group-append">
                            <button class="btn btn-secondary" id="btn_end_ment" type="button">
                                <i class="far fa-window-restore"></i>
                            </button>
                        </div>
                    </div>
                    <small class="text-info">*업무시간 종료시 전화를  거는 발신자에게  안내멘트가 제공됩니다. </small>
                </div>

        </li>

    </ul>


    <!-- 휴식시간 -------------------------------------------------------->
    <ul class="list-group mb-4">

        <li class="list-group-item  list-group-item-warning">
            <h4 class="d-inline-block"><i class="fas fa-utensils"></i> 점심시간 설정 [*선택]</h4>

            <span class="d-block d-md-inline">
            ( <a href="javascript:copyLunchTime()"><i class="fas fa-copy"></i> 학교설정 복사</a> )
            </span>

        </li>

        <li class="list-group-item">
            <div class="row">
                <div class="col-md-6">

                    <label for="wt_lunch_start_time">시작 시간</label>

                    <div class="input-group">
                        <input type="text" name="wt_lunch_start_time" id="wt_lunch_start_time" class="form-control" value="<?=$view['wt_lunch_start_time']?>" readonly  maxlength="10" >
                        <div class="input-group-append">
                            <button class="btn btn-secondary" id="btn_lunch_start_time" type="button">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <label for="wt_lunch_end_time">종료 시간</label>

                    <div class="input-group">
                        <input type="text" name="wt_lunch_end_time" id="wt_lunch_end_time" class="form-control"  value="<?=$view['wt_lunch_end_time']?>" readonly  maxlength="10" >
                        <div class="input-group-append">
                            <button class="btn btn-secondary" id="btn_lunch_end_time" type="button">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </li>

        <li class="list-group-item">
            <div class="row">
                <div class="col-md-6">

                    <label for="wt_lunch_ment_name">점심시간(통화대기) 안내멘트</label>

                    <div class="input-group">
                        <input type="hidden" name="wt_lunch_ment_idx" id="wt_lunch_ment_idx" class="form-control "  value="<?=trim($view['wt_lunch_ment_idx'])?>"  >
                        <input type="text" name="wt_lunch_ment_name" id="wt_lunch_ment_name" class="form-control"    value="<?=trim($view['wt_lunch_ment_name'])?>" readonly >
                        <div class="input-group-append">
                            <button class="btn btn-secondary" id="btn_lunch_ment" type="button">
                                <i class="far fa-window-restore"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="btn_lunch_reset"> 기타</label>
                    <button type="button" id="btn_lunch_reset"  class="form-control btn btn-sm btn-secondary"><i class="fas fa-sync-alt"></i> 점심시간 설정 리셋</button>
                </div>

        </li>
    </ul>


    <div class='d-flex justify-content-center'>

            <button type="button" id="btn_delete_setting" class="btn  btn-danger <?=(!$view['wt_no'])?"d-none":""?> " >설정 삭제하기</button>
            &nbsp;


        <button type="submit" class="btn  btn-primary" >개인설정 저장하기</button>

    </div>

</form>

</section>

<div>&nbsp;</div>


<!-- 모달 영역 MODAL AREA    {   ######################################################################################################################  -->
<div class="modal" id="mentModal">
    <form id="modalFrm" name="modalFrm"  method="post" action="">
        <input type="hidden" name="product_amt" id="product_amt" value="" >
        <input type="hidden" name="product_nm" id="product_nm" value="" >


        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-secondary text-light">
                    <h5 class="modal-title">
                        <i class='fas fa-info-circle'></i>
                        멘트 선택하기
                    </h5>
                    <button type="button" class="close text-light" data-dismiss="modal"><i class="fas fa-window-close" style="font-size:20px;"></i></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <!-- start card class -->
                    <div class="card m-2">
                        <div class="card-header text-danger">
                            *발신 멘트 목록
                        </div>
                        <div class="card-body">


                            <div class="row p-2">

                                <select name="modal_ment_idx" id="modal_ment_idx"></select>

                            </div>

                        </div>



                    </div>
                    <!-- end card class -->

                </div>



                <div class="modal-footer">
                    <a  href="./member_ment_list.php" class="btn btn-sm btn-secondary text-light" ><i class="fas fa-paperclip"></i> 멘트설정 이동하기</a>
                    <button type="button" id="btn_ment_choose" class="btn btn-sm btn-primary" data-dismiss="modal">설정하기</button>
                </div>


            </div>
        </div>




    </form>
</div>
<!--    }      모달 영역 MODAL AREA      ######################################################################################################   -->



<script>


    var IS_REQUEST=false;


    $(function() {

        $('#btn_lunch_reset').click(function(){
            $('#wt_lunch_start_time').val('');
            $('#wt_lunch_end_time').val('');
            $('#wt_lunch_ment_idx').val('');
            $('#wt_lunch_ment_name').val('');
        });

        // 업무시작시간
        $('#wt_start_time').bootstrapMaterialDatePicker({ date: false ,  format : 'HH:mm'});

        $('#btn_start_time').bootstrapMaterialDatePicker({ date: false , format : 'HH:mm'})
        .on('open', function(e, date){
                if($('#wt_start_time').val().length > 0)
                    $('#btn_start_time').bootstrapMaterialDatePicker('setDate', $('#wt_start_time').val());
        })
        .on('change', function(e, date){
            // date is moment object ㅡㅡ;
            $('#wt_start_time').val(date.format("HH:mm"));

        });


        //업무종료시간
        $('#wt_end_time').bootstrapMaterialDatePicker({ date: false ,  format : 'HH:mm'});

        $('#btn_end_time').bootstrapMaterialDatePicker({ date: false , format : 'HH:mm'})
            .on('open', function(e, date){
                if($('#wt_end_time').val().length > 0)
                    $('#btn_end_time').bootstrapMaterialDatePicker('setDate', $('#wt_end_time').val());
            })
            .on('change', function(e, date){
                // date is moment object ㅡㅡ;
                $('#wt_end_time').val(date.format("HH:mm"));
            });


        // 점심 시작시간
        $('#wt_lunch_start_time').bootstrapMaterialDatePicker({ date: false ,  format : 'HH:mm'});

        $('#btn_lunch_start_time').bootstrapMaterialDatePicker({ date: false , format : 'HH:mm'})
            .on('open', function(e, date){
                if($('#wt_lunch_start_time').val().length > 0)
                    $('#btn_lunch_start_time').bootstrapMaterialDatePicker('setDate', $('#wt_lunch_start_time').val());
            })
            .on('change', function(e, date){
                // date is moment object ㅡㅡ;
                $('#wt_lunch_start_time').val(date.format("HH:mm"));

            });

        //점심 종료시간
        $('#wt_lunch_end_time').bootstrapMaterialDatePicker({ date: false ,  format : 'HH:mm'});

        $('#btn_lunch_end_time').bootstrapMaterialDatePicker({ date: false , format : 'HH:mm'})
            .on('open', function(e, date){
                if($('#wt_lunch_end_time').val().length > 0)
                    $('#btn_lunch_end_time').bootstrapMaterialDatePicker('setDate', $('#wt_lunch_end_time').val());
            })
            .on('change', function(e, date){
                // date is moment object ㅡㅡ;
                $('#wt_lunch_end_time').val(date.format("HH:mm"));

            });


        //멘트 선택창 호출
        $('#wt_fwd_ment_name, #btn_fwd_ment').click(function(){
            showMentModal(0,$('#wt_fwd_ment_idx'),$('#wt_fwd_ment_name'));
        })
        $('#wt_rcv_ment_name, #btn_rcv_ment').click(function(){
            showMentModal(1,$('#wt_rcv_ment_idx'),$('#wt_rcv_ment_name'));
        })
        $('#wt_end_ment_name, #btn_end_ment').click(function(){
            showMentModal(0,$('#wt_end_ment_idx'),$('#wt_end_ment_name'));
        })

        $('#wt_lunch_ment_name, #btn_lunch_ment').click(function(){
            showMentModal(0,$('#wt_lunch_ment_idx'),$('#wt_lunch_ment_name'));
        })

        //개인 설정 삭제요청
        $('#btn_delete_setting').click(deleteWorkTime);

    });  //end func__-------



    function formSubmit(){

        if(IS_REQUEST){
            alert('처리 중입니다. 잠시 후 시도하세요.');
            return false;
        }

        //업부시간 체크
        var sdate = moment($('#wt_start_time').val(),'hh:mm');
        var edate = moment($('#wt_end_time').val(),'hh:mm');


        var diffMin = moment.duration(edate.diff(sdate)).asMinutes();

        if (diffMin < 0) {
            alert("업무 시작시간 ~ 종료시간을 바르게 입력하세요.");
            return false;
        }



        // 업무요일
        var chkLen = $('input:checkbox[name="work_days[]"]:checked').length;

        if(chkLen == 0){
            alert('요일을 하나이상 선택하세요.');
            return false;
        }


        //점심시간 체크
        var lstart = $('#wt_lunch_start_time').val().trim();
        var lend =  $('#wt_lunch_end_time').val().trim();
        var lment = $('#wt_lunch_ment_idx').val().trim();

//        console.log(lstart.length);
//        console.log(lend.length);
//        console.log(lment.length);

        if(lstart.length > 0 || lend.length > 0 || lment.length > 0) {
             if(lstart.length == 0 || lend.length == 0 || lment.length == 0) {
                 alert('점심시간 정보를 모두 바르게 입력하세요. ');
                $('#wt_lunch_ment_name').focus();
                return false;

            } else {

                 //점심시간 체크
                 var lsdate = moment($('#wt_lunch_start_time').val(),'hh:mm');
                 var ledate = moment($('#wt_lunch_end_time').val(),'hh:mm');


                 var ldiffMin = moment.duration(ledate.diff(lsdate)).asMinutes();

                 if (ldiffMin < 0) {
                     alert("점심 시작시간 ~ 종료시간을 바르게 입력하세요.");
                     return false;
                 }

            }

        }

        IS_REQUEST=true;
        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.member_worktime_update.php"
        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:$('#wtimeFrm').serialize(),
            success:function(data) {

               //  console.log(data);
                IS_REQUEST=false;

                var obj = data.result_obj;

                var result = data.result_stat;
                if(result){

                    alert(data.result_msg);
                    $('#btn_delete_setting').removeClass("d-none").show();
                } else {
                    alert(data.result_msg);
                }


            },error : function(xhr, status, error) {
                IS_REQUEST=false;
                alert("업무시간 수정시 오류가 발생했습니다. ("+error+")");
            }
        }); //end ajax func ====

        return false;

    } //end func ===========================================================




    //업무시간 삭제 요청함수 ///////////////////////////////////////
    function deleteWorkTime(){

        if(IS_REQUEST){
            alert('처리 중입니다. 잠시 후 시도하세요.');
            return false;
        }

        var cf = confirm('개인 업무시간 설정을 삭제하시겠습니까? \n (*삭제 후 학교단체에서 설정된 시간을 기준으로 서비스됩니다. ) ');
        if(!cf)
            return false;


        var wtNo = $('#wt_no').val();

        IS_REQUEST=true;
        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.member_worktime_delete.php"
        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:{
               'wt_no':wtNo
            },
            success:function(data) {
                IS_REQUEST=false;
                var obj = data.result_obj;
                var result = data.result_stat;
                if(result){
                    alert(data.result_msg);
                    $('#btn_delete_setting').hide();
                    $('#wtimeFrm')[0].reset();
                } else {
                    alert('*삭제 오류 : \n'+data.result_msg);
                }


            },error : function(xhr, status, error) {
                IS_REQUEST=false;
                alert("업무시간 삭제시 오류가 발생했습니다. ("+error+")");
            }
        }); //end ajax func ====

    }



    //학교 > 개인업무시간 복사
    function copyWorkTime(){
        $('#wt_start_time').val($('#sch_start_time').val());
        $('#wt_end_time').val($('#sch_end_time').val());

        var workDays = $('#sch_work_days').val().split(','); // 예) 1,2,3,4,5

        workDays.forEach(function (item, index, array) {
            $('input:checkbox[name="work_days[]"]').each(function() {
                        if(item == $(this).val())
                            this.checked = true;
            });
        });

        $('#wt_fwd_ment_idx').val($('#sch_fwd_ment_idx').val());
        $('#wt_rcv_ment_idx').val($('#sch_rcv_ment_idx').val());
        $('#wt_end_ment_idx').val($('#sch_end_ment_idx').val());

        $('#wt_fwd_ment_name').val($('#sch_fwd_ment_name').val());
        $('#wt_rcv_ment_name').val($('#sch_rcv_ment_name').val());
        $('#wt_end_ment_name').val($('#sch_end_ment_name').val());



    } // end func ============================================================


    //학교 > 점심시간 복사
    function copyLunchTime(){
        $('#wt_lunch_start_time').val($('#sch_lunch_start_time').val());
        $('#wt_lunch_end_time').val($('#sch_lunch_end_time').val());


        $('#wt_lunch_ment_idx').val($('#sch_lunch_ment_idx').val());
        $('#wt_lunch_ment_name').val($('#sch_lunch_ment_name').val());



    } // end func ============================================================



    // 멘트 선택창(modal) 호출 --------
    //type 0 발신, 1 착신
    function showMentModal(type,srcObj,trgObj){

        if(type == 0)
            $('.card-header').text("통화대기 멘트 목록");
        else
            $('.card-header').text("통화연결 멘트 목록");

        $.get("<?php echo G5_BBS_URL?>/ajax.call_ment_list.php",
            {
                'ment_type':type,
                'ment_idx':srcObj.val()
            },
            function(data){

                $('.card-body > div').html(data);

                $('#mentModal').modal();


                $('#modal_ment_idx').change(function(){
                    var selVal = $('#modal_ment_idx option:selected').val();
                    if(selVal.length>0){

                        srcObj.val(selVal);
                        trgObj.val($('#modal_ment_idx option:selected').text());
                        $('#mentModal').modal('hide');
                        srcObj=null;
                        trgObj=null;
                    }
                });

                $('#btn_ment_choose').click(function(){
                    var selVal = $('#modal_ment_idx option:selected').val();
                    if(selVal.length>0){
                        srcObj.val(selVal);
                        trgObj.val($('#modal_ment_idx option:selected').text());
                        $('#mentModal').modal('hide');
                        srcObj=null;
                        trgObj=null;

                    }
                });

            });

    } //end func ==============






</script>