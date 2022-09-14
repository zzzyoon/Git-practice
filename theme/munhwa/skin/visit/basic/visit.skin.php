<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

global $is_admin;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$visit_skin_url.'/style.css">', 0);
?>

<!-- 접속자집계 시작 { -->
<div class="py-1 text-center visit">
  <i class="fa fa-users" aria-hidden="true"></i><span>접속자집계</span>
  <span>오늘: <?php echo number_format($visit[1]) ?></span>
  <span>어제: <?php echo number_format($visit[2]) ?></span>
  <span>최대: <?php echo number_format($visit[3]) ?></span>
  <span>전체: <?php echo number_format($visit[4]) ?></span>
  <?php if ($is_admin == "super") {  ?>
   	<a href="<?php echo G5_ADMIN_URL ?>/visit_list.php" class="btn btn-secondary btn-sm"><span class="text-white">상세보기</span></a>
  <?php } ?>
</div>
<!-- } 접속자집계 끝 -->