<?php
include_once("_common.php"); //bylee

//bylee . monologger
$logger = initializeMonoLogger("UID : {$_SESSION['ss_mb_id']} / MobilePay");
$logger->info("결제결과",convToUrlDecode($_POST));

?>
<!--KICC와 전문통신페이지-->
<!--메뉴얼 '승인페이지 작성' 승인요청/승인응답 파라미터 포함.-->
<?
/*
 * 파라미터 체크 메소드
 */
function getNullToSpace($param)
{
    return ($param == null) ? "" : trim($param);
}
?>
<?    
    /* -------------------------------------------------------------------------- */
    /* ::: 전문처리용 client                                                      */
    /* -------------------------------------------------------------------------- */
    include("./easypay_client.php");
    
    /* -------------------------------------------------------------------------- */
    /* ::: charset 설정                                                           */
    /* -------------------------------------------------------------------------- */
    // $opt = "option value";   //euc-kr 사용시
    $opt = "utf-8";          //bylee. utf-8 사용시
    
    /* -------------------------------------------------------------------------- */
    /* ::: 처리구분 설정                                                          */
    /* -------------------------------------------------------------------------- */
    $TRAN_CD_NOR_PAYMENT  = "00101000";   // 승인(일반, 에스크로)  
    $TRAN_CD_NOR_MGR      = "00201000";   // 변경(일반, 에스크로)  

    /* -------------------------------------------------------------------------- */
    /* ::: 지불 정보 설정                                                         */
    /* -------------------------------------------------------------------------- */

    //$GW_URL               = "testgw.easypay.co.kr";  // Gateway URL ( test )
    $GW_URL               = "gw.easypay.co.kr";      // Gateway URL ( real )
    $GW_PORT              = "80";                    // 포트번호(변경불가)
    //

    /* -------------------------------------------------------------------------- */ 
    /* ::: 지불 데이터 셋업 (업체에 맞게 수정)                                    */ 
    /* -------------------------------------------------------------------------- */ 
    /*     ※ 주의 ※                                                                                                                     
     *       */ 
    /*     #cert_file 변수 설정                                                   */
    /*       - pg_cert.pem 파일이 있는 디렉토리의 절대 경로 설정                  */ 
    /*     #log_dir 변수 설정                                                     */
    /*       - log 디렉토리 설정                                                  */                              
    /*     #log_level 변수 설정                                                   */
    /*       - log 레벨 설정                                                      */
    /* -------------------------------------------------------------------------- */

    //bylee . path 수정
    $HOME_DIR             = "/home/www/teachercall.kr/html/pg";
    $CERT_FILE            = "/home/www/teachercall.kr/html/pg/cert/pg_cert.pem";
    $LOG_DIR              = "/home/www/teachercall.kr/html/pg/log";
    $LOG_LEVEL            = 1;
    
    /* -------------------------------------------------------------------------- */            
    /* ::: 승인요청 정보 설정                                                     */            
    /* -------------------------------------------------------------------------- */            
    //[헤더]                                                                                    
    $tr_cd             = getNullToSpace($_POST["sp_tr_cd"]);           // [필수]결제창 요청구분 
    $trace_no          = getNullToSpace($_POST["sp_trace_no"]);        // [필수]추적번호        
    $order_no          = getNullToSpace($_POST["sp_order_no"]);        // [필수]가맹점 주문번호 
    $mall_id           = getNullToSpace($_POST["sp_mall_id"]);         // [필수]가맹점 ID       
    //[공통]                                                                                    
    $encrypt_data      = getNullToSpace($_POST["sp_encrypt_data"]);    // [필수]암호화전문      
    $sessionkey        = getNullToSpace($_POST["sp_sessionkey"]);      // [필수]세션키          

    /* -------------------------------------------------------------------------- */                                                                                   /* ::: 변경관리 정보 설정                                                     */                                                                                    /* -------------------------------------------------------------------------- */
    $mgr_txtype       = getNullToSpace($_POST["mgr_txtype"]);         // [필수]거래구분 
    $mgr_subtype      = getNullToSpace($_POST["mgr_subtype"]);        // [필수]변경세부구분                                                                                                                                                                                                                                   
    $org_cno          = getNullToSpace($_POST["org_cno"]);            // [필수]원거래고유번호                                                                                                                                                                                                                                                                                                                                       
    $mgr_amt          = getNullToSpace($_POST["mgr_amt"]);            // [선택]부분취소/환불요청 금액                                                                                                                                                                                                                                                                                                                            
    $mgr_bank_cd      = getNullToSpace($_POST["mgr_bank_cd"]);        // [선택]환불계좌 은행코드                                                                                                                                                                                                                                                                                                                                     
    $mgr_account      = getNullToSpace($_POST["mgr_account"]);        // [선택]환불계좌 번호                                                                                                                                                                                                                                                                                                                                          
    $mgr_depositor    = getNullToSpace($_POST["mgr_depositor"]);      // [선택]환불계좌 예금주명                                                                                                                                                                                                                                                                                                                             

    /* -------------------------------------------------------------------------- */
    /* ::: 결제 결과                                                              */
    /* -------------------------------------------------------------------------- */

    $r_res_cd             = "";     //응답코드
    $r_res_msg            = "";     //응답메시지
    $r_cno                = "";     //PG거래번호
    $r_amount             = "";     //총 결제금액
    $r_order_no           = "";     //주문번호
    $r_auth_no            = "";     //승인번호
    $r_tran_date          = "";     //승인일시
    $r_escrow_yn          = "";     //에스크로 사용유무
    $r_complex_yn         = "";     //복합결제 유무
    $r_stat_cd            = "";     //상태코드
    $r_stat_msg           = "";     //상태메시지
    $r_pay_type           = "";     //결제수단
    $r_card_no            = "";     //카드번호
    $r_issuer_cd          = "";     //발급사코드
    $r_issuer_nm          = "";     //발급사명
    $r_acquirer_cd        = "";     //매입사코드
    $r_acquirer_nm        = "";     //매입사명
    $r_install_period     = "";     //할부개월
    $r_noint              = "";     //무이자여부
    $r_part_cancel_yn     = "";     //부분취소 가능여부
    $r_card_gubun         = "";     //신용카드 종류
    $r_card_biz_gubun     = "";     //신용카드 구분
    $r_cpon_flag          = "";     //쿠폰사용유무
    $r_bank_cd            = "";     //은행코드
    $r_bank_nm            = "";     //은행명
    $r_account_no         = "";     //계좌번호
    $r_deposit_nm         = "";     //입금자명
    $r_expire_date        = "";     //계좌사용만료일
    $r_cash_res_cd        = "";     //현금영수증 결과코드
    $r_cash_res_msg       = "";     //현금영수증 결과메세지
    $r_cash_auth_no       = "";     //현금영수증 승인번호
    $r_cash_tran_date     = "";     //현금영수증 승인일시
    $r_cash_issue_type    = "";     //현금영수증 발행용도
    $r_cash_auth_type     = "";     //현금영수증 인증구분
    $r_cash_auth_value    = "";     //현금영수증 인증번호
    $r_auth_id            = "";     //휴대폰 PhoneID
    $r_billid             = "";     //휴대폰 인증번호
    $r_mobile_no          = "";     //휴대폰번호
    $r_mob_ansim_yn       = "";     //안심결제 사용유무
    $r_cp_cd              = "";     //포인트사/쿠폰사
    $r_rem_amt            = "";     //잔액
    $r_bk_pay_yn          = "";     //장바구니 결제여부
    $r_canc_acq_date      = "";     //매입취소일시
    $r_canc_date          = "";     //취소일시
    $r_refund_date        = "";     //환불예정일시

    
    /* -------------------------------------------------------------------------- */
    /* ::: EasyPayClient 인스턴스 생성 [변경불가 !!].                             */
    /* -------------------------------------------------------------------------- */
    $easyPay = new EasyPay_Client;     //전문처리용 class
    $easyPay->clearup_msg();
    
    $easyPay->set_home_dir($HOME_DIR);
    $easyPay->set_gw_url($GW_URL);
    $easyPay->set_gw_port($GW_PORT);
    $easyPay->set_log_dir($LOG_DIR);
    $easyPay->set_log_level($LOG_LEVEL);
    $easyPay->set_cert_file($CERT_FILE); 
          
    /* -------------------------------------------------------------------------- */
    /* ::: 승인요청                                                               */
    /* -------------------------------------------------------------------------- */
    if( $TRAN_CD_NOR_PAYMENT == $tr_cd )
    {
      
        // 승인요청 전문 설정
        $easyPay->set_trace_no($trace_no);
        $easyPay->set_snd_key($sessionkey);
        $easyPay->set_enc_data($encrypt_data);
        
        /* -------------------------------------------------------------------------- */              
        /* ::: 변경관리 요청                                                          */              
        /* -------------------------------------------------------------------------- */              
        }                                                                                             
        else if( $TRAN_CD_NOR_MGR == $tr_cd )                                                         
        {                                                                                             
            $mgr_data = $easyPay->set_easypay_item("mgr_data");                                       
                                                                                                      
            $easyPay->set_easypay_deli_us( $mgr_data, "mgr_txtype"    , $mgr_txtype    );             
            $easyPay->set_easypay_deli_us( $mgr_data, "mgr_subtype"   , $mgr_subtype   );             
            $easyPay->set_easypay_deli_us( $mgr_data, "org_cno"       , $org_cno       );             
            $easyPay->set_easypay_deli_us( $mgr_data, "order_no"      , $order_no      );             
            $easyPay->set_easypay_deli_us( $mgr_data, "mgr_amt"       , $mgr_amt       );             
            $easyPay->set_easypay_deli_us( $mgr_data, "mgr_bank_cd"   , $mgr_bank_cd   );             
            $easyPay->set_easypay_deli_us( $mgr_data, "mgr_account"   , $mgr_account   );             
            $easyPay->set_easypay_deli_us( $mgr_data, "mgr_depositor" , $mgr_depositor );                                   
            $easyPay->set_easypay_deli_us( $mgr_data, "req_ip"        , $easyPay->get_remote_addr() );
                                                                                                       
    }
    /* -------------------------------------------------------------------------- */
    /* ::: 실행                                                                   */
    /* -------------------------------------------------------------------------- */         
    if ( strlen($tr_cd) > 0 ) 
    {
        $easyPay->easypay_exec($mall_id, $tr_cd, $order_no, $client_ip, $opt);
        $r_res_cd  = $easyPay->_easypay_resdata["res_cd"];    // 응답코드
        $r_res_msg = $easyPay->_easypay_resdata["res_msg"];   // 응답메시지    
    } 
    else 
    {
        $r_res_cd  = "M114";
        $r_res_msg = "연동 오류|tr_cd값이 설정되지 않았습니다.";
    }    
    
    /* -------------------------------------------------------------------------- */
    /* ::: 결과 처리                                                              */
    /* -------------------------------------------------------------------------- */
    
    
    $r_cno              = $easyPay->_easypay_resdata[ "cno"             ];     //PG거래번호
    $r_amount           = $easyPay->_easypay_resdata[ "amount"          ];     //총 결제금액
    $r_order_no         = $easyPay->_easypay_resdata[ "order_no"        ];     //주문번호
    $r_auth_no          = $easyPay->_easypay_resdata[ "auth_no"         ];     //승인번호
    $r_tran_date        = $easyPay->_easypay_resdata[ "tran_date"       ];     //승인일시
    $r_escrow_yn        = $easyPay->_easypay_resdata[ "escrow_yn"       ];     //에스크로 사용유무
    $r_complex_yn       = $easyPay->_easypay_resdata[ "complex_yn"      ];     //복합결제 유무
    $r_stat_cd          = $easyPay->_easypay_resdata[ "stat_cd"         ];     //상태코드
    $r_stat_msg         = $easyPay->_easypay_resdata[ "stat_msg"        ];     //상태메시지
    $r_pay_type         = $easyPay->_easypay_resdata[ "pay_type"        ];     //결제수단
    $r_card_no          = $easyPay->_easypay_resdata[ "card_no"         ];     //카드번호
    $r_issuer_cd        = $easyPay->_easypay_resdata[ "issuer_cd"       ];     //발급사코드
    $r_issuer_nm        = $easyPay->_easypay_resdata[ "issuer_nm"       ];     //발급사명
    $r_acquirer_cd      = $easyPay->_easypay_resdata[ "acquirer_cd"     ];     //매입사코드
    $r_acquirer_nm      = $easyPay->_easypay_resdata[ "acquirer_nm"     ];     //매입사명
    $r_install_period   = $easyPay->_easypay_resdata[ "install_period"  ];     //할부개월
    $r_noint            = $easyPay->_easypay_resdata[ "noint"           ];     //무이자여부
    $r_part_cancel_yn   = $easyPay->_easypay_resdata[ "part_cancel_yn"  ];     //부분취소 가능여부
    $r_card_gubun       = $easyPay->_easypay_resdata[ "card_gubun"      ];     //신용카드 종류
    $r_card_biz_gubun   = $easyPay->_easypay_resdata[ "card_biz_gubun"  ];     //신용카드 구분
    $r_cpon_flag        = $easyPay->_easypay_resdata[ "cpon_flag"       ];     //쿠폰사용 유무
    $r_bank_cd          = $easyPay->_easypay_resdata[ "bank_cd"         ];     //은행코드
    $r_bank_nm          = $easyPay->_easypay_resdata[ "bank_nm"         ];     //은행명
    $r_account_no       = $easyPay->_easypay_resdata[ "account_no"      ];     //계좌번호
    $r_deposit_nm       = $easyPay->_easypay_resdata[ "deposit_nm"      ];     //입금자명
    $r_expire_date      = $easyPay->_easypay_resdata[ "expire_date"     ];     //계좌사용만료일
    $r_cash_res_cd      = $easyPay->_easypay_resdata[ "cash_res_cd"     ];     //현금영수증 결과코드
    $r_cash_res_msg     = $easyPay->_easypay_resdata[ "cash_res_msg"    ];     //현금영수증 결과메세지
    $r_cash_auth_no     = $easyPay->_easypay_resdata[ "cash_auth_no"    ];     //현금영수증 승인번호
    $r_cash_tran_date   = $easyPay->_easypay_resdata[ "cash_tran_date"  ];     //현금영수증 승인일시
    $r_cash_issue_type  = $easyPay->_easypay_resdata[ "cash_issue_type" ];     //현금영수증 발행용도
    $r_cash_auth_type   = $easyPay->_easypay_resdata[ "cash_auth_type"  ];     //현금영수증 인증구분
    $r_cash_auth_value  = $easyPay->_easypay_resdata[ "cash_auth_value" ];     //현금영수증 인증번호
    $r_auth_id          = $easyPay->_easypay_resdata[ "auth_id"         ];     //휴대폰 PhoneID
    $r_billid           = $easyPay->_easypay_resdata[ "billid"          ];     //휴대폰 인증번호
    $r_mobile_no        = $easyPay->_easypay_resdata[ "mobile_no"       ];     //휴대폰번호
    $r_mob_ansim_yn     = $easyPay->_easypay_resdata[ "mob_ansim_yn"    ];     //안심결제 사용유무
    $r_cp_cd            = $easyPay->_easypay_resdata[ "cp_cd"           ];     //포인트사/쿠폰사         
    $r_rem_amt          = $easyPay->_easypay_resdata[ "rem_amt"         ];     //잔액
    $r_bk_pay_yn        = $easyPay->_easypay_resdata[ "bk_pay_yn"       ];     //장바구니 결제여부
    $r_canc_acq_date    = $easyPay->_easypay_resdata[ "canc_acq_date"   ];     //매입취소일시
    $r_canc_date        = $easyPay->_easypay_resdata[ "canc_date"       ];     //취소일시
    $r_refund_date      = $easyPay->_easypay_resdata[ "refund_date"     ];     //환불예정일시
        
    /* -------------------------------------------------------------------------- */
    /* ::: 가맹점 DB 처리                                                         */
    /* -------------------------------------------------------------------------- */
    /* 응답코드(res_cd)가 "0000" 이면 정상승인 입니다.                            */
    /* r_amount가 주문DB의 금액과 다를 시 반드시 취소 요청을 하시기 바랍니다.     */
    /* DB 처리 실패 시 취소 처리를 해주시기 바랍니다.                             */
    /* -------------------------------------------------------------------------- */
    
    $bDBProc     = "";     //가맹점 DB처리 성공여부
    
    if ($r_res_cd == "0000" && !$mgr_txtype)
    {
        $bDBProc = "true";     // DB처리 성공 시 "true", 실패 시 "false"


        //bylee  결제 결과 입력  {     ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $ordData = sql_fetch("select * from  {$g5['pg_log']}  where mb_id = '{$member['mb_id']}' and pg_order_no = '{$r_order_no}'  limit 1");


        if(empty($ordData['pg_res_cd'])) {


            sql_begin_transaction();


            // 결제 정보 마스터 테이블 > 수정 ______________________________________________________________
            if($r_pay_type == G5_PG_TYPE_CARD)
                $pg_stat = G5_PG_STAT_SUCC;
            else
                $pg_stat = G5_PG_STAT_READY; // 가상계좌 결제 시도시


            $sql = "update  {$g5['pg_log']} set
            pg_stat = '{$pg_stat}',
            pg_tr_no = '$r_cno',  pg_auth_no = '$r_auth_no', pg_auth_date = '$r_tran_date',
            pg_res_cd = '{$r_res_cd}', pg_res_msg = '".rawurldecode($r_res_msg)."',
            pg_bank_code = '{$r_bank_cd }',pg_bank_nm='{$r_bank_nm}', pg_bank_no = '{$r_account_no}', pg_bank_expire='{$r_expire_date}', pg_deposit_nm='{$r_deposit_nm}'
                where  mb_id = '{$member['mb_id']}' and    pg_order_no='$r_order_no' ";

            if (!sql_query($sql))
                $bDBProc="false";



            //if($r_pay_type == "11") { //카드결제시 > 결제 성공 > 월별 요금현황 테이블 업뎃

            // 학교별 월정산 테이블 >  무통장[입금대기]일때도, 결제 key value 업뎃 (* 사용자가 결제계좌 확인가능하게~)
            $sql = "update {$g5['gmember_charge']} set pg_no = '{$ordData['pg_no']}'  where gc_no = '{$ordData['gc_no']}' and  mg_no = '{$member['mg_no']}' ";
            if (!sql_query($sql))
                $bDBProc = "false";

            //} // }  카드결제 처리 완료 ========================================================================================


            if ($bDBProc == "true") {
                sql_commit();
            } else {
                sql_rollback();
            }



        } //end if ______________________________________

        // }  bylee 결제 결과 입력  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////




        if ( $bDBProc == "false" ) 
        {
            // 승인요청이 실패 시 아래 실행
            if( $TRAN_CD_NOR_PAYMENT == $tr_cd ) 
            {
                $easyPay->clearup_msg();
              
                $tr_cd = $TRAN_CD_NOR_MGR; 
                $mgr_data = $easyPay->set_easypay_item("mgr_data");
            
                if ( $r_escrow_yn != "Y" )    
                {
                    $easyPay->set_easypay_deli_us( $mgr_data, "mgr_txtype"      , "40"   );
                }
                else
                {
                    $easyPay->set_easypay_deli_us( $mgr_data, "mgr_txtype"      , "61"   );
                    $easyPay->set_easypay_deli_us( $mgr_data, "mgr_subtype"     , "ES02" );
                }
                $easyPay->set_easypay_deli_us( $mgr_data, "org_cno",  r_cno     );
                $easyPay->set_easypay_deli_us( $mgr_data, "order_no", order_no  );
                $easyPay->set_easypay_deli_us( $mgr_data, "req_ip",   request.getRemoteAddr() );
                $easyPay->set_easypay_deli_us( $mgr_data, "req_id",   "MALL_R_TRANS" );
                $easyPay->set_easypay_deli_us( $mgr_data, "mgr_msg",  "DB 처리 실패로 망취소"  );
              
                
                $easyPay->easypay_exec($mall_id, $tr_cd, $order_no, $client_ip, $opt);
                $r_res_cd    = $easyPay->_easypay_resdata[ "res_cd"     ];    //응답코드
                $r_res_msg   = $easyPay->_easypay_resdata[ "res_msg"    ];    //응답메시지
                $r_cno       = $easyPay->_easypay_resdata[ "cno"        ];    //PG거래번호 
                $r_canc_date = $easyPay->_easypay_resdata[ "canc_date"  ];    //취소일시
            }
        }
    }

