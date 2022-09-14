<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "상차등록 - 출고데이터 조회 > 출고목록"
 *
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$_REQUEST = array_map_deep('filteringSpcChr', $_REQUEST);
$sublNo = $_REQUEST['subl_no'];



//for debugging_____________
//$sublNo = "2021012500191012";

if(empty($sublNo)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

if(strlen($sublNo) != 16){
    ajaxExitJson("전표번호를 바르게 입력하세요.");
}


$sublDate = substr($sublNo,0,8);
$taxNo = substr($sublNo,8,4);
$sublNo = substr($sublNo,12,4);


$sql = " select   subl_seq,subl_seq2,ju_qty,b_qty,bk_cd,bk_nm
                    from  bkmech
           where subl_date = '{$sublDate}'
              and tax_no =  '{$taxNo}'
              and subl_no =  '{$sublNo}'";


$stmt = sql_query($sql);
$i=0;
while ($row = sql_fetch_assoc($stmt)) {

    $list[$i] = $row;
    $i++;

} //end while ___-------------------------

echo json_encode($list);


/**
[
{
subl_seq: "1",
subl_seq2: "1",
ju_qty: "2",
b_qty: "2",
bk_cd: "32001",
bk_nm: "가장 아름다운 정원"
},
{
subl_seq: "2",
subl_seq2: "1",
ju_qty: "1",
b_qty: "1",
bk_cd: "50165",
bk_nm: "강철 변신"
},
 */