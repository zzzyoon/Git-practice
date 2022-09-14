<!--
*도서 검색 모달창
: 바코드 + 재고구분자(jg_gb)  기준으로 도서추출(tax,loc 따라 다양한 도서 추출)
: 대표적 사용처 : 선택 재고이동
: 검색 파일 > ajax.book_jggb_search.php
-->


<!--모달 영역 MODAL AREA /    {   ----------------------------------------------------------------------->
<div class="modal" id="bookModal">


    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-light">
                <h5 class="modal-title">
                   도서 선택
                    &nbsp;
                    &nbsp;

                    <span class="text-size-3">
                    * 호수 <input type="text" id="kwd_bk_nm" class="form-control d-inline-block w-25 text-center text-danger" size="6" >
                    </span>

                </h5>
                <button type="button" class="close text-light" data-dismiss="modal"><i class="fas fa-window-close" style="font-size:20px;"></i></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">




                        <div class="row my-1">
                            <div class="col-3">
                                도서명
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" readonly id="dt_bk_nm">
                            </div>
                        </div>

                        <div class="row my-1">
                            <div class="col-3">
                                출판사
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control"  readonly id="dt_cust_nm">
                            </div>
                        </div>

                        <div class="row my-1 no-gutters">
                            <div class="col-3 mt-2">
                                재고
                            </div>
                            <div class="col-3 pl-2">
                                <input type="text" class="form-control "   readonly id="dt_jg_qty">
                            </div>
                            <div class="col-2 text-center mt-2">
                                정가
                            </div>
                            <div class="col-4 ">
                                <input type="text" class="form-control "  readonly id="dt_out_danga">
                            </div>
                        </div>
                        <!--
                        <div class="row my-1">
                            <div class="col-3">
                                발행일
                            </div>
                            <div class="col-5">
                                <input type="text" class="form-control" id="dt_pub_date" readonly >
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-info">선택하기</button>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class=" offset-8 col-4">
                                <button type="button" class="btn btn-info">선택하기</button>
                            </div>
                        </div>

                           -->

                        <div id="modal-list">

                        </div>
            </div>
        </div>
    </div>
</div>
<!--  }   모달 영역 MODAL AREA   ----------------------------------------------------------------------->

<script>

    var BookCallback = null;
    var BookIsSelected=false;

    $(function(){

        $('#bookModal').on('hidden.bs.modal', function (e) {
            // do something...
            $('#bookModal #modal-list').html("");
            $('#bookModal #kwd_bk_nm').val('');

            if(!BookIsSelected && BookCallback != null){
                BookCallback(false,null);
            }


        })

        $('#bookModal').on('shown.bs.modal', function (e) {
            BookIsSelected=true;
            // do something...
            $('#bookModal #kwd_bk_nm').focus();

        })


        // 결과내 재검색
        $('#bookModal #kwd_bk_nm').keydown(function(e){

            if(e.keyCode == 13) {
                var $this = $(this);
                var val = $this.val();
                if (val.length == 0)
                    return false;
                searchString(val);
            }

        });
    });


    function searchString(kwd){

        var $this =  $('#bookModal #kwd_bk_nm');

        var resObj = $('#dt_bk_list > tbody > tr:contains("'+kwd+'")')
        resObj.addClass("text-danger font-weight-bold");
        if(resObj.length > 0){

            var hidData = resObj.attr('data');
            var jsonData = JSON.parse(hidData);
            // console.log(hidData);

            MsgBox.confirm("재 검색된 도서 [ "+jsonData.bk_nm+" ] 를 선택 하시겠습니까?",function(res){

                if(res){
                    selectBook(hidData);
                } else {
                    $this.val('');
                    $this.focus();
                }

            });

            //console.log(resObj);

        }

    }

    function showBookDetail(jsonData){

        //console.log(jsonData);
        var json = JSON.parse(jsonData);

        //console.log(json);

        $('#dt_bk_nm').val(json.bk_nm);
        $('#dt_cust_nm').val(json.cust_nm);
        $('#dt_jg_qty').val(number_format(json.jg_qty));
        $('#dt_out_danga').val(number_format(json.out_danga));
        //$('#dt_pub_date').val(json.pub_date);



    }

    /**
     * 바코드 + jg_gb 기준으로 도서추출(tax,loc 따라 다양한 도서 추출)
     * @param findCode
     * @param findName
     * @param callback
     * @returns {boolean}
     */
    function showBookModal(findCode,findJgGb,callback){ //callback(res,code,name)

        if(typeof(callback) != "function"){
            alert('콜백 함수를 바르게 설정하세요. ');
            return false;
        }

        if(DashBoard.isSearching()){ // 검색 중복호출
            ToastBox.showWarningToast(" *  이미 검색중입니다. ");
            return;
        } else {
            DashBoard.setSearchStat(true);
        }

        BookCallback = callback;

        ToastBox.showLoadingToast("검색중입니다.");

        $.get("<?php echo G5_BBS_URL?>/ajax.book_jggb_search.php",
            {'bar_cd':findCode,
            'jg_gb':findJgGb},
            function(data){
                ToastBox.closeToast();
                DashBoard.setSearchStat(false);

                if(data.includes("없습니다.")){
                    BookCallback(false);
                    return false;
                }

                // 도서가 존재할때만 선택창 오픈
                $('#bookModal').modal();

                $('#bookModal #modal-list').append(data);
            });


    }


    function selectBook(jsonData){

        if(jsonData == null || jsonData.length <= 0){
            MsgBox.error("전달값이 누락되었습니다.");
            return;
        }

        var json = JSON.parse(jsonData);
        var code = json.bar_cd;
        var name = json.bk_nm;


        if(BookCallback!=null){
            //BookCallback(true,code,name);
            BookIsSelected=true;
            BookCallback(true,json);
        } else {

            alert('콜백 객체가 존재하지 않습니다. ');

        }

        $('#bookModal').modal('hide');

    }





</script>