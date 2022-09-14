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
    <form id="rtimeFrm" name="rtimeFrm" method="post" action="" onsubmit="return formSubmit()" autocomplete="off">
        <input type="hidden" name="rm_no" id="rm_no"   value="<?=$view['rm_no']?>"  >
        <input type="hidden" name="rm_idx" id="rm_idx"   value="<?=$view['rm_idx']?>"  >
        <!-- 안심번호 이용료   ---------------------------------------->
        <!--    <p class="regist-title">-->
        <!--        <i class="fas fa-info-circle"></i>  안심번호(050) 관리비-->
        <!--    </p>-->
        <ul class="list-group mb-4">
<!--            <li class="list-group-item  list-group-item-primary">-->
<!--                <h4><i class="fas fa-praying-hands"></i> 업무시간 설정</h4>-->
<!--            </li>-->

            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-6">

                        <label for="rm_name">구분 이름 (* 3~20자 . 한글+숫자)</label>

                        <input type="text" name="rm_name" id="rm_name" class="form-control hangulalnum" minlength="3" maxlength="20" required value="<?=$view['rm_name']?>"  >

                    </div>
                    <div class="col-md-6">



                        <!-- Group Button   -->
                        <label for="rm_stat">상태 </label>
                        <br>
                        <div id="rm_stat" class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">

                            <label class="btn btn-warning active">
                                <input type="radio" name="rm_stat" id="rm_stat_0" autocomplete="off" <?=($view['rm_stat']=="Y" || empty($view['rm_stat']))?"checked":""?> value="Y"> On
                            </label>

                            <label class="btn btn-warning">
                                <input type="radio" name="rm_stat" id="rm_stat_1" autocomplete="off" <?=($view['rm_stat']=="N")?"checked":""?> value="N"> Off
                            </label>

                        </div>

                    </div>


                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-6">

                        <label for="rm_start_time">시작 시간</label>

                        <div class="input-group" >
                            <input type="text" name="rm_start_time" id="rm_start_time" class="form-control"  readonly skipped  required value="<?=$view['rm_start_time']?>"   >
                            <div class="input-group-append">
                                <button class="btn btn-secondary" id="btn_start_time" type="button">
                                    <i class="fas fa-calendar-alt"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <label for="rm_end_time">종료 시간</label>

                        <div class="input-group">
                            <input type="text" name="rm_end_time" id="rm_end_time" class="form-control"  readonly skipped required  value="<?=$view['rm_end_time']?>"    >
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
                        요일 선택
                    </div>
                    <div class="col-auto">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="rm_days[]" id="work_day1" <?=(in_array("1",$view['rm_days_stack']))?"checked":"";?>  value="1">
                            <label class="form-check-label" for="work_day1">월</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="rm_days[]"  id="work_day2" <?=(in_array("2",$view['rm_days_stack']))?"checked":"";?>   value="2">
                            <label class="form-check-label" for="work_day2">화</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="rm_days[]"  id="work_day3" <?=(in_array("3",$view['rm_days_stack']))?"checked":"";?>   value="3">
                            <label class="form-check-label" for="work_day3">수</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="rm_days[]"  id="work_day4" <?=(in_array("4",$view['rm_days_stack']))?"checked":"";?>   value="4">
                            <label class="form-check-label" for="work_day4">목</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="rm_days[]"  id="work_day5" <?=(in_array("5",$view['rm_days_stack']))?"checked":"";?>   value="5">
                            <label class="form-check-label" for="work_day5">금</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="rm_days[]"  id="work_day6" <?=(in_array("6",$view['rm_days_stack']))?"checked":"";?>   value="6">
                            <label class="form-check-label" for="work_day6">토</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="rm_days[]"  id="work_day0" <?=(in_array("0",$view['rm_days_stack']))?"checked":"";?>   value="0">
                            <label class="form-check-label" for="work_day0">일</label>
                        </div>


                    </div>
                </div>

            </li>


            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-6">

                        <label for="rm_ment_name" class="msg_sound_only">안내 멘트(발신)</label>

                        <div class="input-group">
                            <input type="hidden" name="rm_ment_idx" id="rm_ment_idx" class="form-control "  value="<?=$view['rm_ment_idx']?>"  >
                            <input type="text" name="rm_ment_name" id="rm_ment_name" class="form-control " required skipped readonly value="<?=$view['rm_ment_name']?>" >
                            <div class="input-group-append">
                                <button class="btn btn-secondary" id="btn_ment" type="button">
                                    <i class="far fa-window-restore"></i>
                                </button>
                            </div>
                        </div>
                    </div>

            </li>

        </ul>


        <div class='d-flex justify-content-center'>
            <a href="<?=$list_href?>" class="btn  btn-secondary text-light">목록</a>
            <?php if($rm_no) { ?>

                &nbsp;
                <button type="button" id="btnDelete" class="btn btn-danger" >삭제</button>

            <?php } ?>

            &nbsp;
            <button type="submit" class="btn  btn-primary" ><?=(empty($rm_no))?"저장하기":"수정하기";?></button>
        </div>

    </form>

</section>


<div>&nbsp;</div>

