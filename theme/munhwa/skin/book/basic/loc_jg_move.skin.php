<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
?>
<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>

<section id="contents">
<form id="bkFrm" name="bkFrm" method="post" action=""  onsubmit="return  transferConfirm()"  autocomplete="off">

    <input type="hidden" name="loc_gb" id="loc_gb"  value="<?php echo MH_LOC_GB_ALLOC;?>"  >  <!-- 일반서가 이동구분자 -->
    <input type="hidden" name="mov_gb" id="mov_gb"  value="<?php echo MH_MOV_GB_MOVEALL;?>"  >  <!-- 파레트 이동 구분자  -->
    <input type="hidden" name="plt_combined" id="plt_combined"  value="N"  > <!-- 파레트 이동시 > 합짐   -->
    <input type="hidden" name="bk_cnt" id="bk_cnt"  value="0"  >


    <div class="form-group row  no-gutters my-1">
        <label for="jg_gb" class="col-5 col-form-label">재고 구분</label>
        <div class="col-7 pt-2">
            정품 <input type="radio" name="jg_gb" id="jg_gb1" checked value="A" <?=(!$DefJgGubun || $DefJgGubun=="A")?"checked":""?> >
            반품 <input  type="radio" name="jg_gb" id="jg_gb2"  value="X" <?=($DefJgGubun=="X")?"checked":""?> >
        </div>

    </div>


    <div class="form-group row  no-gutters my-1">
        <label for="loc_cd" class="col-5 col-form-label">조회 로케이션</label>
<!--        <div class="col-9">-->
<!--            <input type="text" class="form-control  required" name="loc_cd" id="loc_cd" placeholder="">-->
<!--        </div>-->

        <!-- input group area/  찾기 아이콘 붙임   -->
        <div class="input-group col-7">
            <input type="text" name="loc_cd" value="" id="loc_cd" class="form-control" inputmode="search" placeholder="스캔">
            <div class="input-group-append">
                <button class="btn btn-primary" id="btnSrch" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="mov_loc_cd" class="col-5 col-form-label">이동 로케이션</label>
<!--        <div class="col-6">-->
<!--            <input type="text" class="form-control  required" name="mov_loc_cd" id="mov_loc_cd" placeholder="">-->
<!--        </div>-->
        <!-- input group area/  찾기 아이콘 붙임   -->
        <div class="input-group col-7">
            <input type="text" name="mov_loc_cd" value="" id="mov_loc_cd" class="form-control" inputmode="search" placeholder="스캔">
            <div class="input-group-append">
                <button class="btn btn-primary" id="btnSrchMove" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>


    </div>

    <div class=" row  no-gutters my-1">
        <label for="move_gb" class="col-5 col-form-label">이동 구분</label>
        <div class="col-7 text-left">
            <select name="move_gb" class="form-control">
                <option value="21">일반</option>
                <option value="23">합짐</option>
            </select>
        </div>
    </div>

    <!--
    <div class="form-group row  no-gutters my-1">
        <label for="bk_nm" class="col-3 col-form-label">도서명</label>
        <div class="col-9">
            <input type="text" class="form-control  required" name="bk_nm" id="bk_nm" readonly placeholder="도서명">
        </div>
    </div>
    -->



    <hr>

    <div class='d-flex justify-content-end mt-4' >
        <button type="button" class="btn  btn-secondary" id="btnReset" >초기화</button>
        &nbsp;
        <button type="button"  class="btn  btn-danger" id="btnSubmit"> <i class="fas fa-paper-plane"></i>전체 전송하기</button>
    </div>



    <!-- 재고 리스트   --------------------------------------------------------------------------->
    <div class="mt-4">
        <table id="bk_list" class="table  table-hover">
            <thead>
            <tr>
                <th scope="col">도서명</th>
                <th scope="col">재고 수량</th>
            </tr>
            </thead>
            <tbody>
            <!-- 동적 리스트 appending area -->

            </tbody>
        </table>

    </div>


