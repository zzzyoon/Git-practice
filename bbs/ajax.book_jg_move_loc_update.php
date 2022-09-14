<?php
@header('Content-Type: application/json');
include_once('./_common.php');
//ini_set("display_errors", 1);

/**
 *  선택 재고 이동 > 개별이동 > 일반서가
 */

if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}

/////////////////////////////////////////////////////

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$_REQUEST = array_map_deep('clean_xss_tags', $_REQUEST);
$_REQUEST = array_map_deep('get_text', $_REQUEST);

$jgGb = $_REQUEST['jg_gb']; //jg_gb 정품에선 정품으로 이동, 반품에선 반품으로 이동
$bkCd = $_REQUEST['bk_cd'];
$bkNm = $_REQUEST['bk_nm'];

$taxNo = $_REQUEST['tax_no'];
$custNm = $_REQUEST['cust_nm'];

$outDanga = $_REQUEST['out_danga'];
$moveQty = $_REQUEST['move_qty'];

$locCd = $_REQUEST['loc_cd']; //bookcd.loc_cd
//$curLocCd = $_REQUEST['cur_loc_cd']; //bksbjg.loc_cd/
$moveLocCd = strtoupper(str_replace("-","",$_REQUEST['move_loc_cd'])); //적치 로케이션
$moveQty = $_REQUEST['move_qty']; //적치 수량


$locGb = $_REQUEST['loc_gb'];//로케이션 구분
$moveGb = $_REQUEST['move_gb']; //일반21,합짐 구분23

/*
$sublGb="12";//본사
$grpNo="17";
$pubCode="0196";
*/

//trigger_error("error bkcd");
if(!$bkCd || !$bkNm || !$taxNo || !$custNm || !$moveQty || !$moveLocCd || !$locCd || strlen($outDanga) == 0) {
    ajaxExitJson("*필수정보가 누락되었습니다.");
}


// 적치 로케이션 유효성 체크  (clsLocSch.schREc 함수 75 line) ------------------------------------------------------------
//$locGb = MH_LOC_GB_SHELF; // 상수할당 / 참고용 clsMovShelf.cs 37line
$res = validateLocCode($moveLocCd,$locGb);
if($res !== true){
    ajaxExitJson($res);
}

// 로케이션 존재 체크
$locRes = existLocCheck($moveLocCd);
if(!$locRes)
    ajaxExitJson("존재하지 않는 적치 로케이션입니다. ");

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
//01. subl_date, subl_no 추출 _________________ _____________________________
$sql = "begin PKGMHPDA.PROC_GETMOVEKEY(:p_tax_no,:p_subl_date,:p_subl_no); end;";
$stmt = sql_query_parse($sql);


oci_bind_by_name($stmt, ':p_tax_no', $taxNo,4) ; //in parameter
oci_bind_by_name($stmt, ':p_subl_date', $sublDate,10) ; //out parameter
oci_bind_by_name($stmt, ':p_subl_no', $sublNo,10) ; //out parameter

// Execute the statement as in your first try
sql_query_execute($stmt);


if(!$sublDate || !$sublNo){
    ajaxExitJson("필수 파라미터 생성에 실패했습니다. ");
}






// 02. 선택 재고 이동 > 일반서가  / 데이터 전송 ////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////


// BKMOVE table 데이터 입력
$sql = "begin PKGMHPDA.PROC_INSBKMOVE_CHR(
                :p_subl_date,:p_tax_no,:p_subl_no,:p_subl_seq,
                :p_subl_gb,:p_bk_cd,:p_bk_nm,:p_move_gb,
                :p_loc_cd1,:p_loc_cd2,:p_jg_gb1,:p_jg_gb2,
                :p_cust_nm,:p_b_qty,:p_out_danga,:p_pm_remk,
                :p_upd_emp
                ); end;";

$stmt = sql_query_parse($sql);


oci_bind_by_name($stmt, ':p_subl_date', $sublDate, 8);
oci_bind_by_name($stmt, ':p_tax_no', $taxNo, 4);

$sublGb = "31";
oci_bind_by_name($stmt, ':p_subl_gb', $sublGb, 2); //로케이션 이동
oci_bind_by_name($stmt, ':p_subl_no', $sublNo, 22);

$sublSeq = "1";
oci_bind_by_name($stmt, ':p_subl_seq', $sublSeq, 22);

oci_bind_by_name($stmt, ':p_bk_cd', $bkCd, 15);
oci_bind_by_name($stmt, ':p_bk_nm', $bkNm, 100);


//$moveGb = "21";  // 일반 21, 합짐 23_________________________________
oci_bind_by_name($stmt, ':p_move_gb',$moveGb, 2); //이동 구분 :  pda이동



oci_bind_by_name($stmt, ':p_loc_cd1', $locCd, 6); //// bksbjg.loc_cd 원서가
oci_bind_by_name($stmt, ':p_loc_cd2', $moveLocCd, 6); //// 이동서가

//$jgGb1 = "A";
//$jgGb2 = "A";
oci_bind_by_name($stmt, ':p_jg_gb1', $jgGb, 2); // 추가된 재고구분자
oci_bind_by_name($stmt, ':p_jg_gb2', $jgGb, 2); // 적치는 정품에서 정품으로 이동, 반품에서 반품으로 같은 구분자에서만 이동가능
oci_bind_by_name($stmt, ':p_cust_nm', $custNm, 40);



oci_bind_by_name($stmt, ':p_b_qty', $moveQty, 22);
oci_bind_by_name($stmt, ':p_out_danga', $outDanga, 22);

$pmRemk = iconv_euckr("NEW PDA / 선택 재고이동 [개별 전송]");
oci_bind_by_name($stmt, ':p_pm_remk', $pmRemk, 100);
oci_bind_by_name($stmt, ':p_upd_emp', $member['mb_id'], 5);




//echo"<hr>";
//echo  "bkcd : ".$bkCd." / taxno: ".$taxNo." /jggb : ".$jgGb1." / loccd : ".$curLocCd;
//exit;

$res = sql_query_execute($stmt);
$resultStat=false;
$resultMsg = "";

if($res){

    $resultStat=true;
    $resultMsg = "재고이동이 완료되었습니다. ";

} else {


    $resultStat=false;
    $resultMsg = "재고이동 전송시 오류가 발생했습니다.  ";

}

ajaxEchoJson($resultStat,$resultMsg);

