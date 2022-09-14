<?php
@header('Content-Type: application/json');
include_once('./_common.php');
ini_set("display_errors", 1);

if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}


$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$_REQUEST = array_map_deep('clean_xss_tags', $_REQUEST);
$_REQUEST = array_map_deep('get_text', $_REQUEST);


$jgGb = $_REQUEST['jg_gb'];
$pltNo = trim($_REQUEST['plt_no']);
$locCd = trim(strtoupper(str_replace("-","",$_REQUEST['loc_cd'])));


if(!$pltNo || !$locCd || !$jgGb)
    ajaxExitJson("*필수정보가 누락되었습니다. ");


// 적치 로케이션 유효성 체크  (clsLocSch.schREc 함수 75 line) ------------------------------------------------------------

if(strlen($locCd) != 6){
    ajaxExitJson("로케이션 형식이 아닙니다. ");
}

// 로케이션 존재 체크
$locRes = existLocCheck($locCd);
if(!$locRes)
    ajaxExitJson("존재하지 않는 적치 로케이션입니다. ");




//02. 적치 데이터 전송 ////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////


//02-1. 전송할 도서 추출

$sql = "begin PKGMHPDA.PROC_SCGPLTBOOK(:p_plt_cd,:p_jg_gb,:cur_bk); end; ";
$stmt = sql_query_parse($sql);

oci_bind_by_name($stmt, ':p_plt_cd', $pltNo) ;
oci_bind_by_name($stmt, ':p_jg_gb', $jgGb) ;


//oci_bind_by_name($result, ':cur_bk', $output) ;
//But BEFORE statement, Create your cursor
$cursor = oci_new_cursor($g5['connect_db']);
// On your code add the latest parameter to bind the cursor resource to the Oracle argument
oci_bind_by_name($stmt,":cur_bk", $cursor,-1,OCI_B_CURSOR);

// Execute the statement as in your first try
sql_query_execute($stmt);

sql_query_execute($cursor);


$list = array();
$i=0;
while ($row = oci_fetch_array($cursor, OCI_RETURN_LOBS )) {
    $row = array_map_deep('iconv_utf8', $row);
    $row = array_change_key_case($row,CASE_LOWER);

    $list[$i] = $row;
} //end while ___-------------------------


if(count($list) == 0){
    ajaxExitJson("해당 팔레트 {$pltNo} 에는 전송 할 도서가 없습니다.");
}

//exitVarDump($list);

/***
 *    [0]=>
string(5) "50052"
["bk_cd"]=>
string(5) "50052"
[1]=>
string(35) "아기물고기하양이(보드북)"
["bk_nm"]=>
string(35) "아기물고기하양이(보드북)"
[2]=>
string(4) "0048"
["tax_no"]=>
string(4) "0048"
[3]=>
string(19) "한울림 어린이"
["cust_nm"]=>
string(19) "한울림 어린이"
[4]=>
string(3) "192"
["b_qty"]=>
string(3) "192"
[5]=>
string(5) "36000"
["out_danga"]=>
string(5) "36000"
[6]=>
string(10) "0000002598"
["plt_cd"]=>
string(10) "0000002598"
[7]=>
string(1) "A"
["jg_gb"]=>
string(1) "A"
[8]=>
string(1) "1"
["subl_no"]=>
string(1) "1"
[9]=>
string(1) "0"
["chul_qty"]=>
string(1) "0"
 *
 */


//02-2. 팔레트 정보 수정   _________________-----------------------------------------------------
$sql = "UPDATE PALLET SET LOCATION_YN = 'Y', LOC_CD = '{$locCd}'  where PLT_CD = '{$pltNo}' ";
$res = sql_query($sql);


//02-3. 서가 적치 입력  --------------------------------------------------------------------------

/***
 *      PLTOUT Table 입력
 */
$sql = "begin PKGMHPDA.PROC_INSPLTOUT_CHR(
                :p_plt_cd,:p_subl_no,:p_bk_cd,:p_bk_nm,
                :p_tax_no,:p_cust_nm,:p_b_qty,:p_out_danga,
                :p_jg_gb,:p_loc_cd1,:p_loc_cd2,:p_pm_remk,
                :p_upd_emp); end;";


$stmt = sql_query_parse($sql);

$transSuccCnt = 0;
$transFailCnt = 0;
//$list[$i]['']

for($i = 0; $i<count($list);$i++){  //  _______-----------------------------------------------------

    oci_bind_by_name($stmt, ':p_plt_cd', $pltNo, 10);

    $sublNo=$i+1;
    oci_bind_by_name($stmt, ':p_subl_no', $sublNo, 22); // 순번
    oci_bind_by_name($stmt, ':p_tax_no', $list[$i]['tax_no'], 4);
    oci_bind_by_name($stmt, ':p_cust_nm', $list[$i]['cust_nm'], 40);

    oci_bind_by_name($stmt, ':p_bk_cd', $list[$i]['bk_cd'], 15);
    oci_bind_by_name($stmt, ':p_bk_nm', $list[$i]['bk_nm'], 100);


    oci_bind_by_name($stmt, ':p_jg_gb',$jgGb, 2); //이동 구분 :  pda이동+++++++++++++++++++++++++++++++++

    oci_bind_by_name($stmt, ':p_b_qty', $list[$i]['b_qty'], 22);
    oci_bind_by_name($stmt, ':p_out_danga', $list[$i]['out_danga'], 22);


    $locCdTmp = "P00000";
    oci_bind_by_name($stmt, ':p_loc_cd1', $locCdTmp, 6); //  ????????????????
    oci_bind_by_name($stmt, ':p_loc_cd2', $locCd, 6); //적치 로케이션



    $pmRemk = iconv_euckr("NEW PDA / LOC 적치");
    oci_bind_by_name($stmt, ':p_pm_remk', $pmRemk, 100);
    oci_bind_by_name($stmt, ':p_upd_emp', $member['mb_id'], 5);

    $res = sql_query_execute($stmt);
    if($res){
        $transSuccCnt++;
    } else {
        $transFailCnt++;
    }

} //end for_________________________________________-----------------------------------------------------




$resultStat=false;
$resultMsg = "";

if($transSuccCnt > 0){

    if($transFailCnt > 0)
        $resultMsg = sprintf("적치자료 전송이 완료되었습니다. (성공: %d건, 실패: %d건) ",$transSuccCnt,$transFailCnt);
    else
        $resultMsg = "적치자료 전송이 완료되었습니다. ";

    $resultStat=true;

} else {

    $resultStat=false;
    $resultMsg = "적치자료 전송시 오류가 발생했습니다. (*fail : {$transFailCnt}) ";
}

ajaxEchoJson($resultStat,$resultMsg);

