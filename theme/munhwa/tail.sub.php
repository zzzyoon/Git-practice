<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<?php if ($is_admin == 'super') {  ?><!-- <div style='float:left; text-align:center;'>RUN TIME : <?php echo get_microtime()-$begin_time; ?><br></div> --><?php }  ?>

<!-- ie6,7에서 사이드뷰가 게시판 목록에서 아래 사이드뷰에 가려지는 현상 수정 -->
<!--[if lte IE 7]>
<script>
$(function() {
    var $sv_use = $(".sv_use");
    var count = $sv_use.length;

    $sv_use.each(function() {
        $(this).css("z-index", count);
        $(this).css("position", "relative");
        count = count - 1;
    });
});
</script>
<![endif]-->



<!--[if lte IE 9]>
<script type="text/javascript">
    $.reject({
        reject: { all: true }, // Reject all renderers for demo
        display: [ 'chrome', 'msie','firefox'], // Displays only firefox, chrome, and opera
        header: '*현재 사용중인 브라우져는 더이상 지원하지 않습니다! ', // Header Text
        paragraph1: '보다 나은 사용자 경험 및 보안상의 이유로 오래된 "인터넷 브라우져"는 더 이상 이사이트에서  지원하지 않습니다.  ', // Paragraph 1
        paragraph2: '아래의 브라우져 이미지를 클릭해서, 최신의 브라우져로 꼭 설치 및 업데이트 하세요.(* 구글 크롬 브라우져 추천)',
        closeLink: '[ 창 닫기 - Close ]',
        closeMessage:'(업데이트 않을경우 원할하게 저희 서비스를 이용할 수 없습니다.)',
        imagePath: '<?php echo G5_JS_URL ?>/images/',
          browserShow: true, // Should the browser options be shown?
    browserInfo: { // Settings for which browsers to display
        chrome: {
            // Text below the icon
            text: '구글 크롬',
            // URL For icon/text link
            url: 'http://www.google.com/chrome/',
            // (Optional) Use "allow" to customized when to show this option
            // Example: to show chrome only for IE users
            // allow: { all: false, msie: true }
        },
        firefox: {
            text: '파이어폭스',
            url: 'http://www.mozilla.com/firefox/'
        },
        msie: {
            text: '인터넷 익스플로러',
            url: 'http://www.microsoft.com/windows/Internet-explorer/'
        }
    }
    });
    $('.btn').hide();
    $('.navbar-collapse').hide();
    $('.navbar-nav').hide();
</script>
<![endif]-->


</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다. ?>