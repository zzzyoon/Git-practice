<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$colspan=7;
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
add_javascript('<script src="'.G5_THEME_JS_URL.'/socket.io.js"></script>', 12);
$rowMaxSeq = "";

?>

<!-- Page Content -->

<div class="section-header page d-none d-md-block">
<h3><?php echo $board['bo_subject'] ?></h3>
</div>

<!-- 게시판 목록 시작 { -->
<div id="bo_list">

    <!-- 게시판 카테고리 시작 { -->
    <?php if ($is_category) { ?>
    <nav id="bo_cate">
        <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <?php } ?>
    <!-- } 게시판 카테고리 끝 -->


    <!-- 검색 영역  {   ----------------------------------------------------------------------------------------------------->
    <div class="d-flex justify-content-end">

        <form name="fsearch" id="fsearch"  method="post" onsubmit="return doSearch()">

            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sop" value="and">


            <input type="hidden"  name="sfl" id="sfl" value="<?=$sfl?>" >
            <input type="hidden"  name="stx" id="stx" value="<?=$stx?>" >


            <div class="form-group d-inline-block w-auto">
                <label for="wr_6" class="sound_only1">처리상태</label>

                <select name="wr_6" id="wr_6" class="form-control input-sm">
                    <option value="">전체</option>
                    <option value="R"<?php echo get_selected($wr_6, 'R'); ?>>대기</option>
                    <option value="E"<?php echo get_selected($wr_6, 'E'); ?>>처리중</option>
                    <option value="F"<?php echo get_selected($wr_6, 'F'); ?>>처리완료</option>
                </select>

            </div>


            <div class="form-group d-inline-block w-auto">
                <label for="sfl" class="sound_only1">검색대상</label>

                <select name="sfl_kwd" id="sfl_kwd" class="form-control input-sm">
                    <option value="wr_subject"<?php echo get_selected($sfl_kwd, 'wr_subject', true); ?>>제목</option>
                    <option value="wr_content"<?php echo get_selected($sfl_kwd, 'wr_content'); ?>>내용</option>
                    <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
                    <option value="mb_id,1"<?php echo get_selected($sfl_kwd, 'mb_id,1'); ?>>회원아이디</option>
                    <option value="mb_id,0"<?php echo get_selected($sfl_kwd, 'mb_id,0'); ?>>회원아이디(코)</option>
                    <option value="wr_name,1"<?php echo get_selected($sfl_kwd, 'wr_name,1'); ?>>글쓴이</option>
                    <option value="wr_name,0"<?php echo get_selected($sfl_kwd, 'wr_name,0'); ?>>글쓴이(코)</option>
                </select>
            </div>


            <div class="form-group  d-inline-block w-auto">
                <label for="stx_kwd" class="sound_only1">검색어<strong class="sound_only"> 필수</strong></label>
                <input type="text" name="stx_kwd" value="<?php echo stripslashes($stx_kwd) ?>"  id="stx_kwd" class="form-control input-sm" maxlength="20">
            </div>


            <button class="btn btn-raised btn-danger" type="submit" id="btn_do_search">
                검색
            </button>

        </form>

    </div>
    <!--    }    검색 영역   ----------------------------------------------------------------------------------------------------->




    <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div class="bo_fx">
        <div class="bo_list_total">
            <span>전체 <?php echo number_format($total_count) ?>건</span>
            /
            <?php echo $page ?> 페이지
        </div>

        <?php if ($rss_href || $write_href) { ?>
        <ul class="btn_bo_user">
<!--            <li><button class="btn btn-raised btn-default btn-sm" data-toggle="modal" data-target="#cm_search_form" alt="검색"><i class="fa fa-search"></i></button></li>-->
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn btn-raised btn-default btn-sm">RSS</a></li><?php } ?>
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn btn-raised btn-info btn-sm"><span style="color: white; ">관리자</span></a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn btn-raised btn-primary btn-sm"><span style="color: white; ">글쓰기</span></a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->




    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <div class="tbl_head01 tbl_wrap">
        <table id="list_table">
        <caption><?php echo $board['bo_subject'] ?> 목록</caption>
        <thead>
        <tr>
            <?php if ($is_checkbox) { ?>
            <th scope="col">
                <label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            </th>
            <?php } ?>
            <th scope="col" class="d-none d-sm-none d-md-table-cell">번호</th>
            <th scope="col">제목</th>

            <th scope="col">상태</th>

            <th scope="col">담당자</th>
            <th scope="col" class="d-none d-sm-none d-md-table-cell"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>등록일자</a></th>
            <th scope="col" class="d-none d-sm-none d-md-table-cell"><?php echo subject_sort_link('wr_8', $qstr2, 1) ?>완료일자</a></th>
            <!-- <th scope="col" class="d-none d-sm-none d-md-table-cell"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회</a></th>-->
            <?php if ($is_good) { ?><th scope="col" class="d-none d-sm-none d-md-table-cell"><?php echo subject_sort_link('wr_good', $qstr2, 1) ?>추천</a></th><?php } ?>
            <?php if ($is_nogood) { ?><th scope="col" class="d-none d-sm-none d-md-table-cell"><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>비추천</a></th><?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $i<count($list); $i++) {

            if(empty($rowMaxSeq))
                $rowMaxSeq = $list[$i]['num'];


            $stat = "";
            $statClass="";
            switch($list[$i]['wr_6']){
                case "R":
                    $stat = "대기";
                    $statClass="bg-primary";
                    break;
                case "E":
                    $stat = "처리중";
                    $statClass="bg-warning";
                    break;
                case "F":
                    $stat = "처리완료";
                    $statClass="bg-danger";
                    break;
            } //end switch__

         ?>
        <tr id="row_<?php echo $list[$i]['wr_id']?>" class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
            <?php if ($is_checkbox) { ?>
            <td class="td_chk">
                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            </td>
            <?php } ?>
            <td class="td_num  d-none d-sm-none d-md-table-cell">
            <?php
            if ($list[$i]['is_notice']) // 공지사항
                echo '<strong>공지</strong>';
            else if ($wr_id == $list[$i]['wr_id'])
                echo "<span class=\"bo_current\">열람중</span>";
            else
                echo $list[$i]['num'];
             ?>
            </td>
            <td class="td_subject">
                <?php
                echo $list[$i]['icon_reply'];
                if ($is_category && $list[$i]['ca_name']) {
                 ?>
                <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
                <?php } ?>

                <a href="<?php echo $list[$i]['href'] ?>">
                    <?php echo $list[$i]['subject'] ?>
                    <?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><span class="cnt_cmt">+<?php echo $list[$i]['comment_cnt']; ?></span><span class="sound_only">개</span><?php } ?>
				<span class="fa-xs">
                <?php
                // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
                // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

                if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
                if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];
                if (isset($list[$i]['icon_file'])) echo $list[$i]['icon_file'];
                if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
                if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];
                ?>

                </span>

            </td>
            <td class="td_name sv_use p-2"><span class="<?php echo $statClass?> rounded-pill px-2 py-1 text-light text-size-3"> <?php echo $stat ?> </span></td>
            <td class="td_name sv_use"><?php echo $list[$i]['name'] ?></td>
            <td class="td_datetime d-none d-sm-none d-md-table-cell"><?php echo wellKnownDatetimeFormat($list[$i]['wr_datetime']) ?></td>
            <td class="td_datetime d-none d-sm-none d-md-table-cell"><?php echo wellKnownDatetimeFormat($list[$i]['wr_8']) ?></td>
            <!-- <td class="td_num d-none d-sm-none d-md-table-cell"><?php echo $list[$i]['wr_hit'] ?></td> -->

            <?php if ($is_good) { ?><td class="td_num d-none d-sm-none d-md-table-cell"><?php echo $list[$i]['wr_good'] ?></td><?php } ?>
            <?php if ($is_nogood) { ?><td class="td_num d-none d-sm-none d-md-table-cell"><?php echo $list[$i]['wr_nogood'] ?></td><?php } ?>
        </tr>

        <?php } ?>

        <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table text-center">게시물이 없습니다.</td></tr>'; } ?>
        </tbody>
        </table>
    </div>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx mt-2">
        <?php if ($is_checkbox) { ?>
        <ul class="btn_bo_adm mb-4">
            <li><button type="submit" name="btn_submit" value="선택삭제" class="btn btn-raised btn-secondary btn-sm" onclick="document.pressed=this.value">선택삭제</button></li>
            <li><button type="submit" name="btn_submit" value="선택복사" class="btn btn-raised btn-secondary btn-sm" onclick="document.pressed=this.value">선택복사</button></li>
            <li><button type="submit" name="btn_submit" value="선택이동" class="btn btn-raised btn-secondary btn-sm" onclick="document.pressed=this.value">선택이동</button></li>
        </ul>
        <?php } ?>

        <ul class="btn_bo_user">
	        <li><button type="button" class="btn btn-raised btn-default btn-sm" data-toggle="modal" data-target="#cm_search_form" alt="검색"><i class="fa fa-search"></i></button></li>
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn btn-raised btn-info btn-sm">관리자</a></li><?php } ?>
            <?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn btn-raised btn-secondary btn-sm">목록</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn btn-raised btn-primary btn-sm">글쓰기</a></li><?php } ?>
        </ul>
    </div>
    <?php } ?>
    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 게시판 검색 시작 { -->
<!-- 페이지 -->
<div class="mb-4">
<?php echo cm_bootstrap_paging($write_pages);  ?>
</div>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>


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


<script>

    var rowSeq ='<?php echo $rowMaxSeq?>';

    if(rowSeq.length == 0)
        rowSeq=0;

    //var socket = io.connect('<?php echo G5_NODE_SERVER_URL?>',{secure:true});
    var socket = io.connect('<?php echo G5_NODE_SERVER_URL?>/article',{secure:true}); //article > namespace 접근
    socket.on('connect', function() {
        console.log('Node Server Connected __-----------');
    });

    socket.on('post',function(data){
//            console.log('received data : ');
//            console.log(data);
        rowSeq++;
        $('#list_table  > tbody > tr:first').before(makeTableRow(rowSeq,data));

    });

    socket.on('delete',function(data){
        $('#row_'+data.wr_id).remove();

    });

    socket.on('update',function(data){
        var tmpSeq = $('#row_'+data.wr_id+' td:first').text();
        console.log("update / seq : "+tmpSeq);

        $('#row_'+data.wr_id).replaceWith(makeTableRow(tmpSeq,data));

    });



    $(function(){

        $('#btn_append').click(function(){
            var data = {};
            data.time =   new Date().toLocaleTimeString();
            $('#list_table > tbody > tr:first').before('<tr><td>안녕 친구들 </td><td>'+data.time+'</td></tr>');
        });

    });




    function makeTableRow(seq,data){

        var row = '<tr id="row_'+data.wr_id+'" class="">' +
            ' <td class="td_num  d-none d-sm-none d-md-table-cell">'+seq+' </td>' +
            ' <td class="td_subject">' +
            '  <a href="/bbs/board.php?bo_table='+data.bo_table+'&amp;sca='+data.ca_name+'" class="bo_cate_link">'+data.ca_name+'</a>' +
            '        <a href="/bbs/board.php?bo_table='+data.bo_table+'&amp;wr_id='+data.wr_id+'">' +
                '    '+data.wr_subject+'  ' +
            '		<span class="fa-xs">   <img src="/theme/munhwa/skin/board/bs4_work_log_r/img/icon_new.gif" class="title_icon" alt="새글">  </span>' +
            ' </a></td>' +
            ' <td class="td_name sv_use p-2"><span class="bg-primary rounded-pill px-2 py-1 text-light text-size-3"> '+data.wr_6_nm+' </span></td>' +
            ' <td class="td_name sv_use"><span class="sv_member">'+data.wr_name+'</span></td>' +
            '        <td class="td_datetime d-none d-sm-none d-md-table-cell">'+data.wr_datetime_w+'</td>' +
            '        <td class="td_datetime d-none d-sm-none d-md-table-cell">'+data.wr_8_w+'</td>' +
            '  </tr>';

        return row;

    } //end func   ============================ ================================ =======================================




    function doSearch(){

        var sfl="";
        var stx="";

        //sfl = "wr_6";
        var wr6 = $('#wr_6 option:selected').val();
        if(wr6.length > 0) {
            sfl="wr_6"
            stx=wr6;
        }


        var sflKwd = $('#sfl_kwd option:selected').val();
        var stxKwd = $('#stx_kwd').val();



        if(stxKwd.length>0){
            if(sfl.length > 0){
                sfl += "||"+sflKwd;
                stx +=" "+stxKwd;
            } else {
                sfl = sflKwd;
                stx = stxKwd;
            }
        }

        $('#fsearch > #sfl').val(sfl);
        $('#fsearch > #stx').val(stx);

       // $('#fsearch').submit();
        return true;

    } //end func ==============



</script>