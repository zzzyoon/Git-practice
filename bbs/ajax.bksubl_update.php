<?php
@header('Content-Type: application/json');
include_once('./_common.php');
//ini_set("display_errors", 1);
if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}

// 입고 로케이션 //////////////////////////////////////
$gMoveLoc="000000";
/////////////////////////////////////////////////////

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$grpNo = clean_xss_tags(get_text($_REQUEST['grp_no']));
$sublGb = clean_xss_tags(get_text($_REQUEST['subl_gb']));
$binderCode = clean_xss_tags(get_text($_REQUEST['binder_code']));
$binderName = clean_xss_tags(get_text($_REQUEST['binder_name']));

/*
$sublGb="12";//본사
$grpNo="17";
$pubCode="0196";
*/

//if(!$grpNo || !$pubCode)
if(!$grpNo)
    ajaxExitJson("*필수정보가 누락되었습니다.(1) ");

if($sublGb == "11" &&  ( !$binderCode || !$binderName)){
    ajaxExitJson("*필수정보가 누락되었습니다.(2) ");
}


//00. validate
/*
$cdata = sql_fetch("select * from ptmp_bksubl where grp_no = '{$grpNo}' and upd_emp  = '{$_SESSION['ss_mb_id']}' and rownum<=1");
if($cdata['pub_cd'] != $pubCode){
    ajaxExitJson("출판사 코드가 상이합니다. ");
}
*/



// 실제 입고 데이터 전송 ////////////////////////////////////////////////////////////////////////////
$sql = "select * from ptmp_bksubl where grp_no = '{$grpNo}'
                and upd_emp = '{$member['mb_id']}' ";
$result = sql_query($sql);

/////////////////////////////////////////////////////////////////////////////////////
//step 01. subl_date, subl_no 추출 _________________ _____________________________
$sql = "begin PKGMHPDA.PROC_SUBULKEY(:p_subl_date,:p_subl_no,:p_tax_no); end;";
$stmt = sql_query_parse($sql);
oci_bind_by_name($stmt, ':p_subl_date', $sublDate,10) ; //out parameter
oci_bind_by_name($stmt, ':p_subl_no', $sublNo,10) ; //out parameter
oci_bind_by_name($stmt, ':p_tax_no', $data['pub_cd'],4) ; //in parameter

// Execute the statement as in your first try
sql_query_execute($stmt);
if(!$sublDate || !$sublNo){
    ajaxExitJson("필수 파라미터 생성에 실패했습니다. ");
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////

$sublSeq=0;
$transSuccCnt = 0;
$transFailCnt = 0;
while($data=sql_fetch_array($result)){
    $data = array_map_deep('iconv_euckr', $data);


    /// Step 02 수불데이터 입력
    $sublSeq++;
    // BKSUBL table 데이터 입력
    $sql = "begin PKGMHPDA.PROC_INSBKSUBL_CHR_NEWBOOK(
                :p_subl_date,:p_subl_gb,:p_subl_no,:p_subl_seq,
                :p_tax_no,:p_cust_nm,:p_metax_no,:p_mecust_nm,
                :p_emp_no,:p_bk_cd,:p_bk_nm,:p_b_qty,
                :p_out_danga,:p_jg_gb,:p_loc_cd,:p_buga_code,
                :p_newbook_yn,:p_contract_no
                ); end;";
    $stmt = sql_query_parse($sql);
    oci_bind_by_name($stmt, ':p_subl_date', $sublDate,8);
    oci_bind_by_name($stmt, ':p_subl_gb', $sublGb,2);
    oci_bind_by_name($stmt, ':p_subl_no', $sublNo,22);
    oci_bind_by_name($stmt, ':p_subl_seq', $sublSeq,22);
    oci_bind_by_name($stmt, ':p_tax_no', $data['pub_cd'],4);
    oci_bind_by_name($stmt, ':p_cust_nm', $data['pub_nm'],40);
    oci_bind_by_name($stmt, ':p_metax_no', $binderCode,4);
    oci_bind_by_name($stmt, ':p_mecust_nm', $binderName,40);
    oci_bind_by_name($stmt, ':p_emp_no', $member['mb_id'],5);

    oci_bind_by_name($stmt, ':p_bk_cd', $data['bk_cd'],15);
    oci_bind_by_name($stmt, ':p_bk_nm', $data['bk_nm'],100);
    oci_bind_by_name($stmt, ':p_b_qty', $data['subl_qty'],22);
    oci_bind_by_name($stmt, ':p_out_danga', $data['bk_danga'],22);
    oci_bind_by_name($stmt, ':p_jg_gb', $DefJgGubun,2); //$DefJgGubun
    oci_bind_by_name($stmt, ':p_loc_cd', $gMoveLoc,6);
    oci_bind_by_name($stmt, ':p_buga_code', $data['bigo'],5);
    oci_bind_by_name($stmt, ':p_newbook_yn', $data['bk_new'],1);
    oci_bind_by_name($stmt, ':p_contract_no', $data['contract_no'],20);

    $res = sql_query_execute($stmt);
    if(!$res){
        $transFailCnt++;
    } else {
        $transSuccCnt++;
    }
} //end while ____________________________________




$resultStat=false;
$resultMsg = "";
if($transSuccCnt > 0){
    $resultStat=true;
    $resultMsg = sprintf("%d 종의 도서가 입고 전송 되었습니다.(*실패 : %d) ",$transSuccCnt,$transFailCnt);
} else {
    $resultStat=false;
    $resultMsg = "입고 전송시 오류가 발생했습니다.  ";
}
ajaxEchoJson($resultStat,$resultMsg);

