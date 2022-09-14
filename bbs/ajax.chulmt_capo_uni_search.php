<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}


$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$orderNum = $_REQUEST['order_num'];
$jgGb = $_REQUEST['jgGb'];
$seq = 0;

if(empty($orderNum)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

if (substr($jgGb,0,1) == "5") {
    $sql = "begin CAPO.CAPOPDA_CAPO1.SP_SRCHPACKAMT_CAPO(:pordernum,:CUR_LST); end;";
}else {
    $sql = "begin UCAPO.UCAPOPDA_UCAPO1.SP_SRCHPACKAMT_UCAPO(:pordernum,:CUR_LST); end;";
}
$stmt = sql_query_parse($sql);

oci_bind_by_name($stmt, ':pordernum', $orderNum);

$cursor = oci_new_cursor($g5['connect_db']);
oci_bind_by_name($stmt,":CUR_LST", $cursor,-1,OCI_B_CURSOR);

sql_query_execute($stmt);
sql_query_execute($cursor);

//$res = sql_query_execute($stmt,G5_DISPLAY_SQL_ERROR,$isTransaction);

while ($row = oci_fetch_array($cursor, OCI_RETURN_LOBS )) {
    $row = array_map_deep('iconv_utf8', $row);
    $row = array_change_key_case($row,CASE_LOWER);

//    $data = json_encode($row);

    $seq++;
    echo json_encode($row);

}
echo json_encode($cursor);
//echo json_encode($data);