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

        <!-- Modal -->
        <div class="modal fade" data-keyboard="false" data-backdrop="static" id="InvoiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">송장번호 확인</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        존재하지 않는 송장번호 입니다.
                    </div>
                    <div class="modal-footer">
                        <button onclick="inv_no_focus();" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" data-keyboard="false" data-backdrop="static" id="CheckGbModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">송장번호 확인</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        출고완료 된 송장번호 입니다.
                    </div>
                    <div class="modal-footer">
                        <button onclick="inv_no_focus();" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row  no-gutters my-1">

            <label for="subl_date" class="col-3 col-form-label"><b>일자</b></label>
            <div class="col-4">
                <input type="text" class="form-control text-center required" name="subl_date" id="subl_date"  placeholder="">
            </div>

        </div>

        <div class="form-group row  no-gutters my-1">
            <label for="inv_no" class="col-3 col-form-label">송장번호</label>
            <!--            <div class="col-9">-->
            <!--                <input type="text" class="form-control  required" name="inv_no" id="inv_no" placeholder="스캔">-->
            <!--            </div>-->

            <!-- input group area/  아이콘 붙임   -->
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
            <label for="box_no" class="col-3 col-form-label">박스번호</label>
            <!--            <div class="col-9">-->
            <!--                <input type="text" class="form-control  required" name="box_no" id="box_no" placeholder="스캔">-->
            <!--            </div>-->


            <!-- input group area/  아이콘 붙임   -->
            <div class="input-group col-9">
                <input type="text" name="box_no" value="" id="box_no" minlength="13" maxlength="20" class="form-control" placeholder="스캔">
                <div class="input-group-append">
                    <button class="btn btn-primary" id="btnSrchBox" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>


        </div>
        <!--
                <div class="form-group row  no-gutters my-1">
                    <label for="slip_no" class="col-3 col-form-label">전표번호</label>
                    <div class="col-3">
                        <input type="text" class="form-control required" name="slip_no" id="slip_no" readonly placeholder="">
                    </div>

                    <label for="subl_no" class="col-3 col-form-label text-center">주문번호</label>
                    <div class="col-3">
                        <input type="text" class="form-control" name="subl_no" id="subl_no" readonly placeholder="">
                    </div>
                </div>
        -->
        <div class="form-group row  no-gutters my-1">
            <label for="subl_no" class="col-3 col-form-label">전표번호</label>
            <div class="col-3">
                <input type="text" class="form-control required" name="subl_no" id="subl_no" readonly placeholder="">
            </div>

            <label for="order_no" class="col-3 col-form-label text-center">주문번호</label>
            <div class="col-3">
                <input type="text" class="form-control" name="order_no" id="order_no" readonly placeholder="">
            </div>
        </div>
        <div class="form-group row  no-gutters my-1">
            <label for="bk_cd" class="col-3 col-form-label">도서코드</label>
            <div class="col-9">
                <input type="text" class="form-control  required" name="bk_cd" id="bk_cd" readonly placeholder="">
            </div>
        </div>

        <div class="form-group row  no-gutters my-1">
            <label for="bk_nm" class="col-3 col-form-label">도서명</label>
            <div class="col-9">
                <input type="text" class="form-control  required" name="bk_nm" id="bk_nm" readonly placeholder="">
            </div>
        </div>


        <div class="form-group row  no-gutters my-1">
            <label for="ju_qty" class="col-3 col-form-label">출고부수</label>
            <div class="col-3">
                <input type="text" class="form-control" name="ju_qty" id="ju_qty" readonly placeholder="">
            </div>
            <label for="besong_gb_nm" class="col-3 col-form-label text-center">배송구분</label>
            <div class="col-3">
                <input type="text" class="form-control" name="besong_gb_nm" id="besong_gb_nm" readonly placeholder="">
            </div>


        </div>

        <div class="form-group row  no-gutters my-1">
            <label for="chk_qty" class="col-3 col-form-label">검수부수</label>
            <div class="col-3">
                <input type="text" class="form-control bg-warning" name="chk_qty" id="chk_qty" readonly placeholder="">
            </div>

            <label for="order_qty" class="col-3 col-form-label text-center">주문부수</label>
            <div class="col-3">
                <input type="text" class="form-control bg-warning" name="order_qty" id="order_qty" readonly placeholder="">
            </div>
        </div>

        <hr>
        <div class='d-flex justify-content-end my-2' >
            <button type="button" class="btn  btn-secondary" id="btnReset" >초기화</button>
            &nbsp;
            <button type="button"  class="btn  btn-danger" id="btnSubmit"> <i class="fas fa-paper-plane"></i> 출고검수하기</button>
        </div>



        <!-- 검수 리스트   --------------------------------------------------------------------------->
        <!--
        <div class="mt-4">

            <table id="bk_list" class="table  table-hover">
                <thead>
                <tr>
                    <th scope="col">Y/N</th>
                    <th scope="col">검수</th>
                    <th scope="col" class="td_right">도서명</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
        -->



    </form>



