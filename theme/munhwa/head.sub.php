<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$begin_time = get_microtime();
if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | ".$config['cf_title'];
}

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';
?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <meta name="author" content="(주)카포">
    <meta name="description" content="카포 PDA - Hybrid WebSite" />
    <meta name="keywords" content="카포"/>
    <meta property="og:type" content="website">
    <meta property="og:title" content="카포 - PDA">
    <meta property="og:description" content="카포 PDA  - Hybrid WebSite">
    <meta property="og:image" content="<?php echo G5_THEME_IMG_URL?>/.png">
    <meta property="og:url" content="http://easyinfo12.cafe24.com">

    <!-- Chrome, Safari, IE -->
    <link rel="shortcut icon" href="<?php echo G5_THEME_URL?>/img/favicon.ico">
    <!-- Firefox, Opera (Chrome and Safari say thanks but no thanks) -->
    <link rel="icon" href="<?php echo G5_THEME_URL?>/img/favicon.png">

    <!-- 대표 URL / naver webmaster tool -->
    <link rel="canonical" href="https://teachercall.kr/">

    <?php
    echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">'.PHP_EOL;

    if($config['cf_add_meta'])
        echo $config['cf_add_meta'].PHP_EOL;
    ?>

    <title><?php echo $g5_head_title; ?></title>



    <link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL; ?>/<?php echo G5_IS_MOBILE ? 'mobile' : 'munhwa'; ?>.css?ver=<?php echo G5_CSS_VER; ?>">


    <!-- Bootstrap core CSS  4.4.1  / modified : 20200224 -->
    <link href="<?php echo G5_JS_URL; ?>/bootstrap.min.css" rel="stylesheet"><!-- bootstrap css  / vs 4.4.1 -->


    <!-- Custom styles for this template -->
    <link href="<?php echo G5_THEME_URL ?>/asset/css/carousel.css" rel="stylesheet">

    <!-- bootstrap callouts css  / 20200902 -->
    <link href="<?php echo G5_CSS_URL; ?>/callout.css" rel="stylesheet">


    <!-------------   }  CSS CSS CSS  CSS  CSS       AREA     ------------------------------------------------------------------------------------------------------------------->


    <!-------------  SCRIPT SCRIPT SCRIPT SCRIPT      AREA    {        ------------------------------------------------------------------------------------------------------------------->

    <script>
        // 자바스크립트에서 사용하는 전역변수 선언
        var g5_url       = "<?php echo G5_URL ?>";
        var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
        var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
        var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
        var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
        var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
        var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
        var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
        var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
    </script>



    <script src="<?php echo G5_JS_URL ?>/jquery-3.4.1.min.js"></script>
    <script src="<?php echo G5_JS_URL ?>/bootstrap.min.js"></script>

    <script src="<?php echo G5_JS_URL ?>/jquery.menu.js?ver=<?php echo G5_JS_VER; ?>"></script>
    <script src="<?php echo G5_JS_URL ?>/common.js?ver=<?php echo G5_JS_VER; ?>"></script>
    <script src="<?php echo G5_JS_URL ?>/wrest.js?ver=<?php echo G5_JS_VER; ?>"></script>
    <script src="<?php echo G5_JS_URL ?>/placeholders.min.js"></script>

    <!-- bylee -->
    <link rel="stylesheet" href="<?php echo G5_JS_URL ?>/jquery-ui.css">
    <script src="<?php echo G5_JS_URL ?>/jquery-ui.js?ver=<?php echo G5_JS_VER; ?>"></script>


    <!-- Font Awsome  v5.12  -->
    <link href="<?php echo G5_CSS_URL; ?>/awesome.all.css" rel="stylesheet">
    <script src="<?php echo G5_JS_URL ?>/awesome.all.js"></script>



    <!-------------  }      SCRIPT SCRIPT SCRIPT SCRIPT      AREA      ------------------------------------------------------------------------------------------------------------------->

    <!-- moment date lib -->
    <script src="<?php echo G5_JS_URL ?>/moment-with-locales.min.js"></script>

    <!-- toast box lib  -->
    <link href="<?php echo G5_THEME_JS_URL; ?>/notific.css" rel="stylesheet">
    <script src="<?php echo G5_THEME_JS_URL ?>/notific.js"></script>

    <!-- alert lib -->
    <script src="<?php echo G5_THEME_JS_URL ?>/lottie.min.js"></script>

    <script src="<?php echo G5_THEME_JS_URL ?>/alt-alert.js?11"></script>
    <script src="<?php echo G5_THEME_JS_URL ?>/alt-confirm.js?34"></script>
    <script src="<?php echo G5_THEME_JS_URL ?>/jquery-doubleTap.min.js"></script>
    <script src="<?php echo G5_THEME_JS_URL ?>/munhwa.js?23"></script>

    <!-- bootstrap plugin  / mobile right > pulldown menu -->
    <script src="<?php echo G5_JS_URL ?>/popper.min.js"></script>

    <?php
    if(!defined('G5_IS_ADMIN'))
        echo $config['cf_add_script'];
    ?>


</head>

<body<?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?>>
<?php
if(defined('_INDEX_')) { // index에서만 실행
    ?>
    <header>
        <!-- index > header clear   -->
    </header>
<?php } ?>

<!-- 콘텐츠 시작 { -->
<main role="main">
    <div class="container">

