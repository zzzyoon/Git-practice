<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
add_javascript('<script src="'.G5_JS_URL.'/moment-with-locales.min.js"></script>', 9);
?>
<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>

<section id="contents">


<form id="bkFrm" name="bkFrm" method="post" action=""   autocomplete="off">
    <input type="hidden" name="grp_no" id="grp_no"  value=""  >
    <input type="hidden" name="bk_cd" id="bk_cd"  value=""  >
    <input type="hidden" name="bk_price" id="bk_price"  value=""  >
    <input type="hidden" name="contract_no" id="contract_no"  value=""  >  <!-- 발주번호 -->
    <input type="hidden" name="contract_yn" id="contract_yn"  value=""  >
    <!-- PROC_BKINFOCUR > move_yn (js_yn,contract_yn) / 반품 재생 불가 구분자 Y 불가 -->


    <div class="form-group row  no-gutters my-1">
        <label for="bar_cd" class="col-3 col-form-label">도서코드</label>

<!--        <div class="col-9">-->
<!--            <input type="text" class="form-control  required" name="bar_cd" id="bar_cd" value="" placeholder="Scan">-->
<!--        </div>-->
        <!-- input group area/  찾기 아이콘 붙임   -->
        <div class="input-group col-9">
            <input type="text" name="bar_cd" value="" id="bar_cd" class="form-control hide-keyboard" placeholder="스캔">
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
            <input type="text" class="form-control  required" name="bk_nm" id="bk_nm" readonly placeholder="">
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="tax_no" class="col-3 col-form-label">출판사</label>
        <div class="col-3">
            <input type="text" class="form-control  required text-center" name="tax_no" id="tax_no" readonly placeholder="">
        </div>
        <div class="col-6">
            <input type="text" class="form-control  required" name="cust_nm" id="cust_nm" readonly placeholder="">
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="team_nm" class="col-3 col-form-label">출고부서</label>
        <div class="col-3">
            <input type="text" class="form-control" name="team_nm" id="team_nm" readonly placeholder="">
        </div>

        <label for="loc_cd" class="col-3 col-form-label text-center">서가LOC</label>
        <div class="col-3">
            <input type="text" class="form-control  bg-gray-5" name="loc_cd" id="loc_cd" readonly placeholder="">
        </div>
    </div>

   <div class="form-group row  no-gutters my-1">
        <label for="avg_qty" class="col-3 col-form-label">안전재고</label>
        <div class="col-3">
            <input type="text" class="form-control bg-gray-5" name="avg_qty" id="avg_qty" readonly placeholder="">
        </div>

        <label for="rloc_cd" class="col-3 col-form-label text-center">반품LOC</label>
        <div class="col-3">
            <input type="text" class="form-control" name="rloc_cd" id="rloc_cd" readonly placeholder="">
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="ipsu_qty" class="col-3 col-form-label">입수단위</label>
        <div class="col-3">
            <input type="text" class="form-control bg-gray-5" name="ipsu_qty" id="ipsu_qty" readonly placeholder="">
        </div>

        <label for="move_yn" class="col-3 col-form-label text-center">보충불가</label>
        <div class="col-3 pt-2">
            Y
            <input type="radio" name="move_yn" id="move_yn1" checked value="Y"  onclick="return(false);" >
            &nbsp;
            N
            <input  type="radio" name="move_yn" id="move_yn2"  value="N"  onclick="return(false);">

        </div>
    </div>


    <div class="form-group row  no-gutters my-1">
        <label for="rtn_gb" class="col-3 col-form-label">반품재고관리</label>
        <div class="col-3">
            <input type="text" class="form-control" name="rtn_gb" id="rtn_gb" readonly placeholder="">
        </div>

    </div>




    <div class="form-group row  no-gutters my-1">
        <label for="a_qty" class="col-3 col-form-label">정품재고수량</label>
        <div class="col-3">
            <input type="text" class="form-control" name="a_qty" id="a_qty" readonly placeholder="">
        </div>

        <label for="x_qty" class="col-3 col-form-label text-center">반품재고수량
        </label>
        <div class="col-3">
            <input type="text" class="form-control" name="x_qty" id="x_qty" readonly placeholder="">
        </div>
    </div>


    <div class="form-group row  no-gutters my-1">

        <label for="medg_qty" class="col-3 col-form-label">정품대기수량</label>
        <div class="col-3">
            <input type="text" class="form-control" name="medg_qty" id="medg_qty" readonly placeholder="">
        </div>

        <label for="bandg_qty" class="col-3 col-form-label text-center">반품대기수량
        </label>
        <div class="col-3">
            <input type="text" class="form-control" name="bandg_qty" id="bandg_qty" readonly placeholder="">
        </div>
    </div>


    <hr>

    <div class='d-flex justify-content-end my-2' >
        <small>*참고:입수단위,기본서가 수정가능(해당란 더블클릭)</small>
        <button type="button" class="btn  btn-secondary mx-2" id="btnReset" >초기화</button>
    </div>


