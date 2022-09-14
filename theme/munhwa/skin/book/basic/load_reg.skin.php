<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
?>
<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>

<section id="contents">


<form id="bkFrm" name="bkFrm" method="post" action=""    onsubmit="return  transferConfirm()"   autocomplete="off">
    <input type="hidden" name="old_subl_no" id="old_subl_no" value="">
    <input type="hidden" name="jg_gb" id="jg_gb" value="">
    <input type="hidden" name="ju_qty" id="ju_qty" value="">
    <input type="hidden" name="od_qty" id="od_qty" value="">

    <div class="form-group row  no-gutters my-1">

        <label for="subl_no" class="col-3 col-form-label">전표</label>
<!--        <div class="col-4">-->
<!--            <input type="text" class="form-control" name="subl_no" id="subl_no" placeholder="Scan">-->
<!--        </div>-->

        <!-- input group area/  찾기 아이콘 붙임   -->
        <div class="input-group col-5">
            <input type="text" name="subl_no" value="" id="subl_no" class="form-control" placeholder="스캔">
            <div class="input-group-append">
                <button class="btn btn-primary" id="btnSrch" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <label for="scan_cnt" class="col-2 col-form-label text-center"><!--스캔-->횟수</label>
        <div class="col-2">
            <input type="text" class="form-control" name="scan_cnt" id="scan_cnt" readonly placeholder="">
        </div>
    </div>
    <div class="form-group row  no-gutters my-1">
        <label for="tax_no" class="col-3 col-form-label">출판사</label>
        <div class="col-2">
            <input type="text" class="form-control  required" name="tax_no" id="tax_no" readonly placeholder="">
        </div>
        <div class="col-7">
            <input type="text" class="form-control  required" name="cust_nm" id="cust_nm" readonly placeholder="">
        </div>
    </div>


    <div class="form-group row  no-gutters my-1">
        <label for="metax_no" class="col-3 col-form-label">서점</label>
        <div class="col-2">
            <input type="text" class="form-control  required" name="metax_no" id="metax_no" readonly placeholder="">
        </div>
        <div class="col-7">
            <input type="text" class="form-control  required" name="mecust_nm" id="mecust_nm" readonly placeholder="">
        </div>
    </div>



    <div class="form-group row  no-gutters my-1">
        <label for="tot_qty" class="col-3 col-form-label">출고수량</label>
        <div class="col-3">
            <input type="text" class="form-control required" name="tot_qty" id="tot_qty" readonly placeholder="">
        </div>

        <label for="tot_cnt" class="col-3 col-form-label text-center">출고종수</label>
        <div class="col-3">
            <input type="text" class="form-control required" name="tot_cnt" id="tot_cnt" readonly placeholder="">
        </div>
    </div>

    <hr>


    <div class='d-flex justify-content-end mt-4' >

        <button type="button" class="btn  btn-secondary" id="btnReset" >초기화</button>
        &nbsp;
        <button type="button" class="btn  btn-danger" id="btnSubmit"> <i class="fas fa-paper-plane"></i> 전송하기</button>

    </div>


    <!-- 리스트   --------------------------------------------------------------------------->
    <div class="mt-4">

        <table id="bk_list" class="table  table-hover">
            <thead>
            <tr>
                <th scope="col" class="td_qty">출고수량</th>
                <th scope="col">도서명</th>
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

    var SCAN_CNT = 0;

    $(function() {

        //////////////////////////////////////////////////////////////////////////////////////////////
        ///////////   Android Virtual Keyboard / Control  {
        $("#subl_no").doubleTap(function() {
            AndroidKeyboardHide=false;
            setTimeout(function(){
                $("#subl_no").focus();
            },300);
        });

        $("#subl_no").focus(function(){
            if(window.hasOwnProperty("Android")){
                window.Android.setKeyboardHide(AndroidKeyboardHide);
            }
            AndroidKeyboardHide=true;
        });
        ////       }    //////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////


        //전표번호 검색 //////////////////////////////////////////
        $('#subl_no').keyup(function(e){

            if(e.keyCode != 13) {
                return true;
            }


            var $this = $(this);
            var val  = $this.val();

            if(val.length != 16){
                playBeepSound();
                MsgBox.warningCallback("전표번호를 바르게 입력해주세요.",function(){
                    $this.focus();
                })
                return false;
            }


            var oldSublNo = $('#old_subl_no').val();
            if(oldSublNo.length > 0 && oldSublNo != val){
                formClear();
            }
            findChulMaster(val);
        });


        //버튼으로 전표번호 검색
        $('#btnSrch').click(function(){

            var $this = $('#subl_no');
            var val  = $this.val();

            if(val.length != 16){
                MsgBox.warningCallback("전표번호를 바르게 입력해주세요.",function(){
                    $this.focus();
                })
                return false;
            }


            var oldSublNo = $('#old_subl_no').val();
            if(oldSublNo.length > 0 && oldSublNo != val){
                formClear();
            }
            findChulMaster(val);
        });



        $('#btnSubmit').click(function(){
            $('#bkFrm').submit();
        });

        $('#btnReset').click(function(){
            formClear();
            $('#subl_no').focus();
        });

        $('#subl_no').focus();
    });  //end ready func__=======================================================================================================



    //출고데이터 조회
    function findChulMaster(sublNo){


        ToastBox.showLoadingToast("조회중입니다.");

        $.getJSON('ajax.bkmech_mst_search.php',{'subl_no':sublNo},function(data){

            //console.log(data);
            ToastBox.closeToast()

            if(data.hasOwnProperty('result_msg')){
                MsgBox.warning(data.result_msg);
                return false;
            }

            if(data == null){

                    MsgBox.alertCallback("검색된 자료가 없습니다. ",function(){
                        $('#subl_no').focus();
                    });
                    return false;
            }

            $('#subl_no').val('');


            SCAN_CNT++;
            $('#scan_cnt').val(SCAN_CNT);
            if(SCAN_CNT>1){
                return;
            }

            $('#tax_no').val(data.tax_no);
            $('#cust_nm').val(data.cust_nm);
            $('#metax_no').val(data.metax_no);
            $('#mecust_nm').val(data.mecust_nm);
            $('#tot_qty').val(data.tot_qty);
            $('#tot_cnt').val(data.tot_cnt);
            //다음번 스캔 비교위해, old sublNo 셋팅
            $('#old_subl_no').val(sublNo);


            //추가 인자 셋팅
            $('#jg_gb').val(data.jg_gb);
            $('#od_qty').val(data.od_qty);
            $('#ju_qty').val(data.ju_qty);

            //출고내역 조회___________
            findChulList(sublNo);

        });

    } //end func ================================

    //촐고 내역 조회 ______________________________________
    function findChulList(sublNo){

        $('#bk_list  > tbody').html("");

        $.getJSON('ajax.bkmech_dtl_search.php',{'subl_no':sublNo},function(data){

            //console.log(data);
            if(data.length == 0){
                $('#bk_list  > tbody').append(makeMsgTableRow(2,"출고내역이 존재하지 않습니다."));
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
        SCAN_CNT=0;
    }



    function makeMsgTableRow(colNum,msg){
        var row = '<tr><td class="text-center py-3 px-2" colspan="'+colNum+'">'+msg+'</td></tr>';
        return row;
    }



    function makeTableRow(data){

        //console.log(data);

        var row = '<tr id="row_'+data.bk_cd+'" class="" >' +
              ' <td class="td_qty"> '+number_format(data.b_qty)+'</td>' +
            ' <td class="td_left">'+data.bk_nm+'</td>' +
            ' </tr>';

        return row;

    } //end func   ============================ ================================ =======================================




    //상차 전송하기 +++++++++++++++++++++++++++++++++++++++++++++++++
    function transferConfirm(){

        //전표번호
        var sublNo = filteringSpcChr($('#old_subl_no').val());

        if(sublNo.length != 16){
            playBeepSound();
            MsgBox.alert("전표번호를 바르게 입력하세요.");
            return false;
        }

        var taxNo = $('#tax_no').val();
        var totCnt = $('#tot_cnt').val();

        if(taxNo.length == 0 || totCnt.length == 0){
            playBeepSound();
            MsgBox.alert("상차등록 할 자료가 존재하지 않습니다.");
            return false;
        }


        MsgConfirmBox.show("상차 등록 자료를 전송하시겠습니까?",function(res){
            if(res){
                transferData();
            }
        });

        return false;
    }


    // 상차등록 전송하기  /////////////////////////////////////////////////
    function transferData(){

        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.load_reg_update.php";
//        $('#bkFrm').attr("action",actionUrl); //for debugging
//        return true; //for debugging

        //MsgBox.loading();
        ToastBox.showLoadingToast("처리중입니다.");

        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:$('#bkFrm').serialize(),
            success:function(data) {

                ToastBox.closeToast();
                //console.log(data);

                var result = data.result_stat;

                if(result){

                    /*
                    MsgBox.succCallback(data.result_msg, function () {
                        formClear();
                        $('#subl_no').focus();
                    });
                    */

                    ToastBox.showSuccessToast(data.result_msg);
                    formClear();
                    $('#subl_no').focus();


                } else {
                    playBeepSound();
                    MsgBox.fail(data.result_msg);

                }


            },error : function(xhr, status, error) {
                playBeepSound();
                alert("상차등록 자료 전송시 오류가 발생했습니다. ("+error+")");
            }
        }); //end ajax func ====


    } //end func ========================================




</script>