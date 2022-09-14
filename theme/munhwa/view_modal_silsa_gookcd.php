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
                   상품 선택

                </h5>
                <button type="button" class="close text-light" data-dismiss="modal"><i class="fas fa-window-close" style="font-size:20px;"></i></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">




                        <div class="row my-1">
                            <div class="col-3 align-middle">
                                상품명
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" readonly id="dt_good_nm">
                            </div>
                        </div>

                        <div class="row my-1 no-gutters">
                            <div class="col-3 mt-2">
                                로케이션
                            </div>
                            <div class="col-4 pl-2">
                                <input type="text" class="form-control "   readonly id="dt_color">
                            </div>
                            <div class="col-2 text-center mt-2">
                                사이즈
                            </div>
                            <div class="col-3 ">
                                <input type="text" class="form-control "  readonly id="dt_size_gb">
                            </div>
                        </div>

                        <div id="modal-list">

                        </div>





            </div>
        </div>
    </div>
</div>
<!--  }   모달 영역 MODAL AREA   ----------------------------------------------------------------------->

<script>

    var BookCallback = null;


    $(function(){


        //재검색 > 호수 검색관련
        $('#bookModal').on('hidden.bs.modal', function (e) {
            // do something...
            $('#bookModal #modal-list').html("");
            $('#bookModal #kwd_bk_nm').val('');
        })
        //재검색 > 호수 검색관련 > 포커스
        $('#bookModal').on('shown.bs.modal', function (e) {
            // do something...
            //$('#bookModal #kwd_bk_nm').focus(); // soft keyboard 로딩 x

        })


        //호수검색
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
        $('#dt_color').val(json.loc_cd);
        $('#dt_size_gb').val(json.size_gb);

        //$('#dt_pub_date').val(json.pub_date);
    }


    //global var
    LastFindCode = null;
    LastFindName = null;
    /**
     * 바코드 기준으로 도서추출(tax,jg_gb 따라 다양한 도서 추출)
     * @param findCode
     * @param findName
     * @param callback
     * @returns {boolean}
     */
    function showSilsaModal(findCode,slipNo,jgGb, locCd ,callback){ //callback(res,code,name)

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

        LastFindCode = findCode;

        BookCallback = callback;
        ToastBox.showLoadingToast("검색중입니다.");

        //console.log(findName);
        $.get("<?php echo G5_BBS_URL?>/ajax.silsa_good_search.php",
            {'code':findCode,'slipNo':slipNo,'jgGb':jgGb,'locCd':locCd},
            function(data){  // html 리턴

//                console.log('modal');
//                console.log(data);

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


    // 도서 선택시 호출 (row dblclick)
    function selectBook(jsonData){
        if(jsonData == null || jsonData.length <= 0){
            MsgBox.error("전달값이 누락되었습니다.");
            return;
        }
        var json = JSON.parse(jsonData);
        var sublDate = json.subl_date;
        var sublNo = json.subl_no;
        var sublSeq = json.subl_seq;


        if(BookCallback!=null){
            //BookCallback(true,code,name);
            BookCallback(true,json);
        } else {
            alert('콜백 객체가 존재하지 않습니다. ');
        }
        $('#bookModal').modal('hide');
    }




</script>