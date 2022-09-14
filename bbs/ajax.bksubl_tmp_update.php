<?php
@header('Content-Type: application/json');
include_once('./_common.php');
//ini_set("display_errors", 1);
if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);

$grpNo = clean_xss_tags(get_text($_REQUEST['grp_no']));
$bkCd = clean_xss_tags(get_text($_REQUEST['bk_cd']));
$bkNm = clean_xss_tags(get_text($_REQUEST['bk_nm']));
$barCode = clean_xss_tags(get_text($_REQUEST['bar_code'])); //ean code
$pubCode = clean_xss_tags(get_text($_REQUEST['pub_code']));
$pubName = clean_xss_tags(get_text($_REQUEST['pub_name']));

$bkNew = clean_xss_tags(get_text($_REQUEST['bk_new']));
$bkCmt = clean_xss_tags(get_text($_REQUEST['bk_cmt']));

//$sublGb = clean_xss_tags(get_text($_REQUEST['subl_gb']));
$sublQty = clean_xss_tags(get_text($_REQUEST['bk_new_qty']));
$contractNo = clean_xss_tags(get_text($_REQUEST['contract_no']));
$bkPrice = filteringSpcChr($_REQUEST['bk_price']);

if(!$bkCd || !$barCode || !$bkNm  ||  !$pubCode || !$pubName || !$bkNew || !$sublQty)
    ajaxExitJson("*필수정보가 누락되었습니다. ");


if(!$grpNo){
    $grpNo = sql_result(" SELECT ptmp_bksubl_seq.nextval FROM dual ");
}


$isUpdate = false;

$cdata = sql_fetch("select * from ptmp_bksubl  where grp_no = '{$grpNo}' and bk_cd = '{$bkCd}' ");

if($cdata){

    $isUpdate=true;
    $sql = " update ptmp_bksubl  set   subl_qty = subl_qty + {$sublQty}  where grp_no = '{$grpNo}' and bk_cd = '{$bkCd}'  ";


} else {
    $sql = " insert into ptmp_bksubl(grp_no,bk_cd,bar_cd,bk_nm,
                    pub_cd,pub_nm,bigo,bk_danga,
                    subl_qty,bk_new,upd_emp,upd_date,contract_no)
             values($grpNo,'{$bkCd}','{$barCode}','{$bkNm}',
                  '{$pubCode}','{$pubName}','{$bkCmt}','{$bkPrice}',
                  {$sublQty},'{$bkNew}','{$member['mb_id']}',sysdate,'{$contractNo}')";
}


$res = sql_query($sql);



//return object_____________________________________ --------------------------------------------------------
$data = sql_fetch(" select * from ptmp_bksubl where grp_no = '{$grpNo}' and bk_cd = '{$bkCd}'");

//$data = array_map_deep('iconv_utf8', $data);
$retObj = json_decode(json_encode($data));
$retObj->grp_no = $grpNo;
$retObj->is_dup=$isUpdate;
//$retObj->bk_nm="testing";

//입고수, 종수 추출
$tdata = sql_fetch("select sum(subl_qty) as tot_qty,count(*) as tot_cnt from ptmp_bksubl where grp_no = '{$grpNo}' ");
$retObj->tot_qty = $tdata['tot_qty'];
$retObj->tot_cnt = $tdata['tot_cnt'];

$resultStat=false;
$resultMsg = "";

if($res){
    $resultStat=true;
    $resultMsg = "입고정보가 정상 저장되었습니다. ";
} else {
    $resultStat=false;
    $resultMsg = "임시 저장시 오류가 발생했습니다.  ";
}

//ajaxEchoJson($resultStat,$resultMsg);
ajaxEchoJsonObject($resultStat,$resultMsg,$retObj);