<!-- 모달 영역 MODAL AREA    {   ###########################################################  -->
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
<!---->
<!--                        <div class="card-footer small text-center">-->
<!--                            * 참고 ) 멘트를 선택해 주세요.-->
<!--                        </div>-->


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
<!--    }      모달 영역 MODAL AREA      #######################################################   -->



<script>
    $(function() {



        // 업무시작시간
        $('#rm_start_time').bootstrapMaterialDatePicker({ date: false ,  format : 'HH:mm'});

        $('#btn_start_time').bootstrapMaterialDatePicker({ date: false , format : 'HH:mm'})
            .on('open', function(e, date){
                if($('#rm_start_time').val().length > 0)
                    $('#btn_start_time').bootstrapMaterialDatePicker('setDate', $('#rm_start_time').val());
            })
            .on('change', function(e, date){
                // date is moment object ㅡㅡ;
                $('#rm_start_time').val(date.format("HH:mm"));

            });


        //업무종료시간
        $('#rm_end_time').bootstrapMaterialDatePicker({ date: false ,  format : 'HH:mm'});

        $('#btn_end_time').bootstrapMaterialDatePicker({ date: false , format : 'HH:mm'})
            .on('open', function(e, date){
                if($('#rm_end_time').val().length > 0)
                    $('#btn_end_time').bootstrapMaterialDatePicker('setDate', $('#rm_end_time').val());
            })
            .on('change', function(e, date){
                // date is moment object ㅡㅡ;
                $('#rm_end_time').val(date.format("HH:mm"));
            });


        $('#rm_ment_name, #btn_ment').click(function(){
            showMentModal(0,$('#rm_ment_idx'),$('#rm_ment_name'));
        })




        /////////////////////////////////////////////////////////////////
        //form submit ________________________________________________________
        $('#rtimeFrm11').submit(function(e){
            e.preventDefault();
            // deprecated > wrest form validation 사용하기위해 form submit 방법 변경
        });


        $('#rm_stat :input').change(function(){

            var type = $(this).val();
            if(type == "Y"){
                $('#rm_stat > label').removeClass("btn-secondary").addClass("btn-warning");
            } else {
                $('#rm_stat > label').removeClass("btn-warning").addClass("btn-secondary");
            }
        });


        <?php if($view['rm_stat']=="Y" || empty($view['rm_stat'])) { ?>
             $('#rm_stat > label').removeClass("btn-secondary").addClass("btn-warning");
        <?php } else { ?>
             $('#rm_stat > label').removeClass("btn-warning").addClass("btn-secondary");
        <?php  } ?>


        $('#btnDelete').click(function(){
            deleteTime();
        });

    });  //end func__-------_________________________________



    function deleteTime(){

        var cf = confirm('해당 추가시간 설정을 삭제하시겠습니까? ');
        if(!cf)
            return false;


        var rmNo = $('#rm_no').val();
        var rmIdx = $('#rm_idx').val();


        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.member_resttime_delete.php"
        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:{
                'rm_no':rmNo,
                'rm_idx':rmIdx
            },
            success:function(data) {

                console.log(data);

                var obj = data.result_obj;
                var result = data.result_stat;
                if(result){
                    alert(data.result_msg);
                    location.href='./member_resttime_list.php';
                } else {
                    alert('*삭제 실패 : \n'+data.result_msg);
                }


            },error : function(xhr, status, error) {
                alert("추가시간 삭제시 오류가 발생했습니다. ("+error+")");
            }
        }); //end ajax func ====

    }



    function formSubmit(){

        //시간 체크
        var sdate = moment($('#rm_start_time').val(),'hh:mm');
        var edate = moment($('#rm_end_time').val(),'hh:mm');


        var diffMin = moment.duration(edate.diff(sdate)).asMinutes();

        if (diffMin < 0) {
            alert("추가 시작시간 ~ 종료시간을 바르게 입력하세요.");
            return false;
        }

        //요일체크
         var chkLen = $('input:checkbox[name="rm_days[]"]:checked').length;

        if(chkLen == 0){
            alert('요일을 하나이상 선택하세요.');
            return false;
        }


        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.member_resttime_update.php"

        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:$('#rtimeFrm').serialize(),
            success:function(data) {

                // console.log(data);
                var obj = data.result_obj;

                var result = data.result_stat;
                if(result){
                    alert(data.result_msg);
                    location.href="./member_resttime_list.php";
                } else {
                    alert('*설정 실패 : \n'+data.result_msg);
                }


            },error : function(xhr, status, error) {
                alert("추가시간 설정시 오류가 발생했습니다. ("+error+")");
            }
        }); //end ajax func ====



        return false;

    }


    // 멘트 선택창(modal) 호출 --------
    //type 0 발신, 1 착신
    function showMentModal(type,srcObj,trgObj){

        if(type == 0)
            $('.card-header').text("발신 멘트 목록");
        else
            $('.card-header').text("착신 멘트 목록");

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
                        srcObj = null;
                        trgObj = null;
                    }
                });

                $('#btn_ment_choose').click(function(){
                    var selVal = $('#modal_ment_idx option:selected').val();
                    if(selVal.length>0){
                        srcObj.val(selVal);
                        trgObj.val($('#modal_ment_idx option:selected').text());
                        $('#mentModal').modal('hide');
                        srcObj = null;
                        trgObj = null;
                    }
                });

            });

    } //end func ==============








</script>