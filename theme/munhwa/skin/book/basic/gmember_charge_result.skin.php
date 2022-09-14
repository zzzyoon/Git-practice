<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
//add_javascript('<script src="'.$sms_skin_url.'/skin.js"></script>', 10);
?>
<script language="javascript" src="<?php echo G5_PG_PC_URL?>/js/default.js" type="text/javascript"></script>


<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>

<section id="result_area">

   <!-- 결제결과  ---------------------------------------->
    <p class="regist-title">
        <i class="fas fa-info-circle"></i>  결제 결과 메세지
    </p>

    <ul class="list-group mb-4">
        <li class="list-group-item list-group-item-primary">

                <div class="row">
                    <div class="col-12 col-md-6 font-weight-bold">
                        <?php if($pay_type == "11") {  // 카드 결제  -----------------------------------------------    ?>
                            <?php if($res_cd == "0000") echo"결제(납부) 성공"; else echo"결제 실패";?>
                        <?php } else if($pay_type == "22") { ?>
                            <?php if($res_cd == "0000") echo"가상계좌 발급"; else echo"가상계좌 실패";?>
                        <?php } else {
                                echo "결제 중 오류가 발생했습니다.";
                        } ?>
                    </div>
                  </div>

        </li>

    </ul>


    <p class="regist-title">
        <i class="far fa-credit-card"></i>  결제 세부정보
    </p>


    <?php if($res_cd != "0000"){ // 결제 실패  ?>
    <ul class="list-group mb-4">
        <li class="list-group-item list-group-item-danger">

                <div class="row">
                    <div class="col-12 col-md-6 font-weight-bold h3">
                        <i class="fas fa-window-close"></i> 결과 : <?php echo rawurldecode($res_msg)?> (* <?=$res_cd?>)
                    </div>
                </div>

        </li>

    </ul>

    <?php } else  if($pay_type == "11") {  // 카드 결제  -----------------------------------------------    ?>

    <ul class="list-group mb-4">
        <li class="list-group-item">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sms_amt">결제금액 </label>
                        <input type="text" name="sms_amt" id="sms_amt" class="form-control text-danger font-weight-bold"  value="<?php echo number_format($amount)?>원" readonly  >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lms_amt">결제방법</label>
                        <input type="text" name="lms_amt" id="lms_amt" class="form-control font-weight-bold"  value="카드결제"  readonly  maxlength="20" >
                    </div>
                </div>
            </div>
        </li>

        <li class="list-group-item">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mms_amt">승인번호</label>
                        <input type="text" name="mms_amt" id="mms_amt" class="form-control "  value="<?php echo $auth_no?>"  readonly  >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lms_amt">승인일자</label>
                        <input type="text" name="gc_sms_amt" id="gc_sms_amt" class="form-control"   value="<?php echo date_format(date_create($tran_date),"Y-m-d H:i분")?>"  readonly  >

                    </div>
                </div>
            </div>
        </li>
    </ul>

    <?php } else  if($pay_type == "22") {  //무통장입금 (가상계좌) 결제  -----------------------------------------------    ?>

        <ul class="list-group mb-4">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sms_amt">결제금액 </label>
                            <input type="text" name="sms_amt" id="sms_amt" class="form-control font-weight-bold"  value="<?php echo number_format($amount)?>" readonly  >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lms_amt">결제방법</label>
                            <input type="text" name="lms_amt" id="lms_amt" class="form-control font-weight-bold"  value="무통장 입금"  readonly  maxlength="20" >
                        </div>
                    </div>
                </div>
            </li>

            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mms_amt">입금은행명</label>
                            <input type="text" name="mms_amt" id="mms_amt" class="form-control "  value="<?php echo $bank_nm?>"  readonly  >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lms_amt">입금계좌번호</label>
                            <input type="text" name="gc_sms_amt" id="gc_sms_amt" class="form-control"   value="<?php echo $account_no?>"  readonly  >
                        </div>
                    </div>
                </div>
            </li>


            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mms_amt">계좌만료일</label>
                            <input type="text" name="mms_amt" id="mms_amt" class="form-control "  value="<?php echo date_format(date_create($expire_date),"Y-m-d H:i분")?>"  readonly  >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lms_amt">입금자</label>
                            <input type="text" name="gc_sms_amt" id="gc_sms_amt" class="form-control"   value="<?php echo $deposit_nm?>"  readonly  >
                        </div>
                    </div>
                </div>
            </li>

            <li class="list-group-item p-3 text-danger">
                <strong>*입금 참고 사항 :</strong><br>
                위의 임시 발급된 계좌로  만료일
                <?php echo date_format(date_create($expire_date),"Y-m-d H:i분")?>까지, <strong><?php echo number_format($amount);?></strong>원을 입금하시면, 해당월의 관리비가 결제완료 처리 됩니다.

            </li>
        </ul>

    <?php } ?>




    <!-- 기타 버튼 --->

    <div class="mt-4">&nbsp;</div>
    <p class="regist-title">
        <i class="fas fa-question-circle"></i>  기타
    </p>


    <div class="row">
        <div class="col-lg-6">
            <a class="btn btn-sm  p-2 text-primary" href="./gmember_charge.php" role="button"><i class="fas fa-paperclip"></i> 월별 요금현황 페이지로 이동</a>
        </div>

    </div>




</section>

<div>&nbsp;</div>

<script>

    var pay_request_cnt = 0;

    $(function() {


    });




    //bylee  //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 요청때마다 . 주문번호 생성
    function generate_ordno(member_no){
        var today = new Date();
        var year  = today.getFullYear();
        var month = today.getMonth() + 1;
        var date  = today.getDate();
        var time  = today.getTime();

        if(parseInt(month) < 10)
        {
            month = "0" + month;
        }

        if(parseInt(date) < 10)
        {
            date = "0" + date;
        }

        return "ORD_"+member_no+"_"+ year + month + date + time;   //가맹점 주문번호

    }




</script>