<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
add_javascript('<script src="'.G5_JS_URL.'/moment-with-locales.min.js"></script>', 9);

?>
<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>

<section id="contents">


<form id="bkFrm" name="bkFrm" method="post" action=""  onsubmit="return transferConfirm()"  autocomplete="off">

    <input type="hidden" name="bk_cnt" id="bk_cnt"  value=""  >

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
        <label for="loc_cd" class="col-2 col-form-label">LOC</label>
        <div class="col-4">
            <input type="text" class="form-control" name="loc_cd" id="loc_cd" placeholder="스캔">
        </div>
        <label for="bar_cd" class="col-2 col-form-label text-center">바코드 </label>
        <div class="col-4">
            <input type="text" class="form-control" name="bar_cd" id="bar_cd" placeholder="스캔">
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="slip_no" class="col-2 col-form-label">전표 </label>
        <div class="input-group col-4">
            <input type="text" name="slip_no" value="" id="slip_no" class="form-control" inputmode="search" placeholder="스캔">
            <input type="hidden" name="chk_gb" value="" id="chk_gb" class="form-control" inputmode="search">
            <div class="input-group-append">
            </div>
        </div>
        <label for="tot_qty" class="col-2 col-form-label text-center">전 체 </label>
        <div class="input-group col-4">
            <input type="text" name="tot_qty" value="" id="tot_qty" class="form-control" readonly >
            <div class="input-group-append">
            </div>
        </div>
    </div>


    <hr>

    <div class='d-flex justify-content-end mt-4' >

        <button type="button" class="btn  btn-secondary" id="btnReset" >초기화</button>
        &nbsp;
        <button type="button" class="btn  btn-danger" id="btnMoveTrans"> <i class="fas fa-paper-plane"></i> 전송하기</button>
    </div>




    <!-- 재고 리스트   --------------------------------------------------------------------------->
    <div class="mt-4">

        <table id="bk_list" class="table  table-hover">
            <thead>
            <tr>
                <th scope="col">상품명<br>사이즈</th>
                <th scope="col">실사<br>수량</th>
                <th scope="col" class="td_right">실수량</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>


</form>



</section>


<!-- 도서 검색 -->
<? include_once(G5_THEME_PATH . '/view_modal_silsa_gookcd.php'); ?>



