<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
?>
<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>

<section id="contents">
<form id="bkFrm" name="bkFrm" method="post" action=""  onsubmit="return  transferConfirm()"  autocomplete="off">

    <input type="hidden" name="loc_gb" id="loc_gb"  value="<?php echo MH_LOC_GB_ALLOC;?>"  >  <!-- 일반서가 이동구분자 -->
    <input type="hidden" name="mov_gb" id="mov_gb"  value="<?php echo MH_MOV_GB_MOVEALL;?>"  >  <!-- 파레트 이동 구분자  -->
    <input type="hidden" name="bk_cnt" id="bk_cnt"  value="0"  >
    <input hidden="hidden" /> <!-- input field >  prevent submit -->

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
        <label for="bloc_cd" class="col-3 col-form-label">LOC</label>
        <div class="input-group col-3 ">
            <input type="text" name="bloc_cd" value="" id="bloc_cd" class="form-control">
        </div>
        <label for="aloc_cd" class="col-form-label"> -> </label>
        <div class="input-group col-3 ">
            <input type="text" name="aloc_cd" value="" id="aloc_cd" class="form-control">
        </div>
    </div>

<!--    <div class="form-group row  no-gutters my-1">-->
<!--        <label for="aloc_cd" class="col-3 col-form-label">이동후LOC</label>-->
<!--        <div class="input-group col-9 ">-->
<!--            <input type="text" name="aloc_cd" value="" id="aloc_cd" class="form-control">-->
<!--        </div>-->
<!--    </div>-->

    <div class="form-group row  no-gutters my-1">
        <label for="bar_cd" class="col-3 col-form-label">상품</label>
        <div class="input-group col-9 ">
            <input type="text" name="bar_cd" value="" id="bar_cd" class="form-control " placeholder="스캔">
            <div class="input-group-append">
                <button class="btn btn-primary" id="btnSrch" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>


    <hr>

    <div class='d-flex justify-content-end mt-4' >
        <button type="button" class="btn  btn-secondary" id="btnReset" >초기화</button>
        &nbsp;
        <button type="button"  class="btn  btn-danger" id="btnSubmit"> <i class="fas fa-paper-plane"></i> 전체 전송하기</button>
    </div>



    <!-- 재고 리스트   --------------------------------------------------------------------------->
    <div class="mt-4">
        <table id="bk_list" class="table  table-hover">
            <thead>
            <tr>
                <th scope="col">재고<br>수량</th>
                <th scope="col">현재<br> 로케이션</th>
                <th scope="col" >이동<br>수량</th>