</form>

</section>


<!-- 기본 서거 변경  > 모달    {  -------------------------------------------------------------------------------------  -->

<div class="modal" id="avgQtyModal">
    <form name="avgFrm" id="avgFrm" method="post"  onsubmit="return updateAvgQty()">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">안전재고 </h4>
                    <button type="button" class="close" data-dismiss="modal"><i class="fas fa-window-close" style="font-size:20px;"></i></button>
                </div>


                <!-- Modal body -->
                <div id="modal_num_book" class="modal-body">
                    <div>
                    <label for="new_avg_qty" >최소값</label>
                    <input type="text" id="new_avg_qty" name="new_avg_qty"  inputmode="numeric" class="form-control numeric text-center font-weight-bold required text-select" size="10" value="">
                    </div>

                    <div>
                        <label for="new_max_qty" >최대값</label>
                        <input type="text" id="new_max_qty" name="new_max_qty"  inputmode="numeric"   class="form-control numeric text-center font-weight-bold required text-select" size="10" value="">
                    </div>


                </div>


                <!--   Modal footer-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button type="submit"  class="btn btn-primary">확인</button>
                </div>


            </div>
        </div>
    </form>
</div>
<!--   }  기본 서거 변경  > 모달 ------------------------------------------------------------------------ -->






<!-- 기본 서거 변경  > 모달    {  -------------------------------------------------------------------------------------  -->

<div class="modal" id="locModal">
    <form name="locFrm" id="locFrm" method="post"  onsubmit="return updateLocCode()">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">기본서가 변경 </h4>
                               <button type="button" class="close" data-dismiss="modal"><i class="fas fa-window-close" style="font-size:20px;"></i></button>
            </div>


            <!-- Modal body -->
            <div id="modal_num_book" class="modal-body">

                    <label for="new_loc_cd" >새로운 서가 위치</label>
                <input type="text" id="new_loc_cd" name="new_loc_cd"  class="form-control text-center font-weight-bold required text-select" size="10" value="">

            </div>


            <!--   Modal footer-->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                <button type="submit"  class="btn btn-primary">확인</button>
            </div>


        </div>
    </div>
    </form>
</div>

<!--   }  기본 서거 변경  > 모달 ------------------------------------------------------------------------ -->



<!-- 입수단위 변경 > 모달   {  ----------------------------------------------------------------- -->

<div class="modal" id="ipsuModal">
    <form name="locFrm" id="locFrm" method="post"  onsubmit="return updateIpsuQty()">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">입수단위 변경 </h4>
                    <button type="button" class="close" data-dismiss="modal"><i class="fas fa-window-close" style="font-size:20px;"></i></button>
                </div>


                <!-- Modal body -->
                <div id="modal_num_book" class="modal-body">

                    <label for="new_ipsu_qty" >새로운 입수단위</label>
                    <input type="text" id="new_ipsu_qty" name="new_ipsu_qty" inputmode="numeric"  class="form-control text-center font-weight-bold required numeric text-select" size="10" value="">

                </div>


                <!--   Modal footer-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button type="submit"  class="btn btn-primary">확인</button>
                </div>


            </div>
        </div>
    </form>
</div>
<!--  }  입수단위 변경 > 모달   ---------------------------------------------------------------------------------------------------  -->




