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
<form id="sublFrm" name="sublFrm" method="post" action=""  onsubmit="return formSubmit()" autocomplete="off">

    <input type="hidden" name="grp_no" id="grp_no"  value=""  >
    <input type="hidden" name="bk_cd" id="bk_cd"  value=""  >
    <input type="hidden" name="bk_cmt" id="bk_cmt"  value=""  > <!-- lblbuga -->
    <input type="hidden" name="contract_no" id="contract_no"  value=""  >  <!-- 발주번호 -->
    <input type="hidden" name="contract_yn" id="contract_yn"  value=""  > <!-- PROC_BKINFOCUR > move_yn (js_yn,contract_yn) / 반품 재생 불가 구분자 Y 불가 -->

    <input type="hidden" name="ipsu_qty" id="ipsu_qty"  value=""  > <!-- 입수수 임시저장 -->

    <div class="form-group row  no-gutters my-1">
        <label for="subl_gb" class="col-3 col-form-label">입고구분</label>
        <div class="col-9">
            <select name="subl_gb" id="subl_gb" class="form-control d-inline-block" >
                <option value="11">제본소</option>
                <option value="12">본사 입고</option>
                <option value="13">문화 직원 입고</option>
                <option value="15">회송</option>
            </select>
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="binder_code" class="col-3 col-form-label">제본소</label>
        <div class="col-3">
            <input type="text" class="form-control"  name="binder_code" inputmode="search" id="binder_code"   placeholder="">
        </div>
        <div class="col-6">
            <input type="text" class="form-control" name="binder_name" id="binder_name" readonly placeholder="">
        </div>
    </div>




    <div class="form-group row  no-gutters my-1">
        <label for="pub_code" class="col-3 col-form-label">출판사</label> <!-- 실제 bookcd 의 tax_no  -->
        <div class="col-3">
            <input type="text" class="form-control required hide-keyboard" name="pub_code" id="pub_code"  readonly placeholder="">
        </div>
        <div class="col-6">
            <input type="text" class="form-control" name="pub_name" id="pub_name" readonly placeholder="">
        </div>
    </div>



    <div class="form-group row  no-gutters my-1">
        <label for="bar_code" class="col-3 col-form-label">바코드</label>
<!--        <div class="col-9">-->
<!--            <input type="text" class="form-control  required" name="bar_code" id="bar_code" placeholder="EAN 코드">-->
<!--        </div>-->

        <!-- input group area/  찾기 아이콘 붙임   -->
        <div class="input-group col-9">
            <input type="text" name="bar_code" value="" id="bar_code" class="form-control" placeholder="스캔">
            <div class="input-group-append">
                <button class="btn btn-primary" id="btnSrch" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="bk_nm" class="col-3 col-form-label">도서명</label>
        <div class="col-9">
            <input type="text" class="form-control readonly required" name="bk_nm" id="bk_nm" readonly placeholder="">
        </div>
    </div>
    <div class="form-group row  no-gutters my-1">
        <label for="bk_price" class="col-3 col-form-label">정가</label>
        <div class="col-4">
            <input type="text" class="form-control readonly required" name="bk_price" id="bk_price" readonly placeholder="">
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="bk_tot_qty" class="col-3 col-form-label cursor-hand" id="inputQtyLabel">
             수량/TOT
        </label>
        <div class="col-3 pr-1">
            <input type="text" class="form-control text-right readonly  required"  readonly  name="bk_new_qty" id="bk_new_qty" placeholder="입고수">
        </div>
        <div class="col-3 pr-1">
            <input type="text" class="form-control text-right  bg-warning" readonly name="bk_tot_qty" id="bk_tot_qty" placeholder="전체입고">
        </div>
        <div class="col-3">
            <input type="text" class="form-control text-right  bg-warning" readonly name="bk_tot_cnt" id="bk_tot_cnt" placeholder="전체종수">
        </div>
    </div>


    <div class="form-group row  no-gutters my-1">
        <label for="bk_new" class="col-3 col-form-label">도서구분</label>
        <div class="col-9 pt-2">

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="bk_new" id="inlineRadio1" value="Y">
                <label class="form-check-label" for="inlineRadio1">신간</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="bk_new" id="inlineRadio2" checked value="N">
                <label class="form-check-label" for="inlineRadio1">일반</label>
            </div>

        </div>

    </div>

    <hr class="my-2">

    <div class='d-flex justify-content-end mt-0' >
        <button type="button" class="btn  btn-secondary" id="btnReset" >초기화</button>
        &nbsp;

        <button type="button" class="btn  btn-primary" id="btnSubmit" >저장하기</button>
        &nbsp;
        <button type="button" class="btn  btn-danger" id="btnBublTrans"> <i class="fas fa-paper-plane"></i> 전송하기</button>

    </div>

