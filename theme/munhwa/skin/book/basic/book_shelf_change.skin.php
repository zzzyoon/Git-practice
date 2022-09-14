<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
// work time 관련 library___________________________________________________________
add_javascript('<script src="'.G5_JS_URL.'/moment-with-locales.min.js"></script>', 9);
?>
<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>

<section id="contents">
<form id="bkFrm" name="bkFrm" method="post" action=""  onsubmit="return  transferConfirm()"   autocomplete="off">
    <input type="hidden" name="jg_gb" id="jg_gb"  value=""  >

    <div style="display: none;" class="form-group row  no-gutters my-1">
        <label for="jg_gb" class="col-3 col-form-label ">재고 구분</label>
        <div class="col-9 col-md-3 pt-2">
            전체 <input type="radio" name="jg_gb99" id="jg_gb1" checked value="" <?=(!$DefJgGubun)?"checked":""?> >
            정품 <input type="radio" name="jg_gb99" id="jg_gb1" checked value="5" <?=($DefJgGubun=="CAPO")?"checked":""?> >
            반품 <input  type="radio" name="jg_gb99" id="jg_gb2"  value="7" <?=($DefJgGubun=="UCAPO")?"checked":""?> >
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

        <label for="jg_gb" class="col-3 col-form-label">구분</label>
        <div class="col-9 pt-2">
            입고<input type="radio" name="move_type" id="move_type11"  value="A">
            반품<input  type="radio" name="move_type" id="move_type22"  value="B">
            일반<input  type="radio" name="move_type" id="move_type33" checked value="C">
        </div>

        <label for="loc_cd" class="col-3 col-form-label">이동전LOC</label>
        <div class="col-9">
            <input type="text" class="form-control" name="loc_cd" id="loc_cd" placeholder="">
        </div>

    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="bar_cd" class="col-3 col-form-label">바코드</label>
<!--        <div class="col-9">-->
<!--            <input type="text" class="form-control  required" name="bar_cd" id="bar_cd" value="" placeholder="Scan">-->
<!--        </div>-->

            <!-- input group area/  찾기 아이콘 붙임   -->
            <div class="input-group col-9">
                <input type="text" name="bar_cd" value="" id="bar_cd" class="form-control" inputmode="search" placeholder="스캔">
                <div class="input-group-append">
                    <button class="btn btn-primary" id="btnSrch" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="mov_qty" class="col-3 col-form-label ">이동수량</label>
        <div class="col-9">
            <input type="text" class="form-control numeric required text-select" name="mov_qty" id="mov_qty"  placeholder="">
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="jg_qty" class="col-3 col-form-label">재 고 량</label>
        <div class="col-3">
            <input type="text" class="form-control" name="jg_qty" id="jg_qty" readonly placeholder="">
        </div>

        <label for="real_qty" class="col-3 col-form-label text-center">가능수량</label>
        <div class="col-3">
            <input type="text" class="form-control numeric required text-select" name="real_qty" id="real_qty" readonly placeholder="">
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="good_nm" class="col-3 col-form-label">상품명</label>
        <div class="col-9">
            <input type="text" class="form-control  required" name="good_nm" id="good_nm" readonly placeholder="">
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="good_cd" class="col-3 col-form-label">상품코드</label>
        <div class="col-9">
            <input type="text" class="form-control" name="good_cd" id="good_cd" readonly placeholder="">
        </div>
    </div>


    <div class="form-group row  no-gutters my-1">
        <label for="out_danga1" class="col-3 col-form-label">정가</label>
        <div class="col-3">
            <input type="text" class="form-control" name="out_danga1" id="out_danga1" readonly placeholder="">
        </div>

        <label for="size_gb" class="col-3 col-form-label text-center">사 이 즈</label>
        <div class="col-3">
            <input type="text" class="form-control" name="size_gb" id="size_gb" readonly placeholder="">
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">

        <label for="mov_loc_cd" class="col-3 col-form-label">변경서가</label>
        <div class="col-9">
            <input type="text" class="form-control required" name="mov_loc_cd" id="mov_loc_cd"  placeholder="">
        </div>
    </div>


    <hr>

    <div class='d-flex justify-content-end mt-4' >
        <button type="button" class="btn  btn-secondary" id="btnReset" >초기화</button>
        &nbsp;
        <button type="button"  class="btn  btn-danger" id="btnSubmit"> <i class="fas fa-paper-plane"></i> 전송하기</button>
    </div>
</form>
</section>


