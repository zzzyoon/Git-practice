<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
add_javascript('<script src="'.G5_JS_URL.'/moment-with-locales.min.js"></script>', 9);

?>
<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>

<section id="contents">

<form id="bkFrm" name="bkFrm" method="post" action=""  onsubmit="return searchConfirm()"  autocomplete="off">

    <input type="hidden" name="bk_cnt" id="bk_cnt"  value=""  >



    <div class="form-group row  no-gutters my-1">
        <label for="wb_gb" class="col-3 col-form-label">창고 구분</label>
        <div class="col-9">


            <select name="wb_gb" id="wb_gb" class="form-control d-inline-block" >
                <option value="0">전체</option>
            </select>


        </div>
    </div>
    <div class="form-group row  no-gutters my-1">
        <label for="min_row" class="col-3 col-form-label cursor-hand" id="inputQtyLabel">
            행
        </label>
        <div class="col-3 pr-1">
            <input type="text" class="form-control text-center  text-select"  name="min_row" id="min_row" placeholder="최소값">
        </div>
        <div class="col-3 pr-1 text-center font-weight-bold">
         ~
        </div>
        <div class="col-3">
            <input type="text" class="form-control text-center  text-select"  name="max_row" id="max_row" placeholder="최대값">
        </div>
    </div>


    <hr>

    <div class='d-flex justify-content-end mt-4' >

        <button type="button" class="btn  btn-secondary" id="btnReset" >초기화</button>

        &nbsp;

        <button type="submit" class="btn  btn-primary" id="btnMoveTrans">
            <i class="fas fa-search"></i>
            조회하기</button>



    </div>




    <!-- 재고 리스트   --------------------------------------------------------------------------->
    <div class="mt-4">

        <table id="bk_list" class="table  table-hover">
            <thead>
            <tr>
                <th scope="col">로케이션</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>


</form>



</section>




<script>
    $(function() {
        $('#btnReset').click(function(){
            formClear();
            $('#plt_no').focus();
        });

        loadWhGb();// 창고구분 > ajax loading -----------------------------------

        $('#min_row').focus();

    });  //end ready func__=======================================================================================================



    //데이터 전송 - 확인______________
    function searchConfirm() {

        var min = $('#min_row').val();
        var max = $('#max_row').val();

        /*
        if(min.length == 0){
            min = 0;
            $('#min_row').val(0);
        }
        if(max.length == 0){
            max = 0;
            $('#max_row').val(0);
        }

        if(min>max){
            MsgBox.alert("입력값이 올바르지 않습니다.");
            return false;
        }
        */


        $('#bk_list  > tbody').html("");

        var wbGb = $('#wb_gb').find(":selected").val();

        if(min.length == 0 && max.length == 0 && wbGb == '0'){
            /*
            MsgConfirmBox.show("창고 구분 : '전체' 검색시 소요시간이 오래걸립니다. 진행하시겠습니까?",function(res){

                if(res){
                    searchData();
                }
                return false;
            }); */

            playBeepSound();

            MsgBox.warningCallback("*창고 구분자 선택하세요. ",function(){
                $('#wb_gb').focus();
            });

            return false;

        } else {
            searchData();
        }

        return false;
    }

    // 창고구분자 추출
    function loadWhGb(){
        //whloca table ??? 추출

        ToastBox.showLoadingToast("로딩중...");
            //pkgMhPDA.PROC_SCHBKJG procedure
        $.getJSON('ajax.warehouse_gb_list.php',function(data){

            ToastBox.closeToast();
            data.forEach(function(jdata,idx){

                $('#wb_gb').append('<option value="'+jdata.wh_cd+'">  '+jdata.wh_gb+' </option>');
            });

            //default select
            $('#wb_gb').val("G");


        });


    }



    // 빈랙 조회
    function searchData(){

        var wbGb = $('#wb_gb').find(":selected").val();

        var minRow = $('#min_row').val().trim();
        var maxRow = $('#max_row').val().trim();

        ToastBox.showLoadingToast("loading...");

        //pkgMhPDA.PROC_SCHBKJG procedure
        $.getJSON('ajax.rack_search.php',{'wb_gb':wbGb,'min_row':minRow,'max_row':maxRow},function(data){

            ToastBox.closeToast();

            if(data.hasOwnProperty("result_msg")) {
                playBeepSound();
                MsgBox.error(data.result_msg);
                return false;
            }

            var len = data.length;
            if(len == 0){
                MsgBox.alert("검색된 랙 정보가 없습니다. ");
                return false;
            }

            data.forEach(function(jdata,idx){
                $('#bk_list  > tbody').append(makeTableRow(jdata));
            });

        });



        return false;


    } //end func ========== ==============================================================



    function formClear(){
        $("input[type='hidden']").val('');
        $('#bk_list  > tbody').html("");
        $('#bkFrm')[0].reset();
    }



    function makeTableRow(data){

        //console.log(data);
        //var jsonData = JSON.stringify(data);
        //도서명, 현재수량, 적치수량

        var row = '<tr id="row_'+data.loc_cd+'" class="" >' +
            ' <td class="td_left">' +  formatLocCode(data.loc_cd) +
            ' </td>' +
            ' </tr>';

        return row;

    } //end func   ============================ ================================ =======================================







</script>