<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
   ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}

/**
 *   "상차등록 - 전송하기"
 *
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$_REQUEST = array_map_deep('filteringSpcChr', $_REQUEST);



$sublNo = $_REQUEST['old_subl_no'];
$custNm = $_REQUEST['cust_nm'];
$meTaxNo = $_REQUEST['metax_no'];
$meCustNm = $_REQUEST['mecust_nm'];
$jgGb = $_REQUEST['jg_gb'];
$juQty = $_REQUEST['ju_qty'];
$odQty = $_REQUEST['od_qty'];
$outQty = $_REQUEST['tot_qty']; //out_qty

$scanCnt = $_REQUEST['scan_cnt'];


//exitVarDump($_REQUEST);


//for debugging_____________
//$sublNo = "2021012500191012";

if(empty($sublNo) || empty($custNm) || empty($meCustNm) || empty($meTaxNo) || empty($jgGb)
                        || strlen($juQty) == 0 | strlen($odQty) == 0 || strlen($outQty) == 0 || strlen($scanCnt) == 0 )

if(empty($sublNo)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}

if(strlen($sublNo) != 16){
    ajaxExitJson("전표번호를 바르게 입력하세요.");
}

$sublDate = substr($sublNo,0,8);
$taxNo = substr($sublNo,8,4);
$sublNo = substr($sublNo,12,4);

$isUpdate = false;

$sql = "select * from bkload   where subl_date = '{$sublDate}'
              and tax_no =  '{$taxNo}'
              and subl_no =  '{$sublNo}' ";

$cdata = sql_fetch($sql);
if(!$cdata){
    $sql = "insert  into bkload(subl_date,tax_no,subl_no,jg_gb,cust_nm,metax_no,mecust_nm,
                      od_qty,ji_qty,out_qty,
                      load_date,load_time,load_emp,load_ip,load_scan_cnt,
                      ins_date,ins_emp,ins_ip)
          values('{$sublDate}','{$taxNo}','{$sublNo}','{$jgGb}','{$custNm}','{$meTaxNo}','{$meCustNm}',
          {$odQty},{$juQty},{$outQty},
          '".G5_TIME_YMD_PURE."','".substr(G5_TIME_HIS_PURE,0,4)."','{$member['mb_id']}','{$_SERVER['REMOTE_ADDR']}',{$scanCnt},
          '".G5_TIME_YMDHIS_PURE."','{$member['mb_id']}','{$_SERVER['REMOTE_ADDR']}'
          )";

} else {
    $isUpdate=true;

    $sql = " update  bkload  set
            load_scan_cnt = load_scan_cnt + {$scanCnt},
            upd_date = '".G5_TIME_YMDHIS_PURE."',
            upd_emp = '{$member['mb_id']}',
            upd_ip = '{$_SERVER['REMOTE_ADDR']}'
        where subl_date = '{$sublDate}'
        and tax_no =  '{$taxNo}'
        and subl_no =  '{$sublNo}' ";
}

$res = sql_query($sql);

if($res){

    $dataType = (!$isUpdate)?"등록":"수정";
    ajaxEchoJson(true,"상차등록자료 정상 전송되었습니다. (*".$dataType.")");
} else {
    ajaxEchoJson(false,"상차등록자료 전송시 오류가 발생했습니다.");
}


