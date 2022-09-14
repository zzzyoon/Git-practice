<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$goodCd = clean_xss_tags(get_text($_REQUEST['goodCd']));
$sizeGb = clean_xss_tags(get_text($_REQUEST['sizeGb']));
$locCd = clean_xss_tags(get_text($_REQUEST['locCd']));
//$goodCd = null;

if(empty($goodCd) || empty($sizeGb) || empty($locCd)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

$sql = "begin CAPOPDA_CAPO1.SP_SRCHPRDJG_CAPO(:p_good_cd,:p_size_gb,:p_loc_cd,:p_good_nm,:p_jg_qty,:p_medg_qty,:cur_jglst); end; ";
$stmt = sql_query_parse($sql);

oci_bind_by_name($stmt, ':p_good_cd', $goodCd);
oci_bind_by_name($stmt, ':p_size_gb', $sizeGb);
oci_bind_by_name($stmt, ':p_loc_cd', $locCd);
oci_bind_by_name($stmt, ':p_good_nm', $goodNm) ; //out parameter
oci_bind_by_name($stmt, ':p_jg_qty', $jgQty) ; //out parameter
oci_bind_by_name($stmt, ':p_medg_qty', $medgQty) ; //out parameter
//oci_bind_by_name($result, ':cur_bk', $output) ;
//But BEFORE statement, Create your cursor
$cursor = oci_new_cursor($g5['connect_db']);
// On your code add the latest parameter to bind the cursor resource to the Oracle argument
oci_bind_by_name($stmt,":cur_jglst", $cursor,-1,OCI_B_CURSOR);

// Execute the statement as in your first try
sql_query_execute($stmt);
sql_query_execute($cursor);



// Execute the statement as in your first try


//if(!$goodNm || !$jgQty || !$medgQty){
//    ajaxExitJson("필수 파라미터 생성에 실패했습니다. ");
//}

$list = array();
$i=0;

while ($row = oci_fetch_array($cursor, OCI_RETURN_LOBS )) {
    $row = array_map_deep('iconv_utf8', $row);
    $row = array_change_key_case($row,CASE_LOWER);

    $list[$i] = $row;
    $i++;
    //$hidData = json_encode($row);
} //end while ___-------------------------



echo json_encode($list);