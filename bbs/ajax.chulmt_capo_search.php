<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}


$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$invNo = filteringSpcChr($_REQUEST['inv_no']);
$jgGb = filteringSpcChr($_REQUEST['jg_gb']);
$seq = 0;

if(empty($invNo) || empty($jgGb)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

if(strlen($invNo) != 12 && strlen($invNo) != 4){
    ajaxExitJson("송장번호를 바르게 입력하세요.");
}

if (substr($jgGb,0,1) == "5") {
    $sql = "begin CAPO.CAPOPDA_CAPO1.SP_SRCHRELINF_CAPO(:pcd,:p_jg_gb,:CUR_LST); end;";
} else {
    $sql = "begin UCAPO.UCAPOPDA_UCAPO1.SP_SRCHRELINF_UCAPO(:pcd,:p_jg_gb,:CUR_LST); end;";
}

$stmt = sql_query_parse($sql);

oci_bind_by_name($stmt, ':pcd', $invNo);
oci_bind_by_name($stmt, ':p_jg_gb', $jgGb);

$cursor = oci_new_cursor($g5['connect_db']);
oci_bind_by_name($stmt,":CUR_LST", $cursor,-1,OCI_B_CURSOR);

sql_query_execute($stmt);
sql_query_execute($cursor);

while ($row = oci_fetch_array($cursor, OCI_RETURN_LOBS )) {
    $row = array_map_deep('iconv_utf8', $row);
    $row = array_change_key_case($row,CASE_LOWER);

    $row['subl_no'] = str_pad($row['subl_no'], 4, '0', STR_PAD_LEFT);

    $seq++;
    echo json_encode($row);
}
if($seq == "0") {
    echo json_encode($row);
}