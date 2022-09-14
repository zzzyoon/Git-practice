<?php
//@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "출고조회 - gt >  주문 체크"
 *
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$bkCd = filteringSpcChr($_REQUEST['bk_cd']);
$sublDate = filteringSpcChr($_REQUEST['subl_date']);
$sublNo = filteringSpcChr($_REQUEST['subl_no']);


if(empty($bkCd) || empty($sublDate) || empty($sublNo)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}


$sql = "        Select  nvl(nvl(B.b_qty,0) - nvl(a.od_qty,0),0) as cnt from bjumun A left outer join bkmech B on
                 a.tax_no = b.tax_no and a.subl_no = b.subl_no and a.subl_date = b.subl_date and a.bk_cd = b.bk_cd
                 where A.tax_no = '0245'
                 and A.SUBL_DATE = '{$sublDate}'
                 and A.SUBL_NO = '{$sublNo}'
                 and A.bk_cd = '{$bkCd}'
          ";


$data = sql_result($sql);
echo $data;
