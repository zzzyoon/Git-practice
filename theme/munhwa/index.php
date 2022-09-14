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
  //  include_once(G5_THEME_PATH . '/user_dashboard.php');
}


if($is_member) {

    if($DefJgGubun){

        /*
        if($work_type == "A"){ // 정품 작업
            include_once(G5_THEME_PATH . '/view_a_work.php');
        } else if($work_type == "X"){ //반품 작업
            include_once(G5_THEME_PATH . '/view_x_work.php');
        }
        */

        include_once(G5_THEME_PATH . '/view_work_menu.php');

    } else {
        include_once(G5_THEME_PATH . '/view_work_type.php');  // 정품,반품  작업 선택 페이지
    }

} else {

    goto_url("/bbs/login.php");

}
?>

 <!--- }  only apple  ---------------------------------------------->






<?php
include_once(G5_THEME_PATH.'/tail.php');
?>