<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "출고조회 - gt > 검수수량 + 주문수량 추출" 에서 호출
 *
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$bkCd = filteringSpcChr($_REQUEST['bk_cd']);
$sublDate = filteringSpcChr($_REQUEST['subl_date']);


//$bkCd = "13300021";
//$sublDate="20210205";

if(empty($bkCd) || empty($sublDate)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}


$sql = "select (select sum(nvl(b_qty,0)) from bkmech
                 where subl_date  =
                '{$sublDate}'
                 and bk_cd =
                '{$bkCd}'
                 and tax_no = '0245' ) as chk_qty,
                 (select sum(nvl(a.qty,0)) as qqq from gbooks.gt_bjumun a, CHULMT b
                 where a.subl_date  =   '{$sublDate}'
                  and a.goods_code =  '{$bkCd}'
                  and b.subl_date(+) = a.subl_date
                 and b.tax_no(+)    = '0245'
                 and b.subl_no(+)   = a.subl_no
                 and b.besong_gb(+) = '41'
                  and nvl(b.del_yn,'N') != 'Y'
                  ) as order_qty
                 from dual
          ";


$data = sql_fetch($sql);
echo json_encode($data);


/**
 * {
0: "83",
1: "83",
chk_qty: "83",
order_qty: "83"
}
 */