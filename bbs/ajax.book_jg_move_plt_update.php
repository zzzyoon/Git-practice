<?php
@header('Content-Type: application/json');
include_once('./_common.php');
//ini_set("display_errors", 1);
/**
 *  선택 재고 이동 > 개별이동 > 팔레트 서가
 */

if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}

/////////////////////////////////////////////////////

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$_REQUEST = array_map_deep('clean_xss_tags', $_REQUEST);
$_REQUEST = array_map_deep('get_text', $_REQUEST);

$jgGb = $_REQUEST['jg_gb']; //jg_gb 정품에선 정품으로 이동, 반품에선 반품으로 이동
$movGb = $_REQUEST['mov_gb']; //파레트 이동 구분자
$bkCd = $_REQUEST['bk_cd'];
$taxNo = $_REQUEST['tax_no'];
$moveQty = $_REQUEST['move_qty'];
$locCd = $_REQUEST['loc_cd']; //bookcd.loc_cd
$moveLocCd = strtoupper(str_replace("-","",$_REQUEST['move_loc_cd'])); //적치 로케이션
$pltCombined = $_REQUEST['plt_combined']; //plt 합짐 구분자
$sublNo = $_REQUEST['subl_no'];

/*
$sublGb="12";//본사
$grpNo="17";
$pubCode="0196";
*/

//trigger_error("error bkcd");

if(!$jgGb || !$bkCd  || !$taxNo || !$moveQty || !$moveLocCd || !$locCd  || !$sublNo || !$movGb) {

    ajaxExitJson("*필수정보가 누락되었습니다.(1)");

}


// 파레트  로케이션 유효성 체크  (clsLocSch.schREc 함수 75 line) ------------------------------------------------------------
//$locGb = MH_LOC_GB_SHELF; // 상수할당 / 참고용 clsMovShelf.cs 37line
$res = validatePltCode($moveLocCd,$movGb,($pltCombined=="Y")?true:false);
if($res !== true){
    ajaxExitJson($res);
}

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
//01. subl_date, subl_no 추출 _________________ _____________________________
/*
$sql = "begin PKGMHPDA.PROC_PLTTINKEY(:p_plt_cd,:p_subl_no); end;";
$stmt = sql_query_parse($sql);


oci_bind_by_name($stmt, ':p_plt_cd', $moveLocCd,10) ; //in parameter
oci_bind_by_name($stmt, ':p_subl_no', $sublNo2,22) ; //out parameter  >> 추출해놓고 사용을 하지 않는다 ????

// Execute the statement as in your first try
sql_query_execute($stmt);

if(!$sublNo2){
    ajaxExitJson("필수 파라미터 생성에 실패했습니다. ");
}
*/



// 02. 선택 재고 이동 > 일반서가  / 데이터 전송 ////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////


// BKMOVE table 데이터 입력
$sql = "begin PKGMHPDA.PROC_MOVPLTTIN_CHR(
                :p_plt_cd,:p_plt_cd_aft,:p_bk_cd,
                :p_tax_no,:p_jg_gb,:p_subl_no,
                :p_b_qty, :p_upd_emp
                ); end;";

$stmt = sql_query_parse($sql);

oci_bind_by_name($stmt, ':p_plt_cd', $locCd, 10);
oci_bind_by_name($stmt, ':p_plt_cd_aft', $moveLocCd, 10);

oci_bind_by_name($stmt, ':p_bk_cd', $bkCd, 15);
oci_bind_by_name($stmt, ':p_tax_no', $taxNo, 4);
oci_bind_by_name($stmt, ':p_jg_gb', $jgGb, 2); //  재고 구분자

oci_bind_by_name($stmt, ':p_subl_no', $sublNo, 22);
oci_bind_by_name($stmt, ':p_b_qty', $moveQty, 22);

oci_bind_by_name($stmt, ':p_upd_emp', $member['mb_id'], 5);

//echo"<hr>";
//echo  "bkcd : ".$bkCd." / taxno: ".$taxNo." /jggb : ".$jgGb1." / loccd : ".$curLocCd;
//exit;

$res = sql_query_execute($stmt);
$resultStat=false;
$resultMsg = "";

if($res){

    $resultStat=true;
    $resultMsg = "파레트간 재고이동이 완료되었습니다. ";

} else {


    $resultStat=false;
    $resultMsg = "재고이동 전송시 오류가 발생했습니다.  ";

}

ajaxEchoJson($resultStat,$resultMsg);

