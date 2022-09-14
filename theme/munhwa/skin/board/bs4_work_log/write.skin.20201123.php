<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//moment.js include
add_javascript('<script src="'.G5_JS_URL.'/moment-with-locales.min.js"></script>', 10);

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

<div class="section-header page d-none d-md-block">
<h3><?php echo $board['bo_subject'] ?></h3>
</div>	
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


    <div class="form-group label-floating">
        <label for="wr_6">상태</label>
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

        <?php if ($is_category) { ?>
            <div class="form-group label-floating text-left">

                <label for="ca_name">분류</label>
                <!-- Group Button   -->
                <div id="ca_name" class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">

                    <?php   echo $category_option ?>

                </div>

            </div>

        <?php } ?>


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
            <label class="control-label" for="wr_2">거래처명</label>
            <input type="text" class="form-control"  name="wr_2" id="wr_2" placeholder="학교가 아닌경우 입력해주세요." value="<?php echo $write['wr_2'] ?>">
        </div>


     </div>

        <div class="row">
            <div class="col-md-4 form-group label-floating">
                <label class="control-label" for="wr_3">고객명</label>
                <input type="text" class="form-control required" required name="wr_3" id="wr_3" value="<?php echo $write['wr_3'] ?>">
            </div>


            <div class="col-md-4 label-floating">
                <label class="control-label" for="wr_4">전화번호</label>
                <input type="text" class="form-control required telnumpure" required name="wr_4" id="wr_4" value="<?php echo $write['wr_4'] ?>">
            </div>

            <div class="col-md-4 form-group label-floating">
                <label class="control-label" for="wr_5">기타 전화번호(참고용)</label>
                <input type="text" class="form-control"  name="wr_5" id="wr_5" value="<?php echo $write['wr_5'] ?>">
            </div>

        </div>


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


	<div class="form-group label-floating">
	    <label class="control-label" for="wr_content">내용</label>
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>
				<?php echo str_replace('class=""', 'class=form-control rounded-0" wr_content" id="wr_content" rows="10""', $editor_html); // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>

                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
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
        <div class="row">
    <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
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
	<?php } ?>
        </div>
        <?php }?>

    <?php if ($is_guest) { //자동등록방지  ?>
	<div class="form-group" style="text-align: center;padding: 10px 0; ">
		<?php echo $captcha_html ?>
	</div>
    <?php } ?>
    
	<div class="text-center mb-4 mt-4">
	<button type="submit" id="btn_submit" accesskey="s" class="btn btn-raised btn-primary btn-sm">작성완료</button>
	<a class="btn btn-raised btn-secondary btn-sm" href="./board.php?bo_table=<?php echo $bo_table ?>">취소</a>
	</div>
    </form>

    <script>
        //그룹 (학교) 선택시 호출
        var callback = function(grpNo,grpName) {

            $('#wr_1').val(grpNo);
            $('#wr_1_nm').val(grpName);
        };


        $(function() {



            //학교  선택창
            $('#grp_button').click(function() {

                var  newWin=window.open("<?php echo G5_BBS_URL?>/gmember_find_win.php", "grp_find_w", "location=yes,links=no,toolbar=no,top=10,left=10,width=720,height=500,resizable=yes,scrollbars=no,status=no");
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
<!-- } 게시물 작성/수정 끝 -->