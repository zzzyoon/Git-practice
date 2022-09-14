<?php
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$code = clean_xss_tags(get_text($_REQUEST['code']));
$jgGb = clean_xss_tags(get_text($_REQUEST['jgGb']));

//for debugging  ------------------------------------------
//$code = "9772508669003";
//$name=iconv_euckr("사랑");
//$orderBy = "OUT_DANGA";

if(!empty($code)){
    $code = filteringEanCode($code);
}

if(empty($code)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

if (substr($jgGb,0,1) == "5") {
//bookcd 기반 데이터 추출
    $sql = "begin CAPO.CAPOPDA_CAPO1.SP_SRCHGSIZE_CAPO(:p_bar_cd,:cur_bk); end; ";
} else {
    $sql = "begin UCAPO.UCAPOPDA_UCAPO1.SP_SRCHGSIZE_UCAPO(:p_bar_cd,:cur_bk); end; ";
}
$stmt = sql_query_parse($sql);

oci_bind_by_name($stmt, ':p_bar_cd', $code);

//oci_bind_by_name($result, ':cur_bk', $output) ;
//But BEFORE statement, Create your cursor
$cursor = oci_new_cursor($g5['connect_db']);


// On your code add the latest parameter to bind the cursor resource to the Oracle argument
oci_bind_by_name($stmt,":cur_bk", $cursor,-1,OCI_B_CURSOR);

// Execute the statement as in your first try
sql_query_execute($stmt);
sql_query_execute($cursor);


ob_start();
echo'<table  class="table  table-hover">
    <thead>
    </thead>
    </table>
    <div style="width: 100%; height:300px; overflow-y:auto; overflow-x: hidden;">


    <table id="dt_bk_list" class="table table-hover">
    <tbody>
';


$seq=0;

while ($row = oci_fetch_array($cursor, OCI_RETURN_LOBS )) {
    $row = array_map_deep('iconv_utf8', $row);
    $row = array_change_key_case($row,CASE_LOWER);

    $hidData = json_encode($row);

    $seq++;

    $rowUid = filteringEanCode($row['good_cd'])."_".filteringEanCode($row['size_gb']); //primary key 돌겠다 ㅡㅡ;

    echo"
      <tr id='row_bk_id_{$rowUid}' class='book_sel_row' data = '{$hidData}'>
      <td class='td_bknm_m border-top border-primary ' colspan='3'>{$row['good_nm']}</td>
      </tr>
      <tr id='row_bk_id_{$rowUid}' class='book_sel_row' data = '{$hidData}'>
      <td class='td_left'>{$row['good_cd']}</td>
      <td class='td_qty'>{$row['size_gb']}</td>
      <td class='td_qty'>{$row['color']}</td>
    </tr>
    ";
}

if($seq == 0) {
    echo'<tr><td colspan="3" class="text-center p-3 text-danger"> *조회된 정보가 없습니다. </td></tr>';
}

echo"</tbody></table></div>";
?>

<script>

$('#dt_bk_list > tbody > tr').click(function() {
    var $this = $(this);
    var selData = $(this).attr('data');
    if ($this.hasClass('clicked')){  // double click +++++++++++++++++++++++++++++++++++++

         $this.removeClass('clicked');
        //here is your code for double click
        selectBook(selData); //도서 선택 & 창닫기

    }else{  // single click  --------------------------------

        $this.addClass('clicked');
        setTimeout(function() {
            if ($this.hasClass('clicked')){

                $this.removeClass('clicked');

                //your code for single click

                showBookDetail(selData); //도서 상세보기


            }
        }, 500);
    }


});




</script>

<?php

if($seq == 1){
    echo"<script>
            setTimeout(function(){
            var selData = $('#row_bk_id_{$rowUid}').attr('data');
              selectBook(selData);
            },300);
        </script>
    ";
}

$content = ob_get_contents();
ob_end_clean();
echo $content;