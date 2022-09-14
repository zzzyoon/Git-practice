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
        <i class="fas fa-info-circle"></i>  결제취소  메세지
    </p>

    <ul class="list-group mb-4">
        <li class="list-group-item list-group-item-danger">

                <div class="row">
                    <div class="col-12 col-md-6 font-weight-bold">

                            <?php if($res_cd == "0000") echo"결제취소 완료"; else echo"결제취소 실패 (*".rawurldecode($res_msg).")";?>

                    </div>
                  </div>

        </li>

    </ul>


    <p class="regist-title">
        <i class="far fa-credit-card"></i>  결제취소 세부정보
    </p>


    <ul class="list-group mb-4">
        <li class="list-group-item">
            <div class="row">


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lms_amt">취소상품</label>
                        <input type="text" name="lms_amt" id="lms_amt" class="form-control font-weight-bold"  value="<?php echo$product_nm;?>"  readonly  maxlength="20" >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sms_amt">취소금액 </label>
                        <input type="text" name="sms_amt" id="sms_amt" class="form-control font-weight-bold"  value="<?php echo number_format($amount)?>원" readonly  >
                    </div>
                </div>

            </div>
        </li>

        <li class="list-group-item">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mms_amt">주문번호</label>
                        <input type="text" name="mms_amt" id="mms_amt" class="form-control "  value="<?php echo $order_no?>"  readonly  >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lms_amt">취소일자</label>
                        <input type="text" name="gc_sms_amt" id="gc_sms_amt" class="form-control"   value="<?php echo date_format(date_create($canc_date),"Y-m-d H:i분")?>"  readonly  >

                    </div>
                </div>
            </div>
        </li>
    </ul>





    <!-- 기타 버튼 --->

    <div class="mt-4">&nbsp;</div>
    <p class="regist-title">
        <i class="fas fa-question-circle"></i>  기타
    </p>


    <div class="row">
        <div class="col-lg-6">
            <?php if($is_admin == "super") { ?>
                <a class="btn btn-sm p-2" href="<?php echo G5_ADMIN_URL?>/member_grp_pg_list.php" role="button"><i class="fas fa-list-alt"></i> *관리자 > 월관리비 결제관리 이동</a>
            <?php } else { ?>
                  <a class="btn btn-sm  p-2" href="<?php echo G5_BBS_URL?>/gmember_charge.php" role="button"><i class="fas fa-paperclip"></i> 월별 요금현황 페이지로 이동</a>
            <?php } ?>
        </div>

    </div>




</section>

<div>&nbsp;</div>

<script>

    var pay_request_cnt = 0;

    $(function() {


    });



</script>