<!-- 서가변경  도서 검색 -->
<? include_once(G5_THEME_PATH . '/view_modal_bookcd_for_bs.php'); ?>

<script>

    /// Android Virtual Keyboard /////////////////////////////////////////////////////////
    var AndroidKeyboardHide=true; //default true - only bar_cd



    $(function() {

        loadjgWmsGb();// 창고구분 > ajax loading -----------------------------------

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
        $('#bar_cd').keyup(function(e){

            if(e.keyCode != 13) {
                return true;
            }

            doSearch();

        });
        
        //이동전LOC에서 엔터
        $('#loc_cd').keyup(function(e){

            if(e.keyCode != 13) {
                return true;
            }

            var loc = $('#loc_cd').val();

            if(loc.length != 6){
                return true;
            }

            $('#bar_cd').focus();

        });
        
        // 구분 입고
        $('#move_type11').click(function(){
            $('#loc_cd').val('A00000');
            $('#bar_cd').focus();
        });

        // 구분 반품
        $('#move_type22').click(function(){
            $('#loc_cd').val('X00000');
            $('#bar_cd').focus();
        });

        // 구분 일반
        $('#move_type33').click(function(){
            $('#loc_cd').val('');
            $('#loc_cd').focus();
        });

        // 버튼으로 도서검색
        $('#btnSrch').click(function(){
            var $this = $('#bar_cd');
            var val  = $this.val();

            doSearch();
        });


        $('#btnReset').click(function(){
            formClear();
            $('#loc_cd').focus();
        });



        //전송하기 버튼
        $('#btnSubmit').click(function(){
            $('#bkFrm').submit();
        });

        // 이동수량->변경서가
        $('#mov_qty').keyup(function(e){
            if (e.keyCode != 13) {
                return true;
            }
            $('#mov_loc_cd').focus();
            // $('#btnSubmit').trigger('click'); //전송하기 호출
        });

        // 마지막 입력 ele > 전송하기버튼  > 트리거
        $('#mov_loc_cd').keyup(function(e){
            if (e.keyCode != 13) {
                return true;
            }
            $('#btnSubmit').trigger('click'); //전송하기 호출
        });


        $('#loc_cd').focus();

    });  //end ready func__=======================================================================================================

    // 창고구분자 추출
    function loadjgWmsGb(){
        //whloca table ??? 추출

        ToastBox.showLoadingToast("로딩중...");
        //pkgMhPDA.PROC_SCHBKJG procedure

        //var jg_gb = <?//=$DefJgGubun?>//;

        var jgGb = $(':radio[name=jg_gb99]:checked').val();

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


    function doSearch(){

        var $this = $('#bar_cd');
        var val  = $this.val();
        // if(val.length < 13){
        //     $this.val('');
        //     return false;
        // }

        var loc_cd = $('#loc_cd').val();

        if (loc_cd.length == 0){
            $('#loc_cd').focus();
            ToastBox.showToast("이동전 로케이션을 입력하세요.");
            return;
        }

        if (loc_cd.length != 6){
            $('#loc_cd').focus();
            ToastBox.showToast("이동전 로케이션을 올바르게 입력하세요.");
            return;
        }

        var jgGb = $('#jgwms_gb').val();

        showBookModal(val,jgGb,function(res,json){
            //console.log(json);

            if(res){
                $('#good_cd').val(json.good_cd);
                $('#bar_cd').val(val);
                // $('#real_qty').val(realQty); //안전재고
                // $('#jg_qty').val(json.jg_qty);
                $('#size_gb').val(json.size_gb);
                $('#out_danga1').val(json.out_danga1);
                $('#good_nm').val(json.good_nm);
                //$('#x_qty').val(json.x_qty);
                //$('#loc_cd').val(formatLocCode(json.loc_cd));
                $('#out_danga').val(number_format(json.out_danga));

                $('#mov_qty').focus();

                goodjg();

                var locCd = $('#loc_cd').val();

            } else {
                ToastBox.showToast("조회된 도서가 없습니다. ");
                $this.val('');
                $this.focus();
            }

        }); //end showBookModal Func =================


    } //end func ========================================  ===================


    function goodjg() {

        var goodCd = $('#good_cd').val();
        var sizeGb = $('#size_gb').val();
        var locCd = $('#loc_cd').val().toUpperCase();
        var jgGb = $('#jgwms_gb').val();

        showGoodJg(goodCd,sizeGb,locCd,jgGb,function(res,json){

            if(res){
                var jg_qty = json.jg_qty;
                var medg_qty = json.medg_qty;

                var real_qty = jg_qty - medg_qty;
                $('#jg_qty').val(json.jg_qty);
                $('#real_qty').val(real_qty);
                $('#jg_gb').val(json.jg_gb);

                $('#mov_qty').focus();

            } else {
                ToastBox.showToast("서가에 재고가 없습니다. ");
                $('#jg_qty').val('');
                $('#real_qty').val('');
                formClear();
                // $this.val('');
                // $this.focus();
            }

        }); //end showBookModal Func =================
    }
    
    function formClear(){
        $("input[type='hidden']").val('');
        $('#bk_list  > tbody').html("");
        $('#bkFrm')[0].reset();

        var jgGb = $(':radio[name=jg_gb99]:checked').val();
        //default select
        if(jgGb == "5") {
            $('#jgwms_gb').val("51");
        } else if (jgGb == "7"){
            $('#jgwms_gb').val("71");
        }

    }



    function transferConfirm(){

        var oldLocCd = $('#loc_cd').val().toUpperCase();
        var movLocCd = $('#mov_loc_cd').val().toUpperCase();
        var jg_qty = $('#jg_qty').val();
        var real_qty = $('#real_qty').val();
        var mov_qty = $('#mov_qty').val();

        var oldLoc = filteringLocCode(oldLocCd);
        var movLoc = filteringLocCode(movLocCd);
        var movLocHead = movLoc.substr(0,1);
        var jgGb = $('#jgwms_gb').val();


        var GoodCd = $('#good_cd').val();
        if(GoodCd.length<=0){
            playBeepSound();
            MsgBox.warning("상품을 선택해주세요.");
            return false;
        }

        if(oldLocCd.length != 6){
            playBeepSound();
            MsgBox.warning("이동 전 로케이션을 바르게 입력하세요.");
            return false;
        }

        if(movLoc.length != 6){
            playBeepSound();
            MsgBox.warning("이동 후 로케이션을 바르게 입력하세요.");
            return false;
        }

        if(real_qty <= 0){
            playBeepSound();
            MsgBox.warning("이동전 로케이션의 재고수량이 존재하지 않습니다. ");
            return false;
        }

        if(mov_qty.length <= 0){
            playBeepSound();
            MsgBox.warning("이동 할 재고수량을 입력하세요.");
            return false;
        } else if (Number(mov_qty) > Number(real_qty)){

            playBeepSound();
            MsgBox.warning("이동할 재고수량이, 이동전 로케이션 재고수량 보다 많습니다. ");
            return false;
        }

        if(oldLoc == movLoc){
            playBeepSound();

            return false;
        }

        //로케이션체크
        locCheck(oldLoc,jgGb, function(data){
            if(data == 0){
                playBeepSound();//소리출력

                MsgBox.warning("이동전 서가가 존재하지 않습니다");

                $('#loc_cd').focus();
                $('#loc_cd').val('');
                return false;
            }
        });

        //로케이션체크
        locCheck(movLoc,jgGb, function(data){
            if(data == 0){
                playBeepSound();//소리출력

                MsgBox.warning("이동후 서가가 존재하지 않습니다");

                $('#mov_loc_cd').focus();
                $('#mov_loc_cd').val('');
                return false;
            }
        });

        MsgConfirmBox.show("이동을 진행하시겠습니까?",function(res){
            if(res){
                transferData();
            }
        });

        return false;
    }

    /// 로케이션체크
    function locCheck(locCd,jgGb,callback){
        $.getJSON('<?php echo G5_BBS_URL?>/ajax.move_loc_check.php',{'locCd':locCd,},
            function(data) {

                callback(data);
            });


    }


    // 전체 재고이동 전송하기 /////////////////////////////////////////////////
    function transferData() {

        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.book_shelf_change_update.php";
//                $('#bkFrm').attr("action",actionUrl); //for debugging
//                return true; //for debugging

        ToastBox.showLoadingToast("처리중...");

        // console.log($('#bkFrm').serialize());

        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:$('#bkFrm').serialize(),
            success:function(data) {
                ToastBox.closeToast();

                var result = data.result_stat;

                if(result){
                    MsgBox.succCallback(data.result_msg, function () {
                        formClear();
                        $('#bar_cd').focus();
                    });


                } else {
                    playBeepSound();
                    MsgBox.fail(data.result_msg);

                }

                return false;

            },error : function(xhr, status, error) {
                playBeepSound();
                alert("서가이동시 오류가 발생했습니다. ("+error+")");

            }
        }); //end ajax func ====

        return false;
    } //end func ========================================




</script>