<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$jg_gb = clean_xss_tags(get_text($_REQUEST['jg_gb']));

/***
 *  창고구분 리스트
 */

$sql = "select fld_code, fld_name,  fld_code ||'-'|| fld_name as fld_gb from gncode
              where fld_code like '{$jg_gb}'||'%' and fld_id = 'jgwms_gb'       
              order by fld_code ";
$stmt = sql_query($sql);
$list = array();
$i=0;

while ($row = sql_fetch_array($stmt)) {

    $list[$i] = $row;
    $i++;

} //end while ___-------------------------

echo json_encode($list);
