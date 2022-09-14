<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_JS_URL.'/toastr.css">', 11);


//moment.js include
add_javascript('<script src="'.G5_JS_URL.'/moment-with-locales.min.js"></script>', 10);

//bylee . calamansi .js
add_javascript('<script src="'.G5_THEME_JS_URL.'/calamansi.js"></script>', 11);

add_javascript('<script src="'.G5_THEME_JS_URL.'/toastr.js"></script>', 12);


if ($is_category) {
    $ca_name = "";
    if (isset($write['ca_name']))
        $ca_name = $write['ca_name'];

    if($w == "")
        $ca_name = "기타";

    //$category_option = get_category_option($bo_table, $ca_name);
    $category_option = get_category_option_bs($ca_name,"btn-info");
}


if($w=="u" && $write['wr_1']){
    $group = get_member_group($write['wr_1']);
    $write['wr_1_nm'] = $group['mg_name'];
}

?>

<link href="<?php echo $board_skin_url ?>/style.css" rel="stylesheet">

<!-- Page Content -->
<div>&nbsp;</div>
<div class="section-header page d-none d-md-block mt-4">
    <h3><?php echo $board['bo_subject'] ?> <?=($w=='u')?" - 수정":""?></h3>
</div>

<!--  calamansi dashboard    {    ---------------------------------------------------------------------------->
<div id="calamansi_dashboard" class="fixed-top d-flex justify-content-end" style="margin-top: 64px; margin-right: 4px;">
    <div class="alert alert-info d-inline-block px-3 py-2 rounded-pill">
        <form class="form-inline p-0 m-0">
            <button type="button" class="btn btn-sm btn-outline-info rounded-pill font-weight-bold" > <i class="fas fa-phone"></i> 폰 모니터링 </button>
            &nbsp;

            <label for="Calamasi_API_conn" class="ui-controlgroup-label">CONN</label>
            <input id="Calamasi_API_conn" class="form-control form-control-sm text-center text-light  ml-1 bg-secondary" readonly size="8" value="Logout">
            &nbsp;
            <label for="Calamasi_API_stat" class="ui-controlgroup-label">STAT</label>
            <input id="Calamasi_API_stat" class="form-control form-control-sm text-center  ml-1 font-weight-bold" readonly size="10" value="...">
            &nbsp;
            <label for="Calamasi_API_line" class="ui-controlgroup-label">LINE</label>
            <input id="Calamasi_API_line" class="form-control form-control-sm text-center ml-1" size="20" readonly value="...">
            <!--
            &nbsp;
            <label for="Calamasi_API_hold" class="ui-controlgroup-label">HOLD</label>
            <input id="Calamasi_API_hold" class="form-control form-control-sm text-center" size="10" value="UNHOLD">
            &nbsp;
            <label for="Calamasi_API_mute" class="ui-controlgroup-label">MUTE</label>
            <input id="Calamasi_API_mute" class="form-control form-control-sm text-center" size="10" value="UNMUTE">
            -->
            &nbsp;
            <label for="Calamasi_API_live" class="ui-controlgroup-label">LIVE</label>
            <input id="Calamasi_API_live" class="form-control form-control-sm text-center ml-1" size="10" readonly value="...">
        </form>
    </div>
</div>
<!------------------------------------------------------------------------------------   }  calamansi dashboard   ----------------------------->

<!-- Calamasi OCX Object   {  -------------------------------------------------------------------->

<OBJECT classid="clsid:6D7C1184-B072-432C-828E-8ACEFAA69833" codebase="http://KCT/Calamansi_OCX.ocx#version=1,0,0,0"
        width=1
        height=1
        onError='alert("not installed")'
        align=center hspace=0 vspace=0 id="CalamansiAPI">
</OBJECT>

<!-- }    Calamasi OCX Object   -------------------------------------------------------------------->


