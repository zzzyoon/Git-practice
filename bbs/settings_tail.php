<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    echo conv_content($sconfig['settings_mobile_content_tail'], 1);
    // 모바일의 경우 설정을 따르지 않는다.
    include_once('./_tail.php');
} else {
    echo conv_content($sconfig['settings_content_tail'], 1);
    if($sconfig['settings_include_tail'] && is_include_path_check($sconfig['settings_include_tail']))
        @include ($sconfig['settings_include_tail']);
    else
        include ('./_tail.php');
}
?>