<!--                <th scope="col">이동<br> 로케이션</th>-->
<!--                <th>개별<br>이동</th>-->
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

    //재고이동 수량 필드 모니터링
    $(document).on('change', 'input[name="row_mov_qty[]"]',  function(e){
       updateTotMoveQty();
    });

    //재고이동 수량 sum update
    function updateTotMoveQty(){
        var totQty = 0;
        $('#bk_list input[name="row_mov_qty[]"]').each(function(){
             var qty = parseInt(this.value) || 0;

            totQty+= qty;
        });

        //table > end row > 두번째 컬럼 > 이동 합계 표시
        $('#bk_row_tot > td:nth-child(2)').text(number_format(totQty));
    }



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



        $(document).on('keyup', '.input-field', function (e) {

                if (e.which == 13) {
                    moveToNextRowField($(this));
                }

           });

        //재고구분자 변경시 -> 초기화
        $(':radio[name=jg_gb]').change(function(){
            var val = this.value;
            formClear();
            $(this).filter("[value='"+val+"']").prop('checked', true);
            $('#bar_cd').focus();
            return true;
        });


        //도서 검색 //////////////////////////////////////////

        $('#bar_cd').keyup(function(e){
            if(e.keyCode != 13) {
                return true;
            }
            doSearch();
        });

        $('#bloc_cd').keyup(function(e){
            if(e.keyCode != 13) {
                return true;
            }
            $('#aloc_cd').focus();
        });

        $('#aloc_cd').keyup(function(e){
            if(e.keyCode != 13) {
                return true;
            }
            $('#bar_cd').focus();
        });


        $('#btnSrch').click(function(){

            var $this = $('#bar_cd');
            var val  = filteringSpcChr($this.val());

            if(val.length == 0){

                playBeepSound();
                MsgBox.alertCallback("바코드를 바르게 입력하세요.",function(){
                    $this.val('');
                    $this.focus();
                });

                return false;
            }


            doSearch();

        });

        $('#btnReset').click(function(){
            formReset();
            $('#bar_cd').focus();
        });


        // 전체 전송하기
        $('#btnSubmit').click(function(){
           $('#bkFrm').submit();
        });


        /*
        $('.qty-field').blur(function(){


        }); */

        // 비동기 로딩 객체 포함
        $(document).on("blur", ".qty-field", function (e) {

            var $this = $(this);
            if(Number($this.val())<0)
                    $this.val(0);

            calculateMoveQty();

        });

        $('#bar_cd').focus();

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

    function calculateMoveQty(){
        var totQty = 0;
        $(".qty-field").each(function() {
            var qty = Number($(this).val());
            totQty+=qty;
        });

       // console.log(totQty);

        $('#bk_row_tot > td:nth-child(6)').text(number_format(totQty));
    }


    function doSearch(){

        //listClear(); // 리스트 클리어
        formClear(); //20210417 . formReset 초기화 함수 별도 추가

        var $this = $('#bar_cd');

        //var $this = $(this);
        var val = filteringLocCode($this.val());
        if (val.length == 0)
            return false;

        var  blocCd  = $('#bloc_cd').val();
        if(blocCd == 0){
            MsgBox.alert('이동전 로케이션을 입력하세요');
            return false;
        }

        var barCd  = val;
        var jgGb = $('#jgwms_gb').val();
        //도서코드 기준 재고조회
        showBookModal(barCd,jgGb, function(res,json){
            //console.log(json);
            if(res){
                // 재고조회
                var jgGb = $('#jgwms_gb').val();
                findBksbjg(json.good_cd,json.size_gb,blocCd,jgGb);
            } else {
                //도서마스터 조회 실패
                ToastBox.showWarningToast("도서가 존재하지 않습니다.");
                $this.val('');
                $this.focus();
            }

        }); //end showBookModal ++++++++++++++


        return false;


    } //end func  ===================================== ===============

    //도서재고 조회 _______________________------
    // >> 도서코드 기준으로 조회____---
    function findBksbjg(goodCd,sizeGb,locCd,jgGb){
        // $('#bk_list  > tbody').html("");

        locCd = locCd.toUpperCase();

        $.getJSON('ajax.bksbjg_bkcd_search.php',
            {'good_cd':goodCd,'size_gb':sizeGb,'loc_cd':locCd,'jg_gb':jgGb},
            function(data){

                var  len  = data.length;
                if(len == 0){
                    $('#bk_cnt').val(0);
                    MsgBox.alert("검색된 도서가 존재하지 않습니다.(j)");
                    return false;
                }

                $('#bk_cnt').val(len);
                data.forEach(function(jdata,idx){
                    $('#bk_list  > tbody').append(makeTableRow(jdata));
                });

        });

    } //end func findBksbjg  ========== =====================================





    function moveToNextRowField(evtObj){

        var $this = evtObj;

        var $td = $this.closest('td'); // Current TD
        var $row = $td.closest('tr'); // Current TR
        var $rows = $row.parent(); // Current TABLE or TBODY - parent of all rows
        var column = $td.index(); // Current column of TD

        // Search on a row basis in current column, then try next column
        // repeat until we run out of cells
        while ($td.length) {
            // get next row
            $row = $row.next('tr');
            // If we were on last row
            if ($row.length == 0) {
                // Go back to first row
                $row = $rows.children().first();
                // And use next column
                column++;
            }
            // get the position in the row column - if it exists
            $td = $row.children().eq(column);
            var $input = $td.find('.input-field');
            if ($input.length) {
                $input.focus();
                break;
            }
        }

    }


    // 검색시 폼 클리어 (초기화 버튼 구분)
    function formClear(){
        //$("input[type='hidden']").val('');  //bug 상수값 까지 reset
        $('#bk_cnt').val(0);
        // $('#bk_list  > tbody').html("");
        $('#btnSubmit').show();
    }

    // 초기화 버튼
    function formReset(){
        //$("input[type='hidden']").val('');  //bug 상수값 까지 reset
        $('#bk_cnt').val(0);
        $('#bk_list  > tbody').html("");
        $('#bkFrm')[0].reset();
        $('#btnSubmit').show();
        var jgGb = $(':radio[name=jg_gb]:checked').val();
        //default select
        if(jgGb == "5") {
            $('#jgwms_gb').val("51");
        } else if (jgGb == "7"){
            $('#jgwms_gb').val("71");
        }
    }

    function listClear(){
        $('#bk_list  > tbody').html("");
    }


    function transferConfirm(){


        var bkCnt = $('#bk_cnt').val();

        if(bkCnt == 0 ){
            playBeepSound();
            MsgBox.alert("재고이동 할 도서가 없습니다.");
            return false;
        }


        MsgConfirmBox.show("전체 전송을 진행하시겠습니까?",function(res){

            if(res){
                transferData();
            }
            return false;
        });
        return false;
    }



    // 재고이동 > 전체 전송하기 /////////////////////////////////////////////////
    function transferData(){


        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.book_jg_move_update.php";

//        $('#bkFrm').attr("action",actionUrl); //for debugging
//        $('#bkFrm').attr("target",'_blank'); //for debugging
//        return true;

        var blocCd = $('#bloc_cd').val();
        var alocCd = $('#aloc_cd').val();
        var jgGb = $('#jgwms_gb').val();

        //로케이션체크
        locCheck(blocCd,jgGb, function(data){
            if(data == 0){
                playBeepSound();//소리출력

                MsgBox.warning("이동전 서가가 존재하지 않습니다");

                $('#loc_cd').focus();
                $('#loc_cd').val('');
                return false;
            }
        });

        //로케이션체크
        locCheck(alocCd,jgGb, function(data){
            if(data == 0){
                playBeepSound();//소리출력

                MsgBox.warning("이동후 서가가 존재하지 않습니다");

                $('#loc_cd').focus();
                $('#loc_cd').val('');
                return false;
            }
        });

        ToastBox.showLoadingToast("처리중입니다.");

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

                    $('#bar_cd').val('');
                    // $('#btnSubmit').hide();
                    $('#bk_list input[type=text]').prop('readonly',true);
                    $('#bk_list input[type=text]').addClass("readonly");
                    $('#bk_list  > tbody').html("");
                    $('#bk_list button').hide();

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
                //console.log('99');
                playBeepSound();
                alert("재고 이동시 오류가 발생했습니다. ("+error+")");
                ToastBox.closeToast();
            }
        }); //end ajax func ====

        return false;
    } //end func ========================================

    /// 로케이션체크
    function locCheck(locCd,jgGb,callback){
        $.getJSON('<?php echo G5_BBS_URL?>/ajax.move_loc_check.php',{'locCd':locCd,'jgGb':jgGb},
            function(data) {

                callback(data);
            });


    }


    function makeTableRow(data){
         var jsonStr = JSON.stringify(data);
        //console.log(data);
        /**
         * loc_cd 현재 서가
         * basicloc 기본 서가
         * @type {string}
         */
        //재고 변수
          var jgQty = 0;
          jgQty = data.jg_qty;

          if(jgQty == 0){
              MsgBox.warning("재고가없습니다");
              return;
          }

        //위치변수
        var locCode="";
        locCode = data.loc_cd;

        var defMovQty = 1;
        var movDefLoc = "";

        //row index_________________________
        var rowPk =  data.good_cd+"_"+locCode+"_"+(data.goodsize).replace(/[- \.\?,_~&^%\$\!@+#\(\)<>\{\}\[\]\\`]/gi, "");

        var bef_jg_qty = $('#row_jg_qty_'+rowPk).val();

        if(bef_jg_qty >= 0){
            bef_jg_qty = parseInt(bef_jg_qty) + parseInt(1);

            $('#row_jg_qty_'+rowPk).val(bef_jg_qty);
            return;
        }

        var blocCd = $('#bloc_cd').val();
        var alocCd = $('#aloc_cd').val();

        if(blocCd == alocCd){
            MsgBox.warning("같은서가로 이동 할 수 없습니다.");
            return;
        }

        if(data.good_nm.includes("합계")){

            var totMoveQty = 0;

            var row = '<tr id="bk_row_tot" data=\'' + jsonStr + '\'   class="bg-secondary text-light">' +
                ' <td class="td_qty">' + number_format(jgQty) + '</td>' +
                ' <td class="td_qty">'+ number_format(totMoveQty) + '</td>' +
                ' <td class="td_loc text-select"></td>' +
                ' <td class="td_center">*합계</td>' +
                '</tr>';

        } else {
            var row = '<tr><td class="td_left" colspan="3">' + data.good_nm + ' </td>' +
                // ' <td class="td_right"><button id="row_btn_' + rowPk + '" type="button" onclick="transferJgConfirm(\'' + rowPk + '\')" name="btnRowTrans" class="btn btn-danger btn-sm rounded-pill"><i class="fas fa-share"></i></button> </td>' +
                '</tr>' +
                '<tr   class="bg-gray-2" id="bk_row_' + rowPk + '" data=\'' + jsonStr + '\'>' +
                '<input type="hidden" name="row_good_cd[]" value="' + data.good_cd + '" >' +
                '<input type="hidden" name="row_loc_cd[]" value="' + locCode + '" >' +
                '<input type="hidden" name="row_jg_qty[]" value="' + jgQty + '" >' +
                '<input type="hidden" name="row_size_gb[]" value="' + data.goodsize + '" >' +
                '<input type="hidden" name="row_jg_gb[]" value="' + data.jg_gb + '" >' +
                ' <td class="td_qty">' + number_format(jgQty) + '</td>' +
                // ' <td class="td_loc">' + formatLocCode(data.loc_cd) + '</td>' <ㅑ+
                ' <td class="td_loc">' + data.loc_cd + '</td>' +
                ' <td class="td_qty"><input type="text" name="row_mov_qty[]" id="row_jg_qty_' + rowPk + '" value="' + defMovQty + '"  maxlength=4 class="form-control-sm text-right numeric qty-field text-select"></td>' +
                // ' <td class="td_loc"><input type="text" name="row_mov_loc[]" id="row_jg_loc_' + rowPk + '" value="' + movDefLoc + '"  maxlength=10 class="form-control-sm input-field text-center text-select  "></td>' +

                '</tr>';

            $("#bar_cd").val('');
        }

        return row;


    } //end func   ===================================================================================================




    function moveNextTr(){
        $(ctrl).parent('tr').next().children();
    }

</script>