<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$settings_skin_url.'/style.css">', 0);
//exitVarDump($safety_config);
?>

<!-- 회원정보 입력/수정 시작 { -->
<script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
<link href="<?php echo G5_JS_URL ?>/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="<?php echo G5_JS_URL ?>/bootstrap4-toggle.min.js"></script>


<div class="container mb-4">
    <div class="regist-form">
        <div class="section-header page  d-none d-md-block">
            <h3><?php echo $g5['title']?> </h3>
        </div>

        <form id="optForm" name="optForm" action=""  method="post" autocomplete="off">
            <input type="hidden" name="w" value="<?php echo $w ?>">
            <input type="hidden" name="url" value="<?php echo $urlencode ?>">

            <div id="register_form"  class="form_01 pb-3">
                <div>
                    <p class="regist-title"><i class="fa fa-edit"></i> 어플 알림 설정</p>

                    <ul class="list-group mb-4 d-md-inline">

                        <li class="list-group-item">
                            <div class="form-group">
                                <div class="row ">
                                    <div class="col-12 col-md-3">
                                        <label for="mb_opt_fcm" class="sound_only">안심번호 알림<strong>필수</strong></label>
                                        <input  name="mb_opt_fcm" id="mb_opt_fcm" type="checkbox" <?=($member["mb_opt_fcm"])?"checked":"";?> value="1" data-toggle="toggle">

                                    </div>

                                    <div class="col-12">

                                          <small id="mbidHelp" class="form-text text-info">* 해당 [<?php echo phoneNumberFormat($member['mb_id'])?> ] 안심번호로 통화시도시  어플로 알림이 전송됩니다. </small>
                                    </div>
                                </div>
                            </div>
                        </li>


                    </ul>
                </div>




<!--
                <div class="tbl_frm01 tbl_wrap">
                    <p class="regist-title"><i class="fa fa-edit"></i> 개인정보 입력</p>

                    <ul class="list-group mb-4">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="reg_mb_name" class="sound_only">*이름<strong>필수</strong></label>
                                        <input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($mem['mb_name']) ?>" <?php echo $required ?> class="form-control frm_input half_input <?php echo $required ?>" size="10" placeholder="*이름">

                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            -->

                </ul>

            </div>
<!--            <div class="btn_confirm btn_box">-->
<!---->
<!--                <a href="--><?php //echo $list_href ?><!--" class="btn btn-secondary">취소</a>-->
<!---->
<!--                <input type="submit"   value="확인" id="btn_submit" class="btn btn-primary" accesskey="s">-->
<!---->
<!---->
<!---->
<!--            </div>-->
        </form>

    </div>
</div>




<script>


    var isSubmit=false;
    var numChkTimeout=null;
    //var tlogToken="<?php echo $member['mb_10']?>";
    TLOG_AGENCY_CODE="<?php echo $member['mb_10']?>"; //log.js predefined ___________


    $(function() {

        $('#mb_opt_fcm').change(function() {
            notiOptionChanged($(this).prop('checked'));
        })

    }); // on ready ___--------------------------------------------


    function notiOptionChanged(isChecked){
        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.settings_noti_update.php"

        var stat = 0;

        if(isChecked)
            stat=1;


        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache: false,
            data:{"mb_id":"<?php echo $_SESSION['ss_mb_id']; ?>",
                "mb_opt_fcm":stat},
            success:function(data) {
                //console.log(data);
                //result = data.result_stat;
            }
        });


    } //end func__


    // submit 최종 폼체크
    function fregisterform_submit(f) {

            //alert('call 00');

        isSubmit = true;

        var safety_reged='<?php echo $safety_config['sm_is_reged']?>';

        // 회원아이디 검사
        if (f.w.value == "") {

            if (f.mb_id.value.length == 0) {
                alert("안심번호를 생성 해주십시오.");
                f.btnGenNumber.focus();
                isSubmit = false;
                return false;
            }

            var msg = reg_mb_id_check();
            if (msg) {

                alert(msg);
                f.mb_id.select();
                isSubmit = false;
                return false;
            }
        }

        if (f.w.value == "") {
            if (f.mb_password.value.length < 3) {
                alert("비밀번호를 3글자 이상 입력하십시오.");
                f.mb_password.focus();
                isSubmit = false;
                return false;
            }
        }

        if (f.mb_password.value != f.mb_password_re.value) {
            alert("비밀번호가 같지 않습니다.");
            f.mb_password_re.focus();
            isSubmit = false;
            return false;
        }

        if (f.mb_password.value.length > 0) {
            if (f.mb_password_re.value.length < 3) {
                alert("비밀번호를 3글자 이상 입력하십시오.");
                f.mb_password_re.focus();
                isSubmit = false;
                return false;
            }
        }

        // 이름 검사
        if (f.w.value == "") {
            if (f.mb_name.value.length < 1) {
                alert("이름을 입력하십시오.");
                f.mb_name.focus();
                isSubmit = false;
                return false;
            }
        }


        // 휴대폰번호 체크
        var msg = reg_mb_hp_check();
        if (msg) {
            alert(msg);
            f.reg_mb_hp.select();
            isSubmit = false;
            return false;
        }


        document.getElementById("btn_submit").disabled = "disabled";


        ///
        // 안심번호 등록 /////////////////////////////////////////////////////////
        //
        if (f.w.value == "") {

            var res="";
            if(safety_reged=="0") // 미등록 > 등록진행
                res = requestRegSafetyNumber();  // return fase & alert포함
            else //등록되어 이전시 > 정상 등록인지 조회
                res = requestCheckSafetyNumber(); // 기등록된(이전) 기관 등록 (*회선 조회)

            if(!res){
                isSubmit=false;
                document.getElementById("btn_submit").disabled = "";
                return false;
            }

         }


        if(f.w.value == "u" && f.prev_mb_hp.value != f.reg_mb_hp.value){
            alert('*휴대폰번호가 수정되어, 안심번호 수정요청 중입니다. ');
            var res = requestModSafetyNumber();
            if(!res){
                isSubmit=false;
                document.getElementById("btn_submit").disabled = "";
                return false;
            }

        }





        document.getElementById("btn_submit").disabled = "";
        return true;

    }


</script>

<!-- } 회원정보 입력/수정 끝 -->



</section>
<!-- } 게시물 작성/수정 끝 -->