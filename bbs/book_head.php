<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


$_skin_path = get_skin_path('book', (G5_IS_MOBILE ? $_config['bf_mobile_skin'] : $_config['bf_skin']));
$_skin_url  = get_skin_url('book', (G5_IS_MOBILE ? $_config['bf_mobile_skin'] : $_config['bf_skin']));


if($config['bf_include_head'] && is_include_path_check($_config['bf_include_head']))
    @include ($_config['bf_include_head']);
else
    include ('./_head.php');

echo conv_content($_config['bf_content_head'], 1);
?>