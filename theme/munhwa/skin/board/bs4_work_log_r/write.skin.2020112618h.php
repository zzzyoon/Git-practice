<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//moment.js include
add_javascript('<script src="'.G5_JS_URL.'/moment-with-locales.min.js"></script>', 10);

//bylee . calamansi .js
add_javascript('<script src="'.$board_skin_url.'/calamansi.js"></script>', 11);

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
<h3><?php echo $board['bo_subject'] ?></h3>
</div>

<div class="fixed-top d-flex justify-content-end" style="margin-top: 64px; margin-right: 4px;">
    <div class="alert alert-info d-inline-block">
        <form class="form-inline p-0 m-0">
            <button type="button" class="btn btn-sm btn-outline-info rounded-pill font-weight-bold" > <i class="fas fa-phone"></i> 폰 모니터링 </button>
            &nbsp;
            <!-- calamasi > dashboard -->
            <label for="Calamasi_API_conn" class="ui-controlgroup-label">CONN</label>
            <input id="Calamasi_API_conn" class="form-control form-control-sm text-center" size="10" value="Logout">
                &nbsp;
            <label for="Calamasi_API_stat" class="ui-controlgroup-label">STAT</label>
            <input id="Calamasi_API_stat" class="form-control form-control-sm text-center font-weight-bold" size="10" value="...">
                &nbsp;
            <label for="Calamasi_API_line" class="ui-controlgroup-label">LINE</label>
            <input id="Calamasi_API_line" class="form-control form-control-sm text-center" size="14" value="...">
                &nbsp;
            <label for="Calamasi_API_hold" class="ui-controlgroup-label">HOLD</label>
            <input id="Calamasi_API_hold" class="form-control form-control-sm text-center" size="10" value="UNHOLD">
                &nbsp;
            <label for="Calamasi_API_mute" class="ui-controlgroup-label">MUTE</label>
            <input id="Calamasi_API_mute" class="form-control form-control-sm text-center" size="10" value="UNMUTE">
                &nbsp;
            <label for="Calamasi_API_live" class="ui-controlgroup-label">LIVE</label>
            <input id="Calamasi_API_live" class="form-control form-control-sm text-center" size="14" value="...">
        </form>
    </div>
</div>


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
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
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
	<div class="form-group">
		<label>옵션</label>
		<?php echo $option ?>
	</div>
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


    <div class="row">
        <div class="col-md-6 form-group label-floating">
            <label for="wr_1_nm">학교</label>
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
            <div class="col-md-3 form-group label-floating">
                <label class="control-label font-weight-bold" for="wr_3">고객명</label>
                <input type="text" class="form-control required" required name="wr_3" id="wr_3" value="<?php echo $write['wr_3'] ?>">
            </div>


            <div class="col-md-3 label-floating">
                <label class="control-label font-weight-bold" for="wr_4">전화번호</label>
                <input type="text" class="form-control required telnumpure" required name="wr_4" id="wr_4" value="<?php echo $write['wr_4'] ?>">
            </div>

            <div class="col-md-3 form-group label-floating">
                <label class="control-label" for="wr_9">기타 거래처명</label>
                <input type="text" class="form-control"  name="wr_9" id="wr_9" value="<?php echo $write['wr_9'] ?>">
            </div>
            <div class="col-md-3 form-group label-floating">
                <label class="control-label" for="wr_5">기타 전화번호</label>
                <input type="text" class="form-control"  name="wr_5" id="wr_5" value="<?php echo $write['wr_5'] ?>">
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


        <!-- 파일 첨부    ------>
        <?if($file_count > 0) { ?>

    <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
   <div class="row">
	<div class="form-group col-md-6">
		<div class="input-group-prepend">
			<span class="input-group-text" id="inputGroupFileAddon01">파일 첨부 <?php echo ($i+1);?></span>
		</div>
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
        <div class="alert alert-danger">
            <h2 class="demoHeaders">Calamasi Event Log</h2>
            <textarea name="event_log" cols="140" rows="20" class="input" id="event_log"></textarea>
        </div>




        <div class="text-center mb-4 mt-4">
	<button type="submit" id="btn_submit" accesskey="s" class="btn btn-raised btn-primary btn-sm">작성완료</button>
	<a class="btn btn-raised btn-secondary btn-sm" href="./board.php?bo_table=<?php echo $bo_table ?>">취소</a>

            <button type="button" class="btn btn-sm btn-danger" id="btnApiLogin">폰 로그인</button>
            <button type="button" class="btn btn-sm btn-danger" id="btnApiRecon">폰 리커넥트</button>

            <button type="button" class="btn btn-sm btn-danger" id="btnClearLog">클리어 로그</button>
	</div>
    </form>





    <script>

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

            calamansi.setConfig('<?=$mansi['cc_user_id']?>','<?=$mansi['cc_user_pw']?>','<?=$mansi['cc_extension_number']?>','<?=G5_CALAMASI_SERVER?>');
            calamansi.initialize();

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


        });




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
        var schName = $('#wr_1_nm').val().trim();
        var custName = $('#wr_2').val().trim();

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

        // 처리 시간 및 처리 담당자 아이디 셋팅

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

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>

</div>
</section>



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

<!--- 통화 시도   -->
<script language="javascript"  event="SendRingEvent(evtdata)" for="CalamansiAPI">
//    document.all['Calamasi_API_line'].value = "연결중";
//    document.all['event_log'].value += "SendRingEvent  = " + evtdata + "\n";
    calamansi.setLineMsg("연결중");
    calamansi.addLog("SendRingEvent = " + evtdata);

</script>

<!-- bylee 통화시 호출   -->
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
                //phoneNumber = jCidSplit[1];
            }

        }
    }

//    document.all['Calamasi_API_line'].value = "통화중";
//    document.all['event_log'].value += "SendAnwserEvent  = " + evtdata + "\n";
//
    calamansi.setLineMsg("통화중");
    calamansi.addLog("SendAnwserEvent(통화시작)  = " + evtdata);

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