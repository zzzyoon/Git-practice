<?php
//@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "출고조회 - gt >  송장번호 체크"
 *
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$locCd = filteringSpcChr($_REQUEST['locCd']);
$jgGb = clean_xss_tags(get_text($_REQUEST['jgGb']));

if(empty($locCd)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}


if (substr($jgGb,0,1) == "5") {
    $sql = "     select count(*) cnt from CAPO.LOCATE
                 where loc_cd = '{$locCd}'
          ";
} else {
    $sql = "      select count(*) cnt from UCAPO.LOCATE
                 where loc_cd = '{$locCd}'
          ";
}

$data = sql_result($sql);
echo $data;
