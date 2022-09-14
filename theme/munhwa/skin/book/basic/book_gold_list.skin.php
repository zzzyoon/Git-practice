<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
add_javascript('<script src="'.G5_JS_URL.'/moment-with-locales.min.js"></script>', 9);
add_javascript('<script src="'.G5_JS_URL.'/jquery.mtz.monthpicker.js"></script>', 10);



?>
<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>

<section id="contents">

<form id="bkFrm" name="bkFrm" method="post" action=""  onsubmit="return doSearch()" autocomplete="off">


    <div class="form-group row  no-gutters my-1">
        <label for="srch_type" class="col-3 col-form-label">작업구분</label>
        <div class="col-6 text-size-2 pt-2">
            골드존
            <input type="radio" name="srch_type" id="srch_type1"   value="3">

            골드존 제외
            <input  type="radio" name="srch_type" id="srch_type2"  checked  value="1">
        </div>



    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="busu_qty" class="col-3 col-form-label">기준부수</label>
        <div class="col-3">
            <input type="text" class="form-control  required" name="busu_qty" id="busu_qty"  value="10" placeholder="">
        </div>
        <label for="subl_month" class="col-3 col-form-label text-center">일자(월)</label>
        <div class="col-3">
            <input type="text" class="form-control text-center required" name="subl_month" id="subl_month"  placeholder="">
        </div>

    </div>

<!--
    <div class="form-group row  no-gutters my-1">
        <label for="loc_cd" class="col-3 col-form-label">LOC 조회</label>

        <div class="input-group col-9">
            <input type="text" name="loc_cd" value="" id="loc_cd" class="form-control" placeholder="">
            <div class="input-group-append">
                <button class="btn btn-primary" id="btnSrch" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>


    </div>
-->

    <div class="form-group row  no-gutters my-1">
        <label for="min_row" class="col-3 col-form-label cursor-hand" id="inputQtyLabel">
            LOC(행번호)
        </label>
        <div class="col-3 pr-1">
            <input type="text" class="form-control text-center  text-select "  name="min_row" id="min_row" placeholder="from">
        </div>
        <div class="col-3 pr-1 text-center font-weight-bold">
            ~
        </div>
        <div class="col-3">
            <input type="text" class="form-control text-center  text-select "  name="max_row" id="max_row" placeholder="to">
        </div>
    </div>

    <hr>
   <!-- button area ------------------------------------>
    <div class='d-flex justify-content-end my-2' >
        <button type="button" class="btn  btn-secondary" id="btnReset" >초기화</button>
        &nbsp;
        <button type="button" class="btn  btn-primary" id="btnSrch" >
            <i class="fas fa-search"></i>
            조회하기</button>


    </div>



    <!-- 재고 리스트   --------------------------------------------------------------------------->
    <div class="mt-4">

        <table id="bk_list" class="table  table-striped border-top">
            <thead>
            <tr>
                <th scope="col" class="td_center">로케이션</th>
                <th scope="col" class="td_center" >출판사/도서명</th>
            </tr>
            </thead>
            <tbody>


            </tbody>
        </table>

    </div>


</form>



</section>


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
        ////       }    //////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////


        var currentYear = (new Date()).getFullYear();
        var startYear = currentYear-1;

        var options = {
            startYear: startYear,
            finalYear: currentYear,
            pattern: 'yyyy-mm',
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월']

        };

        $("#subl_month").monthpicker(options);
        var now = moment(); //객체
        $("#subl_month").val(now.format("YYYY-MM"));


        //작업구분 변경시 > 초기화
        $(':radio[name=srch_type]').change(function(){
            var val = this.value;
            formClear();
            $(this).filter("[value='"+val+"']").prop('checked', true);
            $("#subl_month").val(now.format("YYYY-MM"));

            $('#bar_cd').focus();
            return true;
        });

        /*
        $('#loc_cd').keyup(function(e) {
            if (e.keyCode != 13) {
                return true;
            }

            doSearch();

        });
            */

        $('#max_row').keyup(function(e) {
            if (e.keyCode != 13) {
                return true;
            }

            $('#bkFrm').submit();

        });


        $('#btnSrch').click(function(){
           $('#bkFrm').submit();
        });


        $('#btnReset').click(function(){
            formClear();
            $("#subl_month").val(now.format("YYYY-MM"));
            $('#min_row').focus();
        });

       // $('#loc_cd').focus();

        $('#min_row').focus();
    });  //end ready func__=======================================================================================================


    //조회하기
    function doSearch(){

        $('#bk_list  > tbody').html("");

        /*
        var locCode = filteringSpcChr($('#loc_cd').val());
        if(locCode > 0 && locCode.length != 6){
            MsgBox.alertCallback("조회할 로케이션을 바르게 입력하세요.",function(){
                $('#loc_cd').focus();
            });
            return false;
        }
        */

        ToastBox.showLoadingToast("조회중입니다.");
        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.book_gold_list_search.php"

        //for debugging_______
//        $('#bkFrm').attr("action",actionUrl)
//        $('#bkFrm').attr('target',"_blank");
//        return true;

        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:$('#bkFrm').serialize(),
            success:function(data) {

                ToastBox.closeToast();

                if(data.length == 0){
                    $('#bk_list  > tbody').append(makeMsgTableRow(2,"조회된 도서가 없습니다."));
                    return false;
                }

                data.forEach(function(jdata,idx){
                    $('#bk_list  > tbody').append(makeTableRow(jdata));
                });

            },error : function(e) {
                playBeepSound();
                ToastBox.closeToast();
                alert("골드존 제외 조회시 오류가 발생했습니다.");
                console.log(e.responseText);
            }
        }); //end ajax func ====

        return false;
    }



    function formClear(){
        $("input[type='hidden']").val('');
        $('#bk_list  > tbody').html("");
        $('#bkFrm')[0].reset();

    }

    function makeMsgTableRow(colNum,msg){
        var row = '<tr><td class="text-center py-3 px-2" colspan="'+colNum+'">'+msg+'</td></tr>';
        return row;
    }


    function makeTableRow(data){
        //console.log(data);

        var chulData = data.tax_no+"/"+data.cust_nm;

        var row = '<tr id="row_'+data.bk_cd+'" class="" >' +
            ' <td class="td_loc"> '+formatLocCode(data.loc_cd)+'</td>' +
            ' <td class="td_center"> '+chulData+'</td>' +
            ' </tr>'+
            '<tr>' +
            ' <td class="td_left" colspan="2"> '+data.bk_nm+'</td>' +
            ' </tr>';

        return row;

    } //end func   ============================ ================================ =======================================



</script>