<section id="bo_w">

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">

        <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
        <input type="hidden" name="w" id="w" value="<?php echo $w ?>">
        <input type="hidden" name="bo_table" id="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="wr_id" id="wr_id" value="<?php echo $wr_id ?>">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="stx" value="<?php echo $stx ?>">
        <input type="hidden" name="spt" value="<?php echo $spt ?>">
        <input type="hidden" name="sst" value="<?php echo $sst ?>">
        <input type="hidden" name="sod" value="<?php echo $sod ?>">
        <input type="hidden" name="page" value="<?php echo $page ?>">

        <!-- wr_subject /bylee -->
        <input type="hidden" name="wr_subject" id="wr_subject" value="">



        <!-- 처리 완료 / 담당자 아이디 -->
        <input type="hidden" name="wr_7" id="wr_7" value="<?php echo $write['wr_7']?>">


        <!-- 처리 완료 시간 -->
        <input type="hidden" name="wr_8" id="wr_8" value="<?php echo $write['wr_8']?>">

        <!-- 이전 처리 상태  -->
        <input type="hidden" name="wr_6_old" id="wr_6_old" value="<?php echo $write['wr_6']?>">




        <?php
        $option = '';
        $option_hidden = '';
        if ($is_notice || $is_html || $is_secret || $is_mail) {
            $option = '';

            if ($is_notice) {
                $option .= "\n".'<div class="form-check form-check-inline">'."\n".'<input type="checkbox" class="form-check-input" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label class="form-check-label" for="notice">공지</label>'."\n".'</div>';
            }

            if ($is_html) {
                if ($is_dhtml_editor) {
                    $option_hidden .= '<input type="hidden" value="html1" name="html">';
                } else {
                    $option .= "\n".'<div class="form-check form-check-inline">'."\n".'<div class="form-check form-check-inline">'."\n".'<input type="checkbox" class="form-check-input" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label class="form-check-label" for="html">html</label>'."\n".'</div>';
                }
            }

            if ($is_secret) {
                if ($is_admin || $is_secret==1) {
                    $option .= "\n".'<div class="form-check form-check-inline">'."\n".'<input type="checkbox" class="form-check-input" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label class="form-check-label" for="secret">비밀글</label>'."\n".'</div>';
                } else {
                    $option_hidden .= '<input type="hidden" name="secret" value="secret">';
                }
            }

            if ($is_mail) {
                $option .= "\n".'<div class="form-check form-check-inline">'."\n".'<input type="checkbox" class="form-check-input" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label class="form-check-label" for="mail">답변메일받기</label>'."\n".'</div>';
            }
        }

        echo $option_hidden;
        ?>

        <?php if ($is_name) { ?>
            <div class="form-group label-floating">
                <label class="control-label" for="email">이름</label>
                <input type="text" class="form-control" id="wr_name" name="wr_name">
            </div>
        <?php } ?>

        <?php if ($is_password) { ?>
            <div class="form-group label-floating">
                <label class="control-label" for="wr_password">비밀번호</label>
                <input type="password" class="form-control" id="wr_password">
            </div>
        <?php } ?>

        <?php if ($is_email) { ?>
            <div class="form-group label-floating">
                <label class="control-label" for="exampleInputEmail1">이메일</label>
                <input type="text" class="form-control" id="exampleInputEmail1">
            </div>
        <?php } ?>

        <?php if ($is_homepage) { ?>
            <div class="form-group label-floating">
                <label class="control-label" for="wr_homepage">홈페이지</label>
                <input type="text" class="form-control" id="wr_homepage">
            </div>
        <?php } ?>

        <?php if ($option) { ?>
            <!--
            <div class="form-group">
                <label>옵션</label>
                <?php echo $option ?>
            </div>
            -->
        <?php } ?>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="wr_6">상태</label>

                <div>
                    <!-- Group Button   -->
                    <div id="wr_6" class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">

                        <label class="btn btn-primary active">
                            <input type="radio" name="wr_6" id="wr_6_0" autocomplete="off" checked value="R"> 대기
                        </label>

                        <label class="btn btn-primary">
                            <input type="radio" name="wr_6" id="wr_6_1" autocomplete="off" value="E">처리중
                        </label>

                        <label class="btn btn-primary">
                            <input type="radio" name="wr_6" id="wr_6_2" autocomplete="off" value="F">처리완료
                        </label>

                    </div>
                </div>
            </div>

            <?php if ($is_category) { ?>
                <div class="col-md-6 form-group label-floating text-left">

                    <label for="ca_name">분류</label>
                    <div>
                        <!-- Group Button   -->
                        <div id="ca_name" class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">

                            <?php   echo $category_option ?>

                        </div>
                    </div>
                </div>

            <?php } ?>


        </div>

        <hr>

        <div class="row">
            <div class="col-md-6 form-group label-floating">
                <label for="wr_1_nm">학교

                   <a  href="#" id="btn_group_info" ><i class="fas fa-info-circle handcursor"></i></a>

                </label>
                <div class="input-group">
                    <input type="hidden" name="wr_1" id="wr_1" value="<?php echo $write['wr_1'] ?>" >
                    <input type="text" name="wr_1_nm" value="<?php echo $write['wr_1_nm'] ?>" id="wr_1_nm"  class="form-control" placeholder="학교를 선택하세요.">
                    <div class="input-group-append">
                        <button id="grp_button" class="btn btn-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

            </div>


            <div class="col-md-6 form-group label-floating">
                <label for="wr_2_nm">대행사</label>
                <div class="input-group">
                    <input type="hidden" name="wr_2" id="wr_2" value="<?php echo $write['wr_2'] ?>" >
                    <input type="text" name="wr_2_nm" value="<?php echo $write['wr_2_nm'] ?>" id="wr_2_nm"  class="form-control" placeholder="대행사를 선택하세요.">
                    <div class="input-group-append">
                        <button id="agency_button" class="btn btn-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

            </div>


        </div>


        <div class="row">
            <div class="col-md-2 form-group label-floating">
                <label class="control-label font-weight-bold text-primary" for="wr_3">고객명</label>
                <input type="text" class="form-control required text-center" required name="wr_3" id="wr_3" value="<?php echo $write['wr_3'] ?>">
            </div>


            <div class="col-md-2 label-floating">
                <label class="control-label font-weight-bold text-primary" for="wr_4">전화번호</label>
                <input type="text" class="form-control required telnumpure font-weight-bold text-center" required name="wr_4" id="wr_4" value="<?php echo $write['wr_4'] ?>">
            </div>

            <div class="col-md-2 label-floating">
                <label class="control-label font-weight-bold text-primary" for="wr_5">아이디(안심번호)
                    <a href="#"  id="btn_member_info"><i class="fas fa-info-circle" ></i></a>
                </label>
                <input type="text" class="form-control   font-weight-bold text-center"  name="wr_5" id="wr_5" value="<?php echo $write['wr_5'] ?>">
            </div>

            <div class="col-md-3 form-group label-floating">
                <label class="control-label" for="wr_9">기타 거래처명</label>
                <input type="text" class="form-control"  name="wr_9" id="wr_9" value="<?php echo $write['wr_9'] ?>">
            </div>

        </div>



        <!--
        <div class="row">
            <div class="col-md-4 form-group label-floating">
                <label class="control-label" for="wr_9">기타 거래처명</label>
                <input type="text" class="form-control"  name="wr_9" id="wr_9" value="<?php echo $write['wr_9'] ?>">
            </div>
            <div class="col-md-4 form-group label-floating">
                <label class="control-label" for="wr_5">기타 전화번호</label>
                <input type="text" class="form-control"  name="wr_5" id="wr_5" value="<?php echo $write['wr_5'] ?>">
            </div>

        </div>
