

<!--모달 영역 MODAL AREA /    {   ----------------------------------------------------------------------->
<div class="modal" id="pubModal">


    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-light">
                <h5 class="modal-title">
                    출판사 선택
                </h5>
                <button type="button" class="close text-light" data-dismiss="modal"><i class="fas fa-window-close" style="font-size:20px;"></i></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">


            </div>
        </div>
    </div>
</div>
<!--  }   모달 영역 MODAL AREA   ----------------------------------------------------------------------->

<script>

    var PubCallback = null;


    $(function(){
        $('#pubModal').on('hidden.bs.modal', function (e) {
            // do something...
            $('#pubModal .modal-body').html("");

        })

    });

    function showPubModal(findCode,findName,callback){ //callback(res,code,name)

        if(typeof(callback) != "function"){
            alert('콜백 함수를 바르게 설정하세요. ');
            return false;
        }



        PubCallback = callback;


        $.get("<?php echo G5_BBS_URL?>/ajax.publisher_search.php",
            {'code':findCode,
            'name':findName},
            function(data){
                //console.log(data);

                //  존재할때만 선택창 오픈
                if(data.includes("없습니다.")){
                    PubCallback(false);
                    return false;
                }


                $('#pubModal').modal();

                $('#pubModal .modal-body').html(data);
            });


    }


    function selectPub(code,name){

        if(code.length <=0)
            return;

        if(PubCallback!=null){
            //$('#'+PubCallback.code).val(code);
            //$('#'+PubCallback.name).val(name);
            PubCallback(true,code,name);

        } else {

            PubCallback(false,null,null);
            alert('콜백 객체가 존재하지 않습니다. ');

        }

        $('#pubModal').modal('hide');

    }

    function selectPubSingleRow(){
        var code = $('#pubModal .modal-body > table > tbody >  tr > td:nth-child(2)').text();
        var name = $('#pubModal .modal-body > table > tbody >  tr > td:nth-child(3)').text();
        //console.log(code+" / "+name);
        selectPub(code,name);
    }


</script>