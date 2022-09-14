<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
add_javascript('<script src="'.G5_JS_URL.'/moment-with-locales.min.js"></script>', 9);
?>
<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>

<section id="contents">


<form id="bkFrm" name="bkFrm" method="post" action=""   onsubmit="return  transferConfirm()"   autocomplete="off">

    <div class="form-group row  no-gutters my-1">
        <label for="order_no" class="col-3 col-form-label">주문번호</label>
<!--        <div class="col-9">-->
<!--            <input type="text" class="form-control  required" name="order_no" id="order_no" placeholder="스캔">-->
<!--        </div>-->

        <!-- input group area/  찾기 아이콘 붙임   -->
        <div class="input-group col-9">
            <input type="text" name="order_no" value="" id="order_no" inputmode="search" class="form-control" placeholder="스캔">
            <div class="input-group-append">
                <button class="btn btn-primary" id="btnSrch" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>


    </div>


    <div class="form-group row  no-gutters my-1">
        <label for="patt_name" class="col-3 col-form-label">패턴명</label>
        <div class="col-3">
            <input type="text" class="form-control" name="patt_name" id="patt_name" readonly placeholder="">
        </div>

        <label for="order_qty" class="col-3 col-form-label text-center">주문수</label>
        <div class="col-3">
            <input type="text" class="form-control" name="order_qty" id="order_qty" readonly placeholder="">
        </div>
    </div>



    <div class="form-group row  no-gutters my-1">
        <label for="chk_qty" class="col-3 col-form-label">주문/검증</label>
        <div class="col-3">
            <input type="text" class="form-control" name="chk_qty" id="chk_qty" readonly placeholder="">
        </div>

        <label for="non_chk_qty" class="col-3 col-form-label text-center">미검증</label>
        <div class="col-3">
            <input type="text" class="form-control" name="non_chk_qty" id="non_chk_qty" readonly placeholder="">
        </div>
    </div>


    <div class="form-group row  no-gutters my-1">
        <label for="bar_cd" class="col-3 col-form-label">바코드</label>
