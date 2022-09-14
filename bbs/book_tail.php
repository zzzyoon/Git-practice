<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


echo conv_content($_config['bf_content_tail'], 1);
if($_config['bf_include_tail'] && is_include_path_check($_config['bf_include_tail']))
    @include ($_config['bf_include_tail']);
else
    include ('./_tail.php');

?>