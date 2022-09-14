<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/head.php');
?>

<?php if (!defined("_INDEX_")) { ?>
    <h2 id="container_title">
        <span title="<?php echo get_text($g5['title']); ?>"><?php echo get_head_title($g5['title']); ?></span>
    </h2>
<?php } ?>


<!--- only apple  {  ---------------------------------------------->
<?php
if($is_member &&  is_mobile() ) {
  // 데쉬보드
  include_once(G5_THEME_PATH . '/user_dashboard.php');
}


if($is_member) {
    // 바로가기 버튼
   include_once(G5_THEME_PATH . '/shortcut_menu_v2.php');
}
?>

<!-- 어플 메뉴 영역 / only Apple  -->
<?php // include_once(G5_THEME_PATH.'/shortcut_menu.php'); ?>

<!--- }  only apple  ---------------------------------------------->



<?php if(!$is_member){ ?>

    <!-- 특징   {  ------------------------------------------------------------------------------------------------------------------>

    <section id="section2" class="py-8 py-md-11 border-bottom mb-4 pb-4 pt-2">
        <div class="container">

            <div class="row">
                <div class="col-12 col-md-4 aos-init aos-animate" data-aos="fade-up">

                    <!-- Icon -->
                    <div class="icon text-primary mb-3">
                        <svg width="48" height="48" viewBox="0 0 16 16" class="bi bi-shield-shaded" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.443 1.991a60.17 60.17 0 0 0-2.725.802.454.454 0 0 0-.315.366C1.87 7.056 3.1 9.9 4.567 11.773c.736.94 1.533 1.636 2.197 2.093.333.228.626.394.857.5.116.053.21.089.282.11A.73.73 0 0 0 8 14.5c.007-.001.038-.005.097-.023.072-.022.166-.058.282-.111.23-.106.525-.272.857-.5a10.197 10.197 0 0 0 2.197-2.093C12.9 9.9 14.13 7.056 13.597 3.159a.454.454 0 0 0-.315-.366c-.626-.2-1.682-.526-2.725-.802C9.491 1.71 8.51 1.5 8 1.5c-.51 0-1.49.21-2.557.491zm-.256-.966C6.23.749 7.337.5 8 .5c.662 0 1.77.249 2.813.525a61.09 61.09 0 0 1 2.772.815c.528.168.926.623 1.003 1.184.573 4.197-.756 7.307-2.367 9.365a11.191 11.191 0 0 1-2.418 2.3 6.942 6.942 0 0 1-1.007.586c-.27.124-.558.225-.796.225s-.526-.101-.796-.225a6.908 6.908 0 0 1-1.007-.586 11.192 11.192 0 0 1-2.417-2.3C2.167 10.331.839 7.221 1.412 3.024A1.454 1.454 0 0 1 2.415 1.84a61.11 61.11 0 0 1 2.772-.815z"/>
                            <path d="M8 2.25c.909 0 3.188.685 4.254 1.022a.94.94 0 0 1 .656.773c.814 6.424-4.13 9.452-4.91 9.452V2.25z"/>
                        </svg>
                    </div>

                    <!-- Heading -->
                    <h3>
                      개인정보 유출 방지
                    </h3>

                    <!-- Text -->
                    <p class="text-muted mb-6 mb-md-0">
                        050으로 시작하는 가상의 번호가 개인 전화번호 대신 노출되므로 개인정보 유출 방지됩니다.
                    </p>

                </div>
                <div class="col-12 col-md-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="50">

                    <!-- Icon -->
                    <div class="icon text-primary mb-3">
                        <svg width="48" height="48" viewBox="0 0 16 16" class="bi bi-chat-right-text-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M16 2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h9.586a1 1 0 0 1 .707.293l2.853 2.853a.5.5 0 0 0 .854-.353V2zM3.5 3a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5z"/>
                        </svg>
                    </div>

                    <!-- Heading -->
                    <h3>
                      문자 수신 기능
                    </h3>

                    <!-- Text -->
                    <p class="text-muted mb-6 mb-md-0">
                        050 가상의 번호로 문자 (SMS, MMS, LMS) 등 모든 문자 서비스를 이용가능합니다.
                    </p>

                </div>
                <div class="col-12 col-md-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">

                    <!-- Icon -->
                    <div class="icon text-primary mb-3">
                        <svg width="48" height="48" viewBox="0 0 16 16" class="bi bi-telephone-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M2.267.98a1.636 1.636 0 0 1 2.448.152l1.681 2.162c.309.396.418.913.296 1.4l-.513 2.053a.636.636 0 0 0 .167.604L8.65 9.654a.636.636 0 0 0 .604.167l2.052-.513a1.636 1.636 0 0 1 1.401.296l2.162 1.681c.777.604.849 1.753.153 2.448l-.97.97c-.693.693-1.73.998-2.697.658a17.471 17.471 0 0 1-6.571-4.144A17.47 17.47 0 0 1 .639 4.646c-.34-.967-.035-2.004.658-2.698l.97-.969zm7.879-.834a.5.5 0 0 1 .708 0L13 2.293 15.146.146a.5.5 0 0 1 .708.708L13.707 3l2.147 2.146a.5.5 0 0 1-.708.708L13 3.707l-2.146 2.147a.5.5 0 0 1-.708-.708L12.293 3 10.146.854a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </div>

                    <!-- Heading -->
                    <h3>
                      전화 연결 차단
                    </h3>

                    <!-- Text -->
                    <p class="text-muted mb-0">
                        설정된 원하는 시간에만 전화 수신가능하며, 그 외 나머지 시간에는 안내멘트 송출 가능합니다.
                    </p>

                </div>
            </div> <!-- / .row -->



            <div class="row mt-4">
                <div class="col-12 col-md-4 aos-init aos-animate" data-aos="fade-up">

                    <!-- Icon -->
                    <div class="icon text-secondary mb-3">
                        <svg width="48" height="48" viewBox="0 0 16 16" class="bi bi-telephone-forward-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M2.267.98a1.636 1.636 0 0 1 2.448.152l1.681 2.162c.309.396.418.913.296 1.4l-.513 2.053a.636.636 0 0 0 .167.604L8.65 9.654a.636.636 0 0 0 .604.167l2.052-.513a1.636 1.636 0 0 1 1.401.296l2.162 1.681c.777.604.849 1.753.153 2.448l-.97.97c-.693.693-1.73.998-2.697.658a17.471 17.471 0 0 1-6.571-4.144A17.47 17.47 0 0 1 .639 4.646c-.34-.967-.035-2.004.658-2.698l.97-.969zM12.646.646a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </div>

                    <!-- Heading -->
                    <h3>
                        안심 발신 통화
                    </h3>

                    <!-- Text -->
                    <p class="text-muted mb-6 mb-md-0">
                       수신만 가능하던 안심번호의 기능을 넘어서, 개인의 휴대폰 번호인 발신번호를 변경해서, 고객과 통화 가능합니다.
                    </p>

                </div>
                <div class="col-12 col-md-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="50">

                    <!-- Icon -->
                    <div class="icon text-secondary mb-3">
                        <svg width="48" height="48" viewBox="0 0 16 16" class="bi bi-person-lines-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7 1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm2 9a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                    </div>

                    <!-- Heading -->
                    <h3>
                        개인화
                    </h3>

                    <!-- Text -->
                    <p class="text-muted mb-6 mb-md-0">
                      다양한 업무환경에 맞게  통화 가능한 업무시간, 휴식시간 등을 개인 회원별로 설정 할 수 있습니다.
                    </p>

                </div>
                <div class="col-12 col-md-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">

                    <!-- Icon -->
                    <div class="icon text-secondary mb-3">
                        <svg width="48" height="48" viewBox="0 0 16 16" class="bi bi-gear-wide-connected" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8.932.727c-.243-.97-1.62-.97-1.864 0l-.071.286a.96.96 0 0 1-1.622.434l-.205-.211c-.695-.719-1.888-.03-1.613.931l.08.284a.96.96 0 0 1-1.186 1.187l-.284-.081c-.96-.275-1.65.918-.931 1.613l.211.205a.96.96 0 0 1-.434 1.622l-.286.071c-.97.243-.97 1.62 0 1.864l.286.071a.96.96 0 0 1 .434 1.622l-.211.205c-.719.695-.03 1.888.931 1.613l.284-.08a.96.96 0 0 1 1.187 1.187l-.081.283c-.275.96.918 1.65 1.613.931l.205-.211a.96.96 0 0 1 1.622.434l.071.286c.243.97 1.62.97 1.864 0l.071-.286a.96.96 0 0 1 1.622-.434l.205.211c.695.719 1.888.03 1.613-.931l-.08-.284a.96.96 0 0 1 1.187-1.187l.283.081c.96.275 1.65-.918.931-1.613l-.211-.205a.96.96 0 0 1 .434-1.622l.286-.071c.97-.243.97-1.62 0-1.864l-.286-.071a.96.96 0 0 1-.434-1.622l.211-.205c.719-.695.03-1.888-.931-1.613l-.284.08a.96.96 0 0 1-1.187-1.186l.081-.284c.275-.96-.918-1.65-1.613-.931l-.205.211a.96.96 0 0 1-1.622-.434L8.932.727zM8 12.997a4.998 4.998 0 1 0 0-9.995 4.998 4.998 0 0 0 0 9.996z"/>
                            <path fill-rule="evenodd" d="M7.375 8L4.602 4.302l.8-.6L8.25 7.5h4.748v1H8.25L5.4 12.298l-.8-.6L7.376 8z"/>
                        </svg>
                    </div>

                    <!-- Heading -->
                    <h3>
                       교직원 회원 관리
                    </h3>

                    <!-- Text -->
                    <p class="text-muted mb-0">
                        학교관리 회원을 별도로 두어, 각 단체(학교)에 속한 교직원 회원을 관리(번호 생성,정지)할 수 있습니다.
                    </p>

                </div>
            </div> <!-- / .row -->


        </div> <!-- / .container -->
    </section>

    <!--  }   특징  ------------------------------------------------------------------------------------------------------------------>

<?php } ?>


