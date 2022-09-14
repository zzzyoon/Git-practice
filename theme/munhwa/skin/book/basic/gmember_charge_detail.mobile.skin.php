<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
//add_javascript('<script src="'.$sms_skin_url.'/skin.js"></script>', 10);
//echoVarDump($gdata);
?>
<script language="javascript" src="<?php echo G5_PG_PC_URL?>/js/default.js" type="text/javascript"></script>
<!-- Test -->
<!--<script type="text/javascript" src="https://testpg.easypay.co.kr/webpay/EasypayCard_Web.js"></script>-->
<!-- Real -->
<script type="text/javascript" src="https://pg.easypay.co.kr/webpay/EasypayCard_Web.js"></script>



<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>




<div class="row">
    <div class="col-md-6 col-12">
        <button type="button" name="title"  id="title" size="12"  readonly class="btn btn-lg btn-primary   text-center font-weight-bold" > * 관리월 : <?php echo $gdata['gc_month'] ?> 월</button>

    </div>

</div>
<div>&nbsp;</div>


<?php include_once $gm_skin_path."/view_gmember_charge_detail.php";?>

<div>&nbsp;</div>

<!-- mobile payment form -->
<form name="frm_pay" method="post" action="">
    <!-- [START] 인증요청 필드 -->     <!--  <table>내에도 일부 파라미터 존재합니다.-->

    <!--공통-->
    <input type="hidden" id="sp_mall_nm"           name="sp_mall_nm"           value="" />               <!--[선택]가맹점명 -->
    <input type="hidden" id="sp_order_no"          name="sp_order_no"          value="" />               <!--[필수]가맹점 주문번호(인증응답) -->
    <input type="hidden" id="sp_currency"          name="sp_currency"          value="" />               <!--[필수]통화코드(수정불가) -->
    <input type="hidden" id="sp_return_url"        name="sp_return_url"        value="" />               <!--[필수]가맹점 return URL -->
    <input type="hidden" id="sp_lang_flag"         name="sp_lang_flag"         value="" />               <!--[선택]언어 -->
    <input type="hidden" id="sp_charset"           name="sp_charset"           value="UTF-8" />               <!--[선택]가맹점 charset -->
    <input type="hidden" id="sp_user_id"           name="sp_user_id"           value="" />               <!--[선택]가맹점 고객ID -->
    <input type="hidden" id="sp_memb_user_no"      name="sp_memb_user_no"      value="" />               <!--[선택]가맹점 고객일련번호 -->
    <input type="hidden" id="sp_user_nm"           name="sp_user_nm"           value="" />               <!--[선택]가맹점 고객명 -->
    <input type="hidden" id="sp_user_mail"         name="sp_user_mail"         value="" />               <!--[선택]가맹점 고객 E-mail -->
    <input type="hidden" id="sp_user_phone1"       name="sp_user_phone1"       value="" />               <!--[선택]가맹점 고객 연락처1 -->
    <input type="hidden" id="sp_user_phone2"       name="sp_user_phone2"       value="" />               <!--[선택]가맹점 고객 연락처2 -->
    <input type="hidden" id="sp_user_addr"         name="sp_user_addr"         value="" />               <!--[선택]가맹점 고객 주소 -->
    <input type="hidden" id="sp_user_define1"      name="sp_user_define1"      value="" />               <!--[선택]가맹점 필드1 -->
    <input type="hidden" id="sp_user_define2"      name="sp_user_define2"      value="" />               <!--[선택]가맹점 필드2 -->
    <input type="hidden" id="sp_user_define3"      name="sp_user_define3"      value="" />               <!--[선택]가맹점 필드3 -->
    <input type="hidden" id="sp_user_define4"      name="sp_user_define4"      value="" />               <!--[선택]가맹점 필드4 -->
    <input type="hidden" id="sp_user_define5"      name="sp_user_define5"      value="" />               <!--[선택]가맹점 필드5 -->
    <input type="hidden" id="sp_user_define6"      name="sp_user_define6"      value="" />               <!--[선택]가맹점 필드6 -->
    <input type="hidden" id="sp_product_type"      name="sp_product_type"      value="" />               <!--[선택]상품정보구분 -->
    <input type="hidden" id="sp_product_expr"      name="sp_product_expr"      value="" />               <!--[선택]서비스 기간 -->
    <input type="hidden" id="sp_app_scheme"        name="sp_app_scheme"        value="" />               <!--[선택]가맹점 APP scheme -->


    <!--신용카드-->
    <input type="hidden" id="sp_usedcard_code"     name="sp_usedcard_code"     value="" />               <!--[선택]사용가능카드 LIST -->
    <input type="hidden" id="sp_quota"             name="sp_quota"             value="00:02:03:06:08:10:12" />               <!--[선택]할부개월 -->
    <input type="hidden" id="sp_os_cert_flag"      name="sp_os_cert_flag"      value="" />               <!--[선택]해외안심클릭 사용여부-->
    <input type="hidden" id="sp_noinst_flag"       name="sp_noinst_flag"       value="N" />               <!--[선택]무이자 여부(Y/N)-->
    <input type="hidden" id="sp_noinst_term"       name="sp_noinst_term"       value="" />               <!--[선택]무이자 기간 -->
    <input type="hidden" id="sp_set_point_card_yn" name="sp_set_point_card_yn" value="" />               <!--[선택]카드사포인트 사용여부(Y/N)-->
    <input type="hidden" id="sp_point_card"        name="sp_point_card"        value="" />               <!--[선택]포인트카드 LIST(카드코드-더할 할부개월) -->
    <input type="hidden" id="sp_join_cd"           name="sp_join_cd"           value="" />               <!--[선택]조인코드 -->

    <!--가상계좌-->
    <input type="hidden" id="sp_vacct_bank"       name="sp_vacct_bank"         value="" />               <!--[선택]가상계좌 사용가능한 은행 LIST -->
    <input type="hidden" id="sp_vacct_end_date"   name="sp_vacct_end_date"     value="" />               <!--[선택]입금 만료 날짜 -->
    <input type="hidden" id="sp_vacct_end_time"   name="sp_vacct_end_time"     value="" />               <!--[선택]입금 만료 시간 -->

    <!--선불카드-->
    <input type="hidden" id="sp_prepaid_cp"       name="sp_prepaid_cp"         value="" />               <!--[선택]선불카드 CP -->

    <!-- [END] 인증요청 필드  -->

    <!-- [START] 인증응답 필드 -->

    <!--공통-->
    <input type="hidden" id="sp_res_cd"              name="sp_res_cd"                value="" />         <!-- [필수]응답코드        -->
    <input type="hidden" id="sp_res_msg"             name="sp_res_msg"               value="" />         <!-- [필수]응답메시지      -->
    <input type="hidden" id="sp_tr_cd"               name="sp_tr_cd"                 value="" />         <!-- [필수]결제창 요청구분 -->
    <input type="hidden" id="sp_ret_pay_type"        name="sp_ret_pay_type"          value="" />         <!-- [필수]결제수단        -->
    <input type="hidden" id="sp_trace_no"            name="sp_trace_no"              value="" />         <!-- [선택]추적번호        -->
    <!-- 가맹점 주문번호 인증요청 필드에 존재.                                                                [필수]가맹점 주문번호 -->
    <input type="hidden" id="sp_sessionkey"          name="sp_sessionkey"            value="" />         <!-- [필수]세션키          -->
    <input type="hidden" id="sp_encrypt_data"        name="sp_encrypt_data"          value="" />         <!-- [필수]암호화전문      -->
    <!-- 가맹점 ID  인증요청 필드에 존재.                                                                     [필수]가맹점 ID       -->
    <input type="hidden" id="sp_mobilereserved1"     name="sp_mobilereserved1"       value="" />         <!-- [선택]여유필드        -->
    <input type="hidden" id="sp_mobilereserved2"     name="sp_mobilereserved2"       value="" />         <!-- [선택]여유필드        -->
    <input type="hidden" id="sp_reserved1"           name="sp_reserved1"             value="" />         <!-- [선택]여유필드        -->
    <input type="hidden" id="sp_reserved2"           name="sp_reserved2"             value="" />         <!-- [선택]여유필드        -->
    <input type="hidden" id="sp_reserved3"           name="sp_reserved3"             value="" />         <!-- [선택]여유필드        -->
    <input type="hidden" id="sp_reserved4"           name="sp_reserved4"             value="" />         <!-- [선택]여유필드        -->

    <!--신용카드-->
    <input type="hidden" id="sp_card_code"            name="sp_card_code"            value="" />         <!-- [필수]카드코드               -->
    <input type="hidden" id="sp_eci_code"             name="sp_eci_code"             value="" />         <!-- [선택]ECI코드(MPI인 경우)    -->
    <input type="hidden" id="sp_card_req_type"        name="sp_card_req_type"        value="" />         <!-- [필수]거래구분               -->
    <input type="hidden" id="sp_save_useyn"           name="sp_save_useyn"           value="" />         <!-- [선택]카드사 세이브 여부     -->
    <input type="hidden" id="sp_card_prefix"          name="sp_card_prefix"          value="" />         <!-- [선택]신용카드 Prefix        -->
    <input type="hidden" id="sp_card_no_7"            name="sp_card_no_7"            value="" />         <!-- [선택]신용카드번호 앞7자리   -->

    <!--간편결제-->
    <input type="hidden" id="sp_spay_cp"              name="sp_spay_cp"              value="" />          <!-- [선택]간편결제 CP코드 -->

    <!--선불카드-->
    <input type="hidden" id="sp_prepaid_cp"           name="sp_prepaid_cp"           value="" />          <!-- [선택]선불카드 CP코드 -->

    <!-- [END] 인증응답 필드  -->


    <!-- BYLEE -->
    <input type="hidden" id="sp_mall_id"       name="sp_mall_id"      value="<?php echo G5_PG_MALL_ID?>"> <!-- PG 몰 아이디 -->
    <input type="hidden" id="sp_cert_type"       name="sp_cert_type"      value="">                       <!-- 인증타입 ? -->
    <input type="hidden" id="sp_window_type"       name="sp_window_type"      value="submit">
    <input type="hidden" id="sp_pay_type"       name="sp_pay_type"      value="11">                 <!-- 결제방법 : 11 카드결제   -->
    <input type="hidden" id="sp_product_nm"       name="sp_product_nm"      value="">               <!-- 상품명  -->
    <input type="hidden" id="sp_product_amt"       name="sp_product_amt"      value="0">            <!-- 결제액    -->

    <input type="hidden" id="sp_disp_cash_yn"       name="sp_disp_cash_yn"      value="N">          <!-- 현금영수증 화면퓨시여부 -->
    <input type="hidden" id="sp_kmotion_useyn"       name="sp_kmotion_useyn"      value="N">        <!-- 국민 앱카드 사용유무 -->

    <!-- bylee cust added / mobile skin -->
    <input type="hidden" id="gc_no"       name="gc_no"      value="<?php echo $gc_no?>">

