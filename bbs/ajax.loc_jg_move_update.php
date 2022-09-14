<?php
@header('Content-Type: application/json');
include_once('./_common.php');
//ini_set("display_errors", 1);

/**
 *  전체 재고이동
 */

if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}

/////////////////////////////////////////////////////

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$_REQUEST = array_map_deep('clean_xss_tags', $_REQUEST);
$_REQUEST = array_map_deep('get_text', $_REQUEST);

// 배열 변수
$bkList = $_REQUEST['row_bk_cd'];
$taxList = $_REQUEST['row_tax_no'];
$locList = $_REQUEST['row_loc_cd'];
$movQtyList = $_REQUEST['row_mov_qty'];
// 이전 qty 체크하기위해 추가
//$jgQtyList = $_REQUEST['row_jg_qty']; //mov_qty  = jg_qty


// 일반 단일 변수
//$movLocList = $_REQUEST['row_mov_loc'];
$movLocCd = filteringCode($_REQUEST['mov_loc_cd']);
$jgGb = $_REQUEST['jg_gb']; //jg_gb 정품에선 정품으로 이동, 반품에선 반품으로 이동
$locGb = $_REQUEST['loc_gb'];//로케이션 구분
$movGb = $_REQUEST['mov_gb']; //파레트 이동 구분자 (상수값/합짐 구분자가 아니다. )
$moveGb = $_REQUEST['move_gb']; //일반21,합짐 구분23

//파레트 이동인경우 > 합짐
$pltCombined = ($_REQUEST['plt_combined'] == "Y")?true:false;   // bug > 파레트 재고이동 처리 프로시져에, 해당 구분자 처리하는 변수 없음????

if(!$bkList || !$taxList || !$locList || !$movQtyList || !$movLocCd || !$jgGb || strlen($locGb) == 0 || strlen($movGb) == 0) {
    ajaxExitJson("*필수정보가 누락되었습니다.");
}


//이전 재고 수량 체크================================================================
for($i = 0;$i<count($bkList);$i++){

    if(strlen($taxList[$i]) == 0) // 합계 row > skip
        continue;


    $realQty = getBookJgQty($bkList[$i],$taxList[$i],$locList[$i],$jgGb);

    //echo"<br>$realQty ---------";

    if($movQtyList[$i] > $realQty){
       $bookData = getBookcd($taxList[$i],$bkList[$i]);
       ajaxExitJson("[{$bookData['bk_nm']}] 도서의 이동 할 재고가 현재고 보다 많습니다.(현재 {$realQty}/ 이동 {$movQtyList[$i]})");
    }
} //end if_____________


$isPalletLoc=false;
$locLen = 0;
for($i = 0;$i<count($locList);$i++){

    if($i == 0) {
        $locLen = strlen($locList[$i]);
        if($locLen != 6)
            $isPalletLoc=true;
        else
            $isPalletLoc=false;
    }

    if(strlen($locList[$i]) != $locLen || strlen($movLocCd) !=  $locLen){
        ajaxExitJson("*이동 로케이션에 이상이 있습니다. ");
    }


    if(!$isPalletLoc){ // 일반서가 체크

        // 이동 로케이션 유효성 체크  (clsLocSch.schREc 함수 75 line) ------------------------------------------------------------
        $res = validateLocCode($movLocCd,$locGb);
        if($res !== true){
            ajaxExitJson($res);
        }

        // 이동 로케이션 존재 체크
        $locRes = existLocCheck($movLocCd);
        if(!$locRes)
            ajaxExitJson("존재하지 않는 적치 로케이션[{$movLocCd}]입니다. ");

    } else { // 팔레트

        //파레트 코드 유효성 체크
        // > 일괄 처리시 합짐이 발생하면 > 실패 처리
        $res = validatePltCode($movLocCd,$movGb,false);
        if($res !== true){
            ajaxExitJson($res);
        }


    }


} //end for______________________________________________________ __________________________



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 일반서가 > 전체이동
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$isQueryError=false;
$isOciTransaction=true;

