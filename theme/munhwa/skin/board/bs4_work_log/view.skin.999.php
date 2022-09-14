<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
include_once(G5_LIB_PATH.'/thumbnail.lib.php');


$workStat = "";
switch($view['wr_6']){
    case "R":
        $workStat = "대기";
        break;
    case "E":
        $workStat = "처리중";
        break;
    case "F":
        $workStat = "처리완료";
        break;
} //end switch__


if($view['wr_6'] == "F" && $view['wr_7']){
    $mb = get_member($view['wr_7']);
    $view['wr_7_nm']=$mb['mb_name'];

}

?>

<!-- Page Content -->
<div class="section-header page d-none d-md-block">
<h3><?php echo $board['bo_subject'] ?></h3>
</div>

<!-- 확대/축소 시 이미지가 화면에 꽉 차는 현상을 제거하기 위해 주석 처리함 -->
<!-- <script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script> -->

<!-- 게시물 읽기 시작 { -->

<article id="bo_v" style="width:<?php echo $width; ?>">
    <header>
        <h1 id="bo_v_title">
            <?php
            if ($category_name) echo '<span class="btn btn-sm btn-danger rounded-pill px-2">'.$view['ca_name'].' </span> '; // 분류 출력 끝
            echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
            ?>
        </h1>
    </header>



    <section id="bo_v_info">
        <h2>페이지 정보</h2>
        작성자 <strong><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></strong>
        <span class="sound_only">작성일</span><strong class="badge badge-secondary badge-pill"><?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></strong>
        조회<strong class="badge badge-secondary badge-pill" ><?php echo number_format($view['wr_hit']) ?>회</strong>
        댓글<strong class="badge badge-secondary badge-pill" ><?php echo number_format($view['wr_comment']) ?>건</strong>
    </section>

    <div class="row my-3 justify-content-end ">

        <?php if($view['wr_6'] == "F") {?>
            <div class="col-6 col-md-2 text-right  p-2">
                <span class="font-weight-bold">처리상태</span> <span class="btn btn-sm btn-primary rounded px-2"> <?php echo $workStat?></span>
            </div>
        <?php } else { ?>
            <div class="col-6 col-md-4 text-right p-2 form-group label-floating">
                <label for="wr_6">상태</label>
                <!-- Group Button   -->
                <div id="wr_6" class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">

                    <label class="btn btn-primary active">
                        <input type="radio" name="wr_6" id="wr_6_0" autocomplete="off" checked value="R"> 대기
                    </label>

                    <label class="btn btn-primary">
                        <input type="radio" name="wr_6" id="wr_6_1" autocomplete="off" value="E">처리중
                    </label>

                    <label class="btn btn-primary">
                        <input type="radio" name="wr_6" id="wr_6_2" autocomplete="off" value="F">처리완료
                    </label>

                </div>
            </div>

        <?php } ?>

        <div class="col-6 col-md-2 text-right p-2">
            완료 담당자
            <?php if($view['wr_7_nm']) { ?>
                <span class="btn btn-sm btn-primary rounded px-2"> <?php echo $view['wr_7_nm']?></span>
            <?php } else { ?>
                <span id="wr_7_nm" class="btn btn-sm btn-secondary rounded px-2"> _ _ _  </span>
            <?php  } ?>
        </div>
        <div class="col-md-3 text-right  p-2">
            완료 시간
            <?php if($view['wr_8']) { ?>
             <span class="btn btn-sm btn-primary rounded px-2"> <?php echo $view['wr_8']?></span>
            <?php } else { ?>
                <span class="btn btn-sm btn-secondary rounded px-2" id="wr_8"> 0000-00-00 00:00:00 </span>
            <?php } ?>
         </div>


    </div>


    <hr>

    <div class="row mt-3">
        <div class="col-md-6 form-group label-floating">
            <label for="wr_1_nm" class="font-weight-bold">학교</label>

            <input type="hidden" name="wr_1" id="wr_1" value="<?php echo $write['wr_1'] ?>" >
            <input type="text" name="wr_1_nm" value="<?php echo $write['wr_1_nm'] ?>" id="wr_1_nm" readonly class="form-control readonly font-weight-bold" placeholder="">

        </div>


        <div class="col-md-6 form-group label-floating">
            <label class="control-label" for="wr_2">거래처명</label>
            <input type="text" class="form-control readonly" readonly name="wr_2" id="wr_2" placeholder="" value="<?php echo $write['wr_2'] ?>">
        </div>


    </div>

    <div class="row">
        <div class="col-md-4 form-group label-floating">
            <label class="control-label font-weight-bold" for="wr_3">고객명</label>
            <input type="text" class="form-control readonly font-weight-bold" readonly name="wr_3" id="wr_3" value="<?php echo $write['wr_3'] ?>">
        </div>


        <div class="col-md-4 label-floating">
            <label class="control-label font-weight-bold" for="wr_4">전화번호</label>
            <input type="text" class="form-control readonly font-weight-bold" readonly name="wr_4" id="wr_4" value="<?php echo phoneNumberFormat($write['wr_4']); ?>">
        </div>

        <div class="col-md-4 form-group label-floating">
            <label class="control-label" for="wr_5">기타 전화번호(참고용)</label>
            <input type="text" class="form-control readonly"  readonly  name="wr_5" id="wr_5" value="<?php echo phoneNumberFormat($write['wr_5']); ?>">
        </div>

    </div>




    <?php

    if ($view['file']['count']) {
        $cnt = 0;
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
     ?>

    <?php if($cnt) { ?>
    <!-- 첨부파일 시작 { -->
    <section id="bo_v_file">
        <h2>첨부파일</h2>
        <ul>
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
            <li>
                <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                    <img src="<?php echo $board_skin_url ?>/img/icon_file.gif" alt="첨부">
                    <strong><?php echo $view['file'][$i]['source'] ?></strong>
                    <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                </a>
                <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드</span>
                <span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php
    if(isset($view['link'][1]) && $view['link'][1]) {
     ?>
     <!-- 관련링크 시작 { -->
    <section id="bo_v_link">
        <h2>관련링크</h2>
        <ul>
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
         ?>
            <li>
                <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                    <img src="<?php echo $board_skin_url ?>/img/icon_link.gif" alt="관련링크">
                    <strong><?php echo $link ?></strong>
                </a>
                <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <!-- } 관련링크 끝 -->
    <?php } ?>



    <!-- 게시물 상단 버튼 시작 { -->
    <div id="bo_v_top">
        <?php
        ob_start();
         ?>
        <?php if ($prev_href || $next_href) { ?>
        <ul class="bo_v_nb">
            <?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?>" class="btn btn-raised btn-dark btn-sm text-light">이전글</a></li><?php } ?>
            <?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>" class="btn btn-raised btn-dark btn-sm text-light">다음글</a></li><?php } ?>
        </ul>
        <?php } ?>

        <ul class="bo_v_com">
            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn btn-raised btn-secondary btn-sm text-light">수정</a></li><?php } ?>
            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;" class="btn btn-raised btn-warning btn-sm text-light">삭제</a></li><?php } ?>
            <?php if ($copy_href) { ?><li><a href="<?php echo $copy_href ?>" onclick="board_move(this.href); return false;" class="btn btn-raised btn-secondary btn-sm text-light">복사</a></li><?php } ?>
            <?php if ($move_href) { ?><li><a href="<?php echo $move_href ?>" onclick="board_move(this.href); return false;" class="btn btn-raised btn-secondary btn-sm text-light">이동</a></li><?php } ?>
            <?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>" class="btn btn-raised btn-secondary btn-sm text-light">검색</a></li><?php } ?>
            <li><a href="<?php echo $list_href ?>" class="btn btn-raised btn-secondary btn-sm text-light">목록</a></li>
            <?php  if ($reply_href) { ?>
                <!-- <li><a href="<?php echo $reply_href ?>" class="btn btn-raised btn-secondary btn-sm text-light">답변</a></li> -->
            <?php  } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn btn-raised btn-primary btn-sm"><span style="color: white">글쓰기</span></a></li><?php } ?>
        </ul>

        <?php
        $link_buttons = ob_get_contents();
        //ob_end_flush(); // 코멘트 아래만 버튼 보이게 , 함수 변경

        //bylee
        ob_end_clean();
         ?>


    </div>
    <!-- } 게시물 상단 버튼 끝 -->


    <hr>

    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title">본문</h2>

        <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    //echo $view['file'][$i]['view'];
                    echo get_view_thumbnail($view['file'][$i]['view']);
                }
            }

            echo "</div>\n";
        }
         ?>

        <!-- 본문 내용 시작 { -->
        <div class="row my-4">

            <div  class="col-md-6">
                <div class="border border-secondary rounded p-1 m-1" >
                    <label class="control-label">문의 내용 : </label>
                    <br>
                    <?php echo nl2br(get_view_thumbnail($view['content'])); ?>
                </div>
            </div>

            <div  class="col-md-6">
                <div class=" border border-success rounded p-1 m-0 font-weight-bold">
                    <label class="control-label" >처리 내용 : </label>
                    <br>
                    <?php if($view['wr_6'] != 'F'){ ?>
                        <form name="wr10Frm" id="wr10Frm" method="post">
                            <input type="hidden" name="wr_id" value="<?php echo $wr_id?>" >
                            <input type="hidden" name="bo_table" value="<?php echo $bo_table?>" >

                        <textarea id="wr_10" name="wr_10" class="form-control rounded-1 mb-2 bg-gray-0"  rows="10" style="width:100%;height:300px"><?php echo $view['wr_10'];?></textarea>

                        <button type="button" id="btnResMody" class="btn btn-sm btn-info" >수정</button>
                        </form>
                    <?php } else { ?>
                    <?php echo nl2br($view['wr_10']);?>
                    <?php } ?>
                </div>
            </div>

        </div>

        <?php//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
        <!-- } 본문 내용 끝 -->

        <hr>


        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>

        <!-- 스크랩 추천 비추천 시작 { -->
        <?php if ($scrap_href || $good_href || $nogood_href) { ?>
        <div id="bo_v_act">
            <?php if ($scrap_href) { ?><a href="<?php echo $scrap_href;  ?>" target="_blank" class="btn btn-raised btn-secondary btn-sm" onclick="win_scrap(this.href); return false;">스크랩</a><?php } ?>
            <?php if ($good_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="btn btn-raised btn-success btn-sm">추천 <strong><?php echo number_format($view['wr_good']) ?></strong></a>
                <b id="bo_v_act_good"></b>
            </span>
            <?php } ?>
            <?php if ($nogood_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="btn btn-raised btn-success btn-sm">비추천  <strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                <b id="bo_v_act_nogood"></b>
            </span>
            <?php } ?>
        </div>
        <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
        <div id="bo_v_act">
            <?php if($board['bo_use_good']) { ?><span>추천 <strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
            <?php if($board['bo_use_nogood']) { ?><span>비추천 <strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
        </div>
        <?php
            }
        }
        ?>
        <!-- } 스크랩 추천 비추천 끝 -->
    </section>



    <?php
    include_once(G5_SNS_PATH."/view.sns.skin.php");
    ?>

    <?php
    // 코멘트 입출력
    include_once(G5_BBS_PATH.'/view_comment.php');
     ?>

    <!-- 링크 버튼 시작 { -->
    <div id="bo_v_bot">
        <?php echo $link_buttons ?>
    </div>
    <!-- } 링크 버튼 끝 -->


</article>
<!-- } 게시판 읽기 끝 -->


<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    // 확대/축소 시 이미지가 화면에 꽉 차는 현상을 제거하기 위해 주석 처리함
    // $("#bo_v_atc").viewimageresize();


    $('#btnResMody').click(function(){
        updateWr10();
    });

    $('#wr_6 :input').change(function(){

        var type = $(this).val();
        //alert(type);
        updateWr6();

    });

});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}


//bylee 처리 내용
function updateWr10(){

    var actionUrl = '/bbs/ajax.bbs_wr10_update.php';

    $.post(actionUrl,$('#wr10Frm').serialize(),function(json){

        if(json.result_stat) {
         //   $('#btnResMody').hide();

        }

        alert(json.result_msg);

    },'json');

} //end func ===============

//처리 상태
function updateWr6(){

    var wrId = '<?php echo $wr_id?>';
    var boTable = '<?php echo $bo_table?>';

    var wr6 = $(':radio[name=wr_6]:checked').val();

    var actionUrl = '/bbs/ajax.bbs_wr06_update.php';


    $.getJSON(actionUrl,{'wr_id':wrId,'bo_table':boTable,'wr_6':wr6},function(json){

        //console.log(json);

        if(json.result_stat){


            if(json.wr_6 == "F") {
                $('#wr_7_nm').text(json.wr_7_nm);
                $('#wr_8').text(json.wr_8);
                $('#btnResMody').hide();
            }

        } else {
            alert(json.result_msg);
        }



    });


} //end func ======================================

</script>

<!-- } 게시글 읽기 끝 -->
