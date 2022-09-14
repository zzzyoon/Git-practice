<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "출고조회 - gt" 에서 호출
 *
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$invNo = filteringSpcChr($_REQUEST['inv_no']);
$sublDate = filteringSpcChr($_REQUEST['subl_date']);


//for debugging
//$invNo = "387151155782";
//$sublDate="20210210";

/**
 * 387151034531
 * 387151037095
 */

if(empty($invNo) || empty($sublDate)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

if(strlen($invNo) != 12 && strlen($invNo) != 4){
    ajaxExitJson("송장번호를 바르게 입력하세요.");
}


$sql = "SELECT A.SUBL_DATE,B.INV_NO,A.SUBL_DATE || A.TAX_NO||A.SUBL_NO AS SLIPNO,A.SUBL_NO ,
                 A.BK_CD,A.BK_NM,A.JU_QTY ,B.BESONG_GB ,substr(B.INV_NO,12,1) BITA,decode(b.parcel_comp,'CJ',mod(substrb(B.INV_NO,3,9),7),'LG',mod(substrb(B.INV_NO,1,11),7),'LO',mod(substrb(B.INV_NO,1,11),7)) BITB
                            FROM CHULJI a INNER JOIN chulmt b ON
                          A.SUBL_DATE = b.subl_date and A.TAX_NO = b.tax_no
                             AND a.subl_no = b.subl_no
                             WHERE A.tax_no = '0245'
          ";



if(strlen($invNo) == 12){ //송장번호  ++++++++++++++++++++++++++++++++++++
    $sql.="  and A.SUBL_DATE = '{$sublDate}'   and B.INV_NO = '{$invNo}' ";
} else { // 수불번호 4자리 +++++++++++++++++++++++++++
    $sql.="  and A.SUBL_DATE = '{$sublDate}'   and A.SUBL_NO = '{$invNo}' ";
}

$data = sql_fetch($sql);


// gt 주문번호 추출
$orderNo = sql_result("select order_serial_no from bjumun  where  subl_date = '{$sublDate}' and tax_no = '0245' and subl_no = '{$data['subl_no']}' ");
if(!$orderNo)
    $orderNo = 0;

$data['order_no'] = $orderNo;
echo json_encode($data);

/**
0: "20210125",
1: "387151023353",
2: "2021012502451293",
3: "1293",
4: "13300021",
5: "도레미곰 2판 1-box",
6: "1",
7: "41",
8: "3",
9: "3",
subl_date: "20210125",
inv_no: "387151023353",
slipno: "2021012502451293",
subl_no: "1293",
bk_cd: "13300021",
bk_nm: "도레미곰 2판 1-box",
ju_qty: "1",
besong_gb: "41",
bita: "3",
bitb: "3"
 */