if(!$isPalletLoc) {




    $sublSeq = "1";
    for($i=0;$i<count($bkList);$i++) {

        //01. subl_date, subl_no 추출 _________________ _____________________________
        $sql = "begin PKGMHPDA.PROC_GETMOVEKEY(:p_tax_no,:p_subl_date,:p_subl_no); end;";
        $stmt = sql_query_parse($sql);


        oci_bind_by_name($stmt, ':p_tax_no', $taxList[$i], 4); //in parameter

        oci_bind_by_name($stmt, ':p_subl_date', $sublDate, 10); //out parameter
        oci_bind_by_name($stmt, ':p_subl_no', $sublNo, 10); //out parameter

        sql_query_execute($stmt,G5_DISPLAY_SQL_ERROR,$isOciTransaction);

        if (!$sublDate || !$sublNo) {
            //            ajaxExitJson("필수 파라미터 생성에 실패했습니다. ");
            $isQueryError=true;
        }


    // 02. 선택 재고 이동 > 일반서가  / 데이터 전송 ////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////

        //도서 마스터
        $bookData = getBookcd($taxList[$i],$bkList[$i]);

        //거래처 마스터
        $custData = getCustcd($taxList[$i]);

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
        oci_bind_by_name($stmt, ':p_tax_no', $taxList[$i], 4);


        oci_bind_by_name($stmt, ':p_subl_no', $sublNo, 22);
        oci_bind_by_name($stmt, ':p_subl_seq', $sublSeq, 22);

        $sublGb = "31";
        oci_bind_by_name($stmt, ':p_subl_gb', $sublGb, 2); //로케이션 이동

        oci_bind_by_name($stmt, ':p_bk_cd', $bkList[$i], 15);
        $bookNm = iconv_euckr($bookData['bk_nm']);
        oci_bind_by_name($stmt, ':p_bk_nm', $bookNm, 100);


        //$moveGb = "21";  // 일반 21, 합짐 23_________________________________
        //  합짐 구분자는 파레트 이동시 존재하는데?   내부 프로시져는 구분자가, 일반 서가 재고이동에만 존재  > Bug????
        oci_bind_by_name($stmt, ':p_move_gb', $moveGb, 2); //이동 구분 :  pda이동


        oci_bind_by_name($stmt, ':p_loc_cd1', $locList[$i], 6); //// bksbjg.loc_cd 원서가
        oci_bind_by_name($stmt, ':p_loc_cd2', $movLocCd, 6); //// 이동서가



        $custNm = iconv_euckr($custData['cust_nm']); // 변수 한번 할당에서 , euc 변환 후 입력하니 오류가 발생하지 않는다. ㅜㅜ
        oci_bind_by_name($stmt, ':p_cust_nm', $custNm,40);
        // iconv_euckr($custData['cust_nm']) >> Warning: oci_bind_by_name(): Invalid variable used for bind in


        oci_bind_by_name($stmt, ':p_jg_gb1', $jgGb, 2); // 추가된 재고구분자
        oci_bind_by_name($stmt, ':p_jg_gb2', $jgGb, 2); // 적치는 정품에서 정품으로 이동, 반품에서 반품으로 같은 구분자에서만 이동가능



        oci_bind_by_name($stmt, ':p_b_qty', $movQtyList[$i], 22);
        oci_bind_by_name($stmt, ':p_out_danga', $bookData['out_danga'], 22);

        $pmRemk = iconv_euckr("NEW PDA / 전체 재고이동");
        oci_bind_by_name($stmt, ':p_pm_remk', $pmRemk, 100);
        oci_bind_by_name($stmt, ':p_upd_emp', $member['mb_id'], 5);

        $res = sql_query_execute($stmt,G5_DISPLAY_SQL_ERROR,$isOciTransaction);

        $sublSeq++;

        unset($sublDate);
        unset($sublNo);

        if(!$res){

            $isQueryError=true;
        }

    } //end for +++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //일반서가 > 전체이동 리턴
    if(!$isQueryError){
        sql_commit();
        $resultStat=true;
        $resultMsg = "전체 재고이동이 완료되었습니다. ";

    } else {

        sql_rollback();
        $resultStat=false;
        $resultMsg = "전체 재고이동시 오류발생으로  전송이 취소되었습니다. ";

    }

    ajaxEchoJson($resultStat,$resultMsg);

} else {

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 파레트  > 전체이동
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $isQueryError=false;
    $isOciTransaction=true;
    $sublSeq = "1";
    for($i=0;$i<count($bkList);$i++) {


        //01. subl_date, subl_no 추출 _________________ _____________________________
        $sql = "begin PKGMHPDA.PROC_PLTTINKEY(:p_plt_cd,:p_subl_no); end;"; // update QUERY 포함
        $stmt = sql_query_parse($sql);

        oci_bind_by_name($stmt, ':p_plt_cd', $movLocCd,10) ; //in parameter
        oci_bind_by_name($stmt, ':p_subl_no', $sublNo,22) ; //out parameter  >> 추출해놓고 사용을 하지 않는다 ????

        // Execute the statement as in your first try
        sql_query_execute($stmt,G5_DISPLAY_SQL_ERROR,$isOciTransaction);

        if(!$sublNo){
            $isQueryError=true;
        }

        // 02. 선택 재고 이동 > 일반서가  / 데이터 전송 ////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////

        //도서 마스터
        $bookData = getBookcd($taxList[$i],$bkList[$i]);

        //거래처 마스터
        $custData = getCustcd($taxList[$i]);

        // BKMOVE table 데이터 입력
        $sql = "begin PKGMHPDA.PROC_MOVPLTTIN_CHR(
                :p_plt_cd,:p_plt_cd_aft,:p_bk_cd,
                :p_tax_no,:p_jg_gb,:p_subl_no,
                :p_b_qty, :p_upd_emp
                ); end;";

        $stmt = sql_query_parse($sql);

        oci_bind_by_name($stmt, ':p_plt_cd', $locList[$i], 10);
        oci_bind_by_name($stmt, ':p_plt_cd_aft', $movLocCd, 10);

        oci_bind_by_name($stmt, ':p_bk_cd', $bkList[$i], 15);
        oci_bind_by_name($stmt, ':p_tax_no', $taxList[$i], 4);
        oci_bind_by_name($stmt, ':p_jg_gb', $jgGb, 2); //  재고 구분자

        oci_bind_by_name($stmt, ':p_subl_no', $sublNo, 22);
        oci_bind_by_name($stmt, ':p_b_qty', $movQtyList[$i], 22);

        oci_bind_by_name($stmt, ':p_upd_emp', $member['mb_id'], 5);

        $res = sql_query_execute($stmt,G5_DISPLAY_SQL_ERROR,$isOciTransaction);

        if(!$res) {
            $isQueryError = true;
        }


        unset($sublNo);
    } //end for  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++



    // 팔레트 서가 > 전체이동 >결과 리턴
    if(!$isQueryError){
        sql_commit();
        $resultStat=true;
        $resultMsg = "파레트 전체 재고이동이 완료되었습니다. ";

    } else {

        sql_rollback();
        $resultStat=false;
        $resultMsg = "파레트 전체 재고이동시 오류발생으로  전송이 취소되었습니다. ";

    }

    ajaxEchoJson($resultStat,$resultMsg);


} //end if //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////









