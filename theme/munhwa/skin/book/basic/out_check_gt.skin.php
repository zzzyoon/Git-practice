<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);

// work time 관련 library___________________________________________________________
add_javascript('<script src="'.G5_JS_URL.'/moment-with-locales.min.js"></script>', 9);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_JS_URL.'/bootstrap-material-datetimepicker.css">', 11);
add_javascript('<script src="'.G5_THEME_JS_URL.'/bootstrap-material-datetimepicker.js"></script>', 11);

?>
<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>

<section id="contents">

    <form id="bkFrm" name="bkFrm" method="post" action=""  onsubmit="return  checkChulGtConfirm()"   autocomplete="off">

        <div style="display: none;" class="form-group row  no-gutters my-1">
            <label for="jg_gb" class="col-3 col-form-label ">재고 구분</label>
            <div class="col-9 col-md-3 pt-2">
                전체 <input type="radio" name="jg_gb" id="jg_gb1" checked value="" <?=(!$DefJgGubun)?"checked":""?> >
                정품 <input type="radio" name="jg_gb" id="jg_gb1" checked value="5" <?=($DefJgGubun=="CAPO")?"checked":""?> >
                반품 <input  type="radio" name="jg_gb" id="jg_gb2"  value="7" <?=($DefJgGubun=="UCAPO")?"checked":""?> >
            </div>
        </div>

        <div class="form-group row  no-gutters my-1">
            <label for="jgwms_gb" class="col-3 col-form-label">창고 구분</label>
            <div class="col-9">
                <select name="jgwms_gb" id="jgwms_gb" class="form-control d-inline-block" >
                </select>
            </div>
        </div>

        <div class="form-group row  no-gutters my-1">
            <label for="inv_no" class="col-3 col-form-label">송장번호</label>
            <div class="input-group col-9">
                <input type="text" name="inv_no" value="" id="inv_no" length="12" class="form-control" inputmode="search" placeholder="스캔">
                <div class="input-group-append">
                    <button class="btn btn-primary" id="btnSrch" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>


        <div class="form-group row  no-gutters my-1">
            <label for="besong_gb_nm" class="col-3 col-form-label">배송구분</label>
            <div class="col-5">
                <input type="hidden" class="form-control" name="besong_gb" id="besong_gb" readonly placeholder="">
                <input type="hidden" class="form-control" name="besong_seq" id="besong_seq" readonly placeholder="">
                <input type="text" class="form-control" name="besong_gb_nm" id="besong_gb_nm" readonly placeholder="">
            </div>
            <label class="col-1 col-form-label"></label>
            <div class="col-3">
                <input type="text" class="form-control" name="tls_gb_nm" id="tls_gb_nm" readonly placeholder="">
                <input type="hidden" class="form-control" name="tls_gb" id="tls_gb" readonly placeholder="">
            </div>
        </div>

        <div class="form-group row  no-gutters my-1">
            <label for="scan_qty" class="col-3 col-form-label">BOX</label>
            <div class="col-3">
                <input type="text" class="form-control" name="scan_qty" id="scan_qty" readonly placeholder="">
            </div>

            <label for="box_qty" class="col-3 col-form-label text-center">/</label>
            <div class="col-3">
                <input type="text" class="form-control" name="box_qty" id="box_qty" readonly placeholder="">
            </div>
        </div>

        <div class="form-group row  no-gutters my-1">
            <label for="slip_no" class="col-3 col-form-label">전표번호</label>
            <div class="col-4">
                <input type="text" class="form-control" name="slip_no" id="slip_no" readonly placeholder="">
                <input type="hidden" class="form-control" name="pre_slip_no" id="pre_slip_no" readonly placeholder="">
                <input type="hidden" class="form-control" name="order_num" id="order_num" readonly placeholder="">
                <input type="hidden" class="form-control" name="subl_date" id="subl_date" readonly placeholder="">
            </div>

            <label for="uni" class="col-2 col-form-label text-center">합포가능</label>
            <div class="input-group col-3">
                <input type="text" class="form-control text-center" name="uni" id="uni" readonly>
                <div class="input-group-append">
                    <button class="btn btn-primary" id="btnUni" type="button">
                    <i class="fas fa-check"></i>
                </button>
                </div>
            </div>

        </div>

        <div class="form-group row  no-gutters my-1">
            <label for="cust_nm" class="col-3 col-form-label">거래처</label>
            <div class="col-4">
                <input type="text" class="form-control" name="cust_nm" id="cust_nm" readonly placeholder="">
            </div>

            <label for="mecust_nm" class="col-1 col-form-label"></label>
            <div class="col-4">
                <input type="text" class="form-control" name="mecust_nm" id="mecust_nm" readonly placeholder="">
            </div>
        </div>

        <div class="form-group row  no-gutters my-1">
            <label for="b_qty" class="col-3 col-form-label">주문수량</label>
            <div class="col-3">
                <input type="text" class="form-control text-right" name="b_qty" id="b_qty" readonly placeholder="">
            </div>

            <label for="b_amt" class="col-3 col-form-label text-center">주문금액</label>
            <div class="col-3">
                <input type="text" class="form-control text-right" name="b_amt" id="b_amt" readonly placeholder="">
            </div>
        </div>


        <div class="form-group row  no-gutters my-1">
            <label for="mark" class="col-3 col-form-label">마크</label>
            <div class="col-3">
                <input type="text" class="form-control text-right" name="mark" id="mark" readonly placeholder="">
            </div>

            <label for="han_amt" class="col-3 col-form-label text-center">한도금액</label>
            <div class="col-3">
                <input type="text" class="form-control text-right" name="han_amt" id="han_amt" readonly placeholder="">
            </div>
        </div>

        <div class="form-group row  no-gutters my-1">
            <label for="jp_msg" class="col-3 col-form-label">구분</label>
            <div class="col-9">
                <input type="text" class="form-control text-center" name="jp_msg" id="jp_msg" readonly placeholder="">
            </div>
        </div>

        <div class="form-group row  no-gutters my-1">
            <label for="jp_msg" class="col-3 col-form-label">비고</label>
            <div class="col-9">
                <input type="text" class="form-control text-center" name="pm_remk" id="pm_remk" readonly placeholder="">
            </div>
        </div>
        
        <hr>
        <div class='d-flex justify-content-end my-2' >
            <button type="button" class="btn  btn-secondary" id="btnReset" >초기화</button>
            &nbsp;
            <button type="button"  class="btn  btn-danger" id="btnSubmit"> <i class="fas fa-paper-plane"></i> 출고검수하기</button>
        </div>

    </form>