<script>
    /// Android Virtual Keyboard //////////////////////////////////////////////////////
    var AndroidKeyboardHide=true; //default true - only bar_cd




    $(function() {

        loadjgWmsGb();// 창고구분 > ajax loading -----------------------------------

        //////////////////////////////////////////////////////////////////////////////////////////////
        ///////////   Android Virtual Keyboard / Control  {
        $("#slip_no").doubleTap(function() {
            AndroidKeyboardHide=false;
            setTimeout(function(){
                $("#slip_no").focus();
            },300);
        });


        $("#slip_no").focus(function(){
            if(window.hasOwnProperty("Android")){
                window.Android.setKeyboardHide(AndroidKeyboardHide);
            }
            AndroidKeyboardHide=true;
        });
        //----------------------------------------------------------------

        $("#loc_cd").doubleTap(function() {
            AndroidKeyboardHide=false;
            setTimeout(function(){
                $("#loc_cd").focus();
            },300);
        });


        $("#loc_cd").focus(function(){
            if(window.hasOwnProperty("Android")){
                window.Android.setKeyboardHide(AndroidKeyboardHide);
            }
            AndroidKeyboardHide=true;
        });

        ////       }    //////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////



        //전표 조회 //////////////////////////////////////////
        $('#slip_no').keyup(function(e) {

            if (e.keyCode != 13) {
                return true;
            }

            var val  = this.value;
            if(val.length == 0) {
                return false;
            }

            findPalletBook(val);

        });

        //전표 상품조회 //////////////////////////////////////////
        $('#bar_cd').keyup(function(e) {

            if (e.keyCode != 13) {
                return true;
            }

            var val  = this.value;
            if(val.length == 0) {
                return false;
            }

            findGood(val);

        });



        $('#loc_cd').keyup(function(e){

            if (e.keyCode != 13) {
                return true;
            }
            $('#bar_cd').focus();
/*
            var $this = $(this);
            var val = filteringSpcChr($this.val());

            if(val.length>0){

                existsCheckLocCode(val,function(res){

                    if(res.result_stat){
                        // $this.val(formatLocCode(val));
                        $('#bar_cd').focus();
                    } else {
                        MsgBox.warningCallback(res.result_msg,function(){
                            $this.val('');
                            $this.focus();
                        });

                    }

                });
            }
*/

        });



        $('#btnMoveTrans').click(function(){
            $('#bkFrm').submit();
        });


        $('#btnReset').click(function(){
            formClear();
            $('#slip_no').focus();
        });


        $('#slip_no').focus();

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

    //데이터 전송 - 확인______________
    function transferConfirm() {

        var bkCnt = $('#bk_cnt').val();

        if(bkCnt.length == 0 || bkCnt<=0){
            playBeepSound();
            MsgBox.alert("전송 할 도서가 존재하지 않습니다.");
            return false;

        }


        ////////////////////////////////////////////////////////////
        MsgConfirmBox.show('실사 완료하시겠습니까? ',function(res){
            if(res){
                transferData();
            }
        });

        return false;
    }


    // 로케이션 존재체크
    function existsCheckLocCode(locCode,callback){

        $.getJSON('ajax.loc_cd_exists_check.php',
            {'loc_cd':locCode},function(data){
                       callback(data);
            });

    } //end validateLocCode method ===========================================



    function transferData(){
        var chkGb = $('#chk_gb').val();

        if(chkGb == "2"){
            playBeepSound();
            MsgBox.alert("* 실사 확정된 전표입니다. ");
            return false;
        }

        if(chkGb == "3"){
            playBeepSound();
            MsgBox.alert("* 실사 승인된 전표입니다. ");
            return false;
        }

        //var actionUrl = "<?php //echo G5_BBS_URL?>///ajax.loc_move_update.php"
        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.msilsa_update.php"
//        $('#bkFrm').attr("action",actionUrl); //for debugging
//        return true; //for debugging

        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:$('#bkFrm').serialize(),
            success:function(data) {
                // console.log(data);
                // var result = data.result_stat;
                if(data == "1"){
                    formClear();
                    // ToastBox.showSuccessToast(data.result_msg);
                    $('#slip_no').focus();
                } else {
                    alert(data.result_msg);
                }

            },error : function(xhr, status, error) {
                //console.log(error);
                playBeepSound();
                alert("실사확정시 오류가 발생했습니다. ("+error+")");
            }
        }); //end ajax func ====

        return false;

    } //end func ==========


    //실사 - 전표조회
    function findPalletBook(slipNo){


        $('#bk_list  > tbody').html("");

        var slipNo = $('#slip_no').val();
        var jgGb = $('#jgwms_gb').val();

        $.getJSON('ajax.silsa_search_detail.php',{'slip_no':slipNo,'jg_gb': jgGb},function(data){

            var len = data.length;
            $('#bk_cnt').val(len);

            if(len == 0){
                //MsgBox.alert("검색된 도서가 없습니다. ");
                ToastBox.showToast("전표가 존재하지 않습니다.");
                $('#slip_no').val('').focus();
                return false;
            }

            data.forEach(function(jdata,idx){
                $('#bk_list  > tbody').append(makeTableRow(jdata));
            });

            if($('#loc_cd').val() == "") $('#loc_cd').focus();
            else $('#bar_cd').focus();

        });

    } //end func ============================================================

    //실사 - 상품조회
    function findGood(barCd){
        //var $this = $(this);

        var slipNo = $('#slip_no').val();
        var jgGb = $('#jgwms_gb').val();
        var locCd = $('#loc_cd').val();

        if(locCd == "" || locCd == null || locCd == undefined){
            MsgBox.alert("* 로케이션을 입력하세요!!");
            return false;
        }

        showSilsaModal(barCd,slipNo, jgGb, locCd, function(res,json){
            //console.log(json);

            if(res){
                var sublDate = json.subl_date;
                var sublNo = json.subl_no;
                var sublSeq = json.subl_seq;

                // console.log(sublDate + ', ' + sublNo + ', ' + sublSeq);
                // 실사업데이트
                findSilsa(sublDate,sublNo,sublSeq,1,jgGb);
            } else {
                //재고 조회 실패
                MsgBox.alertCallback("존재하지 않는 상품입니다. ",function(){
                });
            }
        }); //end showBookModal============

    } //end func ============================================================


    //재고업데이트
    function findSilsa(sublDate,sublNo,sublSeq,silQty,jgGb){
        var chkGb = $('#chk_gb').val();

        if(chkGb == "2"){
            playBeepSound();
            MsgBox.alert("* 실사 확정된 전표입니다. ");
            return false;
        }

        if(chkGb == "3"){
            playBeepSound();
            MsgBox.alert("* 실사 승인된 전표입니다. ");
            return false;
        }


        // console.log(sublDate + ', ' + sublNo + ', ' + sublSeq + ', ' + silQty);
        $.getJSON('ajax.silsa_update.php',{'sublDate':sublDate,'sublNo':sublNo,'sublSeq':sublSeq,'silQty':silQty,'jgGb':jgGb},function(data){

            if(data.length == 0){
                $('#bk_list  > tbody').append(makeMsgTableRow(3,"재고가 존재하지 않습니다."));
                $('#bar_cd').select();
                return false;
            }else {
                var slipNo = $('#slip_no').val();
                findPalletBook(slipNo);
                $('#bar_cd').focus();
            }


        });
    }

    function formClear(){
        $("input[type='hidden']").val('');
        $('#bk_list  > tbody').html("");
        $('#bkFrm')[0].reset();

        var jgGb = $(':radio[name=jg_gb]:checked').val();
        //default select
        if(jgGb == "5") {
            $('#jgwms_gb').val("51");
        } else if (jgGb == "7"){
            $('#jgwms_gb').val("71");
        }
    }


    function makeTableRow(data){

        //console.log(data);
        //var jsonData = JSON.stringify(data);
        //도서명, 현재수량, 적치수량 (b_qty = jg_qty)

        $('#tot_qty').val(number_format(data.jg_qty));
        $('#chk_gb').val(data.chk_gb);

        if(data.good_cd != '' && data.good_cd != null && data.good_cd != undefined) {
            var sublDate = data.subl_date;
            var sublNo = data.subl_no;
            var sublSeq = data.subl_seq;
            var row =
                '<tr id="row_' + data.subl_date + '_' + data.subl_no + '_' + data.subl_seq +  '" class="" >' +
                ' <td colspan="3" class="td_left">' + data.good_nm + ' </td>' +
                // ' <td class="td_right"><button onclick="findSilsa(\'' + sublDate + '\',\'' + sublNo + '\',\'' + sublSeq + '\',1)" type="button" name="btnRowTrans" class="btn btn-danger btn-sm rounded-pill"><i class="fas fa-share"></i></button> </td>' +
                ' </tr>' +
                ' <tr>'  +
                ' <td class="td_left">' + data.size_gb + ' </td>' +
                ' <td class="td_qty">' + number_format(data.jg_qty) + '</td>' +
                ' <td class="td_qty"><input type="text" onkeydown="silsa_update(this,\''+ sublDate +'\', \'' + sublNo + '\', \'' + sublSeq + '\');" value="' + data.sil_qty + '" class="form-control-sm text-right numeric qty-field text-select"></td>' +
                ' </tr>';
        }

        return row;

    } //end func   ============================ ================================ =======================================


    function silsa_update(e,sublDate,sublNo,sublSeq) {

        if (event.keyCode != 13){
            return;
        }

        var val  = e.value;
        if(val.length == 0) {
            return false;
        }

        var jgGb = $('#jgwms_gb').val();
        findSilsa(sublDate,sublNo,sublSeq,val,jgGb);
    }

</script>