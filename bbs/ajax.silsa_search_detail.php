<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");

if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/***
 *  서가 적치 > 팔레트 번호 - 도서검색
 *
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$slipNo = clean_xss_tags(get_text($_REQUEST['slip_no']));
$jgGb = clean_xss_tags(get_text($_REQUEST['jg_gb']));

if(empty($slipNo)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

//ajaxExitJson($slipNo);

//$sql = "begin CAPOPDA_CAPO1.SP_SRCHINVDATA_CAPO(:p_slip_no,:chk_gb,:p_tot_qty,:cur_bk); end; ";
if(substr($jgGb,0,1) == "5") {
    $sql = "begin CAPO.CAPOPDA_CAPO1.SP_SRCHINVDATA_CAPO(:p_slip_no,:p_jg_gb,:cur_bk); end; ";
}else {
    $sql = "begin UCAPO.UCAPOPDA_UCAPO1.SP_SRCHINVDATA_UCAPO(:p_slip_no,:p_jg_gb,:cur_bk); end; ";
}
$stmt = sql_query_parse($sql);

oci_bind_by_name($stmt, ':p_slip_no', $slipNo);
oci_bind_by_name($stmt, ':p_jg_gb', $jgGb);
//oci_bind_by_name($stmt, ':chk_gb', $chkGb);
//oci_bind_by_name($stmt, ':p_tot_qty', $totQty);

//oci_bind_by_name($result, ':cur_bk', $output) ;
//But BEFORE statement, Create your cursor

$cursor = oci_new_cursor($g5['connect_db']);
// On your code add the latest parameter to bind the cursor resource to the Oracle argument
oci_bind_by_name($stmt,":cur_bk", $cursor,-1,OCI_B_CURSOR);


sql_query_execute($stmt);
sql_query_execute($cursor);


$list = array();
$i=0;
$totQty = 0;

while ($row = oci_fetch_array($cursor, OCI_RETURN_LOBS )) {
    $row = array_map_deep('iconv_utf8', $row);
    $row = array_change_key_case($row,CASE_LOWER);


    $list[$i] = $row;
    $totQty = $totQty + $row["jg_qty"];
    $chk_gb = $row["chk_gb"];
    $i++;
    //$hidData = json_encode($row);
} //end while ___-------------------------

//마지막 row 합계 추가
if(count($list) > 0){
    $list[$i]['jg_qty'] = $totQty;
    $list[$i]['chk_gb'] = $chk_gb;
}

echo json_encode($list);
