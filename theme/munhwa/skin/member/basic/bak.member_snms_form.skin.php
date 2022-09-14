<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_javascript('<script src="'.G5_JS_URL.'/tlog.js?vs='.time().'"></script>', 1);
?>

<link rel="stylesheet" href="<?php echo G5_THEME_URL ?>/asset/login/css/style.css">

<div class="container">
	<div class="section-header page">
		<h3><?php echo $g5['title'] ?></h3>
	</div>
	<div class="simple-box">

		<input type="hidden" name="reg_mb_id" id="reg_mb_id" value="<?php echo $member['mb_id']?>" >
		<input type="hidden" name="reg_mb_name" id="reg_mb_name" value="<?php echo $member['mb_name']?>" >
		<input type="hidden" name="reg_mb_hp" id="reg_mb_hp" value="<?php echo $member['mb_hp']?>" >


		<button type="button" class="btn btn-sm btn-outline-danger btn-block rounded-pill text-danger">
			<h5>안심번호 <?php echo phoneNumberFormat($member['mb_id'])?></h5>
		</button>



		<div class="list-group my-2 mt-4">
			<div class="list-group-item list-group-item-info">
				*연결 상태
			</div>
			<div class="list-group-item list-group-item-action text-center">
				<button type="button" id="btn_call_stat" class="btn <?=$callStatClass?> rounded-pill "><?=$callStat?></button>

			</div>
			<div class="list-group-item list-group-item-action text-center">


				<button type="button" id="btn_call_hold" class="btn btn-danger <?=($member['mb_call_stat']=="H")?"d-none":""?> " >
					<i class="fas fa-toggle-off"></i><span> 번호 일시중지</span>
				</button>


				<button type="button" id="btn_call_resume" class="btn btn-primary  <?=($member['mb_call_stat']=="A")?"d-none":""?> " >
					<i class="fas fa-toggle-on"></i><span >  번호 사용하기</span>
				</button>


				<button type="button"  id="btn_call_chk" class="btn btn-secondary  <?=($member['mb_call_stat']!="A")?"d-none":""?>" >
					<i class="fas fa-question-circle"></i><span > 번호 체크</span>
				</button>

			</div>

			<div class="list-group-item list-group-item-action text-center bg-light">
				<small>*  번호 "일시중지" 시, <span class="font-weight-bold">"연결서비스가 중지중이어서 전화연결을 할 수가 없습니다"</span>라는 안내멘트가 발신자에게 제공됩니다.</small>
			</div>


		</div>



		<div class="list-group my-2 mt-3">
			<div class="list-group-item list-group-item-warning">
				*연결 번호
			</div>
			<div class="list-group-item list-group-item-action text-center border-bottom-0">
				<input type="text" class="form-control text-h-4 text-center" id="mb_hp" value="<?php echo phoneNumberFormat($member['mb_hp'])?>">
			</div>

			<div class="list-group-item list-group-item-action text-center">
				<button type="button" id="btn_mod" class="btn btn-primary btn-block" >번호 수정하기</button>
			</div>

			<div class="list-group-item list-group-item-action text-center bg-light">
				<small>*  연결 번호 수정시 24시간 이내  재 수정 불가능합니다. </small>
			</div>
		</div>


		</form> <!-- /form -->
	</div><!-- /card-container -->
</div><!-- /container -->

