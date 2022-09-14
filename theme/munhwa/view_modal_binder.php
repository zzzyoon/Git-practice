

<!--모달 영역 MODAL AREA /    {   ----------------------------------------------------------------------->
<div class="modal" id="binderModal">


    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-light">
                <h5 class="modal-title">
                    제본소 선택
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

    var BinderCallback = null;


    $(function(){
        $('#binderModal').on('hidden.bs.modal', function (e) {
            // do something...
            $('#binderModal .modal-body').html("");

        })

    });

    function showBinderModal(findCode,findName,callback){ //callback(res,code,name)

        if(typeof(callback) != "function"){
            alert('콜백 함수를 바르게 설정하세요. ');
            return false;
        }

        BinderCallback = callback;

        $.get("<?php echo G5_BBS_URL?>/ajax.binder_search.php",
            {'code':findCode,
            'name':findName},
            function(data){

                // 제본소가 존재할때만 선택창 오픈
                if(data.includes("없습니다.")){
                    BinderCallback(false);
                    return false;
                }

                $('#binderModal').modal();

                $('#binderModal .modal-body').html(data);
            });


    }


    function selectBinder(code,name){

        if(code.length <=0)
            return;

        if(BinderCallback!=null){
            //$('#'+BinderCallback.code).val(code);
            //$('#'+BinderCallback.name).val(name);
            BinderCallback(true,code,name);

        } else {

            //BinderCallback(false,null,null);
            alert('콜백 객체가 존재하지 않습니다. ');

        }

        $('#binderModal').modal('hide');

    }

    function selectBinderSingleRow(){
        var code = $('#binderModal .modal-body > table > tbody >  tr > td:nth-child(2)').text();
        var name = $('#binderModal .modal-body > table > tbody >  tr > td:nth-child(3)').text();
        //console.log(code+" / "+name);
        selectBinder(code,name);
    }


</script>