-->

        <!--
	<div class="form-group label-floating">

	    <label class="control-label" for="wr_subject">제목</label>
		<input type="text" class="form-control" name="wr_subject" id="wr_subject" value="<?php echo $subject ?>">
		<div id="autosave_wrapper">
            <?php if ($is_member) { // 임시 저장된 글 기능 ?>
            <script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
            <?php if($editor_content_js) echo $editor_content_js; ?>
            <button type="button" id="btn_autosave" class="btn btn-raised btn-secondary btn_frmline btn_autosave">임시 저장된 글 (<span id="autosave_count"><?php echo $autosave_count; ?></span>)</button>
            <div id="autosave_pop">
                <strong>임시 저장된 글 목록</strong>
				<div><button type="button" class="autosave_close"><img src="<?php echo $board_skin_url; ?>/img/btn_close.gif" alt="닫기"></button></div>
                <ul></ul>
                <div><button type="button" class="autosave_close"><img src="<?php echo $board_skin_url; ?>/img/btn_close.gif" alt="닫기"></button></div>
            </div>
            <?php } ?>
        </div>
	</div>
  -->

        <hr>

        <div class="row" >
            <div class="col-md-6 form-group label-floating">
                <label class="control-label font-weight-bold" for="wr_content">문의 내용</label>
                <?php if($write_min || $write_max) { ?>
                    <!-- 최소/최대 글자 수 사용 시 -->
                    <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>
                <?php echo str_replace('class=""', 'class="form-control rounded-1 wr_content bg-gray-0" id="wr_content" rows="10" ', $editor_html); // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>

                <?php if($write_min || $write_max) { ?>
                    <!-- 최소/최대 글자 수 사용 시 -->
                    <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </div>
            <div class="col-md-6">
                <label class="control-label text-primary" for="wr_10">처리 내용</label>
                <textarea id="wr_10" name="wr_10" class="form-control rounded-1 bg-gray-0"  rows="10" style="width:100%;height:300px"></textarea>
            </div>

        </div>

        <!-- 링크  -->
        <?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
            <!--
	<div class="form-group label-floating">
	    <label class="control-label" for="wr_link<?php echo $i ?>">링크 #<?php echo $i ?></label>
		<input type="text" class="form-control" id="wr_link<?php echo $i ?>" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){echo$write['wr_link'.$i];} ?>">
	</div>
	-->
        <?php } ?>


        <!-- 파일 첨부    -------------------------------------------------------------------->

        <?if($file_count > 0) { ?>

            <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
                <div class="row">
                    <div class="form-group col-md-6">
<!--                        <div class="input-group-prepend">-->
<!--                            <span class="input-group-text" id="inputGroupFileAddon01">파일 첨부 --><?php //echo ($i+1);?><!--</span>-->
<!--                        </div>-->
                        <div class="custom-file">

                            <!-- 업로드한 파일명이 보이지 않는 문제 수정 (18-12-22) -->
                            <input type="file" class="custom-file-input" id="inputGroupFile<?php echo $i ?>" aria-describedby="inputGroupFileAddon01" name="bf_file[]">
                            <label class="custom-file-label" for="bf_file[]">파일 #<?php echo $i+1 ?></label>
                        </div>
                        <!-- 업로드한 파일명이 보이지 않는 문제 수정 (18-12-22) -->

                        <script>
                            $('#inputGroupFile<?php echo $i ?>').on('change',function(){
                                //get the file name
                                var fileName = $(this).val();
                                //replace the "Choose a file" label
                                $(this).next('.custom-file-label').html(fileName);
                            })
                        </script>

                        <?php if ($is_file_content) { ?>
                        <?php } ?>
                        <?php if($w == 'u' && $file[$i]['file']) { ?>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label>
                                <input type="checkbox" class="form-check-input" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1">
                            </div>
                        <?php } ?>
                    </div>

                </div>
            <?php } ?>

        <?php }?>







        <?php if ($is_guest) { //자동등록방지  ?>
            <div class="form-group" style="text-align: center;padding: 10px 0; ">
                <?php echo $captcha_html ?>
            </div>
        <?php } ?>

        <!-- calamasi debugging area  --->
        <!--
        <div class="alert alert-danger">
            <h2 class="demoHeaders">Calamasi Event Log</h2>
            <textarea name="event_log" cols="140" rows="20" class="input" id="event_log"></textarea>
        </div>
        -->



        <div class="text-center mb-4 mt-4">



            <a class="btn btn-raised btn-secondary btn-sm" href="./board.php?bo_table=<?php echo $bo_table ?>">목록</a>

            <button type="button" id="btn_reset" accesskey="s" class="btn btn-sm btn-warning">리셋</button>

            &nbsp;


            <button type="submit" id="btn_submit" accesskey="s" class="btn btn-sm btn-primary "><i class="fas fa-check"></i> 작성완료</button>

            <!--

            <button type="button" class="btn btn-sm btn-danger" id="btnApiLogin">폰 로그인</button>
            <button type="button" class="btn btn-sm btn-danger" id="btnApiRecon">폰 리커넥트</button>

            <button type="button" class="btn btn-sm btn-danger" id="btnClearLog">클리어 로그</button>

            <button type="button" class="btn btn-sm btn-danger" id="btnToastr">Toast Box</button>
            -->

        </div>
    </form>



    <!--모달 영역 MODAL AREA / 정보창   {   ----------------------------------------------------------------------->
    <div class="modal" id="extraModal">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title">
                        <i class='fas fa-info-circle'></i>

                    </h5>
                    <button type="button" class="close text-light" data-dismiss="modal"><i class="fas fa-window-close" style="font-size:20px;"></i></button>
                </div>


                <!-- Modal body -->
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <!--    }  모달 영역 MODAL AREA      ------------------------------------------------------------------------------------------->