<!-- 도서 검색 -->
<? include_once(G5_THEME_PATH . '/view_modal_bookcd.php'); ?>



<script>
    /// Android Virtual Keyboard /////////////////////////////////////////////////////////
    var AndroidKeyboardHide=true; //default true - only bar_cd


    $(function() {


        //ToastBox.showSuccessToast("일괄 처리 완료되었습니다.");
        //////////////////////////////////////////////////////////////////////////////////////////////
        ///////////   Android Virtual Keyboard / Control  {
        $("#bar_cd").doubleTap(function() {
            AndroidKeyboardHide=false;
            setTimeout(function(){
                $("#bar_cd").focus();
            },300);
        });

        $("#bar_cd").focus(function(){
            if(window.hasOwnProperty("Android")){
                window.Android.setKeyboardHide(AndroidKeyboardHide);
            }
            AndroidKeyboardHide=true;
        });
        ////       }    //////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////




        //도서 검색 //////////////////////////////////////////
        $('#bar_cd').keyup(function(e) {

            if (e.keyCode != 13) {
                return true;
            }

            var $this = $('#bar_cd');
            var val  = $this.val();

            // if(val.length < 13){
            //     playBeepSound();
            //     MsgBox.alertCallback("바코드를 바르게 입력하세요.",function(){
            //
            //         $('#bar_cd').val('');
            //         $('#bar_cd').focus();
            //     });
            //
            //     return false;
            // }



            formClear();
            $this.val(val);
            doSearch();

        });


        $('#bkFrm').keyup(function(e){
            if (e.keyCode == 13) {
                if(e.target.id == "bar_cd"){
                    return;
                }
                $('#bar_cd').select();
            }
        });


        /*
        var oldVal='';
        $('#bar_cd').on('input',function(){
            var curVal = $(this).val().trim();
            if(oldVal == curVal){
                return;
            }

            if((curVal.length % 13) == 0) {
                var realVal='';
                if(curVal.length > 13){
                     realVal = curVal.substr(13);
                } else {
                    realVal = curVal;
                }

                oldVal = realVal;
                $(this).val(realVal);
            }
        });
        */

        $('#btnSrch').click(function(){

            var $this = $('#bar_cd');
            var val  = $this.val();
            if(val.length < 13){
                playBeepSound();
                MsgBox.alertCallback("바코드를 바르게 입력하세요.",function(){
                    $('#bar_cd').val('');
                    $('#bar_cd').focus();
                });

                return false;
            }



            formClear();
            $this.val(val);
            doSearch();
        });


        $('#btnReset').click(function(){
            formClear();
            $('#bar_cd').focus();
        });


        //안전재고 변경
        $('#avg_qty').doubleTap(function(){

            var val = $('#avg_qty').val(); // $(this) not working
            if(val.length == 0)
                 return;

            var qtys = val.split('/');
            var avgQty = qtys[0];
            var maxQty = qtys[1];

            $('#avgQtyModal').modal();

            $('#avgQtyModal').modal();
            $('#avgQtyModal .modal-header').text("안전재고 변경 (* 현재 : "+val+") ");

            $('#new_avg_qty').val(avgQty);
            $('#new_max_qty').val(maxQty);

            $('#new_avg_qty').focus();



        });

        ///기본서가 변경
        $('#loc_cd').doubleTap(function(){
            var bkCode = $('#bk_cd').val();
            var locCd = $('#loc_cd').val();
            if(bkCode.length > 0) {
                $('#locModal').modal();
                $('#locModal .modal-header').text("서가위치 변경 (* 현재 : "+locCd+") ");
                $('#new_loc_cd').val(formatLocCode(locCd));
                $('#new_loc_cd').focus();
            }
        });

        ///입수단위 변경
        $('#ipsu_qty').doubleTap(function(){
            var bkCode = $('#bk_cd').val();
            var ipsuQty = $('#ipsu_qty').val();
            if(bkCode.length > 0) {

                $('#ipsuModal').modal();
                $('#ipsuModal .modal-header').text("입수단위 변경 (* 현재 : "+ipsuQty+"권) ");
                $('#new_ipsu_qty').val(ipsuQty);
                $('#new_ipsu_qty').focus();
            }
        });

        $('#bar_cd').focus();

    });  //end ready func__=======================================================================================================


    function doSearch(){

        var $this = $('#bar_cd');
        var val  = $this.val();//.value;
        if(val.length == 0) {
            return false;
        }

        var barCd = "";
        var bkNm = "";

        // if($.isNumeric(val)){
        //     barCd = filteringLocCode(val);
        //     if(val.length < 11){
        //         this.value = '';
        //         return false;
        //     }
        // } else {
        //     bkNm = val;
        // }

        bkNm = val;


        showBookModal('',barCd, bkNm,function(res,json){

            //console.log("showBookModal Callback Funtion ++++++++++");
            //console.log(json);

            if(res){

                $('#bar_cd').val(json.bar_cd);
                $('#bk_cd').val(json.bk_cd);
                $('#bk_nm').val(json.bk_nm);
                $('#tax_no').val(json.tax_no);
                $('#cust_nm').val(json.cust_nm);
                $('#ipsu_qty').val(json.ipsu_qty);
                $('#rtn_gb').val(json.rtn_gb);
                $('#avg_qty').val(json.avg_qty+"/"+json.max_qty); //안전재고
                $('#a_qty').val(json.a_qty);
                $('#x_qty').val(json.x_qty);

                // formatLocCode error
                $('#loc_cd').val(formatLocCode(json.loc_cd));
                $('#rloc_cd').val(formatLocCode(json.rloc_cd));

                // 출고팀 조회
                findChulTeam(json.tax_no,function(data){
                    $('#team_nm').val(data);
                });


                //??
                // 보충불가, 계간지(주간지), 정품대기 ,반품대기
                //move_ym, , medg_qty (출고대기), bandg_qty (bookcd에 컬럼이 없다.)  ---------->>> PKGMHPDA.PROC_BKINFOCUR 프로시져 수정????

                // 보충 불가
                if(json.move_yn == "Y"){
                    $(':radio[name="move_yn"]').filter("[value='Y']").prop('checked', true);
                } else {
                    $(':radio[name="move_yn"]').filter("[value='N']").prop('checked', true);
                }

                $('#medg_qty').val(json.medg_qty); //정품 출고 대기수량
                $('#bandg_qty').val(json.bandg_qty); //반품 출고 대기수량

                $this.select();

            } else {
                ToastBox.showToast("조회된 도서가 없습니다. ");
                $this.val('');
                $this.focus();
            }

        });


    } //end func==========================


    function findChulTeam(taxNo,callback){
        $.get('ajax.team_search.php?tax_no='+taxNo,function(data){
                //console.log(data);
               callback(data);
        });
    }

    function formClear(){
        $("input[type='hidden']").val('');
        //$('#bk_list  > tbody').html("");
        $('#bkFrm')[0].reset();
    }


    // 도서마스터 > 안전재고 변경하기 +++++++++++++++++++++++++++++++++++++++++++++++++
    function updateAvgQty(){


        var bkCode = $('#bk_cd').val();
        var taxNo = $('#tax_no').val();

        var newAvgQty = Number($('#new_avg_qty').val());
        var newMaxQty = Number($('#new_max_qty').val());

        if(newAvgQty <=0 || newMaxQty <= 0){
            MsgBox.warning("안전재고를 바르게 입력하세요.");
            return false;
        }

            /*
        var qtys = bookQty.split('/');

        var avgQty = qtys[0];
        var maxQty = qtys[1];
        */

        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.book_avgqty_update.php"

        //console.log(bkCode+"/"+taxNo+"/"+locCode);

        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:{'bk_cd':bkCode,'tax_no':taxNo,'avg_qty':newAvgQty,'max_qty':newMaxQty},//$('#locFrm').serialize(),
            success:function(data) {
                var result = data.result_stat;
                if(result){

                    ToastBox.showSuccessToast("안전재고가  변경되었습니다.");
                    $('#avgQtyModal').modal('hide');
                    $('#avg_qty').val(newAvgQty+"/"+newMaxQty);

                } else {
                    playBeepSound();
                    //alert(data.result_msg);
                    MsgBox.error(data.result_msg);
                }


            },error : function(xhr, status, error) {
                playBeepSound();
                alert("안전재고 수정시 오류가 발생했습니다. ("+error+")");
            }
        }); //end ajax func ====

        return false;

    } //end func  =========================================================================


    // 도서마스터 > 기본 서가 변경하기 +++++++++++++++++++++++++++++++++++++++++++++++++
    function updateLocCode(){


        var bkCode = $('#bk_cd').val();
        var taxNo = $('#tax_no').val();

        var oldLocCode = filteringSpcChr($('#loc_cd').val());
        var locCode = filteringSpcChr($('#new_loc_cd').val());

        if(locCode.length != 6){
            playBeepSound();
            MsgBox.alertCallback("로케이션을 올바르게 입력하세요.",function(){
                $('#new_loc_cd').focus();
            });
            return false;
        } else if(oldLocCode == locCode){
            playBeepSound();
            MsgBox.alertCallback("변경 할 로케이션이 기존 정보와 같습니다. ",function(){
                $('#new_loc_cd').val('');
                $('#new_loc_cd').focus();
            });
            return false;
        } else if(locCode.substr(0,1) != "A"){
            playBeepSound();
            MsgBox.alertCallback("로케이션은 서가로만 변경이 가능합니다. ",function(){
                $('#new_loc_cd').focus();
            });
            return false;
        }

        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.book_loc_update.php"

        //console.log(bkCode+"/"+taxNo+"/"+locCode);

        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:{'bk_cd':bkCode,'tax_no':taxNo,'loc_cd':locCode},//$('#locFrm').serialize(),
            success:function(data) {
                var result = data.result_stat;
                if(result){

                    ToastBox.showSuccessToast("기본 로케이션이 변경되었습니다.");
                    $('#locModal').modal('hide');
                    $('#loc_cd').val(formatLocCode(locCode));

                } else {
                    playBeepSound();
                    //alert(data.result_msg);
                    MsgBox.error(data.result_msg);
                }


            },error : function(xhr, status, error) {
                playBeepSound();
                alert("로케이션 수정시 오류가 발생했습니다. ("+error+")");
            }
        }); //end ajax func ====

        return false;

    } //end func  =========================================================================


    // 도서마스터 > 입수단위  변경하기 ++++++++++++++++++++++++++++++++
    function updateIpsuQty(){


        var bkCode = $('#bk_cd').val();
        var taxNo = $('#tax_no').val();

        var oldQty = Number($('#ipsu_qty').val());
        var newQty = Number($('#new_ipsu_qty').val());

        if(newQty<=0){
            playBeepSound();
            MsgBox.alertCallback("입수 단위를 올바르게 입력하세요.",function(){
                $('#new_ipsu_qty').focus();
            });
            return false;
        } else if(oldQty == newQty){
            playBeepSound();
            MsgBox.alertCallback("변경 할 입수 단위가 기존것과 같습니다.",function(){
                $('#new_ipsu_qty').focus();
            });
            return false;
        }

        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.book_ipsuqty_update.php"
        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:{'bk_cd':bkCode,'tax_no':taxNo,'ipsu_qty':newQty},//$('#locFrm').serialize(),
            success:function(data) {
                var result = data.result_stat;
                if(result){

                    ToastBox.showSuccessToast(data.result_msg);
                    $('#ipsuModal').modal('hide');
                    $('#ipsu_qty').val(newQty);

                } else {
                    playBeepSound();
                    //alert(data.result_msg);
                    MsgBox.error(data.result_msg);
                }


            },error : function(xhr, status, error) {
                playBeepSound();
                alert("입수수량 수정시 오류가 발생했습니다. ("+error+")");
            }
        }); //end ajax func ====

        return false;
    }




</script>