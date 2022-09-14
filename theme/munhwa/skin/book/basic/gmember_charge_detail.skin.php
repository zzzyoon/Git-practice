<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
//add_javascript('<script src="'.$sms_skin_url.'/skin.js"></script>', 10);
//echoVarDump($gdata);
?>
<script language="javascript" src="<?php echo G5_PG_PC_URL?>/js/default.js" type="text/javascript"></script>
<!-- Test -->
<!-- <script type="text/javascript" src="https://testpg.easypay.co.kr/webpay/EasypayCard_Web.js"></script> -->
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

<form name="frm_pay" method="post" action="">
    <!--------------------------->
    <!-- ::: 공통 인증 요청 값 -->
    <!--------------------------->

    <input type="hidden" id="EP_mall_nm"        name="EP_mall_nm"           value="">         <!-- 가맹점 이름 // -->
    <input type="hidden" id="EP_order_no"       name="EP_order_no"          value="">         <!-- 가맹점 주문번호 // -->
    <input type="hidden" id="EP_currency"       name="EP_currency"          value="00">       <!-- 통화코드 // 00 : 원화-->
    <input type="hidden" id="EP_return_url"     name="EP_return_url"        value="">         <!-- 가맹점 CALLBACK URL // -->
    <input type="hidden" id="EP_ci_url"         name="EP_ci_url"            value="">         <!-- CI LOGO URL // -->
    <input type="hidden" id="EP_lang_flag"      name="EP_lang_flag"         value="">         <!-- 언어 // -->
    <input type="hidden" id="EP_charset"        name="EP_charset"           value="UTF-8">   <!-- 가맹점 CharSet // -->
    <input type="hidden" id="EP_user_id"        name="EP_user_id"           value="">         <!-- 가맹점 고객ID // -->
    <input type="hidden" id="EP_memb_user_no"   name="EP_memb_user_no"      value="">         <!-- 가맹점 고객일련번호 // -->
    <input type="hidden" id="EP_user_nm"        name="EP_user_nm"           value="">         <!-- 가맹점 고객명 // -->
    <input type="hidden" id="EP_user_mail"      name="EP_user_mail"         value="">         <!-- 가맹점 고객 E-mail // -->
    <input type="hidden" id="EP_user_phone1"    name="EP_user_phone1"       value="">         <!-- 가맹점 고객 연락처1 // -->
    <input type="hidden" id="EP_user_phone2"    name="EP_user_phone2"       value="">         <!-- 가맹점 고객 연락처2 // -->
    <input type="hidden" id="EP_user_addr"      name="EP_user_addr"         value="">         <!-- 가맹점 고객 주소 // -->
    <input type="hidden" id="EP_user_define1"   name="EP_user_define1"      value="">         <!-- 가맹점 필드1 // -->
    <input type="hidden" id="EP_user_define2"   name="EP_user_define2"      value="">         <!-- 가맹점 필드2 // -->
    <input type="hidden" id="EP_user_define3"   name="EP_user_define3"      value="">         <!-- 가맹점 필드3 // -->
    <input type="hidden" id="EP_user_define4"   name="EP_user_define4"      value="">         <!-- 가맹점 필드4 // -->
    <input type="hidden" id="EP_user_define5"   name="EP_user_define5"      value="">         <!-- 가맹점 필드5 // -->
    <input type="hidden" id="EP_user_define6"   name="EP_user_define6"      value="">         <!-- 가맹점 필드6 // -->
    <input type="hidden" id="EP_product_type"   name="EP_product_type"      value="">         <!-- 상품정보구분 // -->
    <input type="hidden" id="EP_product_expr"   name="EP_product_expr"      value="">         <!-- 서비스 기간 // (YYYYMMDD) -->



    <!--------------------------->
    <!-- ::: 카드 인증 요청 값 -->
    <!--------------------------->

    <input type="hidden" id="EP_usedcard_code"      name="EP_usedcard_code"     value="">      <!-- 사용가능한 카드 LIST // FORMAT->카드코드:카드코드: ... :카드코드 EXAMPLE->029:027:031 // 빈값 : DB조회-->
    <input type="hidden" id="EP_quota"              name="EP_quota"             value="00:02:03:06:08:10:12">      <!-- 할부개월 (카드코드-할부개월) -->
    <input type="hidden" id="EP_os_cert_flag"       name="EP_os_cert_flag"      value="2">     <!-- 해외안심클릭 사용여부(변경불가) // -->
    <input type="hidden" id="EP_noinst_flag"        name="EP_noinst_flag"       value="N">      <!-- 무이자 여부 (Y/N) // -->
    <input type="hidden" id="EP_noinst_term"        name="EP_noinst_term"       value="">      <!-- 무이자 기간(카드코드-더할할부개월) // -->
    <input type="hidden" id="EP_set_point_card_yn"  name="EP_set_point_card_yn" value="N">      <!-- 카드사포인트 사용여부 (Y/N) // -->
    <input type="hidden" id="EP_point_card"         name="EP_point_card"        value="">      <!-- 포인트카드 LIST  // -->
    <input type="hidden" id="EP_join_cd"            name="EP_join_cd"           value="">      <!-- 조인코드 // -->
    <input type="hidden" id="EP_kmotion_useyn"      name="EP_kmotion_useyn"     value="">      <!-- 국민앱카드 사용유무 // -->

    <!------------------------------->
    <!-- ::: 가상계좌 인증 요청 값 -->
    <!------------------------------->

    <input type="hidden" id="EP_vacct_bank"      name="EP_vacct_bank"     value="">      <!-- 가상계좌 사용가능한 은행 LIST // -->
    <input type="hidden" id="EP_vacct_end_date"  name="EP_vacct_end_date" value="">      <!-- 입금 만료 날짜 // -->
    <input type="hidden" id="EP_vacct_end_time"  name="EP_vacct_end_time" value="">      <!-- 입금 만료 시간 // -->

    <!------------------------------->
    <!-- ::: 선불카드 인증 요청 값 -->
    <!------------------------------->

    <input type="hidden" id="EP_prepaid_cp"    name="EP_prepaid_cp"     value="">      <!-- 선불카드 CP // FORMAT->코드:코드: ... :코드 EXAMPLE->CCB:ECB // 빈값 : DB조회-->

    <!--------------------------------->
    <!-- ::: 인증응답용 인증 요청 값 -->
    <!--------------------------------->

    <input type="hidden" id="EP_res_cd"          name="EP_res_cd"         value="">      <!--  응답코드 // -->
    <input type="hidden" id="EP_res_msg"         name="EP_res_msg"        value="">      <!--  응답메세지 // -->
    <input type="hidden" id="EP_tr_cd"           name="EP_tr_cd"          value="">      <!--  결제창 요청구분 // -->
    <input type="hidden" id="EP_ret_pay_type"    name="EP_ret_pay_type"   value="">      <!--  결제수단 // -->
    <input type="hidden" id="EP_ret_complex_yn"  name="EP_ret_complex_yn" value="">      <!--  복합결제 여부 (Y/N) // -->
    <input type="hidden" id="EP_card_code"       name="EP_card_code"      value="">      <!--  카드코드 (ISP:KVP카드코드 MPI:카드코드) // -->
    <input type="hidden" id="EP_eci_code"        name="EP_eci_code"       value="">      <!--  MPI인 경우 ECI코드 // -->
    <input type="hidden" id="EP_card_req_type"   name="EP_card_req_type"  value="">      <!--  거래구분 // -->
    <input type="hidden" id="EP_save_useyn"      name="EP_save_useyn"     value="">      <!--  카드사 세이브 여부 (Y/N) // -->
    <input type="hidden" id="EP_trace_no"        name="EP_trace_no"       value="">      <!--  추적번호 // -->
    <input type="hidden" id="EP_sessionkey"      name="EP_sessionkey"     value="">      <!--  세션키 // -->
    <input type="hidden" id="EP_encrypt_data"    name="EP_encrypt_data"   value="">      <!--  암호화전문 // -->
    <input type="hidden" id="EP_pnt_cp_cd"       name="EP_pnt_cp_cd"      value="">      <!--  포인트 CP 코드 // -->
    <input type="hidden" id="EP_spay_cp"         name="EP_spay_cp"        value="">      <!--  간편결제 CP 코드 // -->
    <input type="hidden" id="EP_card_prefix"     name="EP_card_prefix"    value="">      <!--  신용카드prefix // -->
    <input type="hidden" id="EP_card_no_7"       name="EP_card_no_7"      value="">      <!--  신용카드번호 앞7자리 // -->

    <!-- BYLEE -->

    <input type="hidden" id="EP_mall_id"       name="EP_mall_id"      value="<?php echo G5_PG_MALL_ID?>"> <!-- PG 몰 아이디 -->
    <input type="hidden" id="EP_cert_type"       name="EP_cert_type"      value="">                       <!-- 인증타입 ? -->
    <input type="hidden" id="EP_window_type"       name="EP_window_type"      value="iframe">
    <input type="hidden" id="EP_pay_type"       name="EP_pay_type"      value="11">                 <!-- 결제방법 : 11 카드결제   -->
    <input type="hidden" id="EP_product_nm"       name="EP_product_nm"      value="">               <!-- 상품명  -->
    <input type="hidden" id="EP_product_amt"       name="EP_product_amt"      value="0">            <!-- 결제액    -->
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

        return "ORD_"+member_no+"_"+ year + month + date + time;   //가맹점 주문번호

    }



    /* 입력 자동 Setting */
    function f_init()
    {
        var frm_pay = document.frm_pay;

        /*--공통--*/
        frm_pay.EP_mall_id.value        = "<?php echo G5_PG_MALL_ID?>";               //가맹점 ID
        frm_pay.EP_mall_nm.value        = "<?php echo G5_PG_MALL_NAME?>";             //가맹점명
        frm_pay.EP_order_no.value       = "";
        //결제수단(select)
        frm_pay.EP_currency.value       = "00";                                    //통화코드 : 00-원
        frm_pay.EP_product_nm.value     = "";                                   //상품명
        frm_pay.EP_product_amt.value    = "0";                                 //상품금액
        //가맹점 return_url(윈도우 타입 선택 시, 분기)
        frm_pay.EP_lang_flag.value      = "KOR"                                    //언어: KOR / ENG
        frm_pay.EP_charset.value        = "UTF-8"                                 //가맹점 Charset: EUC-KR(default) / UTF-8
        frm_pay.EP_user_id.value        = "<?php echo $member['mb_id']?>";                               //가맹점 고객 ID
        frm_pay.EP_memb_user_no.value   = "<?php echo $member['mb_no']?>";                           //가맹점 고객 일련번호
        frm_pay.EP_user_nm.value        = "<?php echo $member['mb_name']?>";                                //가맹점 고객명
        frm_pay.EP_user_mail.value      = "";                    //가맹점 고객 이메일
        frm_pay.EP_user_phone1.value    = "<?php echo $member['mb_hp']?>";                            //가맹점 고객 번호1
        frm_pay.EP_user_phone2.value    = "";                           //가맹점 고객 번호2
        frm_pay.EP_user_addr.value      = "";                  //가맹점 고객 주소
        frm_pay.EP_product_type.value   = "0";                                     //상품정보구분 : 0-실물, 1-서비스
        frm_pay.EP_product_expr.value   = "";                              //서비스기간 : YYYYMMDD


        frm_pay.EP_return_url.value     = "<?php echo G5_PG_PC_URL?>/normal/order_res.php";      // Return 받을 URL (HTTP부터 입력)


        /*--신용카드--*/
        frm_pay.EP_usedcard_code.value  = "";                                      //사용가능한 카드 LIST
        frm_pay.EP_quota.value          = "";                                      //할부개월


        //무이자 여부(Y/N) (select)
        frm_pay.EP_noinst_term.value    = "";                             //무이자기간
        //카드사포인트 사용여부(select)
        frm_pay.EP_point_card.value     = "";                                //포인트카드 LIST
        //조인코드(select)
        //국민 앱카드 사용(select)

        /*--가상계좌--*/
        frm_pay.EP_vacct_bank.value     = "";                                      //가상계좌 사용가능한 은행 LIST
        frm_pay.EP_vacct_end_date.value = "";// "20171231";                              //입금 만료 날짜
        frm_pay.EP_vacct_end_time.value = "";                                //입금 만료 시간


    }



    // 결제방법 선택창(modal) 호출
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
        frm_pay.EP_pay_type.value = payType;
        frm_pay.EP_product_amt.value = prdAmt;
        frm_pay.EP_product_nm.value = prdName;

        var ordNo = generate_ordno('<?php echo $member['mb_no']?>');
        frm_pay.EP_order_no.value = ordNo;


        /*  주문정보 확인 */
        /*
         if( !frm_pay.EP_order_no.value )
         {
         alert("가맹점주문번호를 입력하세요!!");
         frm_pay.EP_order_no.focus();
         return;
         }
         */

        if( !frm_pay.EP_product_amt.value )
        {
            alert("상품금액을 입력하세요!!");
            frm_pay.EP_product_amt.focus();
            return;
        }


        /* UTF-8 사용가맹점의 경우 EP_charset 값 셋팅 필수 */
        if( frm_pay.EP_charset.value == "UTF-8" && pay_request_cnt == 0)
        {
            // 한글이 들어가는 값은 모두 encoding 필수.
            frm_pay.EP_mall_nm.value      = encodeURIComponent( frm_pay.EP_mall_nm.value );

            frm_pay.EP_user_nm.value      = encodeURIComponent( frm_pay.EP_user_nm.value );
            frm_pay.EP_user_addr.value    = encodeURIComponent( frm_pay.EP_user_addr.value );
        }

        frm_pay.EP_product_nm.value   = encodeURIComponent( frm_pay.EP_product_nm.value );


        /* 가맹점에서 원하는 인증창 호출 방법을 선택 */

        if( frm_pay.EP_window_type.value == "iframe" )
        {
            easypay_webpay(frm_pay,"<?php echo G5_PG_PC_URL?>/normal/iframe_req.php","hiddenifr","0","0","iframe",30);

        }
        else if( frm_pay.EP_window_type.value == "popup" )
        {
            easypay_webpay(frm_pay,"./popup_req.php","hiddenifr","","","popup",30);
        }


        pay_request_cnt++;

    }


    function f_submit()
    {
        var frm_pay = document.frm_pay;

        /* UTF-8 사용가맹점의 경우 EP_charset 값 셋팅 필수 */
        if( frm_pay.EP_charset.value == "UTF-8" )
        {
            // 한글이 들어가는 값은 모두 encoding 필수.
            frm_pay.EP_mall_nm.value      = decodeURIComponent( frm_pay.EP_mall_nm.value );
            frm_pay.EP_product_nm.value   = decodeURIComponent( frm_pay.EP_product_nm.value );
            frm_pay.EP_user_nm.value      = decodeURIComponent( frm_pay.EP_user_nm.value );
            frm_pay.EP_user_addr.value    = decodeURIComponent( frm_pay.EP_user_addr.value );
        }

        frm_pay.target = "_self";
        //frm_pay.action = "../easypay_request.php";
        frm_pay.action = "<?php echo G5_PG_PC_URL?>/easypay_request.php"; //bylee
        frm_pay.submit();
    }



    // 결제 영수증 출력 =================================================================================================
    function receiptForVirtualAccount(controlNo){
        receipt(controlNo,'03');
    }

    function receiptForCard(controlNo){
        receipt(controlNo,'01');
    }

    function receipt(controlNo,paytypeCode)
    {

        //var paytypeCode  = '01'; //신용카드, 02 계좌이체, 03 무통장(가상계좌)

        window.open("","MEMB_POP_RECEIPT", 'toolbar=0,scroll=1,menubar=0,status=0,resizable=0,width=380,height=700');
        document.form1.action = "https://office.easypay.co.kr/receipt/ReceiptBranch.jsp"; // 운영
        document.form1.controlNo.value = controlNo;
        document.form1.payment.value = paytypeCode;
        document.form1.target = "MEMB_POP_RECEIPT";
        document.form1.submit();

    }

</script>