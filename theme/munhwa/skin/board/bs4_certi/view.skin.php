<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

$fileCnt = $view['file']['count'];
//echoBox($fileCnt);
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
//echoVarDump($view['file']);



// g5_member_group
if($fileCnt > 0){
    sql_query("update {$g5['member_group_table']} set  mg_have_certi = 1, mg_certi_datetime = sysdate()  where mg_no = '{$member['mg_no']}' and mg_have_certi = '0' ");
} else {
    $sql = "update {$g5['member_group_table']} set  mg_have_certi = 0  where mg_no = '{$member['mg_no']}'  ";

    sql_query($sql);
}


//분류 - 관리자  등록 확인과정을 분류값을 이용
if ($is_category) {
    $ca_name = "";
    if (isset($view['ca_name']))
        $ca_name = $view['ca_name'];
    $category_option = get_category_option_bs($ca_name,"btn-danger");
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
            if ($category_name) echo $view['ca_name'].' | '; // 분류 출력 끝
            echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
            ?>
        </h1>
    </header>

    <section id="bo_v_info">
        <div class="row" >
        <div class="col-md-6">

        *제출일자 :  <strong class="font-weight-bold"><?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></strong>

        </div>

        <?php if (isCSMember() && $is_category) { ?>


            <div class="col-md-6 form-group label-floating text-center">

                <?php if(!$view['wr_2']) { ?>
                <label for="ca_name">*CS 관리자 확인 : </label>

                    <!-- Group Button   -->
                    <div id="ca_name" class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">

                        <?php   echo $category_option ?>

                    </div>

                <?php } else {?>
                    <label for="ca_name" class="text-info">*CS 확인담당자 : </label>
                    <strong class="bg-primary px-2 py-1 rounded-pill text-light"><?php echo get_member($write['wr_2'])['mb_name'];?></strong> /
                    <?php echo wellKnownDatetimeFormat($write['wr_3']);?>
                <?php } ?>
            </div>



        <?php } ?>

        </div>
    </section>


    <?php
    $cnt = 0;
    if ($view['file']['count']) {
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
                            <i class="fa fa-download" aria-hidden="true"></i>
                            <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                                <strong><?php echo $view['file'][$i]['source'] ?></strong>
                            </a>
                            <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                            <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드 | DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </section>
        <!-- } 첨부파일 끝 -->
    <?php } ?>



    <?php if($fileCnt == 0) { ?>
        <section class="mt-4 d-flex justify-content-center py-4">

            <div class="alert alert-info rounded-pill text-center align-middle px-3  pt-3 d-inline">

                <h4>* 아래의 제출하기를 눌러, "통신이용 증명원"을 제출해주세요. </h4>

            </div>

        </section>
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

        $btnLabel = "수정하기";
        if($fileCnt == 0)
            $btnLabel = "제출하기";

        ob_start();
         ?>


        <ul class="bo_v_com">
            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn btn-raised btn-info btn-sm">
                    <i class="fas fa-edit"></i>
                    <?php echo $btnLabel?></a></li>
            <?php } ?>



            <?php if (isCSMember()) { ?>
                <?php if($delete_href) { ?>
                   <li><a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;" class="btn btn-raised btn-secondary btn-sm">삭제</a></li>
                <?php }?>
                <li><a href="<?php echo $list_href ?>" class="btn btn-raised btn-secondary btn-sm">목록</a></li>
            <?php } ?>

            <!--
            <?php if ($copy_href) { ?><li><a href="<?php echo $copy_href ?>" onclick="board_move(this.href); return false;" class="btn btn-raised btn-secondary btn-sm">복사</a></li><?php } ?>
            <?php if ($move_href) { ?><li><a href="<?php echo $move_href ?>" onclick="board_move(this.href); return false;" class="btn btn-raised btn-secondary btn-sm">이동</a></li><?php } ?>


            <?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>" class="btn btn-raised btn-secondary btn-sm">검색</a></li><?php } ?>
            <li><a href="<?php echo $list_href ?>" class="btn btn-raised btn-secondary btn-sm">목록</a></li>
            <?php if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>" class="btn btn-raised btn-secondary btn-sm">답변</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn btn-raised btn-primary btn-sm"><span style="color: white">글쓰기</span></a></li><?php } ?>

              -->
        </ul>
        <?php
        $link_buttons = ob_get_contents();
        //ob_end_flush();
        ob_end_clean();
         ?>
    </div>
    <!-- } 게시물 상단 버튼 끝 -->

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
    //include_once(G5_SNS_PATH."/view.sns.skin.php");
    ?>

    <?php
    // 코멘트 입출력
    //include_once(G5_BBS_PATH.'/view_comment.php');
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


    $('#ca_name :input').change(function(){

        var ca_name = $(this).val();
        //alert(ca_name);
        updateCategory();

    });


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
});



// 분류명 비동기 수정 ////////////////////////////////////////////
function updateCategory(){

    var wrId = '<?php echo $wr_id?>';
    var boTable = '<?php echo $bo_table?>';

    var caName = $(':radio[name=ca_name]:checked').val();

    var actionUrl = '/bbs/ajax.bbs_category_update.php';


    $.getJSON(actionUrl,{'wr_id':wrId,'bo_table':boTable,'ca_name':caName},function(json){


           alert(json.result_msg);


    });


} //end func ======================================


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
</script>

<!-- } 게시글 읽기 끝 -->
