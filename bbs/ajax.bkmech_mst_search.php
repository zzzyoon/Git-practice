<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "상차등록 - 출고데이터 조회"
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


$sql = " select max(jg_gb) as jg_gb, max(tax_no) as tax_no,max(cust_nm) as cust_nm,max(metax_no) as metax_no, max(mecust_nm) as mecust_nm,
           count(*) as tot_cnt,sum(b_qty) as tot_qty,nvl(sum(od_qty),0) as od_qty,nvl(sum(ju_qty),0) as ju_qty
                    from  bkmech
           where subl_date = '{$sublDate}'
              and tax_no =  '{$taxNo}'
              and subl_no =  '{$sublNo}'";

//sleep(4); //for testing
$data = sql_fetch($sql);
echo json_encode($data);


/**
 *
{
tax_no: "0019",
cust_nm: "산하",
metax_no: "03609",
mecust_nm: "SD 커뮤니케이션(에스디)",
tot_cnt: "9",
tot_qty: "10"
}

 */