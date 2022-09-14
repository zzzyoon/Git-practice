<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

</div>
<!-- /.container -->
<!-- } 콘텐츠 끝 -->

<!-- 하단 시작 { -->
<?php
if(defined('_INDEX_')) { // index에서만 실행
?>
	<!-- 접속자 통계 -->
	<div class="py-1 mt-2 bg-light border-top">
	  <?php// echo visit('theme/basic'); // 접속자집계, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정 ?>
  </div>
<?php } ?> 

<?php if(isAppClient()) { ?>
<!--<div class="alert alert-danger">* 어플 로그인 </div>-->
<?php } ?>


<?php if(!isAppClient()) { ?>

  <!--- Footer ---->

  <footer>

</footer>

  <!--
  <footer id="footer" class="py-4 bg-dark">

    <div class="container">
      <div class="row small text-light">
        <div class="col-12">
          <?php if(is_mobile()){ ?>
                Copyright &copy; <?php echo $config['cf_site_name']; ?>. All rights reserved.
          <?php } else { ?>
               Copyright &copy; <?php echo $config['cf_site_name']; ?> 2019. All rights reserved.
          <?php } ?>
        </div>
      </div>


      <div class="row small text-light">
            <div class="col-auto">

            <strong>(주)티로그 텔레콤 </strong> <span class="d-none d-md-inline">사업자 :</span> 609-86-19218   대표 : 조민제

            </div>
                 <div class="col-auto text-left">
            <i class="fas fa-envelope-square"></i> <span class="d-none d-md-inline">이메일 : </span> ceo@shoppr.kr
            </div>


       </div>




    </div>



  </footer>
-->


<?php }  // isAppClient  ?>


<!--모달 영역 MODAL AREA / 개인 정보창   {   ----------------------------------------------------------------------->
<div class="modal" id="workTypeModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-light">
                <h5 class="modal-title">

                    작업 종류를 선택하세요.
                </h5>
                <button type="button" class="close text-light" data-dismiss="modal"><i class="fas fa-window-close" style="font-size:20px;"></i></button>
            </div>


            <!-- Modal body -->
            <div class="modal-body">

                <div  class="row">

                    <div class="col-6 text-center my-1">
                        <a href="/bbs/work_type_set.php?work_type=A"  class="btn btn-sq-lg btn-primary text-light  p-3 rounded-pill ">
                            <br>
                            <i class="fas fa-book fa-4x"></i>
                            <p class="mt-2">
                            Genuine product
                            <br>
                            <strong>정품 작업</strong>
                            </p>

                        </a>

                    </div>
                    <div class="col-6 text-center my-1">
                        <a href="/bbs/work_type_set.php?work_type=X"  class="btn btn-sq-lg btn-danger text-light p-3 rounded-pill">
                            <br>
                            <i class="fas fa-book fa-4x"></i>

                            <p class="mt-2">Return Product
                                <br>
                                <strong>반품 작업</strong>
                            </p>

                        </a>

                    </div>

                </div>

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
//    new ClipboardJS('.btn-cb');

});


//로그인 사용자정보 > modal //////////////////////////////////////////////////
function showWorkTypeDlg(){
    $('#workTypeModal').modal();
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