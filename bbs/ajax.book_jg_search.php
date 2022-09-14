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
$jgGb = clean_xss_tags(get_text($_REQUEST['jgGb']));
//$goodCd = null;

if(empty($goodCd) || empty($sizeGb)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

if (substr($jgGb,0,1) == "5") {
//기획서에 JG_GB 구분자 추가 > 프로시져 추가 생성
    $sql = "begin CAPO.CAPOPDA_CAPO1.SP_SRCHJG_CAPO(:p_good_cd,:p_size_gb,:p_jg_gb,:cur_jglst); end; ";
} else {
    $sql = "begin UCAPO.UCAPOPDA_UCAPO1.SP_SRCHJG_UCAPO(:p_good_cd,:p_size_gb,:p_jg_gb,:cur_jglst); end; ";
}
//$sql = "begin UCAPO.UCAPOPDA_UCAPO1.SP_SRCHJG_UCAPO(:p_good_cd,:p_size_gb,:p_jg_gb,:cur_jglst); end; ";
$stmt = sql_query_parse($sql);

oci_bind_by_name($stmt, ':p_good_cd', $goodCd);
oci_bind_by_name($stmt, ':p_size_gb', $sizeGb);
oci_bind_by_name($stmt, ':p_jg_gb', $jgGb);

//oci_bind_by_name($result, ':cur_bk', $output) ;
//But BEFORE statement, Create your cursor
$cursor = oci_new_cursor($g5['connect_db']);
// On your code add the latest parameter to bind the cursor resource to the Oracle argument
oci_bind_by_name($stmt,":cur_jglst", $cursor,-1,OCI_B_CURSOR);


// Execute the statement as in your first try
sql_query_execute($stmt);
sql_query_execute($cursor);

$list = array();
$i=0;

$totJgQty = 0;
while ($row = oci_fetch_array($cursor, OCI_RETURN_LOBS )) {
    $row = array_map_deep('iconv_utf8', $row);
    $row = array_change_key_case($row,CASE_LOWER);

    $list[$i] = $row;
    $totJgQty+=$row['jg_qty'];
    $i++;
    //$hidData = json_encode($row);
} //end while ___-------------------------

//마지막 row 합계 추가
if(count($list) > 0){
    $list[$i]['loc_cd'] =  "합계";
    $list[$i]['good_cd'] =  "";
    $list[$i]['good_nm'] =  "";
    $list[$i]['out_danga1'] =  "0";
    $list[$i]['last_indt'] =  "";
    $list[$i]['jg_qty'] = $totJgQty;
}



echo json_encode($list);