<?php if(!$is_member || ($is_member &&  !is_mobile()) ){ ?>

    <!-- 최신글 Section {  ------------------------------------------------------->
    <div  class="row mb-2 target">

        <div class="col-lg-6">

            <!-- 최신글 1 시작 { -->
            <?php
            $titleLen=26;
            if(isAppClient() || is_mobile())
                $titleLen=16;

            echo latest('theme/basic', 'notice', 6, $titleLen);
            ?>
            <!-- } 최신글 1 끝 -->

        </div>

        <!-- pc 화면에서만 보임   -->
        <div class="col-lg-6 d-none d-sm-none d-md-block">
            <!--  사진 최신글2 { -->
            <?php
            // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
            // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
            // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
            //echo latest('theme/pic_basic', 'qa', 4, 23);
            echo latest('theme/basic', 'qa', 6, 24);
            ?>
            <!-- } 사진 최신글2 끝 -->
        </div>


    </div>
    <!-- } 최신글 Section ---------------------------------------------------------------------------------------------->

    <hr class="featurette-divider">




   <!-- 서비스 안내  {   -------------------------------------------------------------------------------------------------------------->

    <section id="section3">
        <div class="row">
            <div class="col-lg-12">
                <img class="img-fluid mx-auto d-block" src="<?php echo G5_THEME_URL ?>/img/web_svc_01.png" alt="안심번호서비스 주요기능 소개 01" >
            </div>
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-lg-12">
                <img class="img-fluid mx-auto d-block" src="<?php echo G5_THEME_URL ?>/img/web_svc_022.png" alt="안심번호서비스 주요기능 소개 02" >
            </div>
        </div>

    </section>

    <div>
        &nbsp;
    </div>

    <!--   }  서비스 안내  ------------------------------------------------------------------------------------------------------------->



<?php } ?>



<?php
include_once(G5_THEME_PATH.'/tail.php');
?>