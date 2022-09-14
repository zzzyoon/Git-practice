<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<link rel="stylesheet" href="<?php echo G5_THEME_URL ?>/asset/login/css/style.css">
<div class="container">
	<div class="card card-container">
		<div class="text-center p-1">
			<img  srcset="<?php echo G5_THEME_URL ?>/img/app_login.png,
               <?php echo G5_THEME_URL ?>/img/app_login2x.png 2x"  src="<?php echo G5_THEME_URL ?>/img/app_login.png">
		</div>
		<!--        		<p id="profile-name" class="profile-name-card"></p>-->

		<form name="flogin" autocomplete="off" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post" class="form-signin my-4">
			<input type="hidden" name="url" value="<?php echo $login_url ?>">
			<span id="reauth-email" class="reauth-email"></span>

			<input type="text" name="mb_id" id="mb_id" class="form-control m-1" inputmode="numeric" placeholder="사용자 번호" required autofocus>
			<input type="password" name="mb_password" id="mb_password" class="form-control m-1" placeholder="비밀번호" required>

			<div class="text-warning text-center my-2">
				<small>* 공백 및 특수문자 없이 입력하세요.</small>
			</div>



			<div class="row   my-1">
				<label for="jg_gb" class="offset-1 col-4 col-form-label text-center">작업 구분</label>
				<div class="col-7 pt-2">
					<strong>(주)카포</strong>
					<input type="radio" name="jg_gb" id="jg_gb1" checked value="CAPO">
					&nbsp;
                    <strong>(유)카포</strong>
					<input  type="radio" name="jg_gb" id="jg_gb2"  value="UCAPO">

				</div>
			</div>

			<div>
				&nbsp;
			</div>

			<button class="btn btn-lg btn-primary btn-block btn-signin" type="submit"> <i class="fas fa-sign-in-alt"></i> 로그인</button>
			<a class="btn btn-lg btn-danger btn-block"  href="app://application.exit" target="_self"><i class="fas fa-times-circle"></i> 종료하기</a>



			<div class="mt-4 text-center text-size-4">
					 (c) Easy Information System Co.,Ltd.

			</div>

		</form><!-- /form -->
	</div><!-- /card-container -->
</div><!-- /container -->

<script>

	//ready
	$(function(){


	});

	function flogin_submit(f)
	{
		return true;
	}

</script>
<!-- } 로그인 끝 -->

<script src="<?php echo G5_URL ?>/assets/login/js/scripts.js"></script>