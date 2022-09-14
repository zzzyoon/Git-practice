<?php
//@header('Content-Type: application/json');
include_once('./_common.php');
ini_set("display_errors", 1);

if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}


$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$_REQUEST = array_map_deep('clean_xss_tags', $_REQUEST);
$_REQUEST = array_map_deep('get_text', $_REQUEST);

/*
{'subl_date':bookData.sub_date,
                    'subl_no':bookData.subl_no,
                    'tax_no':bookData.tax_no,
                    'subl_seq':bookData.subl_seq,
                    'subl_seq2':bookData.subl_seq2,
                    'b_qty':chkQty,
                    'p_confirm':stat
                    },
*/


$sublDate = $_REQUEST['subl_date'];
$sublNo = $_REQUEST['subl_no'];
$sublSeq = $_REQUEST['subl_seq'];
$sublSeq2 = $_REQUEST['subl_seq2'];
$taxNo = $_REQUEST['tax_no'];


$bQty = $_REQUEST['b_qty'];
$pConfirm = $_REQUEST['p_confirm'];



$pErrResult = "0"; //output param


if(!$sublDate || !$sublNo || !$sublSeq || !$sublSeq2 || !$taxNo || !$bQty ||  !$pConfirm){
    echo "-9";
    exit;
}



    // 도서 검수데이터 업뎃 ////////////////////////////////////////////////////////////////////////////

    // BKSUBL table 데이터 입력
    $sql = "begin PKGMHPDA.PROC_OUTCONFIRM_SEJONG(
                :p_subl_date,:p_tax_no,:p_subl_no,:p_subl_seq,
                :p_subl_seq2,:p_confirm,:p_emp_no,:p_b_qty,
                :p_err_result
                ); end;";

    $stmt = sql_query_parse($sql);

    oci_bind_by_name($stmt, ':p_subl_date', $sublDate,8);
    oci_bind_by_name($stmt, ':p_tax_no', $taxNo,4);
    oci_bind_by_name($stmt, ':p_subl_no', $sublNo,22);
    oci_bind_by_name($stmt, ':p_subl_seq', $sublSeq,22);
    oci_bind_by_name($stmt, ':p_subl_seq2', $sublSeq2,22);
    oci_bind_by_name($stmt, ':p_confirm', $pConfirm,2);

    oci_bind_by_name($stmt, ':p_emp_no', $member['mb_id'],5) ;
    oci_bind_by_name($stmt, ':p_b_qty', $bQty,10) ;
    oci_bind_by_name($stmt, ':p_err_result',$pErrResult,2) ;

    $res = sql_query_execute($stmt);

if(!$res){
    $pErrResult=-1;
}

//ajaxEchoJson($resultStat,$resultMsg);
//ajaxEchoJson($resultStat,$resultMsg);


echo $pErrResult;


