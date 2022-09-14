<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_path.'/style.css">', 0);
?>
<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>

<section id="wtimeSection">

<form id="mentFrm" name="mentFrm" method="post" onsubmit="return formSubmit()" action="" autocomplete="off">
    <input type="hidden" name="cm_no" id="cm_no"  value="<?=$view['cm_no']?>"  >
    <input type="hidden" name="cm_type" id="cm_type"  value="<?=$view['cm_type']?>"  >
    <input type="hidden" name="cm_idx" id="cm_idx"  value="<?=$view['cm_idx']?>"  >

    <ul class="list-group mb-4">

        <li class="list-group-item">
            <div class="row">
                <div class="col-11">

                    <!-- Group Button   -->
                    <label for="cm_type_frame" class="control-label">멘트 타입 </label>
                    <div class="m-0 p-0" id="cm_type_frame">
                    <div id="cm_type" class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">

                        <label class="btn btn-primary active">
                            <input type="radio" name="cm_type" id="cm_type_0" autocomplete="off" <?=($view['cm_type']=="0" || !$view['cm_type'])?"checked":""?> value="0"> 통화대기 안내멘트
                        </label>

                        <label class="btn btn-primary">
                            <input type="radio" name="cm_type" id="cm_type_1" autocomplete="off" <?=($view['cm_type']=="1")?"checked":""?> value="1"> 통화연결 안내멘트
                        </label>

                    </div>
                    </div>
                </div>
                <div class="col-1 text-right">
                    <?php if($cm_no) { ?>
                        <button type="button" id="btnPreview1" onclick="showAudioModal('<?=$view['cm_name']?>','<?=$view['cm_filename']?>')" class="btn btn-sm btn-secondary d-none d-md-inline-block" ><i class="fas fa-volume-up"></i></button>
                    <?php } ?>

                </div>
            <div>
        </li>


        <li class="list-group-item">
            <div class="row">
                <div class="col-md-6">

                    <label for="cm_name">멘트 이름

                        <?php if($cm_no) { ?>
                            <button type="button" id="btnPreview2" onclick="showAudioModal('<?=$view['cm_name']?>','<?=$view['cm_filename']?>')" class="btn btn-sm btn-secondary rounded-pill d-inline-block d-md-none" ><i class="fas fa-volume-up"></i></button>
                        <?php } ?>
                    </label>

                        <input type="text" name="cm_name" id="cm_name" class="form-control hangulalnum" minlength="3" maxlength="30" required value="<?=$view['cm_name']?>"  >

                </div>

                <div class="col-md-6">
                    <label for="cm_content">멘트 내용</label>

                    <textarea name="cm_content" id="cm_content" required class="form-control hangulalnumspec" rows="6" minlength="4" maxlength="80"  ><?=$view['cm_content']?></textarea>
                    <div class="alert alert-secondary mt-1 small text-danger">
                        *주의사항 : 특수문자를 입력할 수 없습니다.(*예외  " . ,")
                    </div>
                </div>

            </div>
        </li>


        <li class="list-group-item">
            <div class="row">
                <div class="col-md-6">

                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">참고 : 멘트 타입 설명</h4>
                        <p>
                            <strong>통화대기 안내멘트</strong> : 전화를 거는 발신자에게 통화 대기 중 안내되는 멘트입니다.
                            <button type="button" class="btn btn-sm btn-outline-info rounded-pill" onclick="showAudioModal('통화대기 샘플 멘트','<?=G5_FWD_SAMPLE_MENT?>')" name="btnSampleType1" id="btnSampleType1" >
                                샘플 멘트 듣기
                                <i class="fas fa-volume-up"></i></button>
                        </p>
                        <hr>
                        <p>
                            <strong>통화연결 안내멘트 </strong> : 전화를 받는 수신자 즉, 교사들에게 통화 연결 전 안내되는 멘트입니다.
                            <button type="button" class="btn btn-sm btn-outline-info rounded-pill"  onclick="showAudioModal('통화연결 샘플 멘트','<?=G5_RCV_SAMPLE_MENT?>')"  name="btnSampleType2" id="btnSampleType2" >
                                샘플 멘트 듣기
                                <i class="fas fa-volume-up"></i></button>
                        </p>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">참고 : 부가 설명</h4>
                        <p>멘트 내용으로 입력한것이 음성 데이터로 생성되며, 영문사용시 부정확하게 멘트가 생성될 수 있습니다. 한글 및 숫자 조합으로 내용을 입력해주시길 바랍니다.</p>
                        <hr>
                        <p class="mb-0"> 생성된 멘트는 <strong>"안심번호 설정 > 업무시간, 추가시간 설정"</strong>  등에서 이용할 수  있습니다.</p>
                    </div>
                </div>

            </div>
        </li>

    </ul>



    <div class='d-flex justify-content-center'>

        <a href="<?=$list_href?>" class="btn btn-secondary text-light">목록</a>
        <?php if($cm_no) { ?>

            &nbsp;
            <button type="button" id="btnDelete" class="btn btn-danger" >삭제</button>

        <?php } ?>

        &nbsp;
        <?php if($cm_no) { ?>
            <button type="submit" class="btn  btn-primary" >수정하기</button>
        <?php } else { ?>
            <button type="submit" class="btn  btn-primary" >생성하기</button>
        <?php } ?>

    </div>

