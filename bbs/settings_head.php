<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$settings_skin_path = get_skin_path('settings', (G5_IS_MOBILE ? $sconfig['settings_mobile_skin'] : $sconfig['settings_skin']));
$settings_skin_url  = get_skin_url('settings', (G5_IS_MOBILE ? $sconfig['settings_mobile_skin'] : $sconfig['settings_skin']));

if (G5_IS_MOBILE) {
    // 모바일의 경우 설정을 따르지 않는다.
    include_once('./_head.php');
    echo conv_content($sconfig['settings_mobile_content_head'], 1);
} else {
    if($sconfig['settings_include_head'] && is_include_path_check($sconfig['settings_include_head']))
        @include ($sconfig['settings_include_head']);
    else
        include ('./_head.php');
    echo conv_content($sconfig['settings_content_head'], 1);
}
?>