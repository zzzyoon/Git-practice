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

<!--    <div style="display: none;" class="form-group row  no-gutters my-1">-->
<!--        <label for="jg_gb" class="col-3 col-form-label ">재고 구분</label>-->
<!--        <div class="col-9 col-md-3 pt-2">-->
<!--            전체 <input type="radio" name="jg_gb" id="jg_gb1" checked value="" --><?//=(!$DefJgGubun)?"checked":""?><!-- >-->
<!--            정품 <input type="radio" name="jg_gb" id="jg_gb1" checked value="A" --><?//=($DefJgGubun=="A")?"checked":""?><!-- >-->
<!--            반품 <input  type="radio" name="jg_gb" id="jg_gb2"  value="X" --><?//=($DefJgGubun=="X")?"checked":""?><!-- >-->
<!--        </div>-->
<!--    </div>-->

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
        <label for="bar_cd" class="col-3 col-form-label  text-md-center">바코드</label> <div class="input-group col-9 col-md-3">
            <input type="text" name="bar_cd" value="" id="bar_cd" class="form-control" placeholder="">
            <div class="input-group-append">
                <button class="btn btn-primary" id="btnSrch" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="good_nm" class="col-3 col-form-label">상품명</label>
        <div class="col-9">
            <input type="text" class="form-control  required" name="good_nm" id="good_nm" readonly placeholder="">
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="good_nm" class="col-3 col-form-label">상품코드</label>
        <div class="col-9">
            <input type="text" class="form-control  required" name="good_cd" id="good_cd" readonly placeholder="">
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="color_size" class="col-3 col-form-label">색상/사이즈</label> <!-- 실제 bookcd 의 tax_no  -->
        <div class="col-6 pr-1">
            <input type="text" class="form-control required" name="color" id="color" readonly  placeholder="">
        </div>
        <div class="col-3">
            <input type="text" class="form-control" name="size_gb" id="size_gb" readonly placeholder="">
        </div>
    </div>


    <div class="form-group row  no-gutters my-1">
        <label for="out_danga1" class="col-3 col-form-label">소비자가</label>
        <div class="col-9 pr-1">
            <input type="text" class="form-control" name="out_danga1" id="out_danga1" readonly placeholder="">
        </div>
    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="last_indt" class="col-3 col-form-label">최종입고일</label>
        <div class="col-9 pr-1">
            <input type="text" class="form-control" name="last_indt" id="last_indt" readonly placeholder="">
        </div>
    </div>



    <hr>

    <div class='d-flex justify-content-end my-2' >
        <button type="button" class="btn  btn-secondary" id="btnReset" >초기화</button>
    </div>


    <!-- 재고 리스트   --------------------------------------------------------------------------->
    <div class="mt-4">

        <table id="bk_list" class="table  table-hover">
            <thead>
            <tr>
                <th scope="col">로케이션</th>
                <th scope="col">상품명</th>
                <th scope="col" class="td_right">수량</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>


</form>



</section>


<!-- 도서 검색 (도서명 가능) -->
<? include_once(G5_THEME_PATH . '/view_modal_bookcd.php'); ?>



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

            if (e.keyCode != 13) {
                return true;
            }

            doSearch();

        });

        $('#btnSrch').click(function(){
            doSearch();
        });



        $('#btnReset').click(function(){
            formClear();
            $('#bar_cd').focus();
        });


        //빈폼에 스캔시 , 포커스 bar_cd로 이동
        $('#bkFrm').keyup(function(e){
            if (e.keyCode == 13) {
                if(e.target.id == "bar_cd"){
                    return;
                }
                $('#bar_cd').select();
            }
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

    function doSearch(){

        //var $this = $(this);
        var $this = $('#bar_cd');
        var val  = $this.val();
        if(val.length == 0)
            return false;


        var barCd = "";
        var jgGb = $('#jgwms_gb').val();

        barCd = val;

        showBookModal(barCd,jgGb, function(res,json){
            //console.log(json);

            if(res){
                $('#bar_cd').val(json.bar_cd);
                $('#good_nm').val(json.good_nm);
                $('#good_cd').val(json.good_cd);
                $('#color').val(json.color);
                $('#size_gb').val(json.size_gb);
                $('#out_danga1').val(number_format(json.out_danga1));
                $('#last_indt').val(json.last_indt);

                // 재고조회
                var jgGb = $('#jgwms_gb').val();
                findBksbjg(json.good_cd,json.size_gb,jgGb);
            } else {
                //재고 조회 실패
                MsgBox.alertCallback("존재하지 않는 상품입니다. ",function(){
                    $this.val('');
                    $this.focus();
                });
            }
        }); //end showBookModal============
    }


    //도서재고 조회
    function findBksbjg(goodCd,sizeGb,jgGb){
        $('#bk_list  > tbody').html("");

        $.getJSON('ajax.book_jg_search.php',{'goodCd':goodCd,'sizeGb':sizeGb,'jgGb':jgGb},function(data){

                if(data.length == 0){
                    $('#bk_list  > tbody').append(makeMsgTableRow(3,"재고가 존재하지 않습니다."));
                    $('#bar_cd').select();
                    return false;
                }

                data.forEach(function(jdata,idx){
                    $('#bk_list  > tbody').append(makeTableRow(jdata));
                });

            $('#bar_cd').select();

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




    function makeMsgTableRow(colNum,msg){
        var row = '<tr class="text-danger"><td class="text-center py-3 px-2" colspan="'+colNum+'">'+msg+'</td></tr>';
        return row;
    }


    function makeTableRow(data){

        if(data.jg_qty > 0) {
            var row = '<tr id="row_' + data.good_cd + '" class="' + (data.loc_cd.includes("합계") ? "bg-secondary text-light" : "") + '" >' +
                ' <td class="td_jg_gb">' + data.loc_cd +
                ' </td>' +
                ' <td class="td_center"><span class="sv_member">' + data.good_nm + '</span></td>' +
                ' <td class="td_qty"> ' + number_format(data.jg_qty) + '</td>' +
                ' </tr>';
        }
        return row;

    } //end func   ============================ ================================ =======================================







</script>