</section>

<script>
    /// Android Virtual Keyboard /////////////////////////////////////////////////////////
    var AndroidKeyboardHide=true; //default true - only bar_cd

    //마지막 선택된 작업일
    var LastWorkDate = "";


    $(function() {

        loadjgWmsGb();// 창고구분 > ajax loading -----------------------------------


        $("#inv_no").doubleTap(function() {
            AndroidKeyboardHide=false;
            setTimeout(function(){
                $("#inv_no").focus();
            },300);
        });

        $("#inv_no").focus(function(){
            if(window.hasOwnProperty("Android")){
                window.Android.setKeyboardHide(AndroidKeyboardHide);
            }
            AndroidKeyboardHide=true;
        });




        //송장번호 검색 ______________________________________
        $('#inv_no').keyup(function(e) {

            if (e.keyCode != 13) {
                return true;
            }

            var $this = $(this);
            var val  = filteringSpcChr($this.val());
            if(val.length == 0)
                return false;


            if(val.length != 4 && val.length != 12){
                playBeepSound();
                MsgBox.warningCallback("송장번호 바르게 입력해주세요.",function(){
                    $this.focus();
                })
                return false;
            }

            var jgGb = $('#jgwms_gb').val();
            // 송장 조회 /////////////////
            findOutChk(val,jgGb);
        });



        //버튼으로 송장 번호 검색
        $('#btnSrch').click(function() {
            var $this = $('#inv_no');
            var val  = filteringSpcChr($this.val());
            if(val.length == 0)
                return false;
            if(val.length != 4 && val.length != 12){
                playBeepSound();
                MsgBox.warningCallback("송장번호 바르게 입력해주세요.",function(){
                    $this.focus();
                })
                return false;
            }
            var jgGb = $('#jgwms_gb').val();
            findOutChk(val,jgGb);
        });

        //합포
        $('#btnUni').click(function() {

            var $this = $('#uni');
            var val  = filteringSpcChr($this.val());

            if(val == 'N') {
                return;
            }

            var orderNum = $('#order_num').val();
            var jgGb = $('#jgwms_gb').val();

            if(orderNum == null || orderNum == "" || orderNum == undefined){
                MsgBox.alert("전표를 먼저 스캔해 주세요");
                return false;
            }
            findUniChk(orderNum,jgGb);

        });



        $('#btnReset').click(function(){
            formClear();
            $('#inv_no').focus();
        });


        $('#btnSubmit').click(function(){
            $('#bkFrm').submit();
        });


        $('#inv_no').focus();

    });  //end ready func__=======================================================================================================


    // 창고구분자 추출
    function loadjgWmsGb(){
        //whloca table ??? 추출

        ToastBox.showLoadingToast("로딩중...");
        //pkgMhPDA.PROC_SCHBKJG procedure

        //var jg_gb = <?//=$DefJgGubun?>//;

        var jgGb = $(':radio[name=jg_gb]:checked').val();

        $.getJSON('ajax.warehouse_gb_list.php',{'jg_gb':jgGb},function(data){

            ToastBox.closeToast();
            data.forEach(function(jdata,idx){
                $('#jgwms_gb').append('<option value="'+jdata.fld_code+'">  '+jdata.fld_gb+' </option>');
            });

            //default select
            if(jgGb == "5") {
                $('#jgwms_gb').val("51");
            } else if (jgGb == "7"){
                $('#jgwms_gb').val("71");
            }


        });
    }

    function inv_no_focus(){
        $('#inv_no').focus();
    }

    // 합포 데이터 체크
    function findUniChk(orderNum,jgGb){

        $.getJSON('ajax.chulmt_capo_uni_search.php',{'order_num':orderNum,'jgGb':jgGb},function(data){

            MsgBox.alert("* 합포장 정보 <br><br> - 전표 : " + data.tot_cnt + "건<br> - 총금액 : " + number_format(data.tot_amt) + "<br> (해당전표 포함)");

        }); //end ajax

    } //end func ======================

    // 출고 자료 체크
    function findOutChk(invNo,jgGb){

        ToastBox.showLoadingToast("로딩중입니다.");

        $.getJSON('ajax.chulmt_gt_search.php',{'inv_no':invNo,'jgGb':jgGb},function(data){
            ToastBox.closeToast();

            if(data.hasOwnProperty("result_msg")){
                MsgBox.error(data.result_msg);
                return false;
            }


            if(data == "2"){
                playBeepSound();
                MsgBox.alert("* 개별송장 : 삭제된 송장입니다. ");
                return false;
            }else if(data == "3"){
                playBeepSound();
                MsgBox.alert("* 개별송장 : 이미 출고된 송장입니다. ");
                return false;
            }

            var jgGb = $('#jgwms_gb').val();

            findChul(invNo,jgGb);


        }); //end ajax


    } //end func ======================

    function findChul(invNo,jgGb) {

        $.getJSON('ajax.chulmt_capo_search.php',{'inv_no':invNo,'jg_gb':jgGb},function(data){

            if(data == null || data === false || data == undefined){
                playBeepSound();
                MsgBox.alert("송장번호 [" +invNo+ "] 출고자료가 존재하지 않습니다.  ");
                formClear();
                return false;
            }

            var tlsGb = data.tls_gb;
            var $tlsGbNm = $('#tls_gb_nm');

            if(tlsGb == "1"){
                $tlsGbNm.val('선불');
            } else if(tlsGb == "2"){
                $tlsGbNm.val('착불');
            } else if(tlsGb == "3"){
                $tlsGbNm.val('신용');
            }

            var chkGb = data.chk_gb;

            if(chkGb == "" || chkGb == null || chkGb == undefined) chkGb = "1";

            if (chkGb < "4") {
                $('#inv_no').val('');
                $('#inv_no').focus();
                MsgBox.alert("* 아직 패킹되지 않은 전표입니다. ");
                formClear();
                return false;
            }else if (chkGb == "5"){
                $('#inv_no').val('');
                $('#inv_no').focus();
                MsgBox.alert("* 이미 출고된 전표입니다. ");
                // formClear();
                return false;
            }

            var slip_no = data.subl_date + data.subl_no;

            $('#besong_gb').val(data.besong_gb);   //
            $('#besong_seq').val(data.besong_seq);   //
            $('#besong_gb_nm').val(data.besong_nm); //주문번호
            $('#box_qty').val(data.box_qty);
            $('#cust_nm').val(data.cust_nm);
            $('#mecust_nm').val(data.mecust_nm);
            $('#jp_msg').val(data.jp_msg);
            if(data.han_amt != null && data.han_amt != '' && data.han_amt != undefined){
                $('#han_amt').val(number_format(data.han_amt));
            }
            $('#order_num').val(data.order_num);
            $('#subl_date').val(data.subl_date);

            $('#b_qty').val(data.b_qty);
            if(data.b_amt != null && data.b_amt != '' && data.b_amt != undefined){
                $('#b_amt').val(number_format(data.b_amt));
            }
            $('#pm_remk').val(data.pm_remk);
            $('#uni').val(data.is_uni);
            $('#slip_no').val(slip_no);

            $('#mark').val(data.is_mark);

            var pre_slip_no = $('#pre_slip_no').val();

            if(slip_no == pre_slip_no){
                if(number_format(data.box_qty) == $('#scan_qty').val()){
                    MsgBox.alert("스캔수량이 박스 수량을 초과합니다. ");
                }else {$('#scan_qty').val(parseInt($('#scan_qty').val()) + parseInt(1))}
            }else {
                $('#scan_qty').val(1);
            }

            $('#pre_slip_no').val($('#slip_no').val());

        }); //end ajax

    }



    function checkChulGtConfirm(){

        var sublNo = $('#slip_no').val(); // 주문번호
        var invNo = $('#inv_no').val(); // 송장번호

        if(sublNo.length == 0){
            MsgBox.warningCallback("검수할 송장부터 조회하세요.",function(){
                $('#inv_no').focus();

            });
            return false;
        }



        var besongChk = filteringSpcChr($('#besong_gb').val());
        if(besongChk.length==0){
            playBeepSound();
            MsgBox.warning("검수 할 수 없는 운송구분입니다. ");
            return false;
        }

        var scanQty = $('#scan_qty').val();
        var boxQty = $('#box_qty').val();

        if(scanQty != boxQty){
            MsgBox.warning("* BOX 수량이 일치하지 않습니다. ");
            return false;
        }

        ///////////////////////////////////////////////////////////
        //검수 시작 ===============================================
        checkChulGt(function(data){

            if(!data){
                formClear();
                $('#inv_no').focus();
            } else {
                MsgBox.succCallback("*검수 완료 되었습니다. ", function () {
                    formClear();
                    $('#inv_no').focus();
                });
            }

        });

        return false;
    }



    /// 전체 검수 ///////////////////////////////////////////////////////////////
    function checkChulGt(callback){

        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.out_check_gt_verify.php";
//        $('#bkFrm').attr("action",actionUrl); //for debugging
//        return true; //for debugging

        ToastBox.showLoadingToast("검수중입니다.");

        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:$('#bkFrm').serialize(),
            success:function(data) {

                //console.log("검수 결과 =====================");
                //console.log(data);

                ToastBox.closeToast();

                // data > 숫자형태로 검수결과를 return;

                var result = Number(data);

                if(result == -99){
                    playBeepSound();
                    MsgBox.error("검수 처리시 오류가 발생했습니다.(DB) ");
                    callback(false);
                    return false;
                }


                callback(true);

            },error : function(xhr, status, error) {
                ToastBox.closeToast();
                playBeepSound();
                alert("출고 검수시 오류가 발생했습니다. ("+error+")");
                console.log(xhr);
            }
        }); //end ajax func ====


        return false;
    }

    function formClear(){
        $("input[type='hidden']").val('');
        //$('#bk_list  > tbody').html("");
        $('#bkFrm')[0].reset();
        var jgGb = $(':radio[name=jg_gb]:checked').val();
        //default select
        if(jgGb == "5") {
            $('#jgwms_gb').val("51");
        } else if (jgGb == "7"){
            $('#jgwms_gb').val("71");
        }
    }






</script>