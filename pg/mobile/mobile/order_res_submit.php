<!--[submit]인증응답 페이지-->
<!--메뉴얼 '인증페이지 작성' 인증응답 파라미터 포함.-->

<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=10" />
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="Content-Type" content="hidden/html; charset=utf-8" />
<script>
    <?
	/*
	 * 파라미터 체크 메소드
	 */
	function getNullToSpace($param) 
	{
	    return ($param == null) ? "" : $param.trim();
	}
    ?>

    //bylee . bugfix (pc모듈에서 복사)
    function urldecode( str )
    {
        // 공백 문자인 + 를 처리하기 위해 +('%20') 을 공백으로 치환
        return decodeURIComponent((str + '').replace(/\+/g, '%20'));
    }

    
    /*--KICC 서버로부터 인증응답 파라미터 수신--*/
    window.onload = function() 
    {
        // <!--공통-->
        window.document.getElementById("sp_res_cd").value             = "<?=$_POST["sp_res_cd"]           ?>";  // [필수])응답코드
        window.document.getElementById("sp_res_msg").value            = "<?=$_POST["sp_res_msg"]          ?>";  // [필수])응답메세지
        window.document.getElementById("sp_tr_cd").value              = "<?=$_POST["sp_tr_cd"]            ?>";  // [필수])결제창 요청구분
        window.document.getElementById("sp_ret_pay_type").value       = "<?=$_POST["sp_ret_pay_type"]     ?>";  // [필수])결제수단
        window.document.getElementById("sp_trace_no").value           = "<?=$_POST["sp_trace_no"]         ?>";  // [선택])추적번호     
        window.document.getElementById("sp_order_no").value           = "<?=$_POST["sp_order_no"]         ?>";  // [필수])가맹점 주문번호
        window.document.getElementById("sp_sessionkey").value         = "<?=$_POST["sp_sessionkey"]       ?>";  // [필수])세션키
        window.document.getElementById("sp_encrypt_data").value       = "<?=$_POST["sp_encrypt_data"]     ?>";  // [필수])암호화전문
        window.document.getElementById("sp_mall_id").value            = "<?=$_POST["sp_mall_id"]          ?>";  // [필수])가맹점 ID
        window.document.getElementById("sp_mobilereserved1").value    = "<?=$_POST["sp_mobilereserved1"]  ?>";  // [선택])여유필드
        window.document.getElementById("sp_mobilereserved2").value    = "<?=$_POST["sp_mobilereserved2"]  ?>";  // [선택])여유필드
        window.document.getElementById("sp_reserved1").value          = "<?=$_POST["sp_reserved1"]        ?>";  // [선택])여유필드 
        window.document.getElementById("sp_reserved2").value          = "<?=$_POST["sp_reserved2"]        ?>";  // [선택])여유필드
        window.document.getElementById("sp_reserved3").value          = "<?=$_POST["sp_reserved3"]        ?>";  // [선택])여유필드
        window.document.getElementById("sp_reserved4").value          = "<?=$_POST["sp_reserved4"]        ?>";  // [선택])여유필드
                                                                         
        // <!--신용카드-->                                                 
        window.document.getElementById("sp_card_code").value          = "<?=$_POST["sp_card_code"]        ?>";  // [필수])카드코드 
        window.document.getElementById("sp_eci_code").value           = "<?=$_POST["sp_eci_code"]         ?>";  // [선택])ECI코드(MPI인 경우)
        window.document.getElementById("sp_card_req_type").value      = "<?=$_POST["sp_card_req_type"]    ?>";  // [필수])거래구분
        window.document.getElementById("sp_save_useyn").value         = "<?=$_POST["sp_save_useyn"]       ?>";  // [선택])카드사 세이브 여부
        window.document.getElementById("sp_card_prefix").value        = "<?=$_POST["sp_card_prefix"]      ?>";  // [선택])신용카드 Prefix 
        window.document.getElementById("sp_card_no_7").value          = "<?=$_POST["sp_card_no_7"]        ?>";  // [선택])신용카드번호 앞7자리   
                                                                       
        // <!--간편결제-->                                                 
        window.document.getElementById("sp_spay_cp").value            = "<?=$_POST["sp_spay_cp"]          ?>";  // [선택])간편결제 CP코드
                                                                  
        // <!--선불카드-->                                            
        window.document.getElementById("sp_prepaid_cp").value         = "<?=$_POST["sp_prepaid_cp"]       ?>";  // [선택])선불카드 CP코드
     


        if( "<?=$_POST["sp_res_cd"]?>" == "0000" )
        {
        	frm_pay.target = "_self";
            frm_pay.action = "../easypay_request.php";
            frm_pay.submit();
        }
        else
        {
            //bylee . Charset bugfix
            /* UTF-8 사용가맹점의 경우 한글이 들어가는 값은 모두 decoding 필수 */
            var res_msg = urldecode( "<?=$_POST["sp_res_msg"] ?>" );
            //alert( "<?=$_POST["sp_res_cd"] ?> : <?=$_POST["sp_res_msg"] ?>");

            alert( "<?=$_POST["sp_res_cd"] ?> : "+res_msg);

            //location.href="./order.php"; //bylee bugfix
            //추가 Android WebView . location.href not working / bugfix
            if(navigator.userAgent.match(/Android/i))
                document.location="/bbs/gmember_charge_detail.php";
            else
                location.href="/bbs/gmember_charge_detail.php";
            
        }    
    }
</script>
<title>EasyPay 8.0 webpay mobile</title>
</head>
<body>
 <form name="frm_pay" method="post" >  
    
    <!-- [START] 인증응답 필드 -->     
    
    <!--공통-->
    <input type="hidden" id="sp_res_cd"              name="sp_res_cd"                value="" />         <!-- [필수]응답코드        --> 
    <input type="hidden" id="sp_res_msg"             name="sp_res_msg"               value="" />         <!-- [필수]응답메시지      --> 
    <input type="hidden" id="sp_tr_cd"               name="sp_tr_cd"                 value="" />         <!-- [필수]결제창 요청구분 --> 
    <input type="hidden" id="sp_ret_pay_type"        name="sp_ret_pay_type"          value="" />         <!-- [필수]결제수단        --> 
    <input type="hidden" id="sp_trace_no"            name="sp_trace_no"              value="" />         <!-- [선택]추적번호        --> 
    <input type="hidden" id="sp_order_no"            name="sp_order_no"              value="" />         <!-- [필수]가맹점 주문번호 --> 
    <input type="hidden" id="sp_sessionkey"          name="sp_sessionkey"            value="" />         <!-- [필수]세션키          --> 
    <input type="hidden" id="sp_encrypt_data"        name="sp_encrypt_data"          value="" />         <!-- [필수]암호화전문      --> 
    <input type="hidden" id="sp_mall_id"             name="sp_mall_id"               value="" />         <!-- [필수]가맹점 ID       -->
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


</body>
</html>
