<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
add_javascript('<script src="'.G5_JS_URL.'/tlog.js?vs='.time().'"></script>', 1);
//exitVarDump($safety_config);
?>

<!-- 회원정보 입력/수정 시작 { -->
<script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>


<div class="container mb-4">
    <div class="regist-form">
        <div class="section-header page">
            <h3><?php echo $g5['title']?> </h3>
        </div>

        <form id="fregisterform" name="fregisterform" action="<?php echo $action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="w" value="<?php echo $w ?>">
            <input type="hidden" name="url" value="<?php echo $urlencode ?>">
            <input type="hidden" name="agree" value="<?php echo $agree ?>">
            <input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
            <input type="hidden" name="cert_type" value="<?php echo $mem['mb_certify']; ?>">
            <input type="hidden" name="cert_no" value="">
            <input type="hidden" name="mb_grp_no" id="mb_grp_no" value="<?php echo $member['mb_1']; ?>"> <!-- grp no -->
            <input type="hidden" name="old_email" value="<?php echo $mem['mb_email'] ?>">
            <input type="hidden" name="mb_email" id="mb_email" value="<?php echo $mem['mb_email']; ?>">


            <!-- bylee -->
            <input type="hidden" name="prev_mb_hp" id="prev_mb_hp" value="<?php echo $mem["mb_hp"]?>">

            <?php if (isset($mem['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $mem['mb_sex'] ?>"><?php }  ?>
            <?php if (isset($mem['mb_nick_date']) && $mem['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($gconfig['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면  ?>
                <input type="hidden" name="mb_nick_default" value="<?php echo get_text($mem['mb_nick']) ?>">
                <input type="hidden" name="mb_nick" value="<?php echo get_text($mem['mb_nick']) ?>">
            <?php }  ?>

            <div id="register_form"  class="form_01">
                <div>
                    <p class="regist-title"><i class="fa fa-edit"></i> 사이트 이용정보 입력
                        <?php if($lastInsMember) echo"<span class='text-danger'>{ * 마지막 입력 : $lastInsMember } <span>";?></p>
                    <ul class="list-group mb-4">
                        <li class="list-group-item">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="reg_mb_id" class="sound_only">아이디<strong>필수</strong></label>
                                        <input type="text" name="mb_id" value="<?php echo $mem['mb_id'] ?>" id="reg_mb_id"  required <?php echo $required ?> <?php echo $readonly ?> class="form-control font-weight-bold <?php echo $required ?>" minlength="12" maxlength="20" placeholder="*아이디">

                                    </div>
                                    <div class="col-12 col-md-6">
                                        <?php if($w==''){ ?>
                                            <button type="button" id="btnGenNumber" name="btnGenNumber" class="btn btn-warning btn_frmline text-bold" onclick="">안심번호 생성</button>
                                        <?php } ?>
                                    </div>
                                    <div class="col-12">
                                        <!--                                        <small id="emailHelp" class="form-text text-muted">영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.</small>-->
                                        <?php if($w==""){ ?>
                                            <small id="mbidHelp" class="form-text text-info">*교직원 아이디는 050으로 시작되는 안심번호를 이용하며, 우측 버튼을 이용해서 생성하세요. </small>
                                        <?php } else { ?>
                                            <small id="mbidHelp" class="form-text text-info">*교직원 아이디는 050으로 시작되는 안심번호를 이용합니다.  </small>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="reg_mb_password" class="sound_only">비밀번호<strong class="sound_only">필수</strong></label>
                                        <input type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?> class="form-control <?php echo $required ?>" minlength="3" maxlength="20" placeholder="*비밀번호">
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="reg_mb_password_re" class="sound_only">비밀번호 확인<strong>필수</strong></label>
                                        <input type="password" name="mb_password_re" id="reg_mb_password_re" <?php echo $required ?> class="form-control <?php echo $required ?>" minlength="3" maxlength="20" placeholder="*비밀번호 확인">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>





                <div class="tbl_frm01 tbl_wrap">
                    <p class="regist-title"><i class="fa fa-edit"></i> 개인정보 입력</p>

                    <ul class="list-group mb-4">
                        <li class="list-group-item">

                            <div class="row">

                                <div class="col-lg-6 ">
                                    <div class="form-group">
                                        <label for="reg_mb_name" class="sound_only">*이름<strong>필수</strong></label>
                                        <input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($mem['mb_name']) ?>" <?php echo $required ?> class="form-control frm_input half_input <?php echo $required ?>" size="10" placeholder="*이름" onblur="this.value = this.value.trim()">

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group form-inline">
                                        <input type="text" class="form-control readonly" readonly id="mb_call_point" name="mb_call_point" value="발신 포인트 : <?php echo number_format($mem['mb_call_point']);?>원 ">
                                        <?php if($use_tnms) { ?>
                                            &nbsp;
                                            <button id="btnPointTrans" type="button" class="btn btn-warning" ><i class="fas fa-donate"></i> 이체하기</button>
                                        <?php }?>
                                    </div>
                                </div>

                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="reg_mb_9" class="sound_only">직책</label>
                                        <input type="text" name="mb_9" value="<?php echo get_text($mem['mb_9']) ?>" id="reg_mb_9" class="form-control frm_input half_input" maxlength="20" placeholder="직책">

                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <button id="btnApp1" type="button" class="btn btn-secondary"><i class="fas fa-mouse"></i> 교사</button>
                                    <button id="btnApp2" type="button" class="btn btn-secondary"><i class="fas fa-mouse"></i> 교감</button>
                                    <button id="btnApp3" type="button" class="btn btn-secondary"><i class="fas fa-mouse"></i> 교장</button>
                                </div>
                            </div>
                        </li>

                        <!--
                        <li class="list-group-item">
                            <div class="form-group">
                                <label for="reg_mb_email" class="sound_only">-Email<strong>필수</strong></label>
                                <input type="hidden" name="old_email" value="<?php echo $mem['mb_email'] ?>">
                                <input type="email" name="mb_email" value="<?php echo isset($mem['mb_email'])?$mem['mb_email']:''; ?>" id="reg_mb_email" required class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="*E-email">
                            </div>
                        </li>

                        -->

                        <li class="list-group-item">

                            <div class="row">
                                <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="reg_mb_2" class="sound_only">문자 회신번호</label>
                                    <input type="text" name="mb_2" value="<?php echo get_text($mem['mb_2']) ?>" id="reg_mb_2" class="form-control frm_input half_input numeric" maxlength="20" placeholder="문자 회신번호">
                                    <div class="text-danger mt-1 ml-3 small" role="alert">
                                        * 각 반에 있는 일반 전화번호를 입력해주세요. &nbsp; 미입력시 <span class="alert-link">학교 대표 번호</span>로 문자 발송처리되므로, 교무실로 전화가 집중 될 수 있습니다.
                                        <br>  <small>(* '-' 제외 숫자만 입력, 050 안심번호 및 010 휴대폰번호는 회신번호로 사용불가능 합니다. )</small>

                                    </div>
                                </div>
                                </div>

                                <!-- 발신 전화번호 -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="reg_call_mapping_number" class="sound_only">발신 전화번호</label>
                                        <input type="text" name="mb_call_mapping_number" value="<?php echo get_text($mem['mb_call_mapping_number']) ?>" id="reg_call_mapping_number" class="form-control frm_input half_input numeric" maxlength="20" placeholder="발신 전화번호">
                                        <div class="text-danger mt-1 ml-3 small" role="alert">
                                            * 발신번호 변조서비스를 이용해서 통화시 고객에게 보여지는 전화번호를 입력하는곳입니다.
                                            <small> (* '-' 제외 숫자만 입력, 050 안심번호 및 010 휴대폰번호는 발신번호로 사용불가능 합니다. )</small>

                                        </div>
                                    </div>
                                </div>
                            </div>



                </div>



                        </li>



                        <li class="list-group-item">
                            <div class="form-group">
                                <label for="reg_mb_hp" class="sound_only">*휴대폰번호<?php if ($gconfig['gm_req_hp']) { ?><strong>필수</strong><?php } ?></label>

                                <input type="text" name="mb_hp" value="<?php echo $mem['mb_hp'] ?>" id="reg_mb_hp" <?php echo ($gconfig['gm_req_hp'])?"required":""; ?> class="form-control font-weight-bold frm_input right_input half_input numeric <?php echo ($gconfig['gm_req_hp'])?"required":""; ?>" onblur="this.value = this.value.replace(/[- ._]/gi,'')"  maxlength="20" placeholder="*휴대폰번호">

                                <div class="text-danger mt-1 ml-3 small" role="alert">
                                    *  050 안심번호는 해당 휴대폰번호로 착신처리됩니다. ('-' 제외 숫자만 입력)
                                </div>

                            </div>


                        </li>




                        <?php if ($gconfig['gm_use_addr']) { ?>
                            <li class="list-group-item">
                                <div class="form-group">
                                    <?php if ($gconfig['cf_req_addr']) { ?><strong class="sound_only">필수</strong><?php }  ?>
                                    <label for="reg_mb_zip" class="sound_only">우편번호<?php echo $gconfig['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
                                    <input type="text" name="mb_zip" value="<?php echo $mem['mb_zip1'].$mem['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $gconfig['cf_req_addr']?"required":""; ?> class="frm_input <?php echo $gconfig['cf_req_addr']?"required":""; ?>" size="5" maxlength="6"  placeholder="우편번호">
                                    <button type="button" class="btn_frmline" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button><br>
                                    <input type="text" name="mb_addr1" value="<?php echo get_text($mem['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $gconfig['cf_req_addr']?"required":""; ?> class="form-control frm_input frm_address full_input <?php echo $gconfig['cf_req_addr']?"required":""; ?>" size="50"  placeholder="기본주소">
                                    <label for="reg_mb_addr1" class="sound_only">기본주소<?php echo $gconfig['cf_req_addr']?'<strong> 필수</strong>':''; ?></label><br>
                                    <input type="text" name="mb_addr2" value="<?php echo get_text($mem['mb_addr2']) ?>" id="reg_mb_addr2" class="form-control frm_input frm_address full_input" size="50"  placeholder="상세주소">
                                    <label for="reg_mb_addr2" class="sound_only">상세주소</label>
                                    <br>
                                    <input type="text" name="mb_addr3" value="<?php echo get_text($mem['mb_addr3']) ?>" id="reg_mb_addr3" class="form-control frm_input frm_address full_input" size="50" readonly="readonly"  placeholder="참고항목">
                                    <label for="reg_mb_addr3" class="sound_only">참고항목</label>
                                    <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($mem['mb_addr_jibeon']); ?>">
                                </div>
                            </li>
                        <?php }  ?>
                    </ul>
                </div>


                <!--                <p class="regist-title"><i class="fa fa-edit"></i> 기타 개인설정</p>-->


                <!--                </ul>-->

            </div>
            <div class="btn_confirm btn_box">
                <a href="<?php echo $list_href ?>" class="btn btn-secondary">취소(목록)</a>
                <?php if(!$mem["mb_leave_date"]){ ?>
                    <input type="submit"   value="<?php echo $w==''?'회원 추가':'회원 정보수정'; ?>" id="btn_submit" class="btn btn-primary" accesskey="s">
                <?php } ?>

                <?php if($is_admin) { ?>
                    <input type="button"   value="안심번호 재등록" id="btn_call_reg" class="btn btn-warning" >

                    <input type="button"   value="안심번호 수정" id="btn_call_mody" class="btn btn-warning" >



                    <input type="button"   value="안심번호 체크" id="btn_call_chk" class="btn btn-warning" >

                <?php } ?>

            </div>
        </form>

    </div>
</div>


<!--모달 영역 MODAL AREA    {   ###########################################################  -->
<div class="modal" id="pointTransModal">
    <form id="transForm" name="transForm"  method="post" action="">
        <input type="hidden" name="trans_mgr_uid" value="<?php echo $member['mb_id']?>" >
        <input type="hidden"  id="trans_send_uid"   name="trans_send_uid"  value="<?php echo $mem['mb_id']?>">
        <input type="hidden"  id="trans_sendable_point"   name="trans_sendable_point"  value="<?php echo $mem['mb_call_point']?>">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-success text-light">
                <h5 class="modal-title">
                    <i class='fas fa-info-circle'></i>
                    <?php echo $mem['mb_name']?>님 이체하기
                </h5>
                <button type="button" class="close text-light" data-dismiss="modal"><i class="fas fa-window-close" style="font-size:20px;"></i></button>
            </div>



            <!-- Modal body -->
            <div class="modal-body">

                <div id="echo_sendable_point" class="alert alert-danger text-center mt-2 mb-4 ml-2 mr-2 p-1">
                    *이체 가능 포인트 : <strong><?php echo number_format($mem['mb_call_point'])?>원</strong>
                </div>



                <div class="card m-2">
                    <div class="card-header text-danger">*이체 정보 입력</div>
                    <div class="card-body">


                        <div class="row">

                            <div class="col-12 ">
                                <div class="form-group">
                                    <label for="trans_uid" >*수신 회원 아이디</label>
                                    <span id="area_recv_uid"></span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="trans_point" >*이체 포인트 </label><button type="button" id="btnAllPoint" class="btn btn-sm btn-danger m-1">*전체 금액 입력</button>
                                    <input type="number" class="form-control text-right" required name="trans_point" id="trans_point"  value="0">
                                </div>
                            </div>

                        </div>


                    </div>
                </div> <!-- end card class -->



                <div class="alert text-center m-2 p-1">
                    * 참고 : 이체 후 복구 불가능하니, 주의해서 이체하세요.
                </div>
            </div>



            <div class="modal-footer">

                <button type="submit" class="btn btn-sm btn-warning" >이체하기</button>

                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">닫기</button>
            </div>


        </div>
    </div>

    </form>
</div>

<!--    }      모달 영역 MODAL AREA      #######################################################   -->



<script>

    var requestCnt = 0; // 방어코드 전역변수
    var isSubmit=false;
    var numChkTimeout=null;
    //var tlogToken="<?php echo $member['mb_10']?>";
    TLOG_AGENCY_CODE="<?php echo $member['mb_10']?>"; //log.js predefined ___________


    //ondoc /onready ______________________________________________________
    $(function() {

        var object = get_info_of_IE();
        var browserName = object.name;
        var browserVersion = object.version;



        $('#btnApp1').click(function(){
            $('#reg_mb_9').val('교사');
            $('#reg_mb_hp').focus();
        });


        $('#btnApp2').click(function(){
            $('#reg_mb_9').val('교감');
            $('#reg_mb_hp').focus();
        });


        $('#btnApp3').click(function(){
            $('#reg_mb_9').val('교장');
            $('#reg_mb_hp').focus();
        });


        //console.log(object);
        ajaxBrowserCheck(true);


        if($('#reg_mb_id').val()){
            var tmpNumber = $('#reg_mb_id').val();
            $('#reg_mb_id').val(phone_format(tmpNumber));
        }

        $("#reg_zip_find").css("display", "inline-block");

        //번호 발급하기
        $('#btnGenNumber').click(function(){
            generateSafetyNumber($('#reg_mb_id'));
        });

        // 안심번호 등록(관리자)
        $('#btn_call_reg').click(function(){
            requestRegSafetyNumber(true);
        });

        //안심번호 체크
        $('#btn_call_chk').click(function(){
            requestCheckSafetyNumberAlert();
        });



        $('#btn_call_mody').click(function(){
            requestModSafetyNumber(true);
        });


        // 포인트 송금하기 > modal show
        $('#btnPointTrans').click(function(){
            showTransferPointDlg();
        });

        // 포인트 이체하기
        $('#transForm').submit(function(e){

            e.preventDefault();


            var transPoint = $('#trans_point').val();

            if(transPoint<=0){
                alert('이체 할 포인트를 바르게 입력하세요.');
                return false;
            }


            var targetName = $('#trans_recv_uid').find(':selected').text();

            var msg = "[ "+targetName + " ] 님에게 "+number_format(transPoint)+" 포인트를 이체 하시겠습니까? ";
            var cf = confirm(msg);
            if(!cf)
                return;

            transFormSubmit(this);

        });

        // 포인트 이체 창 > 전체금액 입력
        $('#btnAllPoint').click(function(){
           $('#trans_point').val($('#trans_sendable_point').val());
        });

    }); // on ready ___--------------------------------------------



    //콜포인트 이체하기 modal window______________________
    function showTransferPointDlg(){

        $.get("<?php echo G5_BBS_URL?>/ajax.mb_member_list.php",
            {'obj_name':'trans_recv_uid','expt_uid':$('#trans_send_uid').val()},
            function(data){
            $('#area_recv_uid').html(data);
        });

        $('#pointTransModal').modal();
    }


    // 이체하기
    function transFormSubmit(f){


        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.mb_transfer_point.php";

        $.ajax({
            method:"POST",
            dataType:"json",
            url:actionUrl,
            cache: false,
            data: $('#transForm').serialize(),
            success:function(data) {

                if(data.result_stat){

                    //modal window > 남은 포인트
                    $('#trans_sendable_point').val(data.result_point);
                    //modal window >  남은포인트 + 멘트
                    $('#echo_sendable_point').html("*이체 가능 포인트 : <strong>"+number_format(data.result_point)+"원</strong>")

                    // 회원 정보창
                    $('#mb_call_point').val("발신 포인트 : "+ number_format(data.result_point)+"원");

                    var msg = '[이체 성공] \n '+data.result_msg;
                    alert(msg);

                    $('#trans_point').val('0');
                    $('#pointTransModal').modal('hide');

                } else {
                    var msg = '[이체 실패] \n '+data.result_msg;
                    alert(msg);
                }

                //console.log(data);
            }
        });

    } //end func===== = == ==


    //
    // 안심번호 리스트 - 임시발급 s 상태를 다시 > r 대기상태로 변경  ///////////////////////////////////
    //
    function resetSafetyNumber(){



        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.safety_number_reset.php"
        var resetNUmber = $('#reg_mb_id').val().replace("-","");

        //console.log('*call reset : '+resetNUmber);

        if(numChkTimeout){
            // console.log("clear interval ");
            clearInterval(numChkTimeout);
        }


        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache: false,
            data:{"mb_id":"<?php echo $_SESSION['ss_mb_id']; ?>",
                "reset_number":resetNUmber},
            success:function(data) {
                /*
                 $('#reg_mb_id').prop('value','');
                 $('#btnGenNumber').show();
                 requestCnt=0;
                 */
                resetSubmitLayout();


            }
        });

    } //end func __------------


    function get_info_of_IE () {

        var word;
        var agent = navigator.userAgent.toLowerCase();

        var info = {  name: "N/A" , version: -1  };

        if ( navigator.appName == "Microsoft Internet Explorer" ){    // IE old version ( IE 10 or Lower )
            word = "msie ";
        }
        else if ( agent.search( "trident" ) > -1 ) word = "trident/.*rv:";    // IE 11
        else if ( agent.search( "edge/" ) > -1  ) word = "edge/";        // Microsoft Edge
        else  {
            return info;    // etc. ( If it's not IE or Edge )
        }


        var reg = new RegExp( word + "([0-9]{1,})(\\.{0,}[0-9]{0,1})" );

        if (  reg.exec( agent ) != null  ){

            info.version = parseFloat( RegExp.$1 + RegExp.$2 );

            info.name = ( word == "edge/" ) ? "Edge" : "IE";
        }

        return info;
    }




    function validateSafeNumber(safetyNumber){

        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.safety_number_validate.php"
        var grpNo = $('#mb_grp_no').val();
        // state : a : active,  e : expire
        var result = false;

        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            async:false,
            data:{"sn_grp_no":grpNo,
                "sn_number":safetyNumber
            },
            success:function(data) {

                //console.log(data);
                //result = false; //for debugging
                result = data.result_stat;


            },error : function(xhr, status, error) {
                result=false;
            }
        });


        return result;
    }


    // sync ajax . method________________________
    function updateSafetyNumber(updNumber,state,linkedNumber){
        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.safety_number_update.php"

        // state : a : active,  e : expire, m:modify 추가
        var result = false;

        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            async:false,
            data:{"mb_id":"<?php echo $_SESSION['ss_mb_id']; ?>",
                "upd_number":updNumber,
                "linked_number":linkedNumber,
                "upd_state":state},
            success:function(data) {
                //console.log(data);
                requestCnt++;
                result = data.result_stat;

            },error : function(xhr, status, error) {
                requestCnt++;
                result=false;
            }
        });

        return result;
    } //end func ____----------


    function requestCheckSafetyNumberAlert(){

        var safetyNumber = $("#reg_mb_id").val().trim().replace(/-/gi, "");



        var res1 = tlog_number_check(safetyNumber);
        //console.log(res1);


        if (!res1 || res1.Result != "1") {
            alert("안심번호 조회에 실패했습니다. ");
            return false;
        }



        //console.log(res1);

        var statusName = "";

        if(res1.Shop_Satus=="0")
            statusName="미사용";
        else if(res1.Shop_Satus=="1")
            statusName="사용중";
        else if(res1.Shop_Satus == "2")
            statusName="정지중";
        else if(res1.Shop_Satus == "3")
            statusName="해지중";


        if(res1.Shop_phone == "0") //미사용
            alert('* 050 안심번호 상태는 [ '+statusName+' ] 입니다.  ');
        else
            alert('* 현재 '+res1.Shop_phone+'과 연동된,  050 안심번호 상태는 [ '+statusName+' ] 입니다.  ');


    } //end method__________



    //
    // 기 등록된 050 번호 등록시 체크를 위해 사용
    // 즉 미할당되어있으면 오류 ㅡㅡ;
    function requestCheckSafetyNumber(){

        var safetyNumber = $("#reg_mb_id").val().trim().replace(/[- ]/gi, "");
        var safetyName = $('#reg_mb_name').val().trim().replace(/[- \.]/gi, "");
        var targetNumber = $('#reg_mb_hp').val().trim().replace(/[- \.]/gi, "");

        if(!safetyNumber || !safetyName || !targetNumber)
            return false;

        var res1 = tlog_number_check(safetyNumber);
        //console.log(res1);


        if (!res1 || res1.Result != "1") {
            alert("안심번호 조회에 실패했습니다. ");
            return false;
        }


        if(res1.Shop_Satus != "0"){ // 1 . 사용가능

            var statusName = "";
            if(res1.Shop_Satus=="1")
                statusName="사용중";
            else if(res1.Shop_Satus == "2")
                statusName="정지중";
            else if(res1.Shop_Satus == "3")
                statusName="해지중";


            alert('*오류 발생 : 현재 '+res1.Shop_phone+'과 연동된,  050 안심번호 상태는 [ '+statusName+' ] 입니다. \n 확인 바랍니다. ');

            return false;
        } else {
            return true;
        }


    }


    /// 안심번호 등록 요청 함수_________________________ -.- ___________
    function requestRegSafetyNumber(isAlert){ //params = boolean

        var safetyNumber = $("#reg_mb_id").val().trim().replace(/[- ]/gi, "");
        var safetyName = $('#reg_mb_name').val().trim().replace(/[- \.]/gi, "");
        var targetNumber = $('#reg_mb_hp').val().trim().replace(/[- \.]/gi, "");

        if(!safetyNumber || !safetyName || !targetNumber)
            return false;



        var isValid = validateSafeNumber(safetyNumber);
        if(!isValid){
            alert("*안심번호 등록시간이 만료되었습니다. 재시도하세요.");
            return false;
        }

        var res1 = tlog_number_assign(safetyNumber, safetyName, targetNumber);

        if (!res1 || res1.Result != "1") {
          //  alert("안심번호 등록에 실패했습니다. (1 / ErrorCode : "+res1.ErrCode+")");

            if(res1 && res1.hasOwnProperty("ErrCode")) {
                alert("안심번호 등록에 실패했습니다. (1 / 원인 :  "+tlog_get_error_msg(res.ErrCode)+" ) ");
            } else {
                alert("안심번호 등록에 실패했습니다. (1)");
            }

            return false;
        }



        // 멘트 활성화______________________________
        var res9 = tlog_number_member(safetyNumber);


        var res2 = updateSafetyNumber(safetyNumber, 'a',targetNumber);
        if (!res2) {
            alert("안심번호 수정에 실패했습니다. (2)");
            return false;
        }


        if(isAlert)
            alert('안심번호 등록처리 되었습니다. ');


        return true;

    }




    function requestExpSafetyNumber(){

        var safetyNumber = $("#reg_mb_id").val().trim().replace(/-/gi, "");
        if(!safetyNumber)
            return false;

        //var res1 = tlog_number_expire(safetyNumber);
        var res1 = tlog_number_hold(safetyNumber);

        if (!res1 || res1.Result != "1") {

            if(res1 && res1.hasOwnProperty("ErrCode")) {
                alert("안심번호 해제에 실패했습니다. (1 / 원인 :  "+tlog_get_error_msg(res.ErrCode)+" ) ");
            } else {
                alert("안심번호 해제에 실패했습니다. (1)");
            }


            return false;
        }

        var res2 = updateSafetyNumber(safetyNumber, 'e','');
        if (!res2) {
            alert("안심번호 해제에 실패했습니다. (2)");
            return false;
        }

        return true;
    }


    // 수정(w = u) > 사용자 휴대폰번호 수정시 발생
    function requestModSafetyNumber(isAlert){

        var safetyNumber = $("#reg_mb_id").val().trim().replace(/[- ]/gi, "");
        var safetyName = $('#reg_mb_name').val().trim().replace(/[- \.]/gi, "");
        var targetNumber = $('#reg_mb_hp').val().trim().replace(/[- \.]/gi, "");

        if(!safetyNumber || !safetyName || !targetNumber)
            return false;

        var res1 = tlog_number_update(safetyNumber, safetyName, targetNumber);


        if (!res1 || res1.Result != "1") {

            if(res1 && res1.hasOwnProperty("ErrCode")) {
                alert("안심번호 수정에 실패했습니다. (1 / 원인 :  "+tlog_get_error_msg(res.ErrCode)+" ) ");
            } else {
                alert("안심번호 수정에 실패했습니다. (1)");
            }

            return false;
        }

        // 멘트 활성화_______________________________
        var res9 = tlog_number_member(safetyNumber);
        //console.log(res9);
        //alert(JSON.stringify(res9));



        var res2 = updateSafetyNumber(safetyNumber, 'u',targetNumber);
        if (!res2) {
            alert("안심번호 수정에 실패했습니다. (2)");
            return false;
        }


        if(isAlert)
            alert('*안심번호 수정 처리 되었습니다. ');

        return true;

    }




    function generateSafetyNumber(){

        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.safety_number_generate.php"
        $('#btnGenNumber').hide();

        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache: false,
            data:{"mb_id":"<?php echo $_SESSION['ss_mb_id']; ?>",
                "mb_grp_no":"<?php echo $member['mb_1']; ?>"},
            success:function(data) {

                //console.log(data);
                if(!data.result_stat) {

                    alert(data.result_msg);
                    $('#btnGenNumber').show();

                } else {

                    var number = phone_format(data.result_msg);
                    $('#reg_mb_id').prop('value',number);


                    alert("'"+number+"' 번호가 할당되었으며, 3분 이네로 미등록시 초기화 됩니다. ");

                    if(numChkTimeout){
                        //console.log("clear interval / date :  "+new Date());
                        clearInterval(numChkTimeout);
                    }

                    $('#reg_mb_password').focus();

                    numChkTimeout=setInterval(function(){ //주의: event 누적된다.

                        //console.log("check / resetSafetyNumber called / date :  "+new Date());
                        if(isSubmit){
                            return;
                        }


                        resetSafetyNumber();

                    },180 * 1000); // default :  3분 180 * 1000

                }

            }
        });

    } //end func ___---------



    // 입력 중단시 파생되는 작업
    function resetSubmitLayout(){

        if(numChkTimeout){
            clearInterval(numChkTimeout);
        }

        requestCnt = 0;

        $('#reg_mb_id').prop('value','');
        $('#btnGenNumber').show();

        //document.getElementById("btn_submit").disabled="";
        $('#btn_submit').show();

    } //end func_____



    // submit 최종 폼체크________________
    function fregisterform_submit(f) {

        if(requestCnt != 0){
            alert('내부 처리중입니다. ');
            //location.href='./gmember_form.php';
            return false;
        }

        if(isSubmit){
            alert('처리중입니다. ');
            return false;
        }

        //submit button > disabled __
        //document.getElementById("btn_submit").disabled = "disabled";
        $('#btn_submit').hide();
        isSubmit = true;



        // 일괄 등록(이전 데이터 0,1)____________________________________
        var safety_reged="<?php echo $safety_config['sm_is_reged']?>";



        // 회원아이디 검사______
        if (f.w.value == "") {

            if (f.mb_id.value.length == 0) {
                alert("안심번호를 생성 해주십시오.");
                f.btnGenNumber.focus();
                isSubmit = false;
                return false;
                //document.getElementById("btn_submit").disabled="";
                $('#btn_submit').show();
            }

            var msg = reg_mb_id_check();
            if (msg) {

                alert(msg);
                f.mb_id.select();
                isSubmit = false;
                $('#btn_submit').show();
                resetSubmitLayout();

                return false;
            }
        }

        if (f.w.value == "") {
            if (f.mb_password.value.length < 3) {
                alert("비밀번호를 3글자 이상 입력하십시오.");
                f.mb_password.focus();
                isSubmit = false;
                $('#btn_submit').show();
                return false;
            }
        }

        if (f.mb_password.value != f.mb_password_re.value) {
            alert("비밀번호가 같지 않습니다.");
            f.mb_password_re.focus();
            $('#btn_submit').show();
            isSubmit = false;
            return false;
        }

        if (f.mb_password.value.length > 0) {
            if (f.mb_password_re.value.length < 3) {
                alert("비밀번호를 3글자 이상 입력하십시오.");
                f.mb_password_re.focus();
                isSubmit = false;
                $('#btn_submit').show();
                return false;
            }
        }

        // 이름 검사
        if (f.w.value == "") {
            if (f.mb_name.value.length < 1) {
                alert("이름을 입력하십시오.");
                f.mb_name.focus();
                isSubmit = false;
                $('#btn_submit').show();
                return false;
            }
        }


        //문자 회신번호 체크 _______________________________________
        // var spcPattern = /[- \._]/gi;
        var spcPattern = /[- \._\?~\\+#\$\^@!]/gi; // 특수문자 패턴

        var cbNumber = $('#reg_mb_2').val();

        if(cbNumber.length > 0)
            $('#reg_mb_2').val($('#reg_mb_2').val().replace(spcPattern,''));

        cbNumber = $('#reg_mb_2').val();

        var virPattern = /^050.{7,9}$/;
        if(cbNumber.length > 0 && virPattern.test(cbNumber)){
            alert('안심번호(050)는 회신번호로 사용할 수 없습니다.');
            $('#reg_mb_2').val('').focus();
            isSubmit = false;
            $('#btn_submit').show();
            return false;
        }

        var moPattern = /^01.{8,10}$/;
        if(cbNumber.length > 0 && moPattern.test(cbNumber)){
            alert('개인 휴대폰 번호는 회신번호로 사용할 수 없습니다.');
            $('#reg_mb_2').val('').focus();
            isSubmit = false;
            $('#btn_submit').show();
            return false;
        }

        // 발신번호 변조 서비스 -발신 전화번호 / 2200501 _________________________________
        var mappingNumber = $('#reg_call_mapping_number').val();
        if(mappingNumber.length > 0)
            $('#reg_call_mapping_number').val($('#reg_call_mapping_number').val().replace(spcPattern,''));
        mappingNumber = $('#reg_call_mapping_number').val();

        if(mappingNumber.length > 0 && virPattern.test(mappingNumber)){
            alert('안심번호(050)는 발신 전화번호로 사용할 수 없습니다.');
            $('#reg_call_mapping_number').val('').focus();
            isSubmit = false;
            $('#btn_submit').show();
            return false;
        }

        if(mappingNumber.length > 0 && moPattern.test(mappingNumber)){
            alert('개인 휴대폰 번호는 발신 전화번호로 사용할 수 없습니다.');
            $('#reg_call_mapping_number').val('').focus();
            isSubmit = false;
            $('#btn_submit').show();
            return false;
        }


        // 안심-> 맵핑 대상번호 체크 ----------------------------------------------
        $('#reg_mb_hp').val($('#reg_mb_hp').val().replace(spcPattern,''));
        var hpPattern = /^01[016789][0-9]{3,4}[0-9]{4}$/;
        var hpNumber = $("#reg_mb_hp").val();

        if(hpPattern.test(hpNumber)) {
            // 휴대폰번호 체크
            var msg = reg_mb_hp_check();
            if (msg) {
                alert(msg);
                f.reg_mb_hp.select();
                isSubmit = false;
                $('#btn_submit').show();
                return false;
            }
        }


        //20200320 appended
        // 착신번호 -> 대표번호 체크_______
        var mstNumPattern = /^15.{8}$/;
        if(hpNumber.length > 0 && mstNumPattern.test(hpNumber)){
            alert('안심 착신번호는 대표번호를 사용 할 수 없습니다.');
            $('#reg_mb_hp').val('').focus();
            isSubmit = false;
            $('#btn_submit').show();
            return false;
        }

        // 착신번호 -> 050 입력방지 체크
        if(hpNumber.length > 0 && virPattern.test(hpNumber)){
            alert('안심번호 자체를 착신 할 수 없습니다. ');
            $('#reg_mb_hp').val('').focus();
            isSubmit = false;
            $('#btn_submit').show();
            return false;
        }

        ///
        // 안심번호 등록 //////////////////////////////////////////////////////////////////////////
        //
        if (f.w.value == "") {


            alert(' * 안심번호 등록 처리 중입니다. \n\n     [ 완료 메세지 ] 가 나타날때까지 잠시만 기다려 주세요~ \n ');


            var res=false;

            if(safety_reged == "0") { // 미등록 > 등록진행

                var chkSvr = tlog_ping();
                if(!chkSvr){
                    alert('ⓘ 오류발생\n\n안심번호 서버에 일시적으로 장애가 발생했습니다. \n\n ~ 잠시 후 재시도 하세요.  ');
                    res = false;
                } else {

                    res = requestRegSafetyNumber(false);  // return fase & alert포함__

                }


            } else { //등록되어 이전시 > 정상 등록인지 조회__________

                res = requestCheckSafetyNumber(); // 기등록된(이전) 기관 등록 (*회선 조회) - 현재 이조건 거의 발생하지 않음

            }


            if(!res){
                requestCnt=0;
                isSubmit=false;
                document.getElementById("btn_submit").disabled = "";

                resetSubmitLayout();

                return false;
            }


        }


        // 회원정보 수정 > 휴대폰 번호 변경시
        if(f.w.value == "u" && f.prev_mb_hp.value != f.reg_mb_hp.value){

            alert('*휴대폰번호가 수정되어, 안심번호 수정 처리중입니다. \n\n     [ 완료 메세지 ] 가 나타날때까지 잠시만 기다려 주세요~ \n  ');

            var res = false;
            var chkSvr = tlog_ping();
            if(!chkSvr) {

                alert('ⓘ 오류발생\n\n안심번호 서버에 일시적으로 장애가 발생했습니다. \n\n ~ 잠시 후 재시도 하세요.  ');
                res = false;

            } else {
                res = requestModSafetyNumber();
            }



            if(!res){
                isSubmit=false;
                //document.getElementById("btn_submit").disabled = "";
                $('#btn_submit').show();
                return false;
            }

        }


        return true;

    }


</script>

<!-- } 회원정보 입력/수정 끝 -->

<script>
    function html_auto_br(obj)
    {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "2";
            else
                obj.value = "1";
        }
        else
            obj.value = "";
    }


    function fwrite_submit(f)
    {
        <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.qa_subject.value,
                "content": f.qa_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
            f.qa_subject.focus();
            return false;
        }

        if (content) {
            alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
            if (typeof(ed_qa_content) != "undefined")
                ed_qa_content.returnFalse();
            else
                f.qa_content.focus();
            return false;
        }

        <?php if ($is_hp) { ?>
        var hp = f.qa_hp.value.replace(/[0-9\-]/g, "");
        if(hp.length > 0) {
            alert("휴대폰번호는 숫자, - 으로만 입력해 주십시오.");
            return false;
        }
        <?php } ?>

        document.getElementById("btn_submit").disabled = "disabled";
        return true;

    }
</script>
</section>
<!-- } 게시물 작성/수정 끝 -->