<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


if(!$subject) {
    $gmember = get_member_group($member['mg_no']);
    $subject = $gmember['mg_name']." 통신이용 증명원";
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


        <!-- 학교 no  -->
        <input type="hidden" name="wr_1" value="<?php echo $member['mg_no'] ?>">



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


        <?php if ($is_category) {
            $ca_name = "";
            if(empty($w) || empty($write['ca_name'])){

                $categories = explode("|", $board['bo_category_list']);
                if(sizeof($categories) > 0)
                    $ca_name = $categories[0];

            } else {
                $ca_name = $write['ca_name'];
            }
            ?>
            <input type="hidden" name="ca_name" id="ca_name" value="<?php echo $ca_name?>" >
        <?php } ?>


	<div class="form-group label-floating">
<!--	    <label class="control-label" for="wr_subject">제목</label>-->
		<input type="text" class="form-control readonly font-weight-bold" name="wr_subject" id="wr_subject" readonly value="<?php echo $subject ?>">


		<div id="autosave_wrapper">
            <?php if ($is_member) { // 임시 저장된 글 기능 ?>
            <script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
            <?php if($editor_content_js) echo $editor_content_js; ?>

            <?php } ?>
        </div>
	</div>
   <div class="row mt-4">
	<div class=col-md-6 form-group label-floating">
	            <input type="hidden" name="wr_content" value=".">

        <div class="alert alert-info rouded-2">
        *안심발신 서비스는 ? <br><br>
            개인 휴대폰 번호를 유선 일반 전화번호로 발신번호를 변경하는  서비스이기때문에 각 통신사(KT,SK,LG)에서 발급하는에서 <strong>"통신이용 증명원"</strong>이라는 것이 필요합니다.
            <br>
            각 통신사에 문의해 팩스 및 메일로 전달받은 "통신이용 증명원"을   우측의 <strong>"파일첨부"</strong> 기능을 이용해서, 이미지 파일을 첨부해서, 화면 아래의 <strong>"전송하기"</strong> 버튼을 눌러 저희 티처콜 고객센터로 전달해주세요.

            <br><br>*발급문의는 각반이나 학교에 사용하는 유선 전화가 이용하는 통신사의 고객센터(CS Center)로 문의하세요.

            <br><br>
           ▶ SKT<br>
              080-011-6000(무료), 1599-0011(유료)<br>
            ▶ KT<br>

            080-080-1618(무료), 1588-0010(유료)
            <br>


            ▶ LGU+<br>

            080-019-7000(무료), 1544-0010(유료)

            <br><br>

            <small class="text-danger">*참고 : 미납부시 안심발신 서비스 사용이 중지될 수 있습니다. </small>

        </div>
	</div>

        <div class="col-md-6">

            <?php for ($i=0; $is_file && $i<$file_count; $i++) {

                $required="";
                if($i==0 && !$w)
                    $required="required";

                ?>
                <div class="form-group">
                    <div class="input-group-prepend py-2">
                        <span class="font-weight-bold" id="inputGroupFileAddon01">*파일 첨부  <span class="bg-primary text-light rounded-circle py-1 px-2 text-size-4"><?php echo $i+1 ?></span></span>
                    </div>
                    <div class="custom-file">
                        <!-- 업로드한 파일명이 보이지 않는 문제 수정 (18-12-22) -->
                        <input type="file" class="custom-file-input" id="inputGroupFile<?php echo $i ?>" <?php echo $required?>   aria-describedby="inputGroupFileAddon01" accept="image/gif,image/jpeg,image/png"  name="bf_file[]">
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

   </div>







    <?php if ($is_guest) { //자동등록방지  ?>
	<div class="form-group" style="text-align: center;padding: 10px 0; ">
		<?php echo $captcha_html ?>
	</div>
    <?php } ?>
    
	<div class="text-center mb-4 mt-4">
	<button type="submit" id="btn_submit" accesskey="s" class="btn btn-raised btn-primary btn-sm"> <i class="fas fa-paper-plane"></i> 전송하기</button>
        <?php if(isCSMember()) { ?>
        <a class="btn btn-raised btn-secondary btn-sm" href="./board.php?bo_table=<?php echo $bo_table ?>">취소</a>
        <?php } ?>
	</div>
    </form>

    <script>
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