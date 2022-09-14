<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$call_skin_path = get_skin_path('call', (G5_IS_MOBILE ? $sconfig['call_mobile_skin'] : $sconfig['call_skin']));
$call_skin_url  = get_skin_url('call', (G5_IS_MOBILE ? $sconfig['call_mobile_skin'] : $sconfig['call_skin']));

if (G5_IS_MOBILE) {
    // 모바일의 경우 설정을 따르지 않는다.
    include_once('./_head.php');
    echo conv_content($sconfig['call_mobile_content_head'], 1);
} else {
    if($sconfig['call_include_head'] && is_include_path_check($sconfig['call_include_head']))
        @include ($sconfig['call_include_head']);
    else
        include ('./_head.php');
    echo conv_content($sconfig['call_content_head'], 1);
}
?>