</form>


<!-- 모달 영역 MODAL AREA    {   ###########################################################  -->
<div class="modal" id="paytypeModal">
    <form id="modalFrm" name="modalFrm"  method="post" action="">
        <input type="hidden" name="product_amt" id="product_amt" value="" >
        <input type="hidden" name="product_nm" id="product_nm" value="" >


        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-secondary text-light">
                    <h5 class="modal-title">
                        <i class='fas fa-info-circle'></i>
                        결제방법 선택하기
                    </h5>
                    <button type="button" class="close text-light" data-dismiss="modal"><i class="fas fa-window-close" style="font-size:20px;"></i></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <!-- start card class -->
                    <div class="card m-2">
                        <div class="card-header text-danger">
                            *결제 제품 : <span id="echo_product_nm"></span>
                            <br>
                            <strong>*결제 금액 : <span id="echo_product_amt"></span></strong>
                        </div>
                        <div class="card-body">


                            <div class="row p-2">

                                <button type="button" id="btnPaytypeCard" class="btn btn-lg btn-primary btn-block" ><i class="fas fa-credit-card"></i> 카드결제</button>

                            </div>

                            <div class="row mt-2 p-2">

                                <button type="button" id="btnPaytypeVAcc" class="btn btn-lg btn-warning btn-block" ><i class="fas fa-money-check"></i> 무통장 입금</button>

                            </div>

                        </div>
                        <div class="card-footer small text-center">
                            * 참고 ) 위 결제 금액은 부가세 포함금액입니다.
                        </div>


                    </div>
                    <!-- end card class -->

                </div>



                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">닫기</button>
                </div>


            </div>
        </div>

    </form>
