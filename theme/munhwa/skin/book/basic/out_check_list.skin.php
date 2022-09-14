<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
add_javascript('<script src="'.G5_JS_URL.'/moment-with-locales.min.js"></script>', 9);
add_javascript('<script src="'.G5_JS_URL.'/jquery.mtz.monthpicker.js"></script>', 10);



?>
<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>

<section id="contents">



<form id="bkFrm" name="bkFrm" method="post" action=""   autocomplete="off">

    <div class="form-group row  no-gutters my-1">
        <label for="srch_type" class="col-3 col-form-label">작업구분</label>
        <div class="col-9 text-size-2 pt-2">
            히트수
            <input type="radio" name="srch_type" id="srch_type1" checked value="H">
            골드존
            <input  type="radio" name="srch_type" id="srch_type2"  value="G">
        </div>

        <label for="subl_month" class="col-3 col-form-label">일자(월)</label>
        <div class="col-9">
            <input type="text" class="form-control text-center required" name="subl_month" id="subl_month"  placeholder="">
        </div>

    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="bar_cd" class="col-3 col-form-label">바코드</label>
<!--        <div class="col-9">-->
<!--            <input type="text" class="form-control  required" name="bar_cd" id="bar_cd" placeholder="Scan">-->
<!--        </div>-->
        <!-- input group area/  찾기 아이콘 붙임   -->
        <div class="input-group col-9">
            <input type="text" name="bar_cd" value="" id="bar_cd" class="form-control" placeholder="스캔">
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
            <input type="text" class="form-control" name="bk_nm" id="bk_nm" readonly placeholder="">
        </div>
    </div>

    <hr>
   <!-- button area ------------------------------------>
    <div class='d-flex justify-content-end my-2' >
        <button type="button" class="btn  btn-secondary" id="btnReset" >초기화</button>
    </div>


    <!-- 재고 리스트   --------------------------------------------------------------------------->
    <div class="mt-4">

        <table id="bk_list" class="table  table-hover border-top\">
            <thead>
            <tr>
                <th scope="col" class="td_center  border-right" colspan="2">서가</th>
                <th scope="col" class="td_center" colspan="2">하이랙</th>
            </tr>
            <tr>
                <th scope="col" class="td_right">히트종수</th>
                <th scope="col" class="td_right  border-right">히트부수</th>
                <th scope="col" class="td_right">히트종수</th>
                <th scope="col" class="td_right">히트부수</th>
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


        //도서 검색 //////////////////////////////////////////
        $('#bar_cd').keyup(function(e){

            if (e.keyCode != 13) {
                return true;
            }

            // clear - 백스페이스로 지우는경우
            $('#bk_nm').val('');
            $('#bk_list  > tbody').html("");

            doSearch();

        });

        //버튼으로  검색
        $('#btnSrch').click(function(){
            var $this = $('#bar_cd');
            var val  = filteringSpcChr($this.val());
            if(val.length < 13) {
                playBeepSound();
                MsgBox.alertCallback("바코드를 바르게 입력하세요.",function(){
                   $this.focus();
                });
                return false;
            }

            // clear - 백스페이스로 지우는경우
            $('#bk_nm').val('');
            $('#bk_list  > tbody').html("");

            doSearch();

        });



        $('#btnReset').click(function(){
            formClear();
            $("#subl_month").val(now.format("YYYY-MM"));
            $('#bar_cd').focus();
        });

        $('#bar_cd').focus();


    });  //end ready func__=======================================================================================================


    function doSearch(){


        //var $this = $(this);
        var $this = $('#bar_cd');
        var val  = filteringSpcChr($this.val());
        if(val.length == 0)
            return false;

        var barCd = "";
        var bkNm = "";

        // if($.isNumeric(val)){
        //     barCd = val;
        //
        //     if(val.length < 11){
        //         this.value = '';
        //         return false;
        //     }
        // } else {
        //     bkNm = val;
        // }

        bkNm = val;

        var sublMonth = filteringSpcChr($('#subl_month').val());
        if(sublMonth.length != 6){
            playBeepSound();
            MsgBox.alert("일자를 바르게 선택하세요.");
            return false;
        }


        showBookModal('',barCd, bkNm,function(res,json){
            if(res){

                $('#bar_cd').val(json.bar_cd);
                $('#bk_nm').val(json.bk_nm);
                //$('#tax_no').val(json.tax_no);

                // 출고 조회 시작
                //findBksbjg(json.bk_cd,json.tax_no);
                findChulData(sublMonth,json.bk_cd,json.tax_no);

            } else {
                ToastBox.showToast("조회된 도서가 없습니다.");
                $this.val('');
                $this.focus();
            }

        }); //end showBookModal============



    }

    //출고 데이터 조회(히트수,골드존)
    function findChulData(sublMonth,bookCd,taxNo){

        $('#bk_list  > tbody').html("");

        var srchType = $(':radio[name=srch_type]:checked').val();

        //pkgMhPDA.PROC_SCHBKJG procedure
        $.getJSON('ajax.out_check_list_search.php',
            {'subl_month':sublMonth,'bk_cd':bookCd,'tax_no':taxNo,'srch_type':srchType},
            function(data){

                //console.log(data);

                if(data.length == 0){
                    $('#bk_list  > tbody').append(makeMsgTableRow(4,"출고 자료가 존재하지 않습니다."));
                    return false;
                }


                data.forEach(function(jdata,idx){
                    $('#bk_list  > tbody').append(makeTableRow(jdata));
                });

        });

    }




    function formClear(){

        $("input[type='hidden']").val('');
        $('#bk_list  > tbody').html("");
        $('#bkFrm')[0].reset();

    }



    // 수불 임시 저장하기 /////////////////////////////////////////////////
    function formSubmit(){


        var sublGb = $("#subl_gb option:selected").val();
        var binderName = $('#binder_name').val();
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
                    //alert(data.result_msg);
                    playBeepSound();
                    MsgBox.error(data.result_msg);
                }


            },error : function(xhr, status, error) {
                alert("입고 저장시 오류가 발생했습니다. ("+error+")");
            }
        }); //end ajax func ====

        return false;

    } //end func


    function makeMsgTableRow(colNum,msg){
        var row = '<tr class="text-danger"><td class="text-center py-3 px-2" colspan="'+colNum+'">'+msg+'</td></tr>';
        return row;
    }


    function makeTableRow(data){

        //console.log(data);

        var row = '<tr id="row_'+data.bk_cd+'" class="" >' +
            ' <td class="td_qty"> '+number_format(data.shit_qty)+'</td>' +
            ' <td class="td_qty"> '+number_format(data.shit_amt)+'</td>' +
            ' <td class="td_qty"> '+number_format(data.rhit_qty)+'</td>' +
            ' <td class="td_qty"> '+number_format(data.rhit_amt)+'</td>' +
            ' </tr>';

        return row;

    } //end func   ============================ ================================ =======================================







</script>