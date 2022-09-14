<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_path.'/style.css">', 0);
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

     <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div id="bo_btn_top">
        <div id="bo_list_total">
            <span>전체: <?php echo number_format($total_count) ?>건</span>
        </div>
    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->


    <!----------   학교(단체) 휴식시간  리스트  ----------------------------------------------------------------------------------------------->

    <?php if(count($slist) > 0) { ?>

    <ul class="list-group mt-1">
        <li class="list-group-item list-group-item-secondary">*학교 추가시간 목록 (참고)</li>
        <li class="list-group-item">

            <div class="card-columns">

                <?php
                for ($i=0; $i<count($slist); $i++) {
                    $chkId = "chk_".$i;
                    $restTime = $slist[$i]['rm_start_time']." - ".$slist[$i]['rm_end_time'];
                    $wellDaysName = wellKnownDaysName($slist[$i]['rm_days']);


                    // 상태
                    if($slist[$i]['rm_stat'] == "Y")
                        $restStat = "<button type='button' class='btn btn-sm btn-warning rounded-pill' >On</button>";
                    else
                        $restStat = "<button type='button' class='btn btn-sm btn-secondary rounded-pill' >Off</button>";

                    ?>
                    <div class="card">
                        <div class="card-header">

                            <?=$restStat?>
                            <strong>
                                <a  href="#" onclick="alert('학교 추가시간 정보는 수정할 수 없습니다.')" class="text-primary" ><?php echo $slist[$i]['rm_name']?></a>
                            </strong>


                        </div>
                        <div class="card-body  p-3">
                            <h5 class="card-title text-center mt-1">시간: <?php echo $restTime; ?></h5>
                            <p class="card-text text-center mt-1">요일: <?php echo $wellDaysName; ?></p>
                        </div>
                    </div>
                    <?php
                } // end for_________________
                ?>

            </div>



        </li>
    </ul>


    <div>&nbsp;</div>

    <?php } // 학교휴식사간 __________  ?>

    <!----------   개인 휴식시간  리스트  ----------------------------------------------------------------------------------------------->
    <form name="rtFrm" id="rtFrm" action=""  method="post">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="sca" value="<?php echo $sca; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">


        <div class="list-group">
            <div class="list-group-item list-group-item-primary font-weight-bold">
                *개인 추가시간 목록
            </div>
            <div class="list-group-item list-group-item-action">



        <div class="card-columns">

            <?php
            for ($i=0; $i<count($list); $i++) {
                $chkId = "chk_".$i;
                $restTime = $list[$i]['rm_start_time']." - ".$list[$i]['rm_end_time'];

                $mentName = sql_result("select cm_name from {$g5['call_ment']} where mb_id = '{$member['mb_id']}'  and cm_idx = '{$list[$i]['rm_ment_idx']}' ");
                $wellDaysName = wellKnownDaysName($list[$i]['rm_days']);


                // 상태
                if($list[$i]['rm_stat'] == "Y")
                    $restStat = "<button type='button' class='btn btn-sm btn-warning rounded-pill' >On</button>";
                else
                    $restStat = "<button type='button' class='btn btn-sm btn-secondary rounded-pill' >Off</button>";

                ?>
                <div class="card">
                    <div class="card-header">

                        <?=$restStat?>
                        <strong>
                        <a href='./member_resttime_form.php?rm_no=<?=$list[$i]['rm_no']?>' class="" ><?php echo $list[$i]['rm_name']?></a>
                        </strong>
                        &nbsp;
                        <i class="fas fa-clock"></i> <?php echo $list[$i]['rm_datetime']; ?>

                    </div>
                    <div class="card-body  p-3">
                        <h5 class="card-title text-center mt-1">시간: <?php echo $restTime; ?></h5>
                        <p class="card-text text-center mt-1">요일: <?php echo $wellDaysName; ?></p>
                    </div>
                    <div class="card-footer small text-center">
                        (* 멘트 : <?=$mentName?>)
                    </div>
                </div>
                <?php
            } // end for_________________
            ?>

        </div>


        <?php if ($i == 0) { echo '
              <div class="alert alert-info p-4 text-center">

                      *설정 정보가 존재하지 않습니다.
              </div>';
        } ?>



            </div>
        </div>



        <div class="text-right mt-2">
            <a  href="<?=$write_href?>"  class="btn btn-primary text-light" ><i class="fas fa-plus-square"></i> 설정 추가 </a>
        </div>

    </form>
</div>


<!-- 게시판 검색 시작 { -->
<!-- 페이지 -->
<div class="mb-4">
<?php echo cm_bootstrap_paging($write_pages);  ?>
</div>

<!-- Modal -->
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

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $list_pages;  ?>


<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fqalist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]")
            f.elements[i].checked = sw;
    }
}

function fqalist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다"))
            return false;
    }

    return true;
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