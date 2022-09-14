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
<form id="bkFrm" name="bkFrm" method="post" action=""   onsubmit="return transferConfirm()" autocomplete="off">

    <input type="hidden" name="tax_no" id="tax_no"  value=""  >
    <input type="hidden" name="bk_cd" id="bk_cd"  value=""  >
    <input type="hidden" name="pub_cd" id="pub_cd"  value=""  >
    <input type="hidden" name="out_danga" id="out_danga"  value=""  >
    <input type="hidden" name="loc_cd" id="loc_cd"  value=""  > <!-- bookcd.loc_cd  -->
    <input type="hidden" name="cur_loc_cd" id="cur_loc_cd"  value=""  > <!-- bksbjg.loc_cd  -->
    <input type="hidden" name="multi_loc_cd" id="multi_loc_cd"  value=""  > <!--이중적치 가능한 출판사 코드-->



    <div class="form-group row  no-gutters my-1">
        <label for="jg_gb" class="col-3 col-form-label">재고구분</label>
        <div class="col-9 pt-2">
            정품 <input type="radio" name="jg_gb" id="jg_gb1" checked value="A" <?=(!$DefJgGubun || $DefJgGubun=="A")?"checked":""?> >
            반품 <input  type="radio" name="jg_gb" id="jg_gb2"  value="X" <?=($DefJgGubun=="X")?"checked":""?> >

        </div>
    </div>



    <div class="form-group row  no-gutters my-1">
        <label for="bar_cd" class="col-3 col-form-label">도서코드</label>
<!--        -->
<!--        <div class="col-9">-->
<!--            <input type="text" class="form-control  required" name="bar_cd" id="bar_cd"  placeholder="도서 코드">-->
<!--        </div>-->
<!--        -->

        <!-- input group area/  찾기 아이콘 붙임   -->
        <div class="input-group col-9">
            <input type="text" name="bar_cd" value="" id="bar_cd"  class="form-control" inputmode="search" placeholder="스캔">
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
        <label for="pub_nm" class="col-3 col-form-label">출판사</label>
        <div class="col-9">
            <input type="text" class="form-control" name="pub_nm" id="pub_nm" readonly placeholder="">
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="avg_qty" class="col-3 col-form-label">안전재고</label>
        <div class="col-3">
            <input type="text" class="form-control" name="avg_qty" id="avg_qty" readonly placeholder="">
        </div>

        <label for="ipsu_qty" class="col-3 col-form-label text-center">입수단위</label>
        <div class="col-3">
            <input type="text" class="form-control" name="ipsu_qty" id="ipsu_qty" readonly placeholder="">
        </div>
    </div>


    <div class="form-group row  no-gutters my-1">
        <label for="a_qty" class="col-3 col-form-label">현재고</label>
        <div class="col-3">
            <input type="text" class="form-control" name="a_qty" id="a_qty" readonly placeholder="">
        </div>

        <label for="min_qty" class="col-3 col-form-label text-center">권장재고</label>
        <div class="col-3">
            <input type="text" class="form-control" name="min_qty" id="min_qty" readonly placeholder="">
        </div>
    </div>


    <div class="form-group row  no-gutters my-1">

        <label for="jg_qty" class="col-3 col-form-label">재고수량</label>
        <div class="col-3">
            <input type="text" class="form-control" name="jg_qty" id="jg_qty" readonly placeholder="">
        </div>

        <label for="chul_qty" class="col-3 col-form-label text-center"> 출고대기<!--수량-->
        </label>
        <div class="col-3">
            <input type="text" class="form-control" name="chul_qty" id="chul_qty" readonly placeholder="">
        </div>

    </div>


    <div class="form-group row  no-gutters my-1">

        <label for="move_qty" class="col-3 col-form-label">적치수량</label>
        <div class="col-3">
            <input type="text" class="form-control required text-select" name="move_qty" id="move_qty" inputmode="numeric"    placeholder="">
        </div>
        <label for="move_loc_cd" class="col-3 col-form-label text-center">적치 Loc</label>
        <div class="col-3">
            <input type="text" class="form-control required" name="move_loc_cd" id="move_loc_cd"  inputmode="numeric"   placeholder="">
        </div>



    </div>


    <hr>

    <div class='d-flex justify-content-end mt-4' >

        <button type="button" class="btn  btn-secondary" id="btnReset" >초기화</button>

        &nbsp;

        <button type="button" class="btn  btn-danger"  id="btnMoveTrans"> <i class="fas fa-paper-plane"></i> 전송하기</button>



    </div>