</section>




<script>
    /// Android Virtual Keyboard /////////////////////////////////////////////////////////
    var AndroidKeyboardHide=true; //default true - only bar_cd

    //마지막 선택된 작업일
    var LastWorkDate = "";


    $(function() {



        //////////////////////////////////////////////////////////////////////////////////////////////
        ///////////   Android Virtual Keyboard / Control  {
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

        //_------------------------------------------------------------------
        $("#box_no").doubleTap(function() {
            AndroidKeyboardHide=false;
            setTimeout(function(){
                $("#box_no").focus();
            },300);
        });

        $("#box_no").focus(function(){
            if(window.hasOwnProperty("Android")){
                window.Android.setKeyboardHide(AndroidKeyboardHide);
            }
            AndroidKeyboardHide=true;
        });


        ////       }    //////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////


        //var moment = moment();
        $( "#subl_date" ).datepicker({
            onSelect:function(dateText,inst){
                var date = $(this).val();

                LastWorkDate=date;

            }
        });

        var startDate = $('#subl_date').val();
        if(startDate.length == 0)
            $( "#subl_date" ).datepicker('setDate','today');




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

            var sublDate = filteringSpcChr($('#subl_date').val());
            if(sublDate.length != 8){
                playBeepSound();
                MsgBox.warning("일자를 바르게 입력하세요.");
                return false;
            }

            // 송장 조회 /////////////////
            findOutList(val,sublDate);
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

            var sublDate = filteringSpcChr($('#subl_date').val());
            if(sublDate.length != 8){
                playBeepSound();
                MsgBox.warning("일자를 바르게 입력하세요.");
                return false;
            }
            findOutList(val,sublDate);
        });





        //box no > 스캔 > 검수시작
        $('#box_no').keyup(function(e) {

            if (e.keyCode != 13) {
                return true;
            }

            // 출고 검수 호출
            validateChulBoxNo();

        });

        //버튼으로 박스번호 검수
        $('#btnSrchBox').click(function() {
            // 출고 검수 호출
            validateChulBoxNo();
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


    function inv_no_focus(){
        $('#inv_no').focus();
    }


    function validateChulBoxNo(){

        //var $this = $(this);
        var $this = $('#box_no');
        var val = filteringSpcChr($this.val());

        var sublNo = $('#slip_no').val();
        if(sublNo.length == 0){
            playBeepSound();
            MsgBox.warningCallback("검수할 송장부터 조회하세요.",function(){
                $('#inv_no').focus();

            });
            return false;
        }
        var besongChk = filteringSpcChr($('#besong_gb_nm').val());
        if(besongChk.length==0){
            playBeepSound();
            MsgBox.warning("검수 할 수 없는 운송구분입니다. ");
            return false;
        }

        //if(val.length < 13 || val.length > 14){
        if(val.length < 13){
            playBeepSound();
            //MsgBox.warningCallback("박스번호를 확인해주세요.(*13,14자리)",function(){
            MsgBox.warningCallback("박스번호를 확인해주세요.(*13자리 이상)",function(){
                //$this.val('');
                $this.focus();
            });
        }

        var bkCode = $('#bk_cd').val();
        if(bkCode.length >= 8 && val.length>=8){
            if(bkCode.substr(0,8) != val.substr(0,8)){
                playBeepSound();
                MsgBox.warningCallback("박스번호와 도서코드가 일치하지 않습니다.", function () {
                    $this.val('');
                    $this.focus();
                });
                return false;
            }
        }

        //박스 > 출고 검수 시작___________
        checkChulBoxNo(val,function(data){
            if(data>0){
                playBeepSound();
                MsgBox.warningCallback("이미 출고 검수된 박스입니다.",function(){
                    $this.val('');
                    $this.focus();
                });
                return false;
            }
        });


        //box_no 길이가 13,14 > 검수 결과true 이면 > 자동으로 검수버튼 호출 -> 13자리 이상으로 변경
        // if(val.length == 13 || val.length == 14){
        if(val.length >= 13){
            $('#btnSubmit').trigger("click");
        }

    } //end func ============================




    // 출고 자료 추출 -gt
    function findOutList(invNo,sublDate){

        ToastBox.showLoadingToast("로딩중입니다.");

        $.getJSON('ajax.chulmt_gt_search.php',{'inv_no':invNo,'subl_date':sublDate},function(data){
            ToastBox.closeToast();

            //console.log(data);

            if(data.hasOwnProperty("result_msg")){
                MsgBox.error(data.result_msg);
                return false;
            }

            if(data == null || data === false || data == undefined){
                playBeepSound();
                MsgBox.alert("송장번호 [" +invNo+ "] 출고자료가 존재하지 않습니다.  ");
                return false;
            }

            var besongGb = data.besong_gb;
            var $besongNm = $('#besong_gb_nm');
            if(besongGb == "41"){
                $besongNm.val('택배');

                if(Number(data.bita) != Number(data.bitb)){
                    playBeepSound();
                    MsgBox.warning("잘못 발행된 운송장 번호입니다. ");
                    return false;
                }
            } else if(besongGb == "31"){
                $besongNm.val('천일화물');
            } else if(besongGb == "11"){
                $besongNm.val('시내');
            } else if(besongGb == "19"){
                $besongNm.val('파주');
            } else if(besongGb == "51"){
                $besongNm.val('직송');
            } else {
                $besongNm.val('');
            }

            //$('#slip_no').val(data.slipno); // slip_no가 아니다 ㅜㅜ;
            $('#subl_no').val(data.subl_no);   //
            $('#order_no').val(data.order_no); //주문번호
            $('#bk_cd').val(data.bk_cd);
            $('#bk_nm').val(data.bk_nm);
            $('#ju_qty').val(data.ju_qty);

            ToastBox.showLoadingToast("*체크중입니다.");

                //송장번호 체크
                checkInvoiceCheck(sublDate,invNo,function(data){

                    if(data == 0) {
                        playBeepSound();//소리출력
                        ToastBox.closeToast();

                        $('#InvoiceModal').modal("show");

                        $('#inv_no').focus();
                        $('#inv_no').val('');

                        return false;
                    }

                });

                //출고완료 체크
                checkCheckGb(sublDate,invNo,function(data){

                    if(data >= 1){
                        playBeepSound();//소리출력
                        ToastBox.closeToast();
                        $('#CheckGbModal').modal("show");


                        $('#inv_no').focus();
                        $('#inv_no').val('');
                        formClear();
                        return false;
                    }

                });



                //01.출고 주문체크
                checkChulJumun(sublDate,data.subl_no,data.bk_cd,function(data){

                    if(data > 0){
                        playBeepSound();
                        ToastBox.closeToast();
                        MsgBox.warning("이미 출고완료된 주문입니다. ");
                        $('#inv_no').select();
                        return false;
                    }

                    checkChulBkmech(sublDate,data.subl_no,function(data){

                        ToastBox.closeToast();
                        if(data>0){
                            playBeepSound();
                            MsgBox.warning("이미 입력된 출고주문입니다.");
                            $('#inv_no').select();
                            return false;
                        }


                    });

                });



                //검수수량 + 주문수량 구함+++++++++++++++++++++++++++
                if(data.bk_cd.length >0){
                    findGbooksTotQty(sublDate,data.bk_cd,function(data){

                        ToastBox.closeToast();
                        //chk_qty, order_qt
                        //console.log("goods qty");
                        //console.log(data);

                        $('#chk_qty').val(data.chk_qty);
                        $('#order_qty').val(data.order_qty);

                    });
                } else {
                    ToastBox.closeToast();
                }


                $('#box_no').focus();

            }); //end ajax







        } //end func ======================

        /// 출고완료 체크
        function checkCheckGb(sublDate,invNo,callback){

            $.getJSON('ajax.chulmt_gt_check_gb.php',{'subl_date':sublDate,'invc_no':invNo},
                function(data) {

                    callback(data);
                });


        }

        /// 송장번호 체크
        function checkInvoiceCheck(sublDate,invNo,callback){


            $.getJSON('ajax.chulmt_gt_invoice_check.php',{'subl_date':sublDate,'invc_no':invNo},
                function(data) {

                    callback(data);
                });


        }


        /// 출고 >주문체크
        function checkChulJumun(sublDate,sublNo,bkCode,callback){


            $.getJSON('ajax.chulmt_gt_bjumun_check.php',{'subl_date':sublDate,'subl_no':sublNo,'bk_cd':bkCode},
                function(data) {

                    callback(data);
                });


        }


        /// 출고 등록체크
        function checkChulBkmech(sublDate,sublNo,callback){

            $.getJSON('ajax.chulmt_gt_bkmech_check.php',{'subl_date':sublDate,'subl_no':sublNo},
                function(data) {

                    callback(data);
                });
        }


        /// 검수수량 + 주문수 추출 ???
        function findGbooksTotQty(sublDate,bkCode,callback){

            $.getJSON('ajax.chulmt_gt_qty_get.php',{'subl_date':sublDate,'bk_cd':bkCode},
                function(data) {

                    callback(data);
                });
        }


        /// 출고 > 박스번호 > 출고검수 (gt 검수함수)
        function checkChulBoxNo(boxNo,callback){
            ToastBox.showLoadingToast("*박스번호 체크중입니다.");
            $.getJSON('ajax.chulmt_gt_box_check.php',{'box_no':boxNo},
                function(data) {
                    ToastBox.closeToast();
                    callback(data);
                });
        }



        function checkChulGtConfirm(){

            var sublNo = $('#subl_no').val(); // 주문번호
            var invNo = $('#inv_no').val(); // 송장번호
            if(sublNo.length == 0 || invNo.length == 0){
                MsgBox.warningCallback("검수할 송장부터 조회하세요.",function(){
                    $('#inv_no').focus();

                });
                return false;
            }


            var boxNo = $('#box_no').val();

            if(boxNo.length<=0){
                playBeepSound();
                MsgBox.warning("박스번호를 입력하세요.");
                return false;
            }


            var besongChk = filteringSpcChr($('#besong_gb_nm').val());
            if(besongChk.length==0){
                playBeepSound();
                MsgBox.warning("검수 할 수 없는 운송구분입니다. ");
                return false;
            }



            var bkCode = $('#bk_cd').val();
            if(bkCode.length >= 8 && boxNo.length>=8){
                if(bkCode.substr(0,8) != boxNo.substr(0,8)){
                    playBeepSound();
                    MsgBox.warning("박스번호와 도서코드가 일치하지 않습니다.");
                    return false;
                }
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
                    if(result == -1){
                        playBeepSound();
                        MsgBox.warning("이미 검수되었습니다. ");
                        callback(false);
                        return false;
                    } else if(result == -2){
                        playBeepSound();
                        MsgBox.warning("gt_bjumun의 데이터가 없습니다. ");
                        callback(false);
                        return false;
                    } else if(result == -3){
                        playBeepSound();
                        MsgBox.warning("동일한 박스가 출고되었습니다. ");
                        callback(false);
                        return false;
                    } else if(result == -9){
                        playBeepSound();
                        MsgBox.error("필수 파라미터가 누락되었습니다.");
                        callback(false);
                        return false;
                    } else if(result == -99){
                        playBeepSound();
                        MsgBox.error("검수 처리시 오류가 발생했습니다.(DB) ");
                        callback(false);
                        return false;
                    }


                    callback(true);

                },error : function(xhr, status, error) {
                    playBeepSound();
                    alert("출고 검수시 오류가 발생했습니다. ("+error+")");
                }
            }); //end ajax func ====


            return false;
        }

        function formClear(){
            $("input[type='hidden']").val('');
            //$('#bk_list  > tbody').html("");
            $('#bkFrm')[0].reset();

            if(LastWorkDate.length>0)
                $( "#subl_date").val(LastWorkDate);
            else
                $( "#subl_date" ).datepicker('setDate','today'); // 초기화에서 일자 제외
        }






</script>