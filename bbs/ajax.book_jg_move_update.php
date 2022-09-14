<?php
@header('Content-Type: application/json');
include_once('./_common.php');
//ini_set("display_errors", 1);

/**
 *  선택 재고 이동 > 전체 이동
 */

if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}

/////////////////////////////////////////////////////
$sublNo = 0;
$pResult = 0; //result > out parameter
$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$_REQUEST = array_map_deep('clean_xss_tags', $_REQUEST);
$_REQUEST = array_map_deep('get_text', $_REQUEST);


$goodList = $_REQUEST['row_good_cd']; // good_cd
$sizeList = $_REQUEST['row_size_gb']; // 사이즈
$locList = $_REQUEST['row_loc_cd']; // 원서가

$movQtyList = $_REQUEST['row_mov_qty']; //이동 수량
$movLocList = $_REQUEST['aloc_cd']; // 이동서가

// 기본서가 추가 전달받음 - 유효성 체크
//$defLocList = $_REQUEST['row_def_loc_cd'];

// 이전 qty 체크하기위해 추가
$jgQtyList = $_REQUEST['row_jg_qty'];

$jgGb = $_REQUEST['row_jg_gb']; //jg_gb 정품에선 정품으로 이동, 반품에선 반품으로 이동
//$locGb = $_REQUEST['loc_gb'];//로케이션 구분
//$movGb = $_REQUEST['mov_gb']; //파레트 이동 구분자 (상수값)
//$moveGb = $_REQUEST['move_gb']; //일반21,합짐 구분23


if(!$goodList || !$sizeList || !$locList || !$movQtyList || !$movLocList) {
    ajaxExitJson("*필수정보가 누락되었습니다.");
}

if(count($goodList) != count($movQtyList)){
    ajaxExitJson("*이동 수량에 오류가 있습니다. ");
} else {

    for($i = 0;$i<count($locList);$i++){
        $locList[$i] = filteringCode($locList[$i]);
        $movLocList = filteringCode($movLocList);
    }


    //이전 재고 수량 체크
    for($i = 0;$i<count($goodList);$i++){

        if(!$movQtyList[$i])
            continue;

        if($movQtyList[$i] > $jgQtyList[$i]){
            $goodData = getBookcd($sizeList[$i],$goodList[$i]);
            ajaxExitJson("[{$goodData['good_nm']}] 상품의 이동 할 재고가 현재고 보다 많습니다.");
        }
    } //end if_____________

}

$isPalletLoc=false;
$locLen = 0;
for($i = 0;$i<count($locList);$i++){


    if(empty($movLocList) || !$movQtyList[$i])
        continue;


    $locLen = strlen($locList[$i]);
    if($locLen != 6)
        $isPalletLoc=true;
    else
        $isPalletLoc=false;


    if(strlen($locList[$i]) != $locLen || strlen($movLocList) !=  $locLen){
        ajaxExitJson("*이동 로케이션에 이상이 있습니다. ");
    }



} //end for______________________________________________________ __________________________


$isQueryError=false;
$isOciTransaction=true;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//전체이동
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (substr($jgGb,0,1) == "5") {
//01.subl_no 추출 _________________ _____________________________
    $sql = "select nvl(max(subl_no),0)+1 sublno from capo.movedt where subl_date = to_char(sysdate,'yyyymmdd') and subl_gb = '61'"; //
} else {
    $sql = "select nvl(max(subl_no),0)+1 sublno from ucapo.movedt where subl_date = to_char(sysdate,'yyyymmdd') and subl_gb = '61'"; //
}
$sublNo = sql_result($sql);

if(!$sublNo){
    ajaxExitJson("수불번호 에러");
}

    $isQueryError=false;
    $isOciTransaction=true;
    for($i=0;$i<count($goodList);$i++) {

        //move_qty, move_loc_cd 빈값이 존재
        if(empty($movLocList) || !$movQtyList[$i])
            continue;

        // 02. 선택 재고 이동 > 일반서가  / 데이터 전송 ////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        if (substr($jgGb,0,1) == "5") {
            // BKMOVE table 데이터 입력
            $sql = "begin CAPO.CAPOPDA_CAPO1.SP_MVLOCABATCH_CAPO(
                :p_subl_no, :p_bef_loc, :p_af_loc, :p_jg_gb,
                :p_p_good_cd, :p_size_gb, :p_b_qty, :p_upd_emp,:p_res); end;";
        } else {
            $sql = "begin UCAPO.UCAPOPDA_UCAPO1.SP_MVLOCABATCH_UCAPO(
                :p_subl_no, :p_bef_loc, :p_af_loc, :p_jg_gb,
                :p_p_good_cd, :p_size_gb, :p_b_qty, :p_upd_emp,:p_res); end;";
        }
//        $sql = "begin CAPOPDA_CAPO1.SP_MVLOCABATCH_CAPO(
//                '$sublNo', '$locList[$i]', '$movLocList[$i]', '$jgGb[$i]',
//                '$goodList[$i]', '$sizeList[$i], $movQtyList[$i], :p_upd_emp,'$pResult'); end;";


        $stmt = sql_query_parse($sql);

        oci_bind_by_name($stmt, ':p_subl_no', $sublNo);
        oci_bind_by_name($stmt, ':p_bef_loc', $locList[$i]);

        oci_bind_by_name($stmt, ':p_af_loc', $movLocList);
        oci_bind_by_name($stmt, ':p_jg_gb', $jgGb[$i]);
        oci_bind_by_name($stmt, ':p_p_good_cd', $goodList[$i]); //  재고 구분자

        oci_bind_by_name($stmt, ':p_size_gb',$sizeList[$i]);
        oci_bind_by_name($stmt, ':p_b_qty',$movQtyList[$i]);

        oci_bind_by_name($stmt, ':p_upd_emp', $member['mb_id']);
        oci_bind_by_name($stmt, ':p_res',$pResult) ;

        $res = sql_query_execute($stmt,G5_DISPLAY_SQL_ERROR,$isOciTransaction);

        if(!$res) {
            $isQueryError = true;
        }


//        unset($sublNo);
    } //end for  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


    // 팔레트 서가 > 전체이동 >결과 리턴
    if(!$isQueryError){
        sql_commit();
        $resultStat=true;
        $resultMsg = "재고이동이 완료되었습니다. ";

    } else {
        sql_rollback();
        $resultStat=false;
        $resultMsg = "재고이동시 오류발생으로 전송이 취소되었습니다. ";

    }

    ajaxEchoJson($resultStat,$resultMsg);