</form>

</section>

<div>&nbsp;</div>


<!--  멘트 미리듣기 모달창   ---------------------------------------------------------------------------------------------------------------->
<div class="modal" id="audioModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"> *Audio Player </h4>
                <!--                <button type="button" class="close" data-dismiss="modal"><i class="fas fa-window-close" style="font-size:20px;"></i></button>-->
            </div>

            <!-- Modal body -->
            <div id="modal_num_book" class="modal-body">
                <div class="card m-2">
                    <div class="card-header">Header</div>
                    <div class="card-body  d-flex justify-content-center">
                        <!--                        <audio preload="auto" src=""></audio>-->

                        <audio id="audio_player" controls autoplay>
                            <source src="" type="audio/wav">
                            *wav음성파일 미지원 브라우져입니다.
                        </audio>

                    </div>
                </div>

            </div>

            <!--   Modal footer-->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button>
            </div>

        </div>
    </div>
</div>




<script>

var IS_REQUEST=false;

    $(function() {

        $('#btnDelete').click(function(){
            deleteMent();
        });

        // audio 모달창 닫기 > audio stop
        $('#audioModal').on('hidden.bs.modal', function (e) {
            var audioPlayer = $("#audio_player");
            audioPlayer[0].pause();
            $('source').attr("src","");

        })


    });  //end ready func__-------


    function deleteMent(){

        var cf = confirm('해당 멘트를 삭제하시겠습니까? ');
        if(!cf)
            return false;


        var cmNo = $('#cm_no').val();
        var cmType = $('#cm_type').val();
        var cmIdx = $('#cm_idx').val();


        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.member_ment_delete.php"
        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:{
                'cm_no':cmNo,
                'cm_type':cmType,
                'cm_idx':cmIdx
            },
            success:function(data) {

                console.log(data);

                var obj = data.result_obj;
                var result = data.result_stat;
                if(result){
                    alert(data.result_msg);
                    location.href='./member_ment_list.php';
                } else {
                    alert('*삭제 실패 : \n'+data.result_msg);
                }


            },error : function(xhr, status, error) {
                alert("멘트 삭제시 오류가 발생했습니다. ("+error+")");
            }
        }); //end ajax func ====

    }


    function formSubmit(){

        if(IS_REQUEST){
            alert('처리중입니다. 잠시만 기다려주세요.');
            return false;
        }

        var actionUrl = "<?php echo G5_BBS_URL?>/ajax.member_ment_update.php"

        IS_REQUEST=true;

        $.ajax({
            method: "POST",
            dataType:"json",
            url:actionUrl,
            cache:false,
            data:$('#mentFrm').serialize(),
            success:function(data) {

                IS_REQUEST=false;

                console.log(data);

                var obj = data.result_obj;
                var result = data.result_stat;
                if(result){
                    alert(data.result_msg);
                    location.href='./member_ment_list.php';
                } else {
                    alert(data.result_msg);
                }


            },error : function(xhr, status, error) {
                alert("멘트 설정시 오류가 발생했습니다. ("+error+")");
                IS_REQUEST=false;
            }
        }); //end ajax func ====

        return false;

    } //end func====== =================



    function showAudioModal(ment_name,wav_file){

        $('#audioModal').modal();
        $('#audioModal .card-header').text("멘트 이름  : "+ment_name);

        var wav_path = "/recnas/svcment/"+wav_file;

        var loadUrl = "";
        <?php if(isIOsClient()) { ?>
        loadUrl = "<?php echo G5_BBS_URL;?>/curl.tlog_wav_ios.php?wav_path="+wav_path;
        <?php } else { ?>
        loadUrl = "<?php echo G5_BBS_URL;?>/curl.tlog_wav_android.php?wav_path="+wav_path;
        <?php } ?>

        $('#audio_player > source').attr("src",loadUrl);

        var audioPlayer = $("#audio_player");
        audioPlayer[0].pause();
        audioPlayer[0].load();

    }



</script>