<!--        <div class="col-9">-->
<!--            <input type="text" class="form-control  required" name="bar_cd" id="bar_cd" placeholder="스캔">-->
<!--        </div>-->
        <!-- input group area/  찾기 아이콘 붙임   -->
        <div class="input-group col-9">
            <input type="text" name="bar_cd" value="" id="bar_cd" class="form-control" placeholder="스캔">
            <div class="input-group-append">
                <button class="btn btn-primary" id="btnSrchBook" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>



    </div>

    <div class="form-group row  no-gutters my-1">
        <label for="bk_nm" class="col-3 col-form-label">도서명</label>
        <div class="col-9">
            <input type="text" class="form-control  required" name="bk_nm" id="bk_nm" readonly placeholder="도서명">
        </div>
    </div>


    <hr>
    <div class='d-flex justify-content-end mt-4' >
        <button type="button" class="btn  btn-secondary" id="btnReset" >초기화</button>
        &nbsp;
        <button type="button"  class="btn  btn-danger" id="btnSubmit"> <i class="fas fa-paper-plane"></i> 전체 완료하기</button>
    </div>



    <!-- 검수 리스트   --------------------------------------------------------------------------->
    <div class="mt-4">

        <table id="bk_list" class="table  table-hover">
            <thead>
            <tr>
                <th scope="col">Y/N</th>
                <th scope="col">검수</th>
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


    $(function() {



        //////////////////////////////////////////////////////////////////////////////////////////////
        ///////////   Android Virtual Keyboard / Control  {
        $("#order_no").doubleTap(function() {
            AndroidKeyboardHide=false;
            setTimeout(function(){
                $("#order_no").focus();
            },300);
        });

        $("#order_no").focus(function(){
            if(window.hasOwnProperty("Android")){
                window.Android.setKeyboardHide(AndroidKeyboardHide);
            }
            AndroidKeyboardHide=true;
        });

        //_------------------------------------------------------------------
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




        //주문번호 검색 //////////////////////////////////////////
            $('#order_no').keyup(function(e){

                if(e.keyCode != 13) {
                    return true;
                }

                var $this = $(this);
                var val  = $this.val();

                if(val.length != 17){
                    playBeepSound();
                    MsgBox.warningCallback("주문번호를 바르게 입력해주세요.",function(){
                        $this.focus();
                    })
                    return false;
                }


                findOrderData(val);
            });

        //버튼으로 주문번호 검색
        $('#btnSrch').click(function(){

            var $this = $('#order_no');
            var val  = $this.val();

            if(val.length != 17){
                playBeepSound();
                MsgBox.warningCallback("주문번호를 바르게 입력해주세요.",function(){
                    $this.focus();
                })
                return false;
            }


            findOrderData(val);
        });


        //도서코드로 검증
        $('#bar_cd').keyup(function(e) {

            if (e.keyCode != 13) {
                return true;
            }

            var $this = $(this);
            var val  = filteringSpcChr($this.val());
            if(val.length == 0)
                return false;


            var rowCnt = $('#dt_bk_list tbody tr').length;
            if(rowCnt == 0){
                playBeepSound();
                MsgBox.alert("검증 할 자료가 없습니다.");
                $this.val('');
                return false;
            }


            checkChulData(val);
        });


        //버튼으로 바코드 검색
        $('#btnSrchBook').click(function(){

            var $this = $('#bar_cd');
            var val  = filteringSpcChr($this.val());
            if(val.length < 13) {
                playBeepSound();
                MsgBox.alertCallback("바코드를 바르게 입력하세요.",function(){
                   $this.focus();
                });
                return false;
            }

            var rowCnt = $('#dt_bk_list tbody tr').length;
            if(rowCnt == 0){
                playBeepSound();
                MsgBox.alert("검증 할 자료가 없습니다.");
                $this.val('');
                return false;
            }


            checkChulData(val);

        });


        $('#btnReset').click(function(){
            formClear();
            $('#order_no').focus();
        });


        $('#btnSubmit').click(function(){
            $('#bkFrm').submit();
        });

        $('#order_no').focus();

    });  //end ready func__=======================================================================================================


    function checkChulData(barCode){

        $('#bk_nm').val('');

        //주문번호
        var orderNo = filteringSpcChr($('#order_no').val());

        if(orderNo.length != 17){
            playBeepSound();
            MsgBox.alert("주문번호를 바르게 입력하세요.");
            return false;
        }

        var rowObj = $('#row_'+barCode);
        if(rowObj ==null || rowObj == undefined){
            playBeepSound();

            MsgBox.alertCallback("바코드와 일치하는 도서가 없습니다.",function(){
                $('#bar_cd').val('');
                $('#bar_cd').focus();
            });

            return false;
        }

        //선택박스 클리어
        $('#bk_list > tr').removeClass("border-info");

        //console.log('book validate start==');

        $.getJSON("ajax.chulmt_sejong_book_validate.php",{'order_no':orderNo,'bar_cd':barCode},function(res){
            if(res.result_stat){

                MsgBox.alertCallback("이미 검수된 도서입니다. ",function(){
                    playBeepSound();
                    $('#bar_cd').val('');
                    $('#bar_cd').focus();
                });

                return false;

            } else {


                //console.log('barCode is exists > tr loop start------------ -------------------- ');


                var isChecked=false;
                $('#bk_list tr').each(function(){

                    var tr = $(this);
                    var td = tr.children();
                    //var text = td.eq(2).text();


                    var tmpCode = tr.prop('id').replace("row_","");


                    //바코드 비교 -> 검증 시작 { ====================================================================
                    if(tmpCode == barCode){

                        //해당 tr 로우 선택________________
                        tr.toggleClass("border-info");

                        //var bookStrData = tr.attr('data');
                        //console.log('sel book : '+bookStrData);
                        var bookData = JSON.parse(tr.attr('data'));

                        //console.log(bookData);

                        var curQty = Number(bookData.b_qty);
                        if(curQty < bookData.ju_qty){

                            $('#bk_nm').val(bookData.bk_nm);

                            isChecked=true;

                            //console.log("chk step 01");

                            if((curQty+1) == Number(bookData.ju_qty)){
                                //console.log("chk step 02 - 1");
                                //검수 자료 업뎃 호출 > chuli update procedure 호출 001
                                updateChuljiCheckData(bookData,(curQty+1),'Y',function(res){

                                        //console.log('checkData result 11 : '+res);

                                        if(res == -1){
                                            playBeepSound();
                                            MsgBox.error("검수시 일시적인 오류가 발생했습니다. ");
                                            return false;
                                        } else if(res ==-2){
                                            playBeepSound();
                                            MsgBox.warning("["+orderNo+"] 주문번호에 해당되는 출고지시가 없습니다.  ");
                                            return false;
                                        }


                                        bookData.b_qty = curQty+1;
                                        bookData.status = "Y";
                                        var newBookData = JSON.stringify(bookData); //json to string

                                         // 수정된 자료 tr 객체 할당
                                        tr.attr('data',newBookData);
                                        trRowUpdate(bookData);  //table > row update


                                        //마스터 자료 재호출 > db 재로딩 및 검수 완료체크 역활
                                        findOrderMasterData(orderNo);

                                });

                            } else {

                                //console.log("chk step 02 - 2");
                                //검수 자료 업뎃 호출 > chuli update procedure 호출 002
                                updateChuljiCheckData(bookData,(curQty+1),'N',function(res){

                                    //console.log('checkData result 12 : '+res);

                                    if(res == -1){
                                        playBeepSound();
                                        MsgBox.error("검수시 일시적인 오류가 발생했습니다. ");
                                        return false;
                                    } else if(res ==-2){
                                        playBeepSound();
                                        MsgBox.warning("["+orderNo+"] 주문번호에 해당되는 출고지시가 없습니다.  ");
                                        return false;
                                    }

                                    bookData.b_qty = curQty+1;
                                    var newBookData = JSON.stringify(bookData);


                                    // 수정된 자료 tr 객체 할당
                                    tr.attr('data',newBookData);
                                    trRowUpdate(bookData);  //table > row update

                                    //마스터 자료 재호출 > db 재로딩 및 검수 완료체크 역활
                                    findOrderMasterData(orderNo);

                                });
                            }


                            // 주문서 - 동일도서 존재 가능 > 매칭 > exit
                            return true;
                        }


                    } //   }    바코드 비교 -> 검증 끝     =============================================================


                }); //book list > check (loop) ==================================================================================


            }
        });

    }


    // 검수 자료 > table > row ui update (bookData 자료 싱크)
    function trRowUpdate(bookData){
        var tr = $('#row_'+bookData.bar_cd);
        tr.find('td:eq(0)').html(bookData.status);
        tr.find('td:eq(1)').html(bookData.b_qty);
    }


    // 도서 검수 데이터 업데이트(chulji table)
    function updateChuljiCheckData(bookData,chkQty,state,callback){

        $.get('ajax.chulji_sejong_update.php',
                    {'subl_date':bookData.subl_date,
                    'subl_no':bookData.subl_no,
                    'tax_no':bookData.tax_no,
                    'subl_seq':bookData.subl_seq,
                    'subl_seq2':bookData.subl_seq2,
                    'b_qty':chkQty,
                    'p_confirm':state
                    },
                    function(data){

                     //console.log("updateChuljiCheckData Result : "+data);
                     callback(data); //0정상, -1 오류, -2 없음(procedure), -9 필수 인자 누락


        });


    } //end func ============================================================================

    // 출고 자료 추출
    function findOrderData(orderNo){

        $('#bk_list  > tbody').html("");


        ToastBox.showLoadingToast("로딩중입니다.");

        $.getJSON('ajax.chulmt_sejong_search.php',{'order_no':orderNo},function(data){

            //console.log(data);
            if(data == null){
                ToastBox.closeToast();
                playBeepSound();

                ToastBox.showToast("주문번호 ["+orderNo+"]와 일치하는 출고 자료가 없습니다.");
                $('#bk_cnt').val(0);
                $('#order_no').focus();
                return;
            }

            var  len  = data.length;

            /*
             var  len  = data.length;
            if(len == 0){
                ToastBox.closeToast();
                $('#bk_cnt').val(0);
                //MsgBox.alert("주문번호 ["+orderNo+"]와 일치하는 출고 자료가 없습니다.");
                ToastBox.showToast("주문번호 ["+orderNo+"]와 일치하는 출고 자료가 없습니다.");
                return false;
            } */

            var chkGb = data[0].chk_gb;
            if(chkGb<=1){
                playBeepSound();
                ToastBox.closeToast();
                MsgBox.warning("주문번호 ["+orderNo+"]는 출고지시가 확정되지 않았습니다. ");
                return false;
            } else if(chkGb >= 3){
                playBeepSound();
                ToastBox.closeToast();
                MsgBox.succ("주문번호 ["+orderNo+"]는 출고처리 되었습니다. ");
                return false;
            }


            $('#bk_cnt').val(len);


            data.forEach(function(jdata,idx){
                $('#bk_list  > tbody').append(makeTableRow(jdata));
            });

            //출고 마스터 추출 ///////////////////////////////////
            findOrderMasterData(orderNo);

        });

    }


    //출고 마스터 자료 추출  > 데이터 추출 및 출고 기처리 체크

    function findOrderMasterData(orderNo){


        $.getJSON('ajax.chulmt_mst_sejong_search.php',{'order_no':orderNo},function(data){

            //console.log(data);
            ToastBox.closeToast();

              //for debugging
            if(data.ju_qty > 0 && data.ju_qty == data.b_qty){

                MsgConfirmBox.show("모두 검수 되었습니다. ",function(res){
                    //formClear();
                    $('#btnSubmit').prop('disabled',true);
                    if(res){
                        formClear();
                    } else {
                        // 마스터 자료 UI 업데이트 _______________
                        $('#patt_name').val(data.mecust_nm2);
                        $('#order_qty').val(data.ju_qty);
                        $('#chk_qty').val(data.ju_cnt+"/"+data.b_cnt);
                        $('#non_chk_qty').val(data.u_b_qty);
                        $('#bar_cd').focus();

                    }

                    $('#bar_cd').focus();
                });

                return false;
            }

            // 마스터 자료 UI 업데이트 _______________
            $('#patt_name').val(data.mecust_nm2);
            $('#order_qty').val(data.ju_qty);
            $('#chk_qty').val(data.ju_cnt+"/"+data.b_cnt);
            $('#non_chk_qty').val(data.u_b_qty);
            $('#bar_cd').focus();
        });

    }



    function makeTableRow(data){

       // console.log(data);

        var pk = data.subl_date+data.tax_no+String(data.subl_no);

        var bookData = JSON.stringify(data);

        //console.log(pk)
        var row = '<tr id="row_'+data.bar_cd+'"  data=\''+bookData+'\' >' +
            ' <td class="td_stat">' +  data.status + ' </td>' +
            ' <td class="td_qty">'+number_format(data.b_qty)+'</td>' +
            ' <td class="td_left"> '+data.bk_nm+'</td>' +
            ' </tr>';

        return row;

    } //end func   ============================ ================================ =======================================





    function formClear(){

        $("input[type='hidden']").val('');
        $('#bk_list  > tbody').html("");
        $('#bkFrm')[0].reset();

        $('#btnSubmit').prop('disabled',false);
    }


    //검수 > 전체전송하기 confirm
    function transferConfirm(){

        //주문번호
        var orderNo = filteringSpcChr($('#order_no').val());

        if(orderNo.length != 17){
            playBeepSound();
            MsgBox.alert("주문번호를 바르게 입력하세요.");
            return false;
        }

        var bkCnt = $('#bk_cnt').val();

        if(bkCnt == 0 ){
            playBeepSound();
            MsgBox.alert("검수 등록 할 도서가 없습니다.");
            return false;
        }


        MsgConfirmBox.show("일괄 검수등록을  진행하시겠습니까?",function(res){
            if(res){
                transferData(orderNo);
            }
        });


        return false;
    }




    // 전체 일괄 검수등록하기  /////////////////////////////////////////////////
    function transferData(orderNo){


        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.out_check_sejong_update.php";
//        $('#bkFrm').attr("action",actionUrl); //for debugging
//        return true; //for debugging

        ToastBox.showLoadingToast("처리중입니다.");

        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:{'subl_date':orderNo.substr(0,8),
             'tax_no':orderNo.substr(8,4),
            'subl_no':orderNo.substr(12,4)},
            success:function(data) {
                //console.log(data);

                ToastBox.closeToast();

                var result = data.result_stat;

                if(result){
                    MsgBox.succCallback(data.result_msg, function () {
                        formClear();
                        $('#order_no').focus();
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
            }
        }); //end ajax func ====

        return false;
    } //end func ========================================



</script>