<script>

        var KeepPhoneNumber = "";



        //calamansi > disconnect
        window.onbeforeunload = function() {
            calamansi.destroy();
        };



        //그룹 (학교) 새창 > 콜백함수 =====================================
        var callback = function(grpNo,grpName) {

            $('#wr_1').val(grpNo);
            $('#wr_1_nm').val(grpName);

        };

        // 대행사 선택 새창 > 콜백함수  =====================================
        var selectedAgency = function(agCode,agName){

            $('#wr_2').val(agCode);
            $('#wr_2_nm').val(agName);

        }



        $(function() {

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": false,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "4000",
                "extendedTimeOut": "4000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }


            <?php if(isIEBrowser() && !$w  && ($is_cs1_member || $is_cs2_member) ) { ?>
               calamansi.setConfig('<?=$mansi['cc_user_id']?>','<?=$mansi['cc_user_pw']?>','<?=$mansi['cc_extension_number']?>','<?=G5_CALAMASI_SERVER?>');
               calamansi.initialize();
            <?php } else { ?>
                $('#calamansi_dashboard').removeClass("d-flex").addClass("d-none");  //d-flex issue
            <?php } ?>


            $('#btnApiLogin').click(function(){

                CalamansiAPI.LoginAgent('<?=$mansi['cc_user_id']?>','<?=$mansi['cc_user_pw']?>','<?=$mansi['cc_extension_number']?>','<?=G5_CALAMASI_SERVER?>');

            });

            $('#btnApiRecon').click(function(){

                CalamansiAPI.reconnect('<?=$mansi['cc_user_id']?>','<?=$mansi['cc_user_pw']?>','<?=$mansi['cc_extension_number']?>','<?=G5_CALAMASI_SERVER?>');

            });

            $('#btnClearLog').click(function(){

                calamansi.clearLog();

            });

            //학교  선택창
            $('#grp_button').click(function() {

                var  newWin=window.open("<?php echo G5_BBS_URL?>/gmember_find_win.php", "grp_find_w", "location=yes,links=no,toolbar=no,top=10,left=10,width=720,height=500,resizable=yes,scrollbars=no,status=no");
            });



            //대행사  선택창
            $('#agency_button').click(function() {

                var  agWin=window.open("<?php echo G5_BBS_URL?>/agency_find_win.php", "agency_find_w", "location=yes,links=no,toolbar=no,top=10,left=10,width=500,height=280,resizable=yes,scrollbars=no,status=no");
                agWin.onload = function(){
                    agWin.callback = selectedAgency;
                }

            });


            $('#btnToastr').click(function(){

                //toastr.success("testing message !!","title");
                //selectButtonGroup('ca_name','문자');
                showAlertToast("test");

            });

            $('#btn_reset').click(function(){
                $('#fwrite')[0].reset();
                selectButtonGroup('wr_6','R'); //처리상태
                selectButtonGroup('ca_name','기타'); //분류
                $('#wr_3').focus();// 고객명 포커스
            });


            $('#btn_group_info').click(function(){

                var mgNo = $('#wr_1').val();
                if(mgNo.length<=0){
                    alert('학교를 먼저선택하세요.');
                    $('#wr_1').focus();
                    return;
                }

                showGroupInfo('학교 정보',mgNo);

            });


            $('#btn_member_info').click(function(){

                var memId = $('#wr_5').val();
                if(memId.length<=0){
                    alert('회원 아이디 정보를 먼저 입력하세요.');
                    $('#wr_5').focus();

                    return;
                }

                showMemberInfo('회원 정보',memId);

            });

            //처리상태 기본값 셋팅
            selectButtonGroup("wr_6","<?=($write['wr_6'])?$write['wr_6']:'R';?>")

        }); // end on ready func ======================




        <?php if($write_min || $write_max) { ?>
        // 글자수 제한
        var char_min = parseInt(<?php echo $write_min; ?>); // 최소
        var char_max = parseInt(<?php echo $write_max; ?>); // 최대
        check_byte("wr_content", "char_count");


        $(function() {

            $("#wr_content").on("keyup", function() {
                check_byte("wr_content", "char_count");
            });


        });

        <?php } ?>

        function html_auto_br(obj)
        {
            if (obj.checked) {
                result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
                if (result)
                    obj.value = "html2";
                else
                    obj.value = "html1";
            }
            else
                obj.value = "";
        }




        function fwrite_submit(f)
        {



            //bylee
            //wr_subject 자동 설정 ///////////////////////////////////
            var subj="";
            var schId = $('#wr_1').val().trim();
            if(schId.length == 0)
                $('#wr_1_nm').val('');

            var schName = $('#wr_1_nm').val().trim();

            var custId = $('#wr_2').val().trim();
            if(custId.length == 0)
                $('#wr_2').val('');

            var custName = $('#wr_2_nm').val().trim();

            var caller = $('#wr_3').val().trim();
            var number = $('#wr_4').val().trim();

            if(schName.length > 0) {
                subj += schName + " > ";
            } else if(custName.length > 0) {
                subj += custName + " > ";
            }


            subj+=caller+" > ";
            subj+=number+" 문의";

            $('#wr_subject').val(subj);

            // 처리 시간 및 처리 담당자 아이디 셋팅 ///////////////////////////////////////////////////////////////
            var w = '<?php echo $w?>';
            var old_stat = $('#wr_6_old').val();
            var cur_stat = $(':radio[name=wr_6]:checked').val();

            if(w == "u"){
                if(old_stat != cur_stat &&
                    cur_stat == "F" && (old_stat == "R" || old_stat == "E") ){

                    var now = moment(); //객체
                    $('#wr_7').val("<?php echo $member['mb_id'];?>"); // 완료처리 담당자 id
                    $('#wr_8').val(now.format('YYYY-MM-DD hh:mm:ss'));

                }
            } else {
                if(cur_stat == "F"){
                    var now = moment(); //객체
                    $('#wr_7').val("<?php echo $member['mb_id'];?>"); // 완료처리 담당자 id
                    $('#wr_8').val(now.format('YYYY-MM-DD hh:mm:ss'));
                }
            }


            <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

            var subject = "";
            var content = "";
            $.ajax({
                url: g5_bbs_url+"/ajax.filter.php",
                type: "POST",
                data: {
                    "subject": f.wr_subject.value,
                    "content": f.wr_content.value
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
                f.wr_subject.focus();
                return false;
            }

            if (content) {
                alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
                if (typeof(ed_wr_content) != "undefined")
                    ed_wr_content.returnFalse();
                else
                    f.wr_content.focus();
                return false;
            }

            if (document.getElementById("char_count")) {
                if (char_min > 0 || char_max > 0) {
                    var cnt = parseInt(check_byte("wr_content", "char_count"));
                    if (char_min > 0 && char_min > cnt) {
                        alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                        return false;
                    }
                    else if (char_max > 0 && char_max < cnt) {
                        alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                        return false;
                    }
                }
            }

            <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

            //document.getElementById("btn_submit").disabled = "disabled";



            <?php if($w == "u"){ ?>
             return true;
            <?php } ?>

            //var formData = $( "#fwrite" ).serialize();
            //var formData = new FormData($('#fwrite')[0]);

            var submitData = new FormData();

            //Form data ===============================================
            var form_data = $('#fwrite').serializeArray(); // key:val > json array type return;
            $.each(form_data, function (key, input) {
                submitData.append(input.name, input.value);
            });

            //File data ====================================================
            var file_data = $('input[name="bf_file[]"]');//[0].files;

            for (var i = 0; i < file_data.length; i++) {
                //console.log(file_data[i]);
                //console.log(file_data[i].files[0]);
                submitData.append("bf_file[]", file_data[i].files[0]);
            }


            $.ajax({
                url: '/bbs/ajax.write_update.php',
                method: "post",
                processData: false,
                contentType: false,
                data: submitData,
                success: function(data) {


                   //console.log(data);

                    var json  = "";
                    try {
                        json = JSON.parse(data);
                    }catch(e){
                        alert("ajax 저장 결과 파싱시 오류가 발생했습니다. 관리자에게 문의하세요. ");
                        return false;
                    }


                    alert(json.result_msg);



                    if(json.result_stat) {



                        $('#fwrite')[0].reset();
                        selectButtonGroup('wr_6','R'); //처리상태
                        selectButtonGroup('ca_name','기타'); //분류
                        $('#wr_3').focus();// 고객명 포커스


                        if(KeepPhoneNumber.length>0) {

                            getCallerData('<?=$bo_table?>', KeepPhoneNumber);
                        }

                    }


                },
                error: function (e) {
                    //error
                    alert('게시글 포스팅에 실패했습니다. ');
                }
            });


            return false;

        }
    </script>

    </div>
</section>



<!-- 사용자 함수   {    ---------------------------------------------------------------------------------->
<script  language="javascript"  >


    // 학교 정보 추출 & show modal window___----

    function showGroupInfo(title,mgNo){

        $.get("<?php echo G5_BBS_URL?>/ajax.cs_gmember_get.php?mg_no="+mgNo,function(data){

            //console.log(data);

            $('#extraModal .modal-title').text(title);
            $('#extraModal .modal-body').html(data);
        });


        $('#extraModal').modal();

    } //end func ============ ===================

    // 교사회원 정보 추출 & show modal window___----
    function showMemberInfo(title,mbId){

        $.get("<?php echo G5_BBS_URL?>/ajax.cs_member_get.php?mb_id="+mbId,function(data){
            $('#extraModal .modal-title').text(title);
            $('#extraModal .modal-body').html(data);
        });


        $('#extraModal').modal();

    } //end func ============ ===================



    function showCallToast(boTable,phoneNumber){

        var actionUrl = '/bbs/ajax.cs_customer_retreive.php';
        $.getJSON(actionUrl,{'bo_table':boTable,'phone_number':phoneNumber},function(json){

            //console.log(json);

            var toastTitle="";
            var toastMsg="";


            toastMsg=phone_format(phoneNumber)+" 에서 전화"



            if(json.cust_name.length > 0){

                if(json.cust_type == "member"){
                    toastTitle+="회원 > ";
                } else if(json.cust_type == "agency"){
                    toastTitle+="대리점 > ";
                }

                toastTitle+=json.cust_name;
                toastr.success(toastMsg,toastTitle);
            } else {
                toastTitle="미확인";
                toastr.warning(toastMsg,toastTitle);
            }

        });

    }


    function showAlertToast(msg){
        toastr.info(msg,"알림",{
            "timeOut": "2000",
            "extendedTimeOut": "2000",
            positionClass: "toast-center",
            closeButton: true
        });
    }


    function showErrorToast(msg){
        toastr.error(msg,"확인",{
            "timeOut": "3000",
            "extendedTimeOut": "3000",
            positionClass: "toast-center",
            closeButton: true
        });
    }


    function getDocumentData(boTable,wrId){

        var actionUrl = '/bbs/ajax.bbs_document_get.php';
        $.getJSON(actionUrl,{'bo_table':boTable,'wr_id':wrId},function(json){

            //console.log("getDocumentData ____________");
            //console.log(json);

            if(json.wr_id.length == 0){
                alert('검색된 게시글정보가 없습니다. ');
                return;
            }

            $('#w').val("u");
            $('#wr_id').val(json.wr_id);

            selectButtonGroup('wr_6',json.wr_6);//처리 상태
            selectButtonGroup('ca_name',json.ca_name);//분류

            $('#wr_content').val(json.wr_content);

            $('#wr_1').val(json.wr_1);
            $('#wr_1_nm').val(json.wr_1_nm);

            $('#wr_2').val(json.wr_2);
            $('#wr_2_nm').val(json.wr_2_nm);
            $('#wr_3').val(json.wr_3);
            $('#wr_4').val(json.wr_4);
            $('#wr_5').val(json.wr_5); //안심번호
            $('#wr_6').val(json.wr_6);
            $('#wr_7').val(json.wr_7);
            $('#wr_8').val(json.wr_8);
            $('#wr_9').val(json.wr_9);
            $('#wr_10').val(json.wr_10);

            $('#wr_10').focus();



        });

    } //end method == ======



    function getCallerData(boTable,phoneNumber){

        //console.log("getCallData --------------------");

        var custName = $('#wr_3').val().trim();
        var custNumber = $('#wr_4').val().trim();
        var content = $('#wr_content').val().trim();

        if(custName.length > 0 && custNumber.length > 0){

            alert("미처리 자료가 자동 저장됩니다. ");
            if(content.length == 0)
                $('#wr_content').val('임시');

            KeepPhoneNumber=phoneNumber;


            //$('#fwrite').submit(); // 호출 디는 fwrite_check > ajax php파일이 제대로 호출되지 않는다 ㅡㅡ;?
            $('#btn_submit').trigger("click"); //버튼 클릭 이벤트 클릭으로 submit 우회호출
            return;

        }



        KeepPhoneNumber = "";
        var actionUrl = '/bbs/ajax.cs_customer_retreive.php';
        $.getJSON(actionUrl,{'bo_table':boTable,'phone_number':phoneNumber},function(json){

                //console.log("getCallerData");
                //console.log(json);

                if(json.cust_cs_id.length > 0){ //기존 미처리 자료 존재

                    alert('해당 고객에 등록된 [미처리]된 게시글이 로딩됩니다. ');

                    getDocumentData(boTable,json.cust_cs_id);
                    if(json.cust_cs_cnt > 1){
                        alert('해당 고객에 등록된 미처리된 게시글이 1개이상 존재합니다.  \n\n *게시판을 확인하세요.('+json.cust_cs_cnt+'개)');
                    }
                    return;

                }


                $('#wr_4').val(phoneNumber);
                $('#wr_3').val(json.cust_name);
                $('#wr_5').val(json.cust_id);// 회원아이디(안심번호) __

                if(json.cust_type == "member"){
                    $('#wr_1').val(json.grp_no);
                    $('#wr_1_nm').val(json.grp_name);

                } else if(json.cust_type == "agency"){
                    $('#wr_2').val(json.grp_no);
                    $('#wr_2_nm').val(json.grp_name);

                }

                if(json.cust_name.length > 0){
                    $('#wr_content').focus();
                } else {
                    $('#wr_3').focus();
                }

        });



    } //end func =============================


</script>



<!-----------------------------------------------------------------     }   사용자 함수   ------------------------->





<!---Calamansi OCX 연동 Event   ------------------------------------------------------------------------>

<!-- bylee 로그인 결과 (LoginAgent method >  request > response)   ---->
<script language="javascript"  event="SendLoginResultEvent(evtdata)" for="CalamansiAPI">
    var jbSplit = evtdata.split('|');
    for ( var i in jbSplit ) {
        if (jbSplit[i] =='STATUS:1')
        {
            //document.all['Calamasi_API_conn'].value = "Login";
            calamansi.setConnMsg("Login");
        }
        if (jbSplit[i] =='STATUS:0')
        {
            //document.all['Calamasi_API_conn'].value = "Login Fail";
            calamansi.setConnMsg("Login Fail");
        }
    }

    //document.all['event_log'].value = "CalamasiAPI Start\n";
    //document.all['event_log'].value += "SendLoginResultEvent = " + evtdata + "\n";
    calamansi.addLog("CalamasiAPI Start");
    calamansi.addLog("SendLoginResultEvent = " + evtdata);
</script>

<!--- 통화 시도 (링)  -->
<script language="javascript"  event="SendRingEvent(evtdata)" for="CalamansiAPI">
    //    document.all['Calamasi_API_line'].value = "연결중";
    //    document.all['event_log'].value += "SendRingEvent  = " + evtdata + "\n";
    calamansi.setLineMsg("연결중");
    calamansi.addLog("SendRingEvent(벨울림) = " + evtdata);

    var phoneNumber = ""; //bylee

    var jbSplit = evtdata.split('|');
    for ( var i in jbSplit ) {


        //console.log(jbSplit[i]);

        if (i == 6) //GETCID
        {
            var jCidSplit = jbSplit[i].split(':');
            if (jCidSplit[0] == 'CALLERID')
            {
                //document.all['ani_num'].value = jCidSplit[1]; // 통화시 >  고객번호
                //bylee
                phoneNumber = jCidSplit[1];
            }

        }

    } //end for___-------------

    //console.log("phoneNumber : "+phoneNumber);

    if(phoneNumber.length>0){
        showCallToast('<?php echo $bo_table?>',phoneNumber);
    }

</script>

<!-- bylee 통화 시작시 호출   --------------------------------------------------------------->
<script language="javascript"  event="SendAnswerEvent(evtdata)" for="CalamansiAPI">

    var phoneNumber = ""; //bylee
    var jbSplit = evtdata.split('|');
    for ( var i in jbSplit ) {
        if (i == 3) //GETCID
        {
            var jCidSplit = jbSplit[i].split(':');
            if (jCidSplit[0] == 'CALLER1ID')
            {
                //document.all['ani_num'].value = jCidSplit[1]; // 통화시 >  고객번호

                //bylee
                phoneNumber = jCidSplit[1];
            }

        }
    }

    //    document.all['Calamasi_API_line'].value = "통화중";
    //    document.all['event_log'].value += "SendAnwserEvent  = " + evtdata + "\n";
    //
    calamansi.setLineMsg("통화중("+phoneNumber+")");
    calamansi.addLog("SendAnwserEvent(통화시작)  = " + evtdata);

    //bylee
    // caller 정보 추출
    getCallerData('<?php echo $bo_table?>',phoneNumber);

</script>

<!-- 전화 통화 종료 및 통화 대기중 종료시 호출 -->
<script language="javascript"  event="SendHangupEvent(evtdata)" for="CalamansiAPI">
    //    document.all['Calamasi_API_line'].value = "DISCONNECT";
    //    document.all['event_log'].value += "SendHangupEvent  = " + evtdata + "\n";

    calamansi.setLineMsg("통화종료"); // 전화끊김 > default DISCONNECT
    calamansi.addLog("SendHangupEvent(통화종료)  = " + evtdata);
</script>

<script language="javascript"  event="SendCommandResultEvent (evtdata)" for="CalamansiAPI">
    var Calamasi_flag  = 0; // 1:HOLD, 2:MUTE,3:GETCALLERID, 4:GetForward
    var jbSplit = evtdata.split('|');
    for ( var i in jbSplit ) {
        if (jbSplit[i] =='CMD:HOLD') { Calamasi_flag = 1; }
        if (jbSplit[i] =='CMD:MUTE') { Calamasi_flag = 2; }
        if (jbSplit[i] =='CMD:GETCALLERID') { Calamasi_flag = 3; }
        if (jbSplit[i] =='CMD:SETFORWORD') { Calamasi_flag = 4;	}
        if (jbSplit[i] =='CMD:SETCALLREJECT') { Calamasi_flag = 5;	}
        if (Calamasi_flag == 1 && i == 4) //HOLD
        {
            if (jbSplit[i] =='ACT:HOLD')
            {
                //document.all['Calamasi_API_hold'].value = "HOLD";
                calamansi.setHoldMsg("Hold");
            }
            if (jbSplit[i] =='ACT:UNHOLD')
            {
                //document.all['Calamasi_API_hold'].value = "UNHOLD";
                calamansi.setHoldMsg("Unhold");
            }
        }
        if (Calamasi_flag == 2 && i == 4) //MUTE
        {
            if (jbSplit[i] =='ACT:MUTE')
            {
                //document.all['Calamasi_API_mute'].value = "MUTE";
                calamansi.setMuteMsg("Mute");
            }
            if (jbSplit[i] =='ACT:TALK')
            {
                //document.all['Calamasi_API_mute'].value = "UNMUTE";
                calamansi.setMuteMsg("Unmute");
            }
        }
        /*
         if (Calamasi_flag == 3 && i == 4) //GETCALLERID
         {
         var jCidSplit = jbSplit[i].split(':');
         if (jCidSplit[0] == 'CID')
         {
         document.all['dnis_num'].value = jCidSplit[1];
         }
         }

         if (Calamasi_flag == 4 && i == 4) //GetForward
         {
         var jCidSplit = jbSplit[i].split(':');
         if (jCidSplit[0] == 'PHONE')
         {
         document.all['forward_num'].value = jCidSplit[1];
         }
         }

         if (Calamasi_flag == 4 && i == 5) //GetForward
         {
         if (jbSplit[i] =='ACT:1')
         {
         document.all['forward_stat'].value = "Enable";  //착신상태
         }
         if (jbSplit[i] =='ACT:0')
         {
         document.all['forward_stat'].value = "Disable";
         }
         }

         if (Calamasi_flag == 5 && i == 4) //SetCallReject
         {
         if (jbSplit[i] =='ACT:1')
         {
         document.all['CallReject_stat'].value = "Enable"; //수신거부
         }
         if (jbSplit[i] =='ACT:0')
         {
         document.all['CallReject_stat'].value = "Disable";
         }
         }
         */
    }

    //document.all['event_log'].value += "SendCommandResultEvent  = " + evtdata +"\n";
    calamansi.addLog("SendCommandResultEvent  = " + evtdata);


</script>

<script language="javascript"  event="SendCmdErrorEvent (evtdata,evtmsg)" for="CalamansiAPI">
    //    document.all['event_log'].value += "SendCmdErrorEvent(Function)  = " + evtdata +  "\n";
    //    document.all['event_log'].value += "SendCmdErrorEvent(Messages)  = " + evtmsg + "\n";
    calamansi.addLog("----------------------------------------");
    calamansi.addLog("SendCmdErrorEvent(Function)  = " + evtdata);
    calamansi.addLog("SendCmdErrorEvent(Messages)  = " + evtmsg);
</script>

<script language="javascript"  event="SendPhoneStatEvent(evtdata)" for="CalamansiAPI">
    //document.all['Calamasi_API_stat'].value = evtdata;
    calamansi.setStatMsg(evtdata);

    if (evtdata == "TIMEOUT")
    {
        alert("전화기 단말기와 접속이 끊어 졌습니다.  재접속 시도합니다~ ");
        //location.reload();
        // 재접속 함수 호출
        calamansi.reconnect();

    }
</script>




<script language="javascript"  event="SendNetworkEvent(evtdata)" for="CalamansiAPI">
    var jbSplit = evtdata.split('|');
    for ( var i in jbSplit ) {
        if (jbSplit[i] =='CMD:DISCONNECTAGENT')
        {
            //document.all['Calamasi_API_conn'].value = "Logout";
            //document.all['Calamasi_API_live'].value = "...";
            calamansi.setConnMsg("Logout");
            calamansi.setLiveMsg("...");
        }
        if (jbSplit[i] =='CMD:DISCONNECTMANAGER')
        {
            //document.all['Calamasi_API_conn'].value = "Logout";
            //document.all['Calamasi_API_live'].value = "...";
            calamansi.setConnMsg("Logout");
            calamansi.setLiveMsg("...");
        }
    }

    //document.all['event_log'].value += "SendNetworkEvent  = " + evtdata + "\n";
    calamansi.addLog("SendNetworkEvent(네트워크 이벤트)  = " + evtdata);

</script>

<script language="javascript"  event="SendLiveEvent(evtdata)" for="CalamansiAPI">
    var calamansi_date = new Date();
    var calamansi_time =  formatDate(calamansi_date);
    //document.all['Calamasi_API_live'].value = calamansi_time;
    calamansi.setLiveMsg(calamansi_time);

    //document.all['event_log'].value += "SendLiveEvent[" + calamansi_time + ']=' + evtdata + "\n";
</script>

<!---  }    Calamansi OCX 연동 Event    ---------------------------------------------------------------------->

<!-- } 게시물 작성/수정 끝 -->