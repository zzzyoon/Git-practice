<?php
@header('Content-Type: application/json');
ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "출고조회 - 세종" 에서 호출
 *    : 출고 마스터 자료 추출
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$orderNo = clean_xss_tags(get_text($_REQUEST['order_no']));

//for debugging
//$orderNo = "20210205043650031";

if(empty($orderNo)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

if(strlen($orderNo) != 17){
    ajaxExitJson("주문번호를 바르게 입력하세요.");
}


$sublDate = substr($orderNo,0,8);
$taxNo = substr($orderNo,8,4);
$sublNo = substr($orderNo,12,4);
$chgSeq = substr($orderNo,16,1);

$sql = " select A.SUBL_DATE,A.TAX_NO,A.SUBL_NO,MECUST_NM2,
 COUNT(*) JU_CNT,SUM(B.JU_QTY) JU_QTY,SUM(NVL(B.B_QTY,0)) B_QTY,
 (select count(distinct(bk_cd)) from chulji where subl_date = A.subl_date and tax_no = A.tax_no and subl_no = A.subl_no and ju_qty = b_qty ) B_CNT,
 SUM(B.JU_QTY) - SUM(NVL(B.B_QTY,0)) U_B_QTY
 from  CHULMT A inner join  CHULJI B on a.SUBL_DATE = b.subl_DATE
  and a.tax_no = b.tax_no and a.subl_no = b.subl_no
  inner join bookcd C on b.bk_cd = c.bk_cd and b.tax_no = c.TAX_NO
 where A.CHK_GB <> 3
           and A.subl_date = '{$sublDate}'
              and A.tax_no =  '{$taxNo}'
              and A.subl_no =  '{$sublNo}'
              and A.chg_seq =  '{$chgSeq}'
           group by  A.SUBL_DATE,A.TAX_NO,A.SUBL_NO,MECUST_NM2  ";



$data = sql_fetch($sql);
echo json_encode($data);

/*
while ($row = sql_fetch_assoc($stmt)) {

    $list[$i] = $row;
    $i++;

} //end while ___-------------------------

echo json_encode($list);
*/



// sample

/***
 * {
0: "20210205",
1: "0436",
2: "5003",
3: "북센",
4: "1",
5: "4",
6: "4",
7: "1",
8: "0",
subl_date: "20210205",
tax_no: "0436",
subl_no: "5003",
mecust_nm2: "북센",
ju_cnt: "1",
ju_qty: "4",
b_qty: "4",
b_cnt: "1",
u_b_qty: "0"
}
 */