<script>

	var IS_REQUEST=false;
	var requestCnt = 0;
	var TLOG_AGENCY_CODE="<?php echo $gmember['mg_agency_code']?>"; //log.js predefined ___________

	//ready___________________________________________________________
	$(function(){

		// 안심번호 확인
		$('#btn_call_chk').click(function(){
			requestCheckSafetyNumberAlert();
		});

		// 안심번호 > 연결번호 수정
		$('#btn_mod').click(function(){
			$.getJSON("/bbs/ajax.mb_phone_number_check.php",
				{
					'upd_uid':'<?php echo $member['mb_id']?>'
				},
				function(data){
					if(data.result_stat){
						requestModSafetyNumber(true);
					} else {
						alert(data.result_msg);
					}
			});

		});


		//안심번호 홀딩
		$('#btn_call_hold').click(function(){
			requestHoldSafetyNumber();
		});


		//안심번호 재활성화
		$('#btn_call_resume').click(function(){
			requestResumeSafetyNumber();
		});


		$("input[name='mb_type']").change(function(){
			$('#mb_id').val('');
			$('#mb_password').val('');
			$('#mb_id').focus();
		});




	});



	////////////////////////////////////////////////////////////////////////////////
	// 수정(w = u) > 사용자 휴대폰번호 수정시 발생
	function requestModSafetyNumber(isAlert){

		if(IS_REQUEST) {
			alert('처리 중입니다. ');
			return false;
		}


		var mbId = $("#reg_mb_id").val().trim().replace(/[- ]/gi, "");
		var mbName = $('#reg_mb_name').val().trim().replace(/[- \.\?,_~&^%\$\!@+#\(\)<>\{\}\[\]\\`]/gi, "");
		var mbNumber = $('#reg_mb_hp').val().trim().replace(/[- \.]/gi, "");
		var targetNumber = $('#mb_hp').val().trim().replace(/[- \.\?,_~&^%\$\!@+#\(\)<>\{\}\[\]\\`]/gi, "");


		// 안심-> 맵핑 대상번호 체크 ----------------------------------------------

		var hpPattern = /^01[016789][0-9]{3,4}[0-9]{4}$/;

		if(!hpPattern.test(targetNumber)) {
			alert('휴대폰 번호를 바르게 입력하세요.');
			$('#mb_hp').focus();
			return false;
		}

		if(mbNumber == targetNumber){
			alert('변경할 전화번호와 기존 전화번호가 동일합니다. ');
			$('#mb_hp').focus();
			return false;
		}

		//20200320 appended
		// 착신번호 -> 대표번호 체크_______
		var mstNumPattern = /^15.{8}$/;
		if(targetNumber.length > 0 && mstNumPattern.test(targetNumber)){
			alert('안심 착신번호는 대표번호를 사용 할 수 없습니다.');
			return false;
		}

		// 착신번호 -> 050 입력방지 체크
		var virPattern = /^050.{7,9}$/;
		if(targetNumber.length > 0 && virPattern.test(targetNumber)) {
			alert('안심번호 자체를 착신 할 수 없습니다. ');
			return false;
		}

		/*******************
		if(!safetyNumber || !safetyName || !targetNumber)
			return false;
			****/

		IS_REQUEST=true;
		var res1 = tlog_number_update(mbId, mbName, targetNumber);

		//console.log(res1);
		if (!res1 || res1.Result != "1") {
			if(res1 && res1.hasOwnProperty("ErrCode")) {
				alert("안심번호 수정에 실패했습니다. (1 / 원인 :  "+tlog_get_error_msg(res1.ErrCode)+" ) ");
			} else {
				alert("안심번호 수정에 실패했습니다. (1)");
			}

			IS_REQUEST=false;
			return false;
		}


		var actionUrl = "<?php echo G5_BBS_URL?>/ajax.mb_phone_number_update.php"
		$.ajax({
			method: "POST",
			dataType:"json",
			url:actionUrl,
			cache:false,
			data:{
				"upd_uid":mbId,
				"upd_number":targetNumber
			},
			success:function(data){

				IS_REQUEST=false;
				//callback(data.result_stat,data.result_msg);
				if(data.result_stat){

					$('#reg_mb_hp').val(targetNumber);
					if(isAlert)
						alert('*안심번호 수정 처리 되었습니다. ');

				} else {
					alert('*수정실패 \n\n'+data.result_msg);
				}

			},
			error : function(xhr, status, error) {
				alert('네트워크 오류가 발생했습니다. (*잠시 후 재시도)');
				return false;
			}
		});






	} //end func=========================================================



	function requestCheckSafetyNumberAlert(){

		if(IS_REQUEST){
			alert('처리중입니다.');
			return false;
		}

		var safetyNumber = $("#reg_mb_id").val().trim().replace(/-/gi, "");

		IS_REQUEST=true;
		var res1 = tlog_number_check(safetyNumber);
		IS_REQUEST=false;
		if (!res1 || res1.Result != "1") {
			alert("안심번호 조회에 실패했습니다. ");
			return false;
		}


		var statusName = "";

		if(res1.Shop_Satus=="0")
			statusName="미사용";
		else if(res1.Shop_Satus=="1")
			statusName="사용중";
		else if(res1.Shop_Satus == "2")
			statusName="정지중";
		else if(res1.Shop_Satus == "3")
			statusName="해지중";

		var inpNumber = $('#reg_mb_hp').val();

		if(res1.Shop_phone == "0") //미사용
			alert('* 체크 결과 : 오류발생 \n  050 안심번호 상태는 [ '+statusName+' ] 입니다.  \n\n 관리자에 문의하세요. ');
		else if(inpNumber!= res1.Shop_phone) {
			//alert('* 안심서버에 등록된  ' + phone_format(safetyNumber) + '와 연결된 ' + phone_format(res1.Shop_phone) + ' \n 번호와 화면에 입력된 회원 휴대폰번호가 상이합니다. 확인하세요. ');
			alert('*체크 결과 : 오류발생 \n 안심서버에 등록된   ' + phone_format(res1.Shop_phone) + ' \n 번호와 회원님의 입력된 연결번호(휴대폰번호)가 상이합니다. \n\n 화면 아래의 "번호 수정하기"기능을 이용해서 재등록하세요. ');
			$('#reg_mb_hp').focus();
			return true;
		} else if(res1.Shop_Satus == "1") {
			//alert('* 안심번호 ' + phone_format(safetyNumber) + ' ▶ ' + phone_format(res1.Shop_phone) + ' 정상연결중이며,\n   ~상태는 : [ ' + statusName + ' ] 입니다.');
			alert('*체크 결과 : 정상  \n'+phone_format(res1.Shop_phone) + '번호와 연결중이며, 현재 번호상태는 : [ ' + statusName + ' ] 입니다.');
		} else { // 2,3 일시정지 , 해지
			alert('* 현재 안심번호 ' + phone_format(safetyNumber) + '  -▶  ' + phone_format(res1.Shop_phone) + ' 연결 중이며,  \n   *현재 번호상태는 : [ ' + statusName + ' ] 입니다. \n\n 관리자에게 문의 바랍니다.');
		}


	} //end method ====================================================== =====================================



	///
	/// 안심번호 일시정지 /////////////////////////////////////////////
	function requestHoldSafetyNumber(){

		if(IS_REQUEST){
			alert('처리중입니다. ');
			return false;
		}


		var safetyNumber = $("#reg_mb_id").val().trim().replace(/-/gi, "");
		if(!safetyNumber)
			return false;

		var cf = confirm('해당번호를 일시 사용중지 하시겠습니까?');
		if(!cf)
			return false;




		IS_REQUEST=true;
		//var res = tlog_number_expire(safetyNumber);
		var res = tlog_number_hold(safetyNumber);

		if (!res || res.Result != "1") {

			if(res && res.hasOwnProperty("ErrCode")) {
				alert("안심번호 정지요청에 실패했습니다. (1 / 원인 :  "+tlog_get_error_msg(res.ErrCode)+" ) ");
			} else {
				alert("안심번호 정지요청에 실패했습니다. (1)");
			}

			IS_REQUEST=false;
			return false;
		}


		updateCallStat(safetyNumber,'H', function(stat,msg) {

			IS_REQUEST=false;
			alert(msg);

			if(stat){
				$('#btn_call_stat').removeClass('btn-outline-primary font-weight-bold').addClass('btn-outline-secondary').text('일시 정지');
				$('#btn_call_hold').hide();
				$('#btn_call_chk').hide(); // A 정상 . 상태에서만 조회가능
				$('#btn_call_resume').removeClass("d-none").show();
			}

		});

	} //end requestHoldSafetyNumber func=========== ====================================================================



	///
	/// 안심번호 재사용하기 ///////////////////////////////////////////// /////////////////
	///
	function requestResumeSafetyNumber(){


		if(IS_REQUEST){
			alert('처리중입니다. ');
			return false;
		}

		var safetyNumber = $("#reg_mb_id").val().trim().replace(/-/gi, "");
		if(!safetyNumber)
			return false;

		var cf = confirm('해당번호를 다시 사용하시겠습니까?');
		if(!cf)
			return false;


		IS_REQUEST=true;
		var res = tlog_number_resume(safetyNumber);
		if (!res || res.Result != "1") {

			if(res && res.hasOwnProperty("ErrCode")) {
				alert("안심번호 재사용 요청에 실패했습니다. (1 / 원인 :  "+tlog_get_error_msg(res.ErrCode)+" ) ");
			} else {
				alert("안심번호 재사용 요청에 실패했습니다. (1)");
			}

			IS_REQUEST=false;
			return false;
		}


		updateCallStat(safetyNumber,'A', function(stat,msg) {

			IS_REQUEST=false;
			alert(msg);

			if(stat){
				$('#btn_call_stat').removeClass('btn-outline-secondary').addClass('btn-outline-primary font-weight-bold').text('사용중');
				$('#btn_call_hold').removeClass("d-none").show();
				$('#btn_call_chk').removeClass("d-none").show(); // A 정상 . 상태에서만 조회가능
				$('#btn_call_resume').hide();
			}


		});

	} //end requestHoldSafetyNumber func ==============================



	/// 회원 콜 상태 변경 함수 ///////////////////////////////////////////////////////////////////////////////////
	// state : A : active,  E : expire, H:hold 추가
	function updateCallStat(targetUId,callStat,callback){

		if(typeof callback !== "function"){
			alert('callback 파라미터에 오류가 있습니다. ');
			return false;
		}
		var actionUrl = "<?php echo G5_BBS_URL?>/ajax.mb_call_stat_update.php"
		$.ajax({
			method: "POST",
			dataType:"json",
			url:actionUrl,
			cache:false,
			data:{
				"upd_uid":targetUId,
				"upd_stat":callStat
			},
			success:function(data){
				callback(data.result_stat,data.result_msg);
			},
			error : function(xhr, status, error) {
				callback(false,'네트워크 오류가 발생했습니다. (*잠시 후 재시도)');
				return false;
			}
		});

	}




</script>