</form>


    <!-- 입고 도서 리스트   --------------------------------------------------------------------------->
<div class="mt-2">

    <table id="subl_bk_list" class="table  table-hover">
        <thead>
        <tr>
            <th scope="col">도서명</th>
            <th scope="col">수량</th>
            <th scope="col">기타</th>
        </tr>
        </thead>
        <tbody>


        </tbody>
    </table>

</div>

</section>


<!-- 제본소 검색창 -->
<? include_once(G5_THEME_PATH . '/view_modal_binder.php'); ?>

<!-- 출판사 검색창 -->
<? include_once(G5_THEME_PATH . '/view_modal_publisher.php'); ?>

<!-- 도서 검색 -->
<? include_once(G5_THEME_PATH . '/view_modal_bookcd.php'); ?>



<!-- 입고 수량 입력창  {  --->
<div class="modal" id="inputModal">
<form name="frmInput" id="frmInput" method="post" onsubmit="return inputFrmCheck()" >

    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-light">
                <h5 class="modal-title">
                    입고 수량 입력
                </h5>
                <button type="button" class="close text-light" data-dismiss="modal"><i class="fas fa-window-close" style="font-size:20px;"></i></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-center">
                        입수수 * 덩이수 + 잔량
                        <p>
                        <input type="text" class="form-control d-inline-block w-25  text-right required text-select" id="new_qty" value="0" inputmode="numeric" placeholder="입수수">
                        *
                        <input type="text" class="form-control d-inline-block w-25  text-right required text-select" id="pack_qty" value="0" inputmode="numeric" placeholder="덩이수">
                        +
                        <input type="text" class="form-control d-inline-block w-25 text-right  text-select" id="rem_qty" inputmode="numeric" value="0">
                        </p>
                    </li>
                    <li class="list-group-item list-group-item-info text-center">총체수량 :
                        <input type="text" class="form-control d-inline-block w-50 numeric text-right text-select "  inputmode="numeric" id="input_tot_qty" value="0" placeholder="총체수량">
                    </li>
                    <li class="list-group-item text-center">발주번호 :
                        <input type="text" class="form-control d-inline-block w-50 numeric text-center" id="input_contract_no" value="" inputmode="numeric" placeholder="발주번호">
                    </li>
                </ul>

            </div>


            <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary"  data-dismiss="modal" > 취소 </button>
                <button type="submit" class="btn btn-sm btn-primary" > 입력 </button>
            </div>

        </div>
    </div>
</form>
</div>
<!--   }    입고 수량 입력창    --->



