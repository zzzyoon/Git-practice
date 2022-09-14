<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

</div>
<!-- /.container -->
<!-- } 콘텐츠 끝 -->

<!--<div class="d-flex justify-content-center  bg-dark text-light p-1">-->
<!--    Copyright (C) TLogTeleCom Co., Ltd. All rights reserved.-->
<!--</div>-->


<!-- 하단 시작 { -->
<?php
if(defined('_INDEX_')) { // index에서만 실행
?>
	<!-- 접속자 통계 -->
	<div class="py-1 mt-2 bg-light border-top">
	  <?php// echo visit('theme/basic'); // 접속자집계, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정 ?>
  </div>
<?php } ?> 


<!--모달 영역 MODAL AREA / 개인 정보창   {   ----------------------------------------------------------------------->
<div class="modal" id="userModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-light">
                <h5 class="modal-title">
                <i class='fas fa-info-circle'></i>
                <?php echo $member['mb_name']?>님 / 정보
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




</main>    
<!--    
<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { 
}
?>
-->

<?php
if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>
<!-- } 하단 끝 -->

<!-- Return to Top / Circle Image -->
<a href="javascript:" id="return-to-top" class="pt-1 text-light font-weight-bold"><i class="fas fa-chevron-up"></i></a>


<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));


    //bylee. clipboard js > init
    new ClipboardJS('.btn-cb');

    //bootstrap > popover _______________________
    $('[data-toggle="popover"]').popover()
    $('.popover-dismiss').popover({
        trigger: 'focus'
    });



});


//로그인 사용자정보 > modal //////////////////////////////////////////////////
function showUserDlg(){
       $.get("<?php echo G5_BBS_URL?>/ajax.mb_info.php",function(data){
            $('#userModal .modal-body').html(data);
       });
    //$('#userModal').show();
    $('#userModal').modal();
}

//App > App 설명 박스 (About menu) ////////////////////////////////////////////
function showAboutDlg(){
 $('#aboutModal').modal();
}

// ===== Scroll to Top ==== 
$(window).scroll(function() {
    if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
        $('#return-to-top').fadeIn(200);    // Fade in the arrow
    } else {
        $('#return-to-top').fadeOut(200);   // Else fade out the arrow
    }
});
$('#return-to-top').click(function() {      // When arrow is clicked
    $('body,html').animate({
        scrollTop : 0                       // Scroll to top of body
    }, 500);
});


</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>