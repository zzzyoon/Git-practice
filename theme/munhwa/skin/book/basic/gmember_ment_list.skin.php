<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>

<!-- 게시판 목록 시작 { -->
<div id="bo_list">
	
<div class="section-header page d-none d-md-block">
<h3><?php echo $g5['title'] ?></h3>
</div>



    <!-- 공통 멘트 목록   --------------------------------------------------------------------------------------->
    <div class="list-group mt-1">
        <div class="list-group-item list-group-item-secondary">
            *공통 멘트 목록
        </div>
        <div class="list-group-item list-group-item-action">

            <div class="card-columns">
                <?php
                $ments = array_merge(G5_DEFAULT_FWD_MENTS,G5_DEFAULT_RCV_MENTS);
                foreach($ments as $val){

                    $chkId = "chk_".$i;

                    if($val[0] == "71")
                        $cmType = "<button type='button' class='btn btn-sm btn-info rounded-pill' >통화연결</button>";
                    else
                        $cmType = "<button type='button' class='btn btn-sm btn-warning rounded-pill' >통화대기</button>";

                    ?>

                    <div class="card">
                        <div class="card-body">
                            <?php echo $cmType?>

                                <?php echo $val[1]; ?>


                            <a class="text-secondary pull-right" href="javascript:showAudioModal('<?=$val[1]?>','<?=$val[2]?>')"><i class="fas fa-volume-up"></i></a>
                        </div>

                    </div>
                    <?php
                } // end for_________________
                ?>



            </div>

        </div>

    </div>

    <div>&nbsp;</div>

    <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div id="bo_btn_top" class="d-block">
        <div class="bo_list_total">
            <span>전체 <?php echo number_format($total_count) ?>건</span>
        </div>
    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->


    <!-- 학교 멘트 목록    ------------------------------------------------------------------------------------------------>
    <form name="fqalist" id="fqalist" action=""  method="post">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="sca" value="<?php echo $sca; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">

        <div class="list-group">
            <div class="list-group-item list-group-item-primary font-weight-bold">
                *학교 멘트 목록
            </div>
        <div class="list-group-item list-group-item-action">
            <div class="card-columns">

            <?php
            for ($i=0; $i<count($list); $i++) {
                $chkId = "chk_".$i;

                if($list[$i]['cm_type'] == "1")
                    $cmType = "<button type='button' class='btn btn-sm btn-info rounded-pill' >통화연결</button>";
                else
                    $cmType = "<button type='button' class='btn btn-sm btn-warning rounded-pill' >통화대기</button>";
                ?>


                <div class="card">
                    <div class="card-header">
                        <?php echo $cmType?>


                        <a href="<?=$list[$i]['view_href']?>" >
                        <?php echo $list[$i]['cm_name']; ?>
                        </a>


                    </div>
                    <div class="card-body  p-3">
                        <p class="card-text text-center mt-1">
                            <a href="javascript:showAudioModal('<?=$list[$i]['cm_name']?>','<?=$list[$i]['cm_filename']?>')" class="btn btn-sm text-secondary">* 멘트듣기 <i class="fas fa-volume-up  text-secondary"></i></a>
                            <p class="text-center">
                             <?php echo $list[$i]['cm_datetime']; ?>
                            </p>
                        </p>
                    </div>

                </div>
                <?php
            } // end for_________________
            ?>

        </div>
        </div>


        <?php if ($i == 0) { echo '
              <div class="alert alert-info p-4 text-center">
                      *멘트 정보가 존재하지 않습니다.
              </div>';
        } ?>

            <div class="text-right m-2">
                <a  href="<?=$write_href?>"  class="btn btn-primary text-light" ><i class="fas fa-plus-square"></i> 멘트 추가 </a>
            </div>


        </div>

    </form>
</div>


<!-- 게시판 검색 시작 { -->
<!-- 페이지 -->
<div class="mb-4">
<?php echo cm_bootstrap_paging($write_pages);  ?>
</div>


<!-- 검색 Modal ---------------------------------------------------------------------------------------------------->
<div class="modal fade" id="cm_search_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo $board['bo_subject']; ?> 검색
                </h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">


                <form name="fsearch" method="get">
                    <input type="hidden" name="sca" value="<?php echo $sca ?>">
                    <div class="form-group">
                        <label for="stx" class="sound_only1">검색어<strong class="sound_only"> 필수</strong></label>
                        <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="form-control input-sm" maxlength="20">
                    </div>

                    <button class="btn btn-raised btn-danger" type="submit">
                        검색
                    </button>

                </form>

                <?php if(0) { ?>
                    <form name="fsearch" method="get">
                        <input type="hidden" name="sca" value="<?php echo $sca ?>">
                        <div class="input-group">

                            <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
                            <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="form-control input-sm" maxlength="20">
                            <button class="btn btn-danger" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>

                        </div>
                    </form>
                <?php } ?>
            </div>

        </div>
    </div>
</div>
<!-- } 게시판 검색 끝 -->



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




<!-- 페이지 -->
<?php echo $list_pages;  ?>



<script>

$(function(){
    // audio 모달창 닫기 > audio stop
    $('#audioModal').on('hidden.bs.modal', function (e) {
        var audioPlayer = $("#audio_player");
        audioPlayer[0].pause();
        $('source').attr("src","");

    })
});

function all_checked(sw) {
    var f = document.fqalist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]")
            f.elements[i].checked = sw;
    }
}


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


<?php
function cm_bootstrap_paging($pagelist)
{
    $pagelist = str_replace('<nav class="pg_wrap"><span class="pg">', '<div class="text-center"><ul class="pagination justify-content-center">', $pagelist);
    $pagelist = str_replace('</span></nav>', '</ul></div>', $pagelist);
    $pagelist = str_replace('<a', '<li class="page-item"><a class="page-link"', $pagelist);
    $pagelist = str_replace('</a>', '</a></li>', $pagelist);
    $pagelist = str_replace(' class="pg_page"', '', $pagelist);
    $pagelist = preg_replace('/(<span[^\>]*>(.*?)<\/span>)/', '', $pagelist);
    $pagelist = preg_replace('/( class="pg_page [^"]+")/', '', $pagelist);
    $pagelist = preg_replace('/(<strong[^\>]*>(.*?)<\/strong>)/', '<li class="page-item active"><a class="page-link">\2</a></li>', $pagelist);
    return $pagelist;
}
?>

<!-- } 게시판 목록 끝 -->