</div>
<!--    }      모달 영역 MODAL AREA      #######################################################   -->






<script>

    var pay_request_cnt = 0;

    $(function() {


        // 전자 결제  /////////////////////////////////////////////////
        f_init();

        //카드결제
        $('#btnPaytypeCard').click(function(){
            var prdNm = $('#product_nm').val();
            var prdAmt = $('#product_amt').val();
            $('#paytypeModal').modal('hide');
            f_pay_request('11',prdNm,prdAmt);

        });
        //가상계좌이체
        $('#btnPaytypeVAcc').click(function(){
            var prdNm = $('#product_nm').val();
            var prdAmt = $('#product_amt').val();
            $('#paytypeModal').modal('hide');
            f_pay_request('22',prdNm,prdAmt);

        });

        //견적서
        $('#btnEstimate').click(function(){
            location.href='/bbs/export.excel_estimate.php?gc_no=<?php echo $gc_no?>';
        });

        //거래명세서
        $('#btnTrading').click(function(){
            location.href='/bbs/export.excel_trading.php?gc_no=<?php echo $gc_no?>';
        });

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

                // 모바일 주문번호 "ORDM_"으로 시작
        return "ORDM_"+member_no+"_"+ year + month + date + time;   //가맹점 주문번호

    }



    /* 입력 자동 Setting */
    function f_init()
    {
        var frm_pay = document.frm_pay;

        /*--공통--*/
        frm_pay.sp_mall_id.value        = "<?php echo G5_PG_MALL_ID?>";                              //가맹점 ID
        frm_pay.sp_mall_nm.value        = "<?php echo G5_PG_MALL_NAME?>";                    //가맹점명
        frm_pay.sp_order_no.value       = "";   //가맹점 주문번호
        //결제수단(select)
        frm_pay.sp_currency.value       = "00";                                    //통화코드 : 00-원
        frm_pay.sp_product_nm.value     = "";                            //상품명
        frm_pay.sp_product_amt.value    = "0";                                 //상품금액

        //가맹점 return_url(윈도우 타입 선택 시, 분기)
        frm_pay.sp_lang_flag.value      = "KOR"                                    //언어: KOR / ENG
        frm_pay.sp_charset.value        = "UTF-8"                                 //가맹점 Charset: EUC-KR(default) / UTF-8
        frm_pay.sp_user_id.value        = "<?php echo $member['mb_id']?>";                               //가맹점 고객 ID
        frm_pay.sp_memb_user_no.value   = "<?php echo $member['mb_no']?>";                           //가맹점 고객 일련번호
        frm_pay.sp_user_nm.value        = "<?php echo $member['mb_name']?>";                                //가맹점 고객명
        frm_pay.sp_user_mail.value      = "";                    //가맹점 고객 이메일
        frm_pay.sp_user_phone1.value    = "<?php echo $member['mb_hp']?>";                            //가맹점 고객 번호1
        frm_pay.sp_user_phone2.value    = "";                           //가맹점 고객 번호2
        frm_pay.sp_user_addr.value      = "";                  //가맹점 고객 주소
        frm_pay.sp_product_type.value   = "0";                                     //상품정보구분 : 0-실물, 1-서비스
        frm_pay.sp_product_expr.value   = "";                              //서비스기간 : YYYYMMDD
        frm_pay.sp_app_scheme.value     = "";                                      //가맹점 app scheme : 모바일app으로 서비스시 필수

        /*--신용카드--*/
        frm_pay.sp_usedcard_code.value  = "";                                      //사용가능한 카드 LIST
        frm_pay.sp_quota.value          = "";                                      //할부개월
        frm_pay.sp_os_cert_flag.value   = "2";                                     //해외안심클릭 사용여부
                                                                                   //무이자 여부(Y/N) (select)
        frm_pay.sp_noinst_term.value    = "";                             //무이자기간
        frm_pay.sp_point_card.value     = "";                                //포인트카드 LIST
                                                                        //조인코드(select)

    }


    ////////////////////////////////////////////////////////////////////////////////////
    // 결제방법 선택 모달창(modal) 호출
    function show_paytype_modal(prdName,prdAmt){
        var frm = document.modalFrm;

        frm.product_amt.value = prdAmt;
        frm.product_nm.value = prdName;

        $('#echo_product_amt').text(number_format(prdAmt)+"원");
        $('#echo_product_nm').text(prdName);


        $('#paytypeModal').modal();

    } //end func ==============




    // 결제버튼 호출
    /* 인증창 호출, 인증 요청 */
    function f_pay_request(payType,prdName,prdAmt) //f_cert() 수정
    {
        var frm_pay = document.frm_pay;


        //결제방법 추가 202006603
        frm_pay.sp_pay_type.value = payType;

        frm_pay.sp_product_amt.value = prdAmt;
        frm_pay.sp_product_nm.value = prdName;

        var ordNo = generate_ordno('<?php echo $member['mb_no']?>');
        frm_pay.sp_order_no.value = ordNo;

        /*  주문정보 확인 */
        /*
         if( !frm_pay.EP_order_no.value )
         {
         alert("가맹점주문번호를 입력하세요!!");
         frm_pay.EP_order_no.focus();
         return;
         }
         */

        if( !frm_pay.sp_product_amt.value )
        {
            alert("상품금액을 입력하세요!!");
            frm_pay.sp_product_amt.focus();
            return;
        }

        /* UTF-8 사용가맹점의 경우 EP_charset 값 셋팅 필수 */
        if( frm_pay.sp_charset.value == "UTF-8"  && pay_request_cnt == 0)
        {
            // 한글이 들어가는 값은 모두 encoding 필수.
            frm_pay.sp_mall_nm.value      = encodeURIComponent( frm_pay.sp_mall_nm.value );
            //frm_pay.sp_product_nm.value   = encodeURIComponent( frm_pay.sp_product_nm.value );
            frm_pay.sp_user_nm.value      = encodeURIComponent( frm_pay.sp_user_nm.value );
            frm_pay.sp_user_addr.value    = encodeURIComponent( frm_pay.sp_user_addr.value );
        }

        frm_pay.sp_product_nm.value   = encodeURIComponent( frm_pay.sp_product_nm.value );

        frm_pay.sp_return_url.value = "<?php echo G5_PG_MOBILE_URL?>/mobile/order_res_submit.php";

        easypay_card_webpay(frm_pay,"<?php echo G5_PG_MOBILE_URL?>/mobile/order_req.php","_self","0","0","submit",30);

        pay_request_cnt++;

    }






</script>