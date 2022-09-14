<section id="detail_area">

   <!-- 안심번호 이용료   ---------------------------------------->
    <p class="regist-title">
        <i class="fas fa-info-circle"></i>  안심번호(050) 관리비
    </p>
    <ul class="list-group mb-4">
        <li class="list-group-item">
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label for="reg_mb_id">월 이용료</label>
                        <input type="text" name="snms_amt" value="<?php echo number_format($gdata['gc_snms_amt'])?>원" id="snms_amt"  readonly class="form-control font-weight-bold text-danger" minlength="12" maxlength="20">
                    </div>
                  </div>
            </div>
        </li>

    </ul>


    <!-- sms 이용료 -------------------------------------------------------->


    <p class="regist-title">
        <i class="fas fa-sms"></i>  문자 서비스 사용료
    </p>
    <ul class="list-group mb-4">
        <li class="list-group-item">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sms_amt">SMS 이용료</label>
                        <input type="text" name="sms_amt" id="sms_amt" class="form-control "  value="<?php echo number_format($gdata['sms_amt'])?>원" readonly  maxlength="20" >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lms_amt">LMS 이용료</label>
                        <input type="text" name="lms_amt" id="lms_amt" class="form-control"  value="<?php echo number_format($gdata['lms_amt'])?>원"  readonly  maxlength="20" >
                    </div>
                </div>
            </div>
        </li>

        <li class="list-group-item">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mms_amt">MMS 이용료</label>
                        <input type="text" name="mms_amt" id="mms_amt" class="form-control "  value="<?php echo number_format($gdata['mms_amt'])?>원"  readonly  maxlength="20" >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lms_amt" class="font-weight-bold">문자 전체 사용료</label>
                        <input type="text" name="gc_sms_amt" id="gc_sms_amt" class="form-control text-danger font-weight-bold"   value="<?php echo number_format($gdata['gc_sms_amt'])?>원"  readonly  maxlength="20" >
                    </div>
                </div>
            </div>
        </li>

    </ul>





    <!-- tnms 이용료 -------------------------------------------------------->




    <p class="regist-title">
        <i class="fas fa-phone-alt"></i>  안심발신 서비스 사용료
    </p>
    <ul class="list-group mb-4">
        <li class="list-group-item">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tnms_cnt">통화 건수</label>
                        <input type="text" name="tnms_cnt" id="tnms_cnt" class="form-control "  value="<?php echo number_format($gdata['gc_tnms_cnt'])?>건" readonly  maxlength="20" >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tnms_time">통화 시간</label>
                        <input type="text" name="tnms_time" id="tnms_time" class="form-control"  value="<?php echo wellKnownSecondsTime($gdata['gc_tnms_time'])?>"  readonly  maxlength="20" >
                    </div>
                </div>
            </div>
        </li>

        <li class="list-group-item">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tnms_amt">안심발신 이용료</label>
                        <input type="text" name="tnms_amt" id="tnms_amt" class="form-control font-weight-bold text-danger"  value="<?php echo number_format($gdata['gc_tnms_amt'])?>원"  readonly  maxlength="20" >
                    </div>
                </div>


            </div>
        </li>

    </ul>



    <!--   결제 정보   ---------------------------------------------------------------------------->




    <div>&nbsp;</div>
    <p class="regist-title font-weight-bold text-primary mt-4">
        <i class="fas fa-money-check-alt"></i>  결제 정보
    </p>
    <ul class="list-group mb-4">
        <li class="list-group-item list-group-item-primary">
            <div class="row">
                <div class="col-md-6 font-weight-bold p-3">
                    <h5>*결제 상태 : <?php echo $payStatus;?></h5>
                </div>


            </div>
        </li>


        <!-- 결제 상태(미결제, 입금대기, 결제완료 )에 따른 하위 > 레이아웃 결정  ------->

        <li class="list-group-item">
            <div class="row">
                <div class="col-12 p-3">

                        <label class="font-weight-bold text-danger p-2"> 총 사용요금 :
                            <?php echo number_format($payAmt)?>원 (*부가세 포함)
                        </label>
                        <div class="small text-warning">
                            * 서비스 사용유무에 따라, 안심번호 + 문자서비스 + 안심발신 서비스 월 이용요금의 합계입니다.
                        </div>

                </div>
            </div>
        </li>



        <?php if($payStatus == "미결제" || $payStatus == "결제취소") { ?>
        <li class="list-group-item">
            <div class="row">
                <div class="col-12 p-3">
                    <button type="button"  onclick="show_paytype_modal('<?=$payName?>',<?=$payAmt?>);" class="btn btn-primary btn-lg">결제하기</button>
                    <div class="small text-warning mt-2">
                        *결제 방법은 "카드결제", "무통장입금"이 가능합니다.
                    </div>
                </div>
            </div>
        </li>
        <?php } else if($payStatus == "입금대기") { ?>

            <li class="list-group-item">
                <div class="row">
                    <div class="col-auto">
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item"><?=$payData['pg_bank_nm']?></li>
                        <li class="list-group-item"><?=$payData['pg_bank_no']?></li>
                        <li class="list-group-item">*입금액 : <?=number_format($payAmt)?>원</li>
                    </ul>
                    </div>
                    <div class="col-auto small text-warning">

                        *  <?=date_format(date_create($payData['pg_bank_expire']),"Y-m-d H:i분");?> 까지 입금해주세요. 미입금시 해당계좌가 폐쇠처리됩니다.
                    </div>
                </div>
            </li>

        <?php  } else if($payStatus == "결제완료")  { ?>

            <li class="list-group-item">
                <div class="row p-2">

                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item">결제방법 : <?=$payMethod?></li>
                        <li class="list-group-item">결제일자 : <?=$payDate?></li>
                        <li class="list-group-item">결제금액 : <?=number_format($payAmt)?>원</li>
                    </ul>
                 </div>
            </li>
        <?php } ?>

    </ul>





    <!-- 파일 다운로드 ---------------------------------------->
    <p class="regist-title">
        <i class="fas fa-download"></i>  기타
    </p>
    <ul class="list-group mb-4">
        <li class="list-group-item">
                <div class="row">
                    <div class="col-md-6">
                            <button type="button" id="btnEstimate" class="btn btn-sm btn-info" ><i class="fas fa-file-invoice-dollar"></i> 견적서 다운로드</button>
                        <?php if($payData['pg_stat'] == G5_PG_STAT_SUCC){?>
                             <button type="button" id="btnTrading" class="btn btn-sm btn-success" ><i class="fas fa-file-alt"></i> 거래명세서 다운로드</button>


                            <!-- 결제 영수증 출력 --->
                            <?php if($payData['pg_type'] == G5_PG_TYPE_CARD){ ?>
                                <button type="button" id="btnReceipt" onclick="receiptForCard('<?php echo $payData['pg_tr_no']?>')" class="btn btn-sm btn-warning d-none d-sm-none d-md-inline"><i class="fas fa-print"></i> 결제 영수증 확인</button>
                            <?php } else if($payData['pg_type'] == G5_PG_TYPE_BANK_VIR) {?>
                                <button type="button" id="btnReceipt" onclick="receiptForVirtualAccount('<?php echo $payData['pg_tr_no']?>')" class="btn btn-sm btn-warning d-none d-sm-none d-md-inline"><i class="fas fa-print"></i>결제 영수증 확인</button>
                            <?php } ?>

                        <?php } ?>



                    </div>
                </div>
        </li>

    </ul>


    <!-- kicc 영수증 출력 관련 / 폼  -->
    <form name="form1" method="get" action="">
        <input type=hidden name=controlNo>
        <input type=hidden name=payment>
    </form>





</section>

