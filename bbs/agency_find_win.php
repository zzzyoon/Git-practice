<?php
include_once('./_common.php');

$colspan = 4;
$g5['title'] = '대행사 회원관리';
$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';



// 대행사 관련 변수 정의 //////////////////////////////////////
$sfl_so_no = $_REQUEST['sfl_so_no'];
$sfl_dt_no = $_REQUEST['sfl_dt_no'];
$sfl_ag_no = $_REQUEST['sfl_ag_no'];



include_once('./_head.sub.php');
?>
<style>

    .container{
        max-width: 99%;
    }
</style>



<div class="container">



    <div class="alert alert-info">
        <h5 class="alert-heading">대행사 선택</h5>
        <hr>
        <?php

            echo get_sales_org_menu("sfl_so_no",$sfl_so_no,true);
        ?>
        <?php

            echo get_distributor_menu($sfl_so_no,"sfl_dt_no",$sfl_dt_no,true);
        ?>

        <?php

            echo get_agency_menu($sfl_dt_no,"sfl_ag_no",$sfl_ag_no,true);
        ?>


    </div>

    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-sm btn-primary" id="btn_select" >선택</button>
    </div>


    <!-- close button   -->
    <div class="fixed-top m-3">
        <button type="button" class="close close_window text-h-6" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

</div>



<script>


    var selectGroup = function(no,name,agency){
        window.opener.callback(no,name,agency);
        window.close();
    }

    $(function() {

        $('#stx').focus();

        $('.close_window').click(function(){
            window.close();
        });


        $('#btn_select').click(function(){
            selectAgency();
        });


        //검색 > 대행사 선택 > 이벤트 처리
        // ----> 하위 총판 추출
        $('#sfl_so_no').change(function(){

            var so_no = $(this).val();
            $('#sfl_dt_no').html("<option value=''>총판(선택)</option>");
            $('#sfl_ag_no').html("<option value=''>대리점(선택)</option>");

            if(so_no.length <= 0) {
                return false;
            }


            $.get("<?php echo G5_ADMIN_URL?>/ajax.distributor_select_options.php",
                {'so_no':so_no},
                function(data){
                    $('#sfl_dt_no').html(data);
                });


        }); //end method _______-------



        //검색 > 총판 선택 > 이벤트 처리
        // ----> 하위 대리점 추출
        $('#sfl_dt_no').change(function(){

            var dt_no = $(this).val();
            $('#sfl_ag_no').html("<option value=''>대리점(선택)</option>");

            if(dt_no.length <= 0) {
                return false;
            }


            $.get("<?php echo G5_ADMIN_URL?>/ajax.agency_select_options.php",
                {'dt_no':dt_no},
                function(data){
                    $('#sfl_ag_no').html(data);
                });


        }); //end method _______-------


    });


    function selectAgency(){

        var agName = '';
        var agCode = '';

        var soNo = $('#sfl_so_no option:selected').val();
        var dtNo = $('#sfl_dt_no option:selected').val();
        var agNo = $('#sfl_ag_no option:selected').val();


        if(soNo.length  == 0 && dtNo.length == 0 && agNo.length == 0){
            alert('대행사를 바르게 선택하세요.');
            $('#sfl_so_no').focus();
            return false;
        }

        if(soNo.length > 0){
            agCode = soNo;
            agName+= $('#sfl_so_no option:selected').text();
        }


        if(dtNo.length > 0){
            agCode = dtNo;
            agName+= " > "+$('#sfl_dt_no option:selected').text();
        }


        if(agNo.length > 0){
            agCode = agNo;
            agName+= " > "+$('#sfl_ag_no option:selected').text();
        }


        if (typeof callback != 'function') {
            alert('콜백 함수가 정의되지 않았습니다. ');
            return false;
        }

        // parent Widnow > callback function called__
        callback(agCode,agName);

        window.close();
    }


</script>

<?php
include_once('./_tail.sub.php');
?>