</form>



</section>


<!-- 서가적취 도서 검색 -->
<? include_once(G5_THEME_PATH . '/view_modal_move_bookcd.php'); ?>

<script>

    /// Android Virtual Keyboard /////////////////////////////////////////////////////////
    var AndroidKeyboardHide=true; //default true - only bar_cd

    $(function() {

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
            doSearch();
        });




        $('#btnSrch').click(function(){

            var $this = $('#bar_cd');
            var val  = $this.val();
            if(val.length < 13){
                playBeepSound();
                MsgBox.alertCallback("바코드를 바르게 입력하세요.",function(){
                    $this.val('');
                    $this.focus();
                });

                return false;
            }


            doSearch();

        });

        //초기화 버튼
        $('#btnReset').click(function(){
            formClear();
            $('#bar_cd').focus();
        });


        //전송하기 버튼
        $('#btnMoveTrans').click(function(){
            $('#bkFrm').submit();
        });

        // 마지막 입력 Dom Element > 전송버튼 트리거
        $('#move_loc_cd').keyup(function(e){
            if (e.keyCode != 13) {
                return true;
            }
            $('#btnMoveTrans').trigger('click'); //전송하기 호출
        });

        $('#bar_cd').focus();

    });  //end ready func__=======================================================================================================



    function doSearch(){


        var $this = $('#bar_cd');
        var val  = $this.val();

        if(val.length == 0) {
            return false;
        }

        if(val.length < 11){
            this.value = '';
            return false;
        }


        showBookModal(val,function(res,json){

            //console.log(json);

            if(res){

                if(json.hasOwnProperty("result_msg")){
                    MsgBox.error(json.result_msg);
                    return false;
                }

                //$('#bar_cd').val(json.bar_cd);
                $('#bk_nm').val(json.bk_nm);
                $('#pub_cd').val(json.tax_no);
                $('#pub_nm').val(json.cust_nm);

                $('#ipsu_qty').val(json.ipsu_qty);

                $('#avg_qty').val(json.avg_qty+"/"+json.max_qty); //안전재고
                $('#min_qty').val(json.avg_qty); //권장재고
                $('#chul_qty').val(json.chul_qty); //출고대기수량
                $('#a_qty').val(json.a_qty); //현재고
                $('#jg_qty').val(json.jg_qty); //재고수량


                //hidden field _________________________
                $('#loc_cd').val(json.loc_cd); //bookcd.loc_cd
                $('#cur_loc_cd').val(json.loc_cd1); //bksbjg.loc_cd

                $('#bk_cd').val(json.bk_cd);
                $('#tax_no').val(json.tax_no);
                $('#out_danga').val(json.out_danga);


                //적치 로케이션 _________________________________
                $('#move_loc_cd').val(json.move_loc_cd); // - format
                $('#multi_loc_cd').val(json.multi_loc_cd); // gncode > location__multiple
                $('#move_qty').focus();

            } else {
                // alert box >  toast box > show
                ToastBox.showErrorToast("검색된 도서가  없습니다. ");
                $this.val('');
                $this.focus();
            }

        });



    }

    function findBookInfo(bookCd){



        $.getJSON('/bbs/ajax.plt_book_search.php',{'code':bookCd},function(json){


            //console.log(json);


            if(json.hasOwnProperty("result_msg")){
                MsgBox.error(json.result_msg);
                return false;
            }

            //$('#bar_cd').val(json.bar_cd);
            $('#bk_nm').val(json.bk_nm);
            $('#pub_nm').val(json.cust_nm);
            $('#ipsu_qty').val(json.ipsu_qty);

            $('#avg_qty').val(json.avg_qty+"/"+json.max_qty);
            $('#min_qty').val(json.avg_qty); //권장재고
            $('#chul_qty').val(json.chul_qty); //출고대기수량
            $('#a_qty').val(json.a_qty); //현재고
            $('#jg_qty').val(json.jg_qty); //재고수량


            //hidden field _________________________
            $('#loc_cd').val(json.loc_cd); //bookcd.loc_cd
            $('#cur_loc_cd').val(json.loc_cd1); //bksbjg.loc_cd

            $('#bk_cd').val(json.bk_cd);
            $('#tax_no').val(json.tax_no);
            $('#out_danga').val(json.out_danga);


            //적치 로케이션 _________________________________
            $('#move_loc_cd').val(json.move_loc_cd); // - format
            $('#multi_loc_cd').val(json.multi_loc_cd); // gncode > location__multiple


        });





    } //end func++=====




    //서가적치 > 전송하기______________
    function transferConfirm(){


        var mvLocCode = $('#move_loc_cd').val().trim().replace(/[- \.\?,_~]/gi, ""); // 적치로케이션
        var locCode = $('#loc_cd').val().trim(); //bookcd.loc_cd

        var multiLocCode = $('#multi_loc_cd').val().trim(); //이정적치가능한 거래처 코드 tax_no

//        console.log(mvLocCode);

        if(mvLocCode.length != 6){
            playBeepSound();
            MsgBox.warning("서가랙을 바르게 입력하세요.",function(){
                $('#move_loc_cd').focus();
            });

            return false;
        } else if(mvLocCode !=  locCode){
            playBeepSound();
            MsgBox.warning("도서에 지정된 서가가 아닙니다.",function(){
                $('#move_loc_cd').focus();
            });
            return false;
        }

        /*
        if (this.loc_cd.Substring(0, 1) == "0" || this.multiLocCus != string.Empty)
        {
            if (this.txtLacLoc.Text.Substring(0, 1) != "A")
            {
                common.MsgWind.AlertMsg("기본서가랙을 지정해 주세요");
                this.txtLacLoc.Focus();
                return;
            }
        }
        */

        if( (locCode.substr(0,1) == "0" || multiLocCode.length >0) && mvLocCode.substr(0,1) != "A"){
            playBeepSound();
            MsgBox.warning("기본 서가랙을 지정해 주세요.",function(){
                $('#move_loc_cd').focus();
            });
            return false;
        }



        var mvQty = $('#move_qty').val().trim();
        if(!$.isNumeric(mvQty) || mvQty<=0){
            playBeepSound();
            MsgBox.warning("적치수량을 바르게 입력하세요.",function(){
                $('#move_qty').focus();
            });
            return false;
        }


        var jgQty = $('#jg_qty').val().trim();
        if(jgQty.length == 0)
            jgQty=0;

        var chulQty = $('#chul_qty').val().trim();
        if(chulQty.length == 0)
            chulQty=0;

        if(mvQty > (jgQty-chulQty) ){
            playBeepSound();
            MsgBox.warning("적치수량이 대기수량보다 많습니다. ",function(){
                $('#move_qty').focus();
            });
            return false;
        }


        ////////////////////////////////////////////////////////////
        MsgConfirmBox.show('적치 자료를 전송하시겠습니까? ',function(res){
            if(res){
                transferData();
            }
        });

        return false;


    } //end func === ==========





    function formClear(){
        $("input[type='hidden']").val('');
        $('#bkFrm')[0].reset();
    }

    //적치 데이터 전송하기  ///////////////////////////////////////////////
    function transferData(){

        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.book_move_update.php"

        //$('#bkFrm').attr("action",actionUrl); //for debugging
        //return true; //for debugging


        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:$('#bkFrm').serialize(),
            success:function(data) {

                //console.log(data);


                var result = data.result_stat;
                if(result){

                    formClear();
                    ToastBox.showSuccessToast(data.result_msg);
                    $('#bar_cd').focus();

                } else {
                    playBeepSound();
                    alert(data.result_msg);
                }


            },error : function(xhr, status, error) {
                //console.log(error);
                playBeepSound();
                alert("적치자료 전송시 오류가 발생했습니다. ("+error+")");
            }
        }); //end ajax func ====

        return false;
    }




    // 수불 임시 저장하기 /////////////////////////////////////////////////
    function formSubmit(){


        var sublGb = $("#subl_gb option:selected").val();
        var binderName = $('#binder_name').val();
        if(sublGb == '11' && binderName.length == 0 ){
            playBeepSound();
            MsgBox.warning("제본소 정보를 입력하세요.",function(){
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

                //console.log(data);

                var obj = data.result_obj;
                var result = data.result_stat;


                if(result){
                    $('#grp_no').val(obj.grp_no);

                    if(!obj.is_dup) {
                        //console.log('insert');
                        //$('#subl_bk_list  > tbody > tr:first').before(makeTableRow(obj));
                        $('#subl_bk_list  > tbody').prepend(makeTableRow(obj));
                    }else {
                        //console.log('update');
                        $('#row_' + obj.bk_cd).replaceWith(makeTableRow(obj));
                    }

                    ToastBox.showSuccessToast("'"+obj.bk_nm+"' 도서가 입고등록 되었습니다.");
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
        }); //end ajax func ====

        return false;

    } //end func






</script>