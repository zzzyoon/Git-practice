<?php
@header('Content-Type: application/json');
include_once('./_common.php');
//ini_set("display_errors", 1);

if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$_REQUEST = array_map_deep('clean_xss_tags', $_REQUEST);
$_REQUEST = array_map_deep('get_text', $_REQUEST);

$jgGb = $_REQUEST['jg_gb'];

$goodCd = $_REQUEST['good_cd'];
$goodNm = $_REQUEST['good_nm'];
$sizeGb = $_REQUEST['size_gb'];
$befLoc = filteringCode($_REQUEST['loc_cd']);
$afLloc = filteringCode($_REQUEST['mov_loc_cd']);
$moveQty = filteringCode($_REQUEST['mov_qty']);
$empId = $member['mb_id'];

//exitVarDump($_REQUEST);

if(!$jgGb || !$goodCd || !$sizeGb || !$befLoc || !$afLloc || !$moveQty || strlen($moveQty) == 0 || !$empId) {
    ajaxExitJson("*필수정보가 누락되었습니다.");
}

// 로케이션 존재 체크
$locRes = existLocCheck($afLloc);
if(!$locRes)
    ajaxExitJson("존재하지 않는 로케이션입니다. ");

//이전 재고수량 체크
$realQty = getBookJgQty($befLoc,$goodCd,$sizeGb,$jgGb); //서가변경은 정품 A
if($moveQty > $realQty){
    ajaxExitJson("[{$goodNm}] 상품의 서가변경 할 재고가 현재고 보다 많습니다.");
}

// 02. 서가변경 (부분이동) ////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

//원래의 처리 프로시져 >>>>   PROC_ALTERBOOKSHELF
// : 서가 전체 재고를 이동을 처리하는 프로세스에서 > 반품 + 서가 부분이동 가능한 구조로 변경   > 즉 서가 부분이동  (=ajax.book_jg_move_loc_update.php )


// BKSUBL table 데이터 입력
//  원코드  PKGMHPDA.PROC_INSBKMOVE_CHR(
//move_div 서가변경 구분자 때문에
if (substr($jgGb,0,1) == "5") {
    $sql = "begin CAPO.CAPOPDA_CAPO1.SP_MVLOCA_CAPO(
                '$goodCd','$sizeGb','$jgGb',
                '$befLoc','$afLloc','$moveQty','$empId'); end;";
} else {
    $sql = "begin UCAPO.UCAPOPDA_UCAPO1.SP_MVLOCA_UCAPO(
                '$goodCd','$sizeGb','$jgGb',
                '$befLoc','$afLloc','$moveQty','$empId'); end;";
}
$stmt = sql_query_parse($sql);
//oci_bind_by_name($stmt, ':p_good_cd', $gooCd,30);
//oci_bind_by_name($stmt, ':p_size_gb', $sizeGb,20);
//oci_bind_by_name($stmt, ':p_jg_gb',$jgGb,2);
//
////$sublSeq = "1";
////oci_bind_by_name($stmt, ':p_subl_seq', $sublSeq, 22);
//
//oci_bind_by_name($stmt, ':p_bef_loc', $befLoc,6);
//oci_bind_by_name($stmt, ':p_af_loc', $afLloc,6);
//
//oci_bind_by_name($stmt, ':p_b_qty', $moveQty,10);
//oci_bind_by_name($stmt, ':p_upd_emp', $empId,7);

//$moveDiv = "M"; // 이동사유(move_div) /  M = 서가변경
//oci_bind_by_name($stmt, ':p_move_div', $moveDiv, 1);

$res = sql_query_execute($stmt,G5_DISPLAY_SQL_ERROR,true);  // 프로시져 내부 MULTI DML QUERY

if(!$res)
    $isQueryError=true;

$resultStat=false;
$resultMsg = "";

if(!$isQueryError){
    sql_commit();

    $resultStat=true;
    $resultMsg = "서가이동이 정상 완료되었습니다. ";

} else {
    sql_rollback();

    $resultStat=false;
    $resultMsg = "서가이동시 오류가 발생했습니다.  ";

}



ajaxEchoJson($resultStat,$resultMsg);

