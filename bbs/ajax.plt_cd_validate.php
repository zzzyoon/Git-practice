<?php
@header('Content-Type: application/json');
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("*로그인 정보가 존재하지 않습니다.  ");
}


$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$pltCd = clean_xss_tags(get_text($_REQUEST['plt_cd']));
$movGb = clean_xss_tags(get_text($_REQUEST['mov_gb']));

//$pltCd = "0000000014";
//$movGb = MH_MOV_GB_MOVEALL;


if(!$pltCd || strlen($movGb) == 0){
    ajaxExitJson("필수정보가 누락되었습니다.(v) ");
}


$isCombineConfirm=false;

$sql = "SELECT nvl(USE_YN,'N') as use_yn,nvl(LOCATION_YN,'N') as loc_yn FROM PALLET WHERE PLT_CD = '{$pltCd}' ";
$data =sql_fetch($sql);

if(!$data){
    ajaxExitJson("등록되지 않는 파레트 입니다. ");
}

if($data['loc_yn'] == "Y"){
    ajaxExitJson("이미 이동 적치된 파레트 입니다. ");
}


if($data['use_yn'] == "Y" && $movGb == MH_MOV_GB_PALLET){
    $isCombineConfirm=true;
}

$resObj = new stdClass();
$resObj->plt_cd = $pltCd;
$resObj->use_yn = $data['use_yn'];
$resObj->loc_yn = $data['loc_yn'];
$resObj->combine_chk = $isCombineConfirm;

ajaxEchoJsonObject(true,"해당 파레트는 이용가능합니다.",$resObj);