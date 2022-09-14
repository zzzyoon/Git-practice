<?php
@header('Content-Type: application/json');
include_once('./_common.php');
//ini_set("display_errors", 1);


if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}


$grpNo = clean_xss_tags(get_text($_REQUEST['grp_no']));
$bkCd = clean_xss_tags(get_text($_REQUEST['bk_cd']));

if(!$bkCd || !$grpNo)
    ajaxExitJson("*필수정보가 누락되었습니다. ");


$sql = "delete from  ptmp_bksubl  where grp_no = '{$grpNo}' and bk_cd = '{$bkCd}'  ";
$res = sql_query($sql);

$resultStat=false;
$resultMsg = "";

$retObj = new stdClass();
//입고수, 종수 추출
$tdata = sql_fetch("select sum(subl_qty) as tot_qty,count(*) as tot_cnt from ptmp_bksubl where grp_no = '{$grpNo}' ");
$retObj->tot_qty = $tdata['tot_qty'];
$retObj->tot_cnt = $tdata['tot_cnt'];


if($res){
    $resultStat=true;
    $resultMsg = "입고정보가 정상 삭제되었습니다. ";
} else {
    $resultStat=false;
    $resultMsg = "삭제시 오류가 발생했습니다.  ";
}

//ajaxEchoJson($resultStat,$resultMsg);
ajaxEchoJsonObject($resultStat,$resultMsg,$retObj);