</form>



</section>


<!-- 바코드 + 재구구분자(jg_gb) 기준   /  도서 검색 -->
<? include_once(G5_THEME_PATH . '/view_modal_bksbjg.php'); ?>

<script>
    /// Android Virtual Keyboard /////////////////////////////////////////////////////////
    var AndroidKeyboardHide=true; //default true - only bar_cd



    $(function() {


        //////////////////////////////////////////////////////////////////////////////////////////////
        ///////////   Android Virtual Keyboard / Control  {
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

        //_------------------------------------------------------------------
        $("#mov_loc_cd").doubleTap(function() {
            AndroidKeyboardHide=false;
            setTimeout(function(){
                $("#mov_loc_cd").focus();
            },300);
        });

        $("#mov_loc_cd").focus(function(){
            if(window.hasOwnProperty("Android")){
                window.Android.setKeyboardHide(AndroidKeyboardHide);
            }
            AndroidKeyboardHide=true;
        });


        ////       }    //////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////




        //재고구분자 변경
        $(':radio[name=jg_gb]').change(function(){
            var val = this.value;
            formClear();
            $(this).filter("[value='"+val+"']").prop('checked', true);
            $('#loc_cd').focus();
            return true;
        });


        //로케이션 및 파레트 검색 or 도서코드 //////////////////////////////////////////
        $('#loc_cd').keyup(function(e){

            if(e.keyCode != 13) {
                return true;
            }

            doLocSearch();

        });

        //버튼으로 로케이션 조회____________-------------------
        $('#btnSrch').click(function(){
            var $this = $('#loc_cd');
            var val  = filteringSpcChr($this.val());
            if(val.length == 0){
                playBeepSound();

                MsgBox.alertCallback("로케이션 코드를 바르게 입력하세요.",function(){
                    $this.val('');
                    $this.focus();
                });

                return false;
            }

            doLocSearch();
        });



        //이동할 로케이션 검증 //////////////////////////////////////////
        $('#mov_loc_cd').keyup(function(e) {

            if (e.keyCode != 13) {
                return true;
            }

            doMovLocSearch();

        });


        //버튼으로 이동 로케이션 조회____________-------------------
        $('#btnSrchMove').click(function(){

            var $this = $('#mov_loc_cd');
            var val  = filteringSpcChr($this.val());
            if(val.length == 0){
                playBeepSound();
                MsgBox.alertCallback("이동 로케이션 코드를 바르게 입력하세요.",function(){
                    $this.val('');
                    $this.focus();
                });

                return false;
            }


            doMovLocSearch();
        });




        $('#btnReset').click(function(){
            formClear();
            $('#loc_cd').focus();

        });


        $('#btnSubmit').click(function(){
           $('#bkFrm').submit();
        });


        $('#loc_cd').focus();

    });  //end ready func__=======================================================================================================


    function doLocSearch(){

        var bkCnt = $('#bk_cnt').val();
        if(bkCnt.length == 0)
            bkCnt = 0;

        var jgGb = $(':radio[name=jg_gb]:checked').val();
        var $this = $('#loc_cd');

        var val = filteringLocCode($this.val());

        /*
         if(e.keyCode != 13) {

         if(val.length > 0 && val.length != 6 && bkCnt > 0){
         $('#bk_cnt').val(0);
         $('#bk_list  > tbody').html("");
         }

         return true;
         }
         */

        if (val.length == 0)
            return false;


        if(val.length == 6){
            findBksbjgByLoc(val,jgGb); // 서가코드 > 재고조회
            $this.val(formatLocCode(val)); //loc 포맷
            return false;
        } else if(val.length == 10){
            findBksbjgByPltNo(val,jgGb); //팔레트 코드 > 재고조회
            return false;
        }

        var barCd  = val;
        //도서코드 기준 재고조회
        showBookModal(barCd, jgGb,function(res,json){
            //console.log(json);
            if(res){
                //$('#bar_cd').val(json.bar_cd);
                //$('#bk_nm').val(json.bk_nm);
                //$('#bk_cd').val(json.bk_cd);

                // 선택재고이동  > 재고조회
                //findBksbjg(json.bk_cd,json.tax_no,json.jg_gb);
                // 전체 재고 이동 > loc_cd 인자 추가
                findBksbjg(json.loc_cd,json.bk_cd,json.tax_no,json.jg_gb);  //1 row return; 즉, 한권 선택

            } else {
                //MsgBox.alert("검색된 도서가 존재하지 않습니다.");
                $this.val('');
                $this.focus();
            }
        }); //end showBookModal ++++++++++++++




    } //end func =================== ====================================


    function doMovLocSearch(){

       // var $this = $(this);
        var $this = $('#mov_loc_cd');

        var movGb = $('#mov_gb').val();// 로케이션 구분
        var locGb = $('#loc_gb').val();// 로케이션 구분


        var val = filteringLocCode($this.val());
        if (val.length == 0)
            return false;

        if(val.length == 6){ //일반서가  -----------------------------------------


            //일반서가 validate
            validateLocCode(val,locGb,function(res){
                if(!res){
                    $this.val('');
                    $this.focus();
                } else {
                    $this.val(formatLocCode(val));
                    $('#btnSubmit').focus();
                }
            });



            return false;
        } else if(val.length == 10){  // 파레트 코드 ----------------------------------------

            //파레트 코드 체크 및 합짐 체크 (현재- 선택 재고이동에선 합짐 X)
            validatePltCode(val,movGb,function(res,isCombined){
                if(res){
                    $('#plt_combined').val('N'); //합짐 구분자
                    $('#btnSubmit').focus();
                } else { //false > 합짐이면 진행

                    if(isCombined) {
                        $('#plt_combined').val('Y'); //합짐 구분자
                        $('#btnSubmit').focus();

                    }else {
                        $this.val('');
                        $this.focus();
                        return false;
                    }
                }
            });

            return false;
        }

    } //end func ============================ ============================


    function validateLocCode(locCode,locGb,callback){

        $.getJSON('ajax.loc_cd_validate.php',
                {'loc_cd':locCode,'loc_gb':locGb},function(data){

                // console.log(data);
                if(!data.result_stat){
                    playBeepSound();
                    MsgBox.warning(data.result_msg);
                }

                callback(data.result_stat);
        });

    } //end validateLocCode method ===========================================




    //파레트 코드 검증
    function validatePltCode(pltCode,movGb,callback){ //callback(stat,isUnited 합짐여부)
        $.getJSON('ajax.plt_cd_validate.php',{'plt_cd':pltCode,'mov_gb':movGb},function(data){

           // console.log(data);

            if(!data.result_stat){
                playBeepSound();
                MsgBox.warning(data.result_msg);
                callback(false,false);
                return;
            }

            var obj = data.result_obj;
            if(obj.combine_chk){
                    MsgConfirmBox.show("합짐하시겠습니까? (사용중인 파레트) ",function(res){
                        callback(false,res);
                    });

            } else {
                callback(true,false);
            }
        });

    } //end validatePltCode method =================================================



    //도서재고 조회 _______________________------
    // >> 도서코드 기준으로 조회____---
    function findBksbjg(locCd,bookCd,taxNo,jgGb){

        $('#bk_list  > tbody').html("");


        //"pkgMhPDA.SCHBKBYBCD";
        // 1 row return;
        $.getJSON('ajax.bksbjg_bkcd_search.php',{'loc_cd':locCd,'bk_cd':bookCd,'tax_no':taxNo,'jg_gb':jgGb},function(data){

            //console.log(data);

            var  len  = data.length;
            if(len == 0){
                $('#bk_cnt').val(0);
                MsgBox.alert("검색된 도서가 존재하지 않습니다.");
                return false;
            }

            $('#loc_cd').val(formatLocCode(locCd));

            $('#bk_cnt').val(len);

            $('#loc_cd').val(formatLocCode(locCd));

            data.forEach(function(jdata,idx){
                $('#bk_list  > tbody').append(makeTableRow(jdata));
            });

        });

    } //end func findBksbjg  ========== =====================================




    //도서재고 조회 _______________________------
    // >> 로케이션 기준으로 조회
    function findBksbjgByLoc(locCode,jgGb){

        $('#bk_list  > tbody').html("");


        //"pkgMhPDA.SCHBKBYBCD";
        $.getJSON('ajax.bksbjg_loc_search.php',{'loc_cd':locCode,'jg_gb':jgGb},function(data){

            //console.log(data);




            if(data.hasOwnProperty('result_stat')){
                playBeepSound();
                MsgBox.warningCallback(data.result_msg,function(){
                    $('#loc_cd').val('');
                    $('#loc_cd').focus();
                });
                return false;
            }

            var  len  = data.length;
            if(len == 0){
                $('#bk_cnt').val(0);
                MsgBox.alert("검색된 도서가 존재하지 않습니다.");
                return false;
            }


            $('#bk_cnt').val(len);

            data.forEach(function(jdata,idx){
                $('#bk_list  > tbody').append(makeTableRow(jdata));
            });

            $('#mov_loc_cd').focus();

        });

    } //end func findBksbjg  ==========


    //도서재고 조회 _______________________------
    // >> 로케이션 기준으로 조회
    function findBksbjgByPltNo(pltNo,jgGb){

        $('#bk_list  > tbody').html("");


        //"pkgMhPDA.SCHBKBYBCD";
        $.getJSON('ajax.bksbjg_plt_search.php',{'plt_no':pltNo,'jg_gb':jgGb},function(data){

            //console.log(data);

            if(data.hasOwnProperty('result_stat')){
                playBeepSound();
                MsgBox.warningCallback(data.result_msg,function(){
                    $('#loc_cd').val('');
                    $('#loc_cd').focus();
                });
                return false;
            }



            var  len  = data.length;
            if(len == 0){
                $('#bk_cnt').val(0);
                MsgBox.alert("검색된 도서가 존재하지 않습니다.");
                return false;
            }


            $('#bk_cnt').val(len);

            data.forEach(function(jdata,idx){
                $('#bk_list  > tbody').append(makeTableRow(jdata));
            });

            $('#mov_loc_cd').focus();
        });

    } //end func findBksbjg  ==========



    function formClear(){

        //$("input[type='hidden']").val(''); //상수값 고정
        $('#bk_list  > tbody').html("");
        $('#bkFrm')[0].reset();

        $('#bk_cnt').val(0);
        $('#plt_combined').val('N'); // 팔레트 합짐 구분자

    }



    function transferConfirm(){

        var oldLocCd = $('#loc_cd').val();
        var movLocCd = $('#mov_loc_cd').val();

        var oldLoc = filteringLocCode(oldLocCd);
        var movLoc = filteringLocCode(movLocCd);
        var movLocHead = movLoc.substr(0,1);

        var bkCnt = $('#bk_cnt').val();
        if(bkCnt.length == 0)
            bkCnt = 0;

        if(bkCnt == 0 ){
            playBeepSound();
            MsgBox.alert("재고이동 할 도서가 없습니다.");
            return false;
        }

        if(movLoc.length != 6 && movLoc.length != 10){
            playBeepSound();
            MsgBox.warning("이동 할 로케이션을 바르게 입력하세요.");
            return false;
        }

        if(oldLoc == movLoc){
            playBeepSound();
            MsgBox.warning("같은 로케이션으로 이동 할수 없습니다. ");
            return false;
        }

        if(movLocHead == "A"){
            playBeepSound();
            MsgBox.warning("서가로의 이동은 서가이동을 사용바랍니다.");
            return false;
        }

        if(oldLoc.length == 6 && movLoc.length != 6){
            playBeepSound();
            MsgBox.warning("서가 로케이션으로만 이동 할 수 있습니다.");
            return false;
        }

        if(oldLoc.length == 10 && movLoc.length != 10){
            playBeepSound();
            MsgBox.warning("파레트는 파레트로만 이동 할 수 있습니다.");
            return false;
        }

        if(oldLoc == movLoc){
            playBeepSound();
            MsgBox.warning("같은 서가로는 이동 할 수 있습니다.");
            return false;
        }


        MsgConfirmBox.show("전체 전송을 진행하시겠습니까?",function(res){
            if(res){
                transferData();
            }
        });


        return false;
    }


    // 전체 재고이동 전송하기 /////////////////////////////////////////////////
    function transferData(){

        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.loc_jg_move_update.php";


        // 합계 row  의 빈 loc_cd,bk_cd 등이 넘어가서 문제 유발
//         $('#bkFrm').attr("action",actionUrl); //for debugging
//        $('#bkFrm').attr("target","_blank");
//         return true; //for debugging

        ToastBox.showLoadingToast("처리중...");

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

                    MsgBox.succCallback(data.result_msg,
                        function () {
                            formClear();
                            $('#loc_cd').focus();
                    });

                } else {
                    playBeepSound();
                    MsgBox.fail(data.result_msg);

                }

                return false;

            },error : function(xhr, status, error) {
                playBeepSound();
                alert("재고 이동시 오류가 발생했습니다. ("+error+")");
            }
        }); //end ajax func ====

        return false;
    } //end func ========================================



    function makeTableRow(data){


        //var moveType = $(':radio[name=move_type]:checked').val();

         var jsonStr = JSON.stringify(data);
        //console.log(data);
        /**
         * loc_cd 현재 서가
         * basicloc 기본 서가
         * @type {string}
         */

        //재고 변수
          var jgQty = 0;
          //팔레트 기준 검색
         if(data.hasOwnProperty("b_qty"))
            jgQty = data.b_qty;
        else
            jgQty = data.jg_qty;



        //위치변수
        var locCode="";
        if(data.hasOwnProperty("plt_cd"))
            locCode = data.plt_cd;
        else
            locCode = data.loc_cd;


        /*
        var defMovQty = 0;
        if(moveType == "A"){
            defMovQty = jgQty;
        }
        */

        //row index_________________________
        //var rowPk =  data.bk_cd+"_"+locCode
        var rowPk =  data.bk_cd+"_"+data.tax_no;
        var row = null;

        if(data.bk_nm.includes("합계")) {

            row = '<tr id="bk_row_' + rowPk + '" data=\'' + jsonStr + '\'  class="' + (data.bk_nm.includes("합계") ? "bg-secondary text-light" : "") + '" >' +
                ' <td class="td_left">' + data.bk_nm + ' </td>' +
                ' <td class="td_qty_l">' + number_format(jgQty) + '</td>' +
                '</tr>';

        } else {

             row = '<tr id="bk_row_' + rowPk + '" data=\'' + jsonStr + '\'  class="' + (data.bk_nm.includes("합계") ? "bg-secondary text-light" : "") + '" >' +
                '<input type="hidden" name="row_bk_cd[]" value="' + data.bk_cd + '" >' +
                '<input type="hidden" name="row_tax_no[]" value="' + data.tax_no + '" >' +
                '<input type="hidden" name="row_loc_cd[]" value="' + locCode + '" >' +
                '<input type="hidden" name="row_mov_qty[]" value="' + jgQty + '" >' +
                ' <td class="td_left">' + data.bk_nm + ' </td>' +
                ' <td class="td_qty_l">' + number_format(jgQty) + '</td>' +
                '</tr>';
        }

        return row;


    } //end func   ============================ ================================ =======================================



    function moveNextTr(){
        $(ctrl).parent('tr').next().children();
    }



</script>