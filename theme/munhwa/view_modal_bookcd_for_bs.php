<!--
*도서 검색 모달창
: 바코드(도서명) 기준으로 도서추출(tax,jg_gb,loc 따라 다양한 도서 추출)
: 대표적 사용처 : 도서재고 조회
: 검색 파일 > ajax.book_search.php
-->

<!--모달 영역 MODAL AREA /    {   ----------------------------------------------------------------------->
<div class="modal" id="bookModal">


    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-light">
                <h5 class="modal-title">
                   도서 선택
                </h5>
                <button type="button" class="close text-light" data-dismiss="modal"><i class="fas fa-window-close" style="font-size:20px;"></i></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                        <div class="row my-1">
                            <div class="col-3">
                                상품명
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" readonly id="dt_good_nm">
                            </div>
                        </div>

                        <div class="row my-1 no-gutters">
                            <div class="col-3">
                                사이즈<BR>상품코드
                            </div>
                            <div class="col-5 pl-2">
                                <input type="text" class="form-control"  readonly id="dt_size_gb">
                            </div>
                            <div class="col-4 pl-2">
                                <input type="text" class="form-control text-center "  readonly id="dt_good_cd">
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


<!--모달 영역 MODAL AREA /    {   ----------------------------------------------------------------------->
<div class="modal" id="GoodModal">


    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-light">
                <h5 class="modal-title">
                    도서 선택
                </h5>
                <button type="button" class="close text-light" data-dismiss="modal"><i class="fas fa-window-close" style="font-size:20px;"></i></button>
            </div>

            <!-- Modal body -->
            <div class="Gmodal-body">

                <div class="row my-1">
                    <div class="col-3">
                        상품명
                    </div>
                    <div class="col-9">
                        <input type="text" class="form-control" readonly id="dt_good_nm1">
                    </div>
                </div>

                <div class="row my-1 no-gutters">
                    <div class="col-3">
                        재고/대기
                    </div>
                    <div class="col-5 pl-2">
                        <input type="text" class="form-control"  readonly id="dt_jg_qty">
                    </div>
                    <div class="col-4 pl-2">
                        <input type="text" class="form-control text-center "  readonly id="dt_medg_qty">
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

                <div id="Gmodal-list">

                </div>





            </div>
        </div>
    </div>
</div>
<!--  }   모달 영역 MODAL AREA   ----------------------------------------------------------------------->


<script>

    var BookCallback = null;


    $(function(){



        $('#bookModal').on('hidden.bs.modal', function (e) {
            // do something...
            $('#bookModal #modal-list').html("");
            $('#bookModal #kwd_bk_nm').val('');
        })

        $('#bookModal').on('shown.bs.modal', function (e) {
            // do something...
            $('#bookModal #kwd_bk_nm').focus();

        })


        //결과내 재검색
        $('#bookModal #kwd_bk_nm').keydown(function(e){

            if(e.keyCode == 13) {
                var $this = $(this);
                var val = $this.val();
                if (val.length == 0)
                    return false;

                 reSearch(val);
            }

        });

    });

    function showBookDetail(jsonData){

        //console.log(jsonData);
        var json = JSON.parse(jsonData);

        //console.log(json);

        $('#dt_good_nm').val(json.good_nm);
        $('#dt_size_gb').val(json.size_gb);
        $('#dt_good_cd').val(json.good_cd);
        //$('#dt_pub_date').val(json.pub_date);

    }



    var LastFindCode = "";



    /**
     * 바코드 기준으로 도서추출(tax,jg_gb,loc 따라 다양한 도서 추출)
     * @param findCode
     * @param callback
     * @returns {boolean}
     */
    function showBookModal(findCode,jgGb,callback){ //callback(res,code,name)

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
        $.get("<?php echo G5_BBS_URL?>/ajax.book_search_for_bs.php",
            {'code':findCode,
             'jgGb':jgGb},
            function(data){
                ToastBox.closeToast();
                DashBoard.setSearchStat(false);

                // 도서가 존재할때만 선택창 오픈
                if(data.includes("없습니다.")){
                    BookCallback(false);
                    return false;
                }


                $('#bookModal').modal();
                //console.log(data);
                //$('#bookModal .modal-body').html(data);
                $('#bookModal #modal-list').append(data);
                $('#dt_bk_list > tbody > tr:first-child').trigger('click');


            });


    }

    function showGoodJg(goodCd,sizeGb,locCd,jgGb,callback){ //callback(res,code,name)

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

        $.get("<?php echo G5_BBS_URL?>/ajax.good_jg_search_bs.php",
            {'goodCd':goodCd,'sizeGb':sizeGb,'locCd':locCd,'jgGb':jgGb},
            function(data){
                ToastBox.closeToast();
                DashBoard.setSearchStat(false);

                // 도서가 존재할때만 선택창 오픈
                if(data.includes("없습니다.")){
                    BookCallback(false);
                    return false;
                }


                $('#bookModal').modal();
                //console.log(data);
                //$('#bookModal .modal-body').html(data);
                $('#bookModal #modal-list').append(data);
                $('#dt_bk_list > tbody > tr:first-child').trigger('click');


            });

    }


    function selectBook(jsonData){
        if(jsonData == null || jsonData.length <= 0){
            MsgBox.error("전달값이 누락되었습니다.");
            return;
        }

        var json = JSON.parse(jsonData);

        if(BookCallback!=null){
            //BookCallback(true,code,name);
            BookCallback(true,json);
        } else {

            alert('콜백 객체가 존재하지 않습니다. ');

        }
        $('#bookModal').modal('hide');

    }



    function selectGood(jsonData){
        if(jsonData == null || jsonData.length <= 0){
            MsgBox.error("전달값이 누락되었습니다.");
            return;
        }

        var json = JSON.parse(jsonData);

        if(BookCallback!=null){
            //BookCallback(true,code,name);
            BookCallback(true,json);
        } else {

            alert('콜백 객체가 존재하지 않습니다. ');

        }

        $('#bookModal').modal('hide');

    }




</script>