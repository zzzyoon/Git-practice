<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$_REQUEST = array_map_deep('filteringSpcChr', $_REQUEST);


$sublMonth = $_REQUEST['subl_month'];
$taxNo = $_REQUEST['tax_no'];
$bkCd = $_REQUEST['bk_cd'];
$srchType = $_REQUEST['srch_type'];  //H 히트수, G 골드존 히트수



$giBusu=10; // 골드존 조회 > 기준부수

//$bookCd = "15002";
//$taxNo = "0037";

//히트수
//$srchType="H";
//$sublMonth="202102";
//$taxNo="0001";
//$bkCd="12020";

//골드존 - 히트수 샘플
//$srchType="G";
//$sublMonth="202102";
//$taxNo="0003";
//$bkCd="14045";

/**
 * 0003 정신세계사
14045
9788935703081
리얼리티 트랜서핑1
 *
 */

if(empty($sublMonth) || empty($taxNo) || empty($bkCd) || empty($srchType)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

$sql = "";
if($srchType == "H") { // 일반서가 - 히트수
    $sql = " SELECT A.TAX_NO  TAX_NO,
	              A.BK_CD   BK_CD,
	              MAX(A.CUST_NM) CUST_NM,
	              MAX(A.BK_NM) BK_NM,
	              MAX(A.OUT_DANGA) OUT_DANGA,
 	              MAX(SUBSTRB(B.loc_cd,1,2)||'-'||SUBSTRB(B.loc_cd,3,2)||'-'||SUBSTRB(B.loc_cd,5,2)) LOC_CD,
 	              MAX(B.ipsu_qty) IPSU_QTY,
	              SUM(DECODE(A.SUBL_GB,'51',DECODE(SUBSTR(A.LOC_CD,1,1),'A',1,0),0))       SHIT_QTY,
	              SUM(DECODE(A.SUBL_GB,'51',DECODE(SUBSTR(A.LOC_CD,1,1),'A',A.B_QTY,0),0)) SHIT_AMT,
		            SUM(DECODE(A.SUBL_GB,'51',DECODE(SUBSTR(A.LOC_CD,1,1),'A',0,1),0))       RHIT_QTY,
		            SUM(DECODE(A.SUBL_GB,'51',DECODE(SUBSTR(A.LOC_CD,1,1),'A',0,A.B_QTY),0)) RHIT_AMT,
		            SUM(DECODE(A.SUBL_GB,'52',A.B_QTY,0)) NW_AMT,
		            MAX((SELECT NVL(C.JG_QTY,0) FROM BKSBJG C WHERE C.TAX_NO = A.TAX_NO AND C.BK_CD = A.BK_CD AND C.LOC_CD = B.LOC_CD AND C.JG_GB = 'A')) JG_QTY
         FROM   V_BKMECH2 A ,BOOKCD B
WHERE A.SUBL_DATE like '{$sublMonth}%'
   AND  A.TAX_NO = '{$taxNo}'
 AND A.BK_CD = '{$bkCd}'
    AND A.TAX_NO = B.TAX_NO
    AND A.BK_CD  = B.BK_CD
    AND A.JG_GB = 'A'
    AND A.B_QTY > 0
    GROUP BY A.TAX_NO,A.BK_CD
   ";

} else {   // 골드존 - 히트수

    $sql="
     SELECT A.TAX_NO          TAX_NO,
	                A.BK_CD           BK_CD,
	                SUBSTRB(A.loc_cd,1,2)||'-'||SUBSTRB(A.loc_cd,3,2)||'-'||SUBSTRB(A.loc_cd,5,2) LOC_CD,
	                max(A.CUST_NM)    CUST_NM,
	                max(A.BK_NM)      BK_NM,
	                max(A.OUT_DANGA)  OUT_DANGA,
 	                max(B.ipsu_qty)   IPSU_QTY,
	                0                 SHIT_QTY,
	                0                 SHIT_AMT,
		              sum(1)            RHIT_QTY,
		              sum(A.B_QTY)      RHIT_AMT,
		              sum(DECODE(SUBSTRB(A.LOC_CD,1,1),'G',1,0))        G_RHIT_QTY,
		              sum(DECODE(SUBSTRB(A.LOC_CD,1,1),'G',A.B_QTY,0))  G_RHIT_AMT,
		              0                                                   NW_AMT,
		              sum(nvl(c.jg_qty,0) - nvl(c.chul_qty,0))            JG_QTY
           FROM   V_BKMECH2 A, BOOKCD B, BKSBJG C
WHERE A.SUBL_DATE  like '{$sublMonth}%'
  AND A.TAX_NO != '0300'
  AND A.METAX_NO != '05414'
  AND A.B_QTY >= {$giBusu}
        AND A.TAX_NO = '{$taxNo}'
        AND A.BK_CD = '{$bkCd}'
  AND A.TAX_NO = B.TAX_NO
  AND A.BK_CD  = B.BK_CD
  AND A.JG_GB = 'A'
  AND A.B_QTY > 0
  AND ((A.TAX_NO != '0245' AND NVL(B.OUT_DANGA,0) != 0) OR (A.TAX_NO = '0245'))
        AND SUBSTRB(A.LOC_CD,1,1) NOT IN('A')
  and c.bk_cd = a.bk_cd and c.tax_no = a.tax_no and c.jg_gb = 'A' and c.loc_cd = a.loc_cd
    and (a.subl_date, a.tax_no, a.subl_no) in (
    select subl_date, tax_no, subl_no from CHULMT
     where  subl_date like '{$sublMonth}%'
      and    team_cd   != '34'
  	   )

 GROUP BY A.TAX_NO,A.BK_CD,A.LOC_CD
    ";



}



//order by   TAX_NO,SHIT_QTY DESC,BK_NM
$result = sql_query($sql);
$list = array();
$i=0;
while ($row = sql_fetch_array($result)) {
    $list[$i] = $row;

    $i++;
    //$hidData = json_encode($row);
} //end while ___-------------------------


echo json_encode($list);


/**
 *
 * 일반서가 - 히트수조회
 *
 * [
{
0: "0001",
1: "12020",
2: false,
3: false,
4: "12000",
5: "A2-14-45",
6: "30",
7: "2",
8: "3",
9: "0",
10: "0",
11: "0",
12: "30",
tax_no: "0001",
bk_cd: "12020",
cust_nm: false,
bk_nm: false,
out_danga: "12000",
loc_cd: "A2-14-45",
ipsu_qty: "30",
shit_qty: "2",
shit_amt: "3",
rhit_qty: "0",
rhit_amt: "0",
nw_amt: "0",
jg_qty: "30"
}
]
 */



/***
 *
 *  // 골드존 - 히트수조회
 *
 * [
{
0: "0003",
1: "14045",
2: "GT-45-01",
3: false,
4: false,
5: "11000",
6: "30",
7: "0",
8: "0",
9: "1",
10: "50",
11: "1",
12: "50",
13: "0",
14: "477",
tax_no: "0003",
bk_cd: "14045",
loc_cd: "GT-45-01",
cust_nm: false,
bk_nm: false,
out_danga: "11000",
ipsu_qty: "30",
shit_qty: "0",
shit_amt: "0",
rhit_qty: "1",
rhit_amt: "50",
g_rhit_qty: "1",
g_rhit_amt: "50",
nw_amt: "0",
jg_qty: "477"
}
]
 *
 */