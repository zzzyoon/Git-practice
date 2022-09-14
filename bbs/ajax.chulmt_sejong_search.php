<?php
@header('Content-Type: application/json');
ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "출고조회 - 세종" 에서 호출
 *
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

$sql = " select A.SUBL_DATE,A.TAX_NO,A.SUBL_NO,
          B.SUBL_SEQ,B.SUBL_SEQ2,B.BK_NM,B.BK_CD,
          A.MECUST_NM,A.CUST_NM, B.JU_QTY  JU_QTY, NVL(B.B_QTY,0) B_QTY,
          NVL(A.DUNG_QTY,0) DUNG_QTY , case when NVL(B.B_QTY,0) > 0 and  NVL(B.B_QTY,0) = b.ju_qty then 'Y' else 'N' end  AS STATUS,
          A.CHK_GB,C.BAR_CD,A.METAX_NO,B.UPD_DATE
          from  CHULMT A inner join  CHULJI B on a.SUBL_DATE = b.subl_DATE
           and a.tax_no = b.tax_no and a.subl_no = b.subl_no
           inner join bookcd C on b.bk_cd = c.bk_cd
           and b.tax_no = c.TAX_NO
           where A.subl_date = '{$sublDate}'
              and A.tax_no =  '{$taxNo}'
              and A.subl_no =  '{$sublNo}'
              and A.chg_seq =  '{$chgSeq}'
          order by B.UPD_DATE,C.bk_nm,B.bk_cd ";


$stmt = sql_query($sql);
$i=0;
while ($row = sql_fetch_assoc($stmt)) {

    $list[$i] = $row;
    $i++;

} //end while ___-------------------------

echo json_encode($list);


/**
[
0: "20210205",
1: "0436",
2: "5003",
3: "1",
4: "1",
5: "깨끗한 존경",
6: "00003",
7: "북센",
8: "헤엄출판사",
9: "4",
10: "4",
11: "1",
12: "Y",
13: "4",
14: "9791196589141",
15: "02501",
16: "20210205115229",

subl_date: "20210205",
tax_no: "0436",
subl_no: "5003",
subl_seq: "1",
subl_seq2: "1",
bk_nm: "깨끗한 존경",
bk_cd: "00003",
mecust_nm: "북센",
cust_nm: "헤엄출판사",
ju_qty: "4",
b_qty: "4",
dung_qty: "1",
status: "Y",
chk_gb: "4",
bar_cd: "9791196589141",
metax_no: "02501",
upd_date: "20210205115229"
}
 */