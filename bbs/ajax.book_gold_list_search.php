<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}


$sublMonth = filteringSpcChr($_REQUEST['subl_month']);
//$locCode = filteringSpcChr($_REQUEST['loc_cd']);

$minRow = filteringSpcChr($_REQUEST['min_row']);
$maxRow = filteringSpcChr($_REQUEST['max_row']);

$busuQty = $_REQUEST['busu_qty']; //기준부수 > 기본 10
$srchType = $_REQUEST['srch_type'];  //1 제외, 3 골드존



//골드존 - 히트수 샘플

//for debugging
//$sublMonth="202101";
//$busuQty=10;
//$srchType="3"; //골드존

/**
 * 0003 정신세계사
14045
9788935703081
리얼리티 트랜서핑1
 *
 */

if(empty($sublMonth) || empty($busuQty) || empty($srchType)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

//SUBSTRB(A.loc_cd,1,2)||'-'||SUBSTRB(A.loc_cd,3,2)||'-'||SUBSTRB(A.loc_cd,5,2) LOC_CD,

$sql="
     SELECT A.TAX_NO          TAX_NO,
	                A.BK_CD           BK_CD,
	                A.LOC_CD,
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
  AND A.TAX_NO = B.TAX_NO
  AND A.BK_CD  = B.BK_CD
  AND A.JG_GB = 'A'
  AND A.B_QTY > 0
  AND ((A.TAX_NO != '0245' AND NVL(B.OUT_DANGA,0) != 0) OR (A.TAX_NO = '0245')) ";


if($srchType == "1") { //골드존 제외
    //$sql .= "  and substrb(a.loc_cd,1,1) not in('G','A') ";  //oracle substr > start index is 1 , not 0
    $sql .= " and substrb(a.loc_cd,1,1) in('G')    AND A.B_QTY <= {$busuQty} "; //20210404

}else if($srchType == "3") { //골드존

    $sql .= " and substrb(a.loc_cd,1,1) in('G')    AND A.B_QTY >= {$busuQty} ";


}




$non_search_sql = "";
if(strlen($minRow) > 0 && strlen($maxRow) > 0){
    $sql.=" and substr(a.loc_cd,2,1) between '{$minRow}' and '{$maxRow}' ";
    $non_search_sql = " and substr(loc_cd,2,1) between '{$minRow}' and '{$maxRow}' ";
}

//   }   로케이션 검색 ----------------------------------------------------------  -----------------------------------------



// 매출이 없는 로케이션 검색
$non_sql = "SELECT MAX(TAX_NO) ,MAX(BK_CD),LOC_CD,MAX(CUST_NM),MAX(BK_NM), MAX(OUT_DANGA),0,0,0,0,0,0,0,0,0 FROM (
 SELECT TAX_NO,BK_CD,T.LOC_CD,CUST_NM,BK_NM,OUT_DANGA
 FROM (
SELECT LOC_CD,WH_CD FROM BKLOCA a
WHERE substrb(loc_cd,1,1) in('G')
{$non_search_sql}
AND NOT exists(SELECT 1 FROM bkmech WHERE SUBL_DATE LIKE '{$sublMonth}%' AND LOC_CD = a.LOC_CD)
) T  JOIN BKSBJG  B ON (B.LOC_CD = T.LOC_CD AND JG_GB = 'A')
) GROUP BY LOC_CD ";


$sql.=" and c.bk_cd = a.bk_cd and c.tax_no = a.tax_no and c.jg_gb = 'A' and c.loc_cd = a.loc_cd
    and (a.subl_date, a.tax_no, a.subl_no) in (
    select subl_date, tax_no, subl_no from CHULMT
     where  subl_date like '{$sublMonth}%'
      and    team_cd   != '34'
  	   )
 GROUP BY A.TAX_NO,A.BK_CD,A.LOC_CD
 UNION
 {$non_sql}
  order by TAX_NO,BK_CD,loc_cd
  ";

//exit($sql);

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