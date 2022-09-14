<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
$menus = array();
?>
<!-- 상단 시작 { -->
<h1 id="hd_h1"><?php echo $g5['title'] ?></h1>
<div id="skip_to_container"><a href="#container">본문 바로가기</a></div>


<div id="hd_wrapper"></div>    

<!-- Navigation -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
      <div class="container">

          <!-- logo img -->
          <?php if($_SERVER['PHP_SELF']=="/index.php" || $_SERVER['PHP_SELF']=="/bbs/login.php"  || (!is_mobile() && !isAppClient() ) ) { //!is_mobile() ?>
              <a class="navbar-brand" href="<?php echo G5_URL ?>"><img  srcset="<?php echo G5_THEME_URL ?>/img/top_logo.png,
               <?php echo G5_THEME_URL ?>/img/top_logo_2x.png 2x"  src="<?php echo G5_THEME_URL ?>/img/top_logo.png">
              </a>
          <?php } else { ?>
              <!-- sub page / backword & logo -->
              <a class="navbar-brand d-flex align-items-center align-middle" href="javascript:historyGoBack(<?=(isAndroidAppClient())?"true":"false"?>,'<?=getHistoryBackCount()?>');">
                  <i class="fas fa-chevron-left" style="font-size: 1.4em; color:#71757f;"></i>
                  <?php if($g5['title'] || $board['bo_subject']) { ?>
                      <!-- subpage title  -->
                      <span class="text-h-5 text-light mx-2" style="color:#b8b8b8 !important;"><?=($board['bo_subject'])?$board['bo_subject']:$g5['title']?></span>
                  <?php } else { ?>
                      <!-- logo image -->
                      <img  class="ml-1 img-btn" srcset="<?php echo G5_THEME_URL ?>/img/web_top_txt_en.png,
                <?php echo G5_THEME_URL ?>/img/web_top_txt_en_2x.png 2x"  src="<?php echo G5_THEME_URL ?>/img/web_top_txt_en.png">

                  <?php }?>
              </a>
          <?php } ?>


          <span class="bg-light border py-0 px-2 rounded-pill d-inline-block ">
              <?php if($DefJgGubun == "CAPO"){ ?>
                  <i class="fas fa-info-circle"></i> (주)카포
              <?php } else if($DefJgGubun == "UCAPO") { ?>
                  <i class="fas fa-info-circle"></i> (유)카포
              <?php } ?>
          </span>


          <?php if(isLogined()) { ?>
              <button class="navbar-toggler" type="button" data-toggle="modal" data-target="#mobileMenu" aria-controls="mobileMenu" aria-expanded="false">
                  <span class="navbar-toggler-icon"></span>
              </button>
          <?php } ?>



        <!-- mobile collapse 메뉴  {  ------------------------------------------------------------------------------------------>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto navbar-right">

                <!----- 로그인 사용자 정보   {      ------------------------------------------------------>
                <?php if($_SESSION["ss_mb_id"]) {?>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:showUserDlg()">
                         <span class=" badge badge-secondary"> <i class='fas fa-info-circle'></i>  <?php echo $member['mb_name']?>님 접속중~</span>
                        </a>
                    </li>
                <?php } ?>
                <!------------------------     }     로그인 사용자 정보    ------------------------------------------------------>



            <?php if ($is_member) { ?>
            <!-----------------     마이메뉴      ------------------------------------------------------------------------------------------------>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-user-circle"></i>
                 마이메뉴
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">

<!--				<a class="dropdown-item" href="--><?php //echo G5_BBS_URL ?><!--/memo.php" target="_blank"><i class="far fa-envelope" aria-hidden="true"></i><span> 쪽지</span></a>-->
            	<a class="dropdown-item" href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php"><i class="fas fa-user-edit"></i> 개인정보 수정</a>

                  <?php if ($is_admin) { ?>
                      <a class="dropdown-item" href="<?php echo G5_BBS_URL ?>/current_connect.php"><i class="fa fa-users" aria-hidden="true"></i><span> 접속자</span><strong class="visit-num"><?php echo connect('theme/basic'); // 현재 접속자수, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정  ?></strong></a>

                      <a class="dropdown-item" href="<?php echo G5_BBS_URL ?>/faq.php"><i class="fa fa-question" aria-hidden="true"></i><span> FAQ</span></a>
                      <a class="dropdown-item text-danger" href="<?php echo G5_ADMIN_URL ?>"><b><i class="fas fa-user-shield"></i> 관리자</b></a>

                  <?php } else if(isMgrMember($member['mb_level'])){ ?>
                      <!--       관리자 > 관리자권한설정 등록된 회원/ 관리자 접근 메뉴 보이기   -->
                      <a class="dropdown-item text-danger" href="<?php echo G5_ADMIN_URL ?>"><b><i class="fas fa-user-shield"></i> 관리자</b></a>
                  <?php } ?>
              </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo G5_BBS_URL ?>/logout.php"><i class="fas fa-sign-out-alt" aria-hidden="true"></i> <u>로그아웃</u></a>
            </li>


            <?php } else {  ?>


                <!--
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo G5_BBS_URL ?>/login.php" target="_self"><i class="fas fa-sign-in-alt" aria-hidden="true"></i> 로그인</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo G5_BBS_URL ?>//content.php?co_id=join" target="_self"><i class="fas fa-user-plus"></i> 회원가입</a>
                    </li>
                    -->

            <?php }  ?>

                <?php if($client_type == "android"){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="app://application.exit" target="_self"><i class="fas fa-times-circle"></i></i> 어플 종료하기</a>
                    </li>
                <?php }?>

            </ul>
        </div>

          <!----------------      }   mobile collapse 메뉴  ------------------------------------------------------------------------------------------>

      </div>
    </nav>


<!---------------------------------------------------------------------------------------------------------------------------------------------------->
<!-- Modal Mobile App Menu  -------------------------------------------------------------------------------------------------------------------------------------->
<!-- Modal Mobile App Menu   -------------------------------------------------------------------------------------------------------------------------------------->

<div class="modal right fade" id="mobileMenu" tabindex="-1" role="dialog" aria-labelledby="mobileMenu">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel2">
                    <?php if(defined("_INDEX_") || !isLogined()) {?>
                        Menu
                    <?PHP } else { ?>
                        <a class="dropdown-item modal-menu-item" href="/" target="_self"><i class="fas fa-house-damage"></i> 홈</a>
                    <?php } ?>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>

            </div>

            <div class="modal-body">

                <!----- 로그인 사용자 정보   {      ------------------------------------------------------>
                <?php if($_SESSION["ss_mb_id"]) {?>
                    <div class="alert alert-secondary text-center p-2">


                        <i class="fas fa-user-circle"></i> <?php echo $member['mb_name']?>님

                        <strong>
                        <?php if($DefJgGubun == "CAPO"){ ?>
                            (주)카포
                        <?php } else { ?>
                            (유)카포
                        <?php } ?>
                        </strong>
                        작업 중~

                    </a>
                    </div>
                <?php } ?>
                <!------------------------     }     로그인 사용자 정보    ------------------------------------------------------>


            <!------- 학교회원  {   ----------------------------------------------------------------------------------------------------------------------------->

                <?php if ($is_school_member) { ?>

                <div class="dropdown-divider"></div>
                <!--안심번호 설정 -------------------------------------------->
                <div class="pl-3 modal-menu-item">
                    <button class="btn btn-sm " type="button"  aria-haspopup="true" aria-expanded="false">
                        <a href="<?php echo G5_BBS_URL ?>/goodjg_info.php">
                            <strong> <i class="fas fa-search"></i>상품조회</strong> </a>
                    </button>
                </div>

                <div class="pl-3 modal-menu-item">
                    <button class="btn btn-sm " type="button"  aria-haspopup="true" aria-expanded="false">
                        <a href="<?php echo G5_BBS_URL ?>/book_shelf_change.php">
                            <strong> <i class="fas fa-exchange-alt"></i>LOC 재고이동</strong> </a>
                    </button>
                </div>

                <div class="pl-3 modal-menu-item">
                    <button class="btn btn-sm " type="button"  aria-haspopup="true" aria-expanded="false">
                        <a href="<?php echo G5_BBS_URL ?>/book_jg_move.php">
                            <strong> <i class="fas fa-exchange-alt"></i>재고이동 Batch</strong> </a>
                    </button>
                </div>

                <div class="pl-3 modal-menu-item">
                    <button class="btn btn-sm " type="button"  aria-haspopup="true" aria-expanded="false">
                        <a href="<?php echo G5_BBS_URL ?>/out_check_gt.php">
                            <strong> <i class="fas fa-desktop"></i>출고검수</strong> </a>
                    </button>
                </div>


                <div class="pl-3 modal-menu-item">
                    <button class="btn btn-sm " type="button"  aria-haspopup="true" aria-expanded="false">
                        <a href="<?php echo G5_BBS_URL ?>/loc_move.php">
                            <strong> <i class="fas fa-pallet"></i>재고실사</strong> </a>
                    </button>
                </div>



                <?php } ?>
        <!------- }     학교회원  ----------------------------------------------------------------------------------------------------------------------------->


                <?php if(!$is_member) { ?>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item modal-menu-item" href="/" target="_self"><i class="fas fa-house-damage"></i> 홈</a>
                    <a class="dropdown-item modal-menu-item" href="/#section2" target="_self"><i class="fas fa-rainbow"></i>  주요기능 소개</a>
                    <a class="dropdown-item modal-menu-item" href="<?php echo G5_BBS_URL ?>/login.php" target="_self"><i class="fas fa-sign-in-alt" aria-hidden="true"></i> 로그인</a>

                    <?php if(!isIosAppClient()) { ?>
                        <a class="dropdown-item modal-menu-item" href="<?php echo G5_BBS_URL ?>//content.php?co_id=join" target="_self"><i class="fas fa-user-plus"></i> 회원가입</a>
                    <?php } ?>

                <?php }  ?>


                <div class="dropdown-divider"></div>

                <?php if($is_member) { ?>
<!--                <div class="dropdown-divider"></div>-->
                <a class="dropdown-item text-danger modal-menu-item" href="<?php echo G5_BBS_URL ?>/logout.php">
                    <i class="fas fa-sign-out-alt" aria-hidden="true"></i> 로그아웃
                </a>

                <?php } ?>

                <a class="dropdown-item  text-danger modal-menu-item" href="app://application.exit" target="_self"><i class="fas fa-times-circle"></i></i> 어플 종료하기</a>


                <div class="dropdown-divider"></div>



            </div> <!-- modal-body -->

        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->




<?php if (!defined("_INDEX_")) { ?>
<!--<div>&nbsp;</div>-->
<?php }?>


<!--

<div class="alert alert-danger" >
    <?php if(!isIOsClient()) { ?>
        NON IOS
    <?php } else { ?>
        IOS /
        <? echo $_SERVER['HTTP_USER_AGENT']; ?>
    <?php } ?>
</div>
-->


<!-- } 상단 끝 -->
