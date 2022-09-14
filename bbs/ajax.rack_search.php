<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/***
 * 빈랙조회
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$wbGb = clean_xss_tags(get_text($_REQUEST['wb_gb']));
$minRow = clean_xss_tags(get_text($_REQUEST['min_row']));
$maxRow = clean_xss_tags(get_text($_REQUEST['max_row']));



/*
if( strlen($wbGb) == 0 || empty($minRow) || empty($maxRow)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}
*/

/*
if(!is_numeric($minRow) || !is_numeric($minRow)){
    ajaxExitJson("검색 행을 숫자로 입력해주세요.");
}
*/

$wbGbHead = substr($wbGb,0,1);

$sql_search = "";

if(!empty($wbGbHead))
    $sql_search.=" and a.wh_cd = '{$wbGbHead}'  ";

if(strlen($minRow) > 0 && strlen($maxRow) > 0)
     $sql_search .= " and  a.loc1 between '{$minRow}' and '{$maxRow}' ";

$sql = "    select a.loc_cd from bkloca a     left outer join bksbjg b on a.loc_cd = b.loc_cd and b.jg_qty>0
             where b.loc_cd is null and a.cell_gb <> '3'  {$sql_search}
             group by a.loc_cd  order by a.loc_cd ";
$stmt = sql_query($sql);

$list = array();
$i=0;
while ($row = sql_fetch_array($stmt)) {

    $list[$i] = $row;
    $i++;

} //end while ___-------------------------

echo json_encode($list);