<script>




    /// Android Virtual Keyboard //////////////////////////////////////////////////////
    var AndroidKeyboardHide=true; //default true - only bar_cd



    $(function() {

       //////////////////////////////////////////////////////////////////////////////////////////////
        ///////////   Android Virtual Keyboard / Control / Autoloading block  {
        $("#bar_code").doubleTap(function() {
            AndroidKeyboardHide=false;
            setTimeout(function(){
                // console.log("timeout fire~~");
                $("#bar_code").focus();
            },300);
        });


        $("#bar_code").focus(function(){
            if(window.hasOwnProperty("Android")){
                window.Android.setKeyboardHide(AndroidKeyboardHide);
            }
            AndroidKeyboardHide=true;
        });

    /***
        $("#binder_code").doubleTap(function() {
            AndroidKeyboardHide=false;
            setTimeout(function(){
                // console.log("timeout fire~~");
                $("#binder_code").focus();
            },300);
        });


        $("#binder_code").focus(function(){
            if(window.hasOwnProperty("Android")){
                window.Android.setKeyboardHide(AndroidKeyboardHide);
            }
            AndroidKeyboardHide=true;
        });
            *********/

        ////       }    //////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////



        $('#inputQtyLabel,#bk_new_qty').click(showInputModal);


        //저장하기(임시)
        $('#btnSubmit').click(function(){
           $('#sublFrm').submit();
        });

    // 더블클릭 > 내용 클리어
        $('#binder_code').doubleTap(function() {

            $('#binder_name').val('');
            $('#binder_code').val('');

        });

        // 더블클릭 > 내용 클리어
        $('#pub_code').doubleTap(function() {

            $('#pub_name').val('');
            $('#pub_code').val('');

        });


        //제본소 검색
        $('#binder_code').keyup(function(e) {
            if (e.keyCode != 13) {
                return true;
            }
            var $this = $(this);
            var val  = $this.val();

            if(val.length > 0) {
                var findCode="";
                var findName="";
                if($.isNumeric(val)) {
                    findCode = val;
                } else {
                    findName = val;
                }
                    //view_modal_binder.php defined ___
                    showBinderModal(findCode, findName,function(res,code,name){

                    if(res){

                        $('#binder_code').val(code);
                        $('#binder_name').val(name);
                        $('#bar_code').focus();

                    } else {

                        playBeepSound();
                        ToastBox.showErrorToast("존재하지 않는 제본소입니다. ");
                        $this.val('');
                        $this.focus();

                    }

                });

                $this.val('');
                $('#binder_name').val("");
            }

        });


        //출판사 검색
        $('#pub_code').blur(function(e) {

            /*
            if (e.keyCode != 13) {
                return true;
            }*/

            var $this = $(this);

            var val  = this.value;
            if(val.length > 0) {

                var findCode="";
                var findName="";
                if($.isNumeric(val)) {
                    findCode = val;
                } else {
                    findName = val;
                }


                showPubModal(findCode, findName,function(res,code,name){

                    if(res){
                        $('#pub_code').val(code);
                        $('#pub_name').val(name);
                        $('#bar_code').focus();

                    } else {
                        playBeepSound();
                        ToastBox.showErrorToast("존재하지 않는 출판사입니다. ");
                        $this.val('');
                        $this.focus();
                    }

                });

                this.value="";
                $('#pub_name').val("");


            }

        });




        //도서 검색 ///////////////////////////////////////
        $('#bar_code').keyup(function(e) {

            if (e.keyCode != 13) {
                return true;
            }

            doBookSearch();
        });

        $('#btnSrch').click(function(){

            var $this = $('#bar_code');
            var val  = $this.val();
            if(val.length < 11){
                playBeepSound();
                MsgBox.alertCallback("바코드를 바르게 입력하세요.",function(){
                    $this.val('');
                    $this.focus();
                });

                return false;
            }


            doBookSearch();
        });




        // 입고 수량 입력창(modal)
        $('#new_qty,#pack_qty,#rem_qty').change(function(){

            var newQty = $('#new_qty').val()*1;
            var packQty = $('#pack_qty').val()*1;
            var remQty = $('#rem_qty').val()*1;
            var totQty = (newQty * packQty) + remQty;

            //$('#input_tot_qty').val(totQty);
        });

        $('#rem_qty').blur(function(){
            //$('#input_contract_no').focus();
            $('#input_tot_qty').focus();
        });

        // 전송하기
        $('#btnBublTrans').click(function(){
           sublTransferConfirm();
        });


        $('#btnReset').click(function(){
            formClear();
            $('#binder_code').focus();
        });


        $('#binder_code').focus();

    });  //end ready func__=======================================================================================================




    function doBookSearch(){

        bookDataClear();

        //var $this = $(this);
        var $this = $('#bar_code');
        var val  = $this.val();

        $('#bk_cmt').val('');

        if(val.length == 0) {
            return false;
        }


        var taxNo = $('#pub_code').val().trim();

        /*
        if(taxNo.length == 0){
            MsgBox.warningCallback("출판사를 먼저 선택하세요.",function(){
                $this.val('');
                $('#pub_code').focus();
            });
            return false;
        }
        */


        var barCd = "";
        var bkNm = "";

        // if($.isNumeric(val)){
        //     barCd = val;
        //
        //     if(val.length < 11){
        //         this.value = '';
        //         return false;
        //     }
        //
        //     if(val.length == 18){
        //         $('#bk_cmt').val(val.substr(13,5));
        //     }
        //
        //
        //     // 출판사코드
        //     var pubCd = $('#pub_code').val().trim();
        //     if (pubCd == "0245")
        //     {
        //         barCd =barCd.substr(0, 8) + "00000";
        //
        //     }
        //
        // } else {
        //     bkNm = val;
        // }


        bkNm = val;


        showBookModal(taxNo,barCd, bkNm,function(res,json){
            //console.log(json);
            if(res){
                // 출판사 체크
                   if(taxNo.length > 0 && taxNo != json.tax_no){
                        MsgBox.warning("출판사를 확인하세요.<br>다른 출판사가 선택되었습니다. ");
                        return false;
                    } else {

                        $('#bar_code').val(json.bar_cd);
                        $('#bk_nm').val(json.bk_nm);

                        $('#pub_code').val(json.tax_no);  // 출판사(거래처) 정보 유지
                        $('#pub_name').val(json.cust_nm);

                        $('#bk_cd').val(json.bk_cd);
                        $('#bk_price').val(number_format(json.out_danga));
                        $('#contract_yn').val(json.move_yn); //vs code > js_yn 구분자

                        // 입고수량 default value (입수수 )
                       $('#ipsu_qty').val(json.ipsu_qty); // 입고 모달창  new_qty 할당
                    }



            } else {
                // alert box >  toast box > show
                ToastBox.showErrorToast("존재하지 않는 도서입니다. ");
                $this.val('');
                $this.focus();

            }

        });

        $this.val('');
        $('#bk_nm').val("");


    } //end func =============== ========================================================

    // 입고 수량창 오픈_______ (입고입력창/입력모달)
    function showInputModal(){

        $('#frmInput')[0].reset();

        $('#inputModal').modal();

        $('#input_contract_no').val($('#contract_no').val());

        //bookcd. ipsu_qty 할당
        //$('#new_qty').val($('#ipsu_qty').val());
        $('#new_qty').select();
    }


    // 입고 수량 새창창 > 입력
    function inputFrmCheck(){


        var contractYn = $('#contract_yn').val();
        var contractNo = $('#input_contract_no').val();

        // 필수가 아니라 옵션
        /*
        if(contractYn == "Y" && contractNo.length  == 0){
            MsgBox.warning("계약번호를 넣어주세요.");
            return false;
        }
        */


        var totQty = $('#input_tot_qty').val();
        if(totQty <= 0){
            MsgBox.warning("입고수량을 바르게 입력하세요.");
            $('#new_qty').select();
            return false;
        }

        //입고 총체수량 > 직접 입력
        var newQty = $('#new_qty').val()*1;
        var packQty = $('#pack_qty').val()*1;
        var remQty = $('#rem_qty').val()*1;
        var totQty = (newQty * packQty) + remQty;

        var tmpTotQty = $('#input_tot_qty').val();
        if(totQty != tmpTotQty){
            MsgBox.warningCallback("총체 수량에 오류가 있습니다. 확인하세요.",function(){
                $('#input_tot_qty').val('');
                $('#input_tot_qty').focus();
            });

            return false;
        }



        $('#bk_new_qty').val(totQty);
        $('#contract_no').val($('#input_contract_no').val());
        $('#inputModal').modal('hide');


        // 바로 전송하기 버튼 호출 / 20210317---------------------------------
        $('#btnSubmit').trigger("click");

        return false;
    }



    function makeTableRow(data){

        var jsonData = JSON.stringify(data);
        var row = '<tr id="row_'+data.bk_cd+'" class="" data=\''+jsonData+'\'>' +
            ' <td class="td_subject">' +  data.bk_nm +
            ' </td>' +
            ' <td class="td_qty_m sv_use"><span class="sv_member">'+data.subl_qty+'</span></td>' +
            ' <td class="td_name text-center"><button type="button" class="btn btn-sm btn-danger" id="btnDelRow" onclick="deleteBookReq(\''+data.bk_cd+'\',\''+data.bk_nm+'\')">X</button> </td>' +
            ' </tr>';

        return row;

    } //end func   ============================ ================================



    function deleteBookReq(_bkcd,_bknm){

        var grpNo = $('#grp_no').val();

        var cf = confirm("'"+_bknm+"' 도서를 삭제하시겠습니까? ");
        if(!cf)
            return false;


        $.getJSON('ajax.bksubl_tmp_delete.php',{'bk_cd':_bkcd,'grp_no':grpNo},function(data){
                    if(data.result_stat){
                        ToastBox.showSuccessToast(data.result_msg);
                        $('#row_'+_bkcd).remove();

                        var obj = data.result_obj;

                        // 전체입고,종수 업데이트
                        $('#bk_tot_qty').val(number_format(obj.tot_qty));
                        $('#bk_tot_cnt').val(number_format(obj.tot_cnt));

                    } else {
                        MsgBox.error(data.result_msg);
                    }
        });


    }


    // 부분리셋
    function formReset(data){

        var sublGb = $("#subl_gb option:selected").val();


        //폼 정리 //////////////////////
        $('#sublFrm')[0].reset();
        $("input[type='hidden']").val('');

        //필수데이터 유지 ///////////////////////////////////////////////

        // 전체입고,종수 업데이트
        $('#bk_tot_qty').val(number_format(data.tot_qty));
        $('#bk_tot_cnt').val(number_format(data.tot_cnt));


        $('#grp_no').val(data.grp_no);
        $('#subl_gb').val(sublGb);

//        $('#pub_code').val(data.pub_cd);  // 출판사(거래처) 정보 유지
//        $('#pub_name').val(data.pub_nm);

        // 제본소 유지
        $('#binder_code').val(data.binder_code);  // 제본수 정보 유지
        $('#binder_name').val(data.binder_name);

        // 출판사 유지
        $('#pub_code').val(data.pub_code);  // 출판사 정보 유지
        $('#pub_name').val(data.pub_name);


        $('#bar_code').focus();

    }

    // 도서 스캔수 > 기존 도서 데이터 클리어
    function bookDataClear(){


        $('#bk_nm').val('');

        //$('#pub_code').val('');  // 출판사(거래처) 정보 유지
        //$('#pub_name').val('');

        $('#bk_cd').val('');
        $('#bk_price').val('');
        $('#contract_yn').val(''); //vs code > js_yn 구분자

        // 입고수량 default value (입수수 )
        $('#ipsu_qty').val(''); // 입고 모달창  new_qty 할당
    }



    //입고 데이터 전송 - 확인______________
    function sublTransferConfirm(){
        MsgConfirmBox.show('입고 자료를 전송하시겠습니까? ',function(res){
            if(res){
                sublTransfer();
            }
        });
    } //end func === ==========



    function formClear(){

        var BinderCode = $('#binder_code').val(); // 20210409
        var BinderName = $('#binder_name').val();

        $("input[type='hidden']").val('');
        $('#subl_bk_list  > tbody').html("");
        $('#sublFrm')[0].reset();

         $('#binder_code').val(BinderCode);
         $('#binder_name').val(BinderName);
    }


    //입고 데이터 전송하기  ///////////////////////////////////////////////
    function sublTransfer(){
        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.bksubl_update.php"
        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:$('#sublFrm').serialize(),
            success:function(data) {
                var result = data.result_stat;
                if(result){
                    formClear();
                    ToastBox.showSuccessToast("입고 자료가 정상 전송되었습니다.");
                    $('#bar_code').focus();

                } else {
                    playBeepSound();
                    alert(data.result_msg);
                }

            },error : function(xhr, status, error) {
                playBeepSound();
                alert("입고 전송시 오류가 발생했습니다. ("+error+")");
            }
        }); //end ajax func ====
    }




    // 수불 임시 저장하기 /////////////////////////////////////////////////
    function formSubmit(){
        var sublGb = $("#subl_gb option:selected").val();
        var binderName = $('#binder_name').val();
        var binderCode = $('#binder_code').val();

        var pubName = $('#pub_name').val();
        var pubCode = $('#pub_code').val();

        if(sublGb == '11' && binderName.length == 0 ){
            playBeepSound();
            MsgBox.warningCallback("제본소 정보를 입력하세요.",function(){
                $('#binder_code').focus();
            })

            return false;
        }


        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.bksubl_tmp_update.php"

        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:$('#sublFrm').serialize(),
            success:function(data) {
                var obj = data.result_obj;
                var result = data.result_stat;

                if(result){
                    $('#grp_no').val(obj.grp_no);
                    if(!obj.is_dup) { // 입고 데이터 입력
                        $('#subl_bk_list  > tbody').prepend(makeTableRow(obj));
                    }else {  ///  기존 입고 레코드 수정
                        $('#row_' + obj.bk_cd).replaceWith(makeTableRow(obj));
                    }

                    ToastBox.showSuccessToast("'"+obj.bk_nm+"' 도서가 입고등록 되었습니다.");

                    obj.binder_code = binderCode;
                    obj.binder_name = binderName;

                    obj.pub_code = pubCode;
                    obj.pub_name = pubName;
                    formReset(obj);

                } else {
                    playBeepSound();
                    //alert(data.result_msg);
                    MsgBox.error(data.result_msg);
                }


            },error : function(xhr, status, error) {
                playBeepSound();
                alert("입고 저장시 오류가 발생했습니다. ("+error+")");
            }
        }); //end ajax func ==== ===============

        return false;

    } //end func


    // 멘트 선택창(modal) 호출 --------
    //type 0 발신, 1 착신
    function showMentModal(type,srcObj,trgObj){

        if(type == 0)
            $('.card-header').text("통화대기 멘트 목록");
        else
            $('.card-header').text("통화연결 멘트 목록");

        $.get("<?php echo G5_BBS_URL?>/ajax.call_ment_list.php",
            {
                'ment_type':type,
                'ment_idx':srcObj.val()
            },
            function(data){
                $('.card-body > div').html(data);
                $('#mentModal').modal();

                $('#modal_ment_idx').change(function(){
                    var selVal = $('#modal_ment_idx option:selected').val();
                    if(selVal.length>0){

                        srcObj.val(selVal);
                        trgObj.val($('#modal_ment_idx option:selected').text());
                        $('#mentModal').modal('hide');
                        srcObj=null;
                        trgObj=null;
                    }
                });

                $('#btn_ment_choose').click(function(){
                    var selVal = $('#modal_ment_idx option:selected').val();
                    if(selVal.length>0){
                        srcObj.val(selVal);
                        trgObj.val($('#modal_ment_idx option:selected').text());
                        $('#mentModal').modal('hide');
                        srcObj=null;
                        trgObj=null;
                    }
                });

            });

    } //end func ==============







</script>