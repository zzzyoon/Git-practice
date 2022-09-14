<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$filePath = dirname(__FILE__);

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');


if(!isCSMember()){
    //티처콜 사이트 head.php /////////////////////////////////////////////////////////
    // 통신이용 증명원 게시판이 , 학교회원과 공용으로 사용하고 있어서 ~ bo_table=certi
    include_once(G5_BBS_PATH.'/_head.php');
} else {
    //cs 관리자 head_cs.php ////////////////////////////////////////////////////////////
?>

<!-- 상단 시작 { -->
<h1 id="hd_h1"><?php echo $g5['title'] ?></h1>
<div id="skip_to_container"><a href="#container">본문 바로가기</a></div>
<div id="hd_wrapper"></div>

<!-- Navigation -->
<nav class="navbar fixed-top navbar-dark bg-dark p-0" >

      <!-- logo img -->
        <div class="p-2">

            <a class="navbar-brand" href="<?php echo G5_URL ?>"><img  srcset="<?php echo G5_THEME_URL ?>/img/web_top_logo_en.png,
           <?php echo G5_THEME_URL ?>/img/web_top_logo_en_2x.png 2x"  src="<?php echo G5_THEME_URL ?>/img/web_top_logo_en.png">
            </a>

        </div>

        <div class="p-2">
            <button type="button" class="btn btn-sm btn-outline-light rounded-pill">
                <i class="fas fa-user-circle"></i>
                <strong><?=$member['mb_name']?></strong>님 로그인 중</button>
        </div>


        <div class="p-2">
            <?php if(!isContains("cs_bbs",$bo_table)) { ?>
                <a href="/bbs/board.php?bo_table=cs_bbs" target="_blank" class="btn btn-sm btn-warning text-size-4" >상담 게시판</a>
            <?php }  ?>

            <?php if(!isContains("cs_doc",$bo_table)) {?>
                 <a href="/bbs/board.php?bo_table=cs_doc" target="_blank" class="btn btn-sm btn-info text-size-4" >신청서 게시판</a>
            <?php } ?>

            <?php if(!isContains("certi",$bo_table)) {?>
                <a href="/bbs/board.php?bo_table=certi" target="_blank" class="btn btn-sm btn-success text-size-4" >통신증명원 게시판</a>
            <?php } ?>

            <a href="https://teachercall.kr" target="_blank" class="btn btn-sm btn-light text-size-4" >티처콜 링크</a>
            <a href="https://center-pf.kakao.com/_jKMGK/chats" target="_blank" class="btn btn-sm btn-light text-size-4" >KAKAO 고객센터</a>


        </div>
        <div class="p-2">


            <a href="/adm" target="_blank" class="btn btn-sm btn-outline-light rounded-circle text-light"><i class="fas fa-cog"></i></a>
            <a  href="/adm/member_list.php" target="_blank" class="btn btn-sm btn-outline-info rounded-circle text-info"><i class="fas fa-users-cog"></i></a>
            <a  href="/adm/member_grp_list.php" target="_blank"class="btn btn-sm btn-outline-primary rounded-circle text-primary"><i class="fas fa-school"></i></a>
            <a  href="/adm/member_grp_pg_list.php" target="_blank" class="btn btn-sm btn-outline-danger rounded-circle text-danger"><i class="far fa-credit-card"></i></a>
            <a  href="/bbs/logout.php" class="btn btn-sm btn-outline-secondary rounded-circle text-secondary"> <i class="fas fa-sign-out-alt"></i></a>


<!--            <h3 class="d-inline-block ml-2">Customer Center</h3>-->
        </div>



</nav>



<?php if (!defined("_INDEX_")) { ?>
<div>&nbsp;</div>
<?php }?>



<? } ?>

<!-- } 상단 끝 -->