/* -------------------------------------------------------------------------- */
/* ::: [charset설정] utf-8 사용시, 아래와 같이 설정해주시기 바랍니다.         */
/* -------------------------------------------------------------------------- */
//BYLEE bugfix ㅡㅡ;
/*
    if($opt == "utf-8")
    {
        $r_res_msg      = iconv("EUC-KR","UTF-8", $r_res_msg     );
        $r_stat_msg     = iconv("EUC-KR","UTF-8", $r_stat_msg    );
        $r_issuer_nm    = iconv("EUC-KR","UTF-8", $r_issuer_nm   );
        $r_acquirer_nm  = iconv("EUC-KR","UTF-8", $r_acquirer_nm );
        $r_bank_nm      = iconv("EUC-KR","UTF-8", $r_bank_nm     );
        $r_deposit_nm   = iconv("EUC-KR","UTF-8", $r_deposit_nm  );
        $r_cash_res_msg = iconv("EUC-KR","UTF-8", $r_cash_res_msg);
    }
*/

//bylee
//$result_url = "/bbs/callmapping_payment_result.php"; // 결제 요청 처리결과 페이지

if($mgr_txtype && $r_canc_date)
    $result_url = "/bbs/gmember_charge_cancel.php"; // 결제 요청 처리결과 - 결제취소
else
    $result_url = "/bbs/gmember_charge_result.php"; // 결제 요청 처리결과 페이지

?>
<html>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<script type="text/javascript">

function f_submit(){
    document.frm.submit();
}

</script>

<body onload="f_submit();">
<!--<form name="frm" method="post" action="./result.php">-->
<form name="frm" method="post" action="<?php echo $result_url?>">

<input type="hidden" id="res_cd"           name="res_cd"          value="<?=$r_res_cd?>">            <!-- 결과코드 //-->
<input type="hidden" id="res_msg"          name="res_msg"         value="<?=$r_res_msg?>">           <!-- 결과메시지 //-->
<input type="hidden" id="cno"              name="cno"             value="<?=$r_cno?>">               <!-- PG거래번호 //-->
<input type="hidden" id="amount"           name="amount"          value="<?=$r_amount?>">            <!-- 총 결제금액 //-->
<input type="hidden" id="order_no"         name="order_no"        value="<?=$r_order_no?>">          <!-- 주문번호 //-->
<input type="hidden" id="auth_no"          name="auth_no"         value="<?=$r_auth_no?>">           <!-- 승인번호 //-->
<input type="hidden" id="tran_date"        name="tran_date"       value="<?=$r_tran_date?>">         <!-- 승인일시 //-->
<input type="hidden" id="escrow_yn"        name="escrow_yn"       value="<?=$r_escrow_yn?>">         <!-- 에스크로 사용유무 //-->
<input type="hidden" id="complex_yn"       name="complex_yn"      value="<?=$r_complex_yn?>">        <!-- 복합결제 유무 //-->
<input type="hidden" id="stat_cd"          name="stat_cd"         value="<?=$r_stat_cd?>">           <!-- 상태코드 //-->
<input type="hidden" id="stat_msg"         name="stat_msg"        value="<?=$r_stat_msg?>">          <!-- 상태메시지 //-->
<input type="hidden" id="pay_type"         name="pay_type"        value="<?=$r_pay_type?>">          <!-- 결제수단 //-->
<input type="hidden" id="card_no"          name="card_no"         value="<?=$r_card_no?>">           <!-- 카드번호 //-->
<input type="hidden" id="issuer_cd"        name="issuer_cd"       value="<?=$r_issuer_cd?>">         <!-- 발급사코드 //-->
<input type="hidden" id="issuer_nm"        name="issuer_nm"       value="<?=$r_issuer_nm?>">         <!-- 발급사명 //-->
<input type="hidden" id="acquirer_cd"      name="acquirer_cd"     value="<?=$r_acquirer_cd?>">       <!-- 매입사코드 //-->
<input type="hidden" id="acquirer_nm"      name="acquirer_nm"     value="<?=$r_acquirer_nm?>">       <!-- 매입사명 //-->
<input type="hidden" id="install_period"   name="install_period"  value="<?=$r_install_period?>">    <!-- 할부개월 //-->
<input type="hidden" id="noint"            name="noint"           value="<?=$r_noint?>">             <!-- 무이자여부 //-->
<input type="hidden" id="part_cancel_yn"   name="part_cancel_yn"  value="<?=$r_part_cancel_yn?>">    <!-- 부분취소 가능여부 //-->
<input type="hidden" id="card_gubun"       name="card_gubun"      value="<?=$r_card_gubun?>">        <!-- 신용카드 종류 //-->
<input type="hidden" id="card_biz_gubun"   name="card_biz_gubun"  value="<?=$r_card_biz_gubun?>">    <!-- 신용카드 구분 //-->
<input type="hidden" id="cpon_flag"        name="cpon_flag"       value="<?=$r_cpon_flag?>">         <!-- 쿠폰사용 유무 //-->
<input type="hidden" id="bank_cd"          name="bank_cd"         value="<?=$r_bank_cd?>">           <!-- 은행코드 //-->
<input type="hidden" id="bank_nm"          name="bank_nm"         value="<?=$r_bank_nm?>">           <!-- 은행명 //-->
<input type="hidden" id="account_no"       name="account_no"      value="<?=$r_account_no?>">        <!-- 계좌번호 //-->
<input type="hidden" id="deposit_nm"       name="deposit_nm"      value="<?=$r_deposit_nm?>">        <!-- 입금자명 //-->
<input type="hidden" id="expire_date"      name="expire_date"     value="<?=$r_expire_date?>">       <!-- 계좌사용만료일 //-->
<input type="hidden" id="cash_res_cd"      name="cash_res_cd"     value="<?=$r_cash_res_cd?>">       <!-- 현금영수증 결과코드 //-->
<input type="hidden" id="cash_res_msg"     name="cash_res_msg"    value="<?=$r_cash_res_msg?>">      <!-- 현금영수증 결과메세지 //-->
<input type="hidden" id="cash_auth_no"     name="cash_auth_no"    value="<?=$r_cash_auth_no?>">      <!-- 현금영수증 승인번호 //-->
<input type="hidden" id="cash_tran_date"   name="cash_tran_date"  value="<?=$r_cash_tran_date?>">    <!-- 현금영수증 승인일시 //-->
<input type="hidden" id="cash_issue_type"  name="cash_issue_type" value="<?=$r_cash_issue_type?>">   <!-- 현금영수증발행용도 //-->
<input type="hidden" id="cash_auth_type"   name="cash_auth_type"  value="<?=$r_cash_auth_type?>">    <!-- 인증구분 //-->
<input type="hidden" id="cash_auth_value"  name="cash_auth_value" value="<?=$r_cash_auth_value?>">   <!-- 인증번호 //-->
<input type="hidden" id="auth_id"          name="auth_id"         value="<?=$r_auth_id?>">           <!-- PhoneID //-->
<input type="hidden" id="billid"           name="billid"          value="<?=$r_billid?>">            <!-- 인증번호 //-->
<input type="hidden" id="mobile_no"        name="mobile_no"       value="<?=$r_mobile_no?>">         <!-- 휴대폰번호 //-->
<input type="hidden" id="mob_ansim_yn"     name="mob_ansim_yn"    value="<?=$r_mob_ansim_yn?>">      <!-- 안심결제 사용유무 //-->
<input type="hidden" id="cp_cd"            name="cp_cd"           value="<?=$r_cp_cd?>">             <!-- 포인트사/쿠폰사 //-->
<input type="hidden" id="rem_amt"          name="rem_amt"         value="<?=$r_rem_amt?>">           <!-- 잔액 //-->
<input type="hidden" id="bk_pay_yn"        name="bk_pay_yn"       value="<?=$r_bk_pay_yn?>">         <!-- 장바구니 결제여부 //-->
<input type="hidden" id="canc_acq_date"    name="canc_acq_date"   value="<?=$r_canc_acq_date?>">     <!-- 매입취소일시 //-->
<input type="hidden" id="canc_date"        name="canc_date"       value="<?=$r_canc_date?>">         <!-- 취소일시 //-->
<input type="hidden" id="refund_date"      name="refund_date"     value="<?=$r_refund_date?>">       <!-- 환불예정일시 //-->

<!-- bylee 추가 / 결제 취소 구분자로 활용 -->
<input type="hidden" id="mgr_txtype"      name="mgr_txtype"     value="<?=$mgr_txtype?>">

</form>
</body>
</html>
