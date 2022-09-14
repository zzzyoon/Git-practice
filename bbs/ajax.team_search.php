<?php
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    die("<strong>로그인 정보가 존재하지 않습니다. </strong>");
}


$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$taxNo = clean_xss_tags(get_text($_REQUEST['tax_no']));

//$taxNo="0196";

if(empty($taxNo) ){
    alert("필수 인자가 누락되었습니다. ");
}


$sql = "select f_gncode('team_cd',team_cd) team_nm from custcd where tax_no = '{$taxNo}' ";

$result = sql_result($sql);
echo $result;