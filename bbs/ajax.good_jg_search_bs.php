<?php
include_once("./_common.php");

///
///  서가 변경 > 도서검색
///

if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}


$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$goodCd = clean_xss_tags(get_text($_REQUEST['goodCd']));
$sizeGb = clean_xss_tags(get_text($_REQUEST['sizeGb']));
$locCd = clean_xss_tags(get_text($_REQUEST['locCd']));
$jgGb = clean_xss_tags(get_text($_REQUEST['jgGb']));

if(empty($goodCd) || empty($sizeGb) || empty($locCd) || empty($jgGb)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}


if(!empty($locCd)){
//    $goodCd = filteringEanCode($goodCd);
    $locCd = filteringEanCode($locCd);
}




//$sql = "begin PKGMHPDA.PROC_SHOWBOOKSHELF(:p_bar_cd,:cur_bk); end; ";
if (substr($jgGb,0,1) == "5") {
    $sql = "begin CAPO.CAPOPDA_CAPO1.SP_SRCHPRDJG_CAPO(:p_good_cd,:p_size_gb,:p_loc_cd,:p_jg_gb,:CUR_JGLST); end; "; //
}
else {
    $sql = "begin UCAPO.UCAPOPDA_UCAPO1.SP_SRCHPRDJG_UCAPO(:p_good_cd,:p_size_gb,:p_loc_cd,:p_jg_gb,:CUR_JGLST); end; "; //
}
$stmt = sql_query_parse($sql);


oci_bind_by_name($stmt, ':p_good_cd', $goodCd);
oci_bind_by_name($stmt, ':p_size_gb', $sizeGb);
oci_bind_by_name($stmt, ':p_loc_cd', $locCd);
oci_bind_by_name($stmt, ':p_jg_gb', $jgGb);



//oci_bind_by_name($result, ':cur_bk', $output) ;
//But BEFORE statement, Create your cursor
$cursor = oci_new_cursor($g5['connect_db']);
// On your code add the latest parameter to bind the cursor resource to the Oracle argument
oci_bind_by_name($stmt,":CUR_JGLST", $cursor,-1,OCI_B_CURSOR);

// Execute the statement as in your first try
sql_query_execute($stmt);
sql_query_execute($cursor);



/**
 *     [0] => 201300901
[bk_cd] => 201300901
[1] => 아름다운집 9권
[bk_nm] => 아름다운집 9권
[2] => 0004
[tax_no] => 0004
[3] => 출판명인 (주)
[cust_nm] => 출판명인 (주)
[4] => 5800
[out_danga] => 5800
[5] => 20070101
[bk_date] => 20070101
[6] => 000000
[loc_cd] => 000000
[7] => 20
[ipsu_qty] => 20
[8] => 0
[avg_qty] => 0
[9] => 30
[max_qty] => 30
[10] => 0
[a_qty] => 0
[11] => 0
[x_qty] => 0
[13] => 0000000000004X
[bar_cd] => 0000000000004X
[15] => Y
[move_yn] => Y
[16] => 0
[jg_qty] => 0

 *
 *
 *
DataRow dr = dt.NewdtBooksRow();
dr[dt.BK_CDColumn] = odr.GetString(0);
dr[dt.BK_NMColumn] = odr.GetString(1);
dr[dt.TAX_NOColumn] = odr.GetString(2);
dr[dt.CUST_NMColumn] = odr.GetString(3);
dr[dt.OUT_DANGAColumn] = odr.GetString(4);
dr[dt.A_QTYColumn] = odr.GetString(10);
dr[dt.X_QTYColumn] = odr.GetString(11);
dr[dt.JS_YNColumn] = odr.GetString(15);

dt.Rows.Add(dr);
 *
 * *
 */


ob_start();
echo'
    <div style="width: 100%; height:300px; overflow-y:auto; overflow-x: hidden;">

    <table id="dt_good_list" class="table table-hover">
    <tbody>
';


$seq=0;

while ($row = oci_fetch_array($cursor, OCI_RETURN_LOBS )) {
    $row = array_map_deep('iconv_utf8', $row);
    $row = array_change_key_case($row,CASE_LOWER);

    $hidData = json_encode($row);

    $seq++;

    $rowUid = $row['jg_qty']."_".$row['medg_qty']; //primary key 돌겠다 ㅡㅡ;

    echo"
    <tr id='row_good_id_{$rowUid}' class='book_sel_row' data = '{$hidData}'>
      <td class='td_bknm_m border-top border-primary ' colspan='3'>{$row['good_nm']}</td>
      </tr>
      <tr id='row_bk_id_{$rowUid}' class='book_sel_row' data = '{$hidData}'>
      <td class='td_left'>{$row['good_nm']}</td>
      <td class='td_qty'>{$row['jg_qty']}</td>
      <td class='td_qty'>{$row['medg_qty']}</td>
    </tr> 
        
    ";
}

if($seq == 0) {
    echo'<tr><td colspan="3" class="text-center p-3"> *조회된 정보가 없습니다. </td></tr>';
}

echo"</tbody></table></div>";
?>

<?php

if($seq == 1){
    echo"<script>
            setTimeout(function(){
            var selData = $('#row_good_id_{$rowUid}').attr('data');
              selectGood(selData);
            },300);
        </script>
    ";
}

$content = ob_get_contents();
ob_end_clean();
echo $content;