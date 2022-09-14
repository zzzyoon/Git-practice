<?php
@header('Content-Type: application/json');
include_once('./_common.php');

/*
 *
 * PARAMETER : dev_uid
 * */

$paramsStr = trim(base64_decode($_REQUEST["params"]));
//$paramsStr = trim($_REQUEST["params"]); //browser debugging__

if(empty($paramsStr) && count($_REQUEST) == 0){
    ajaxExitJson("필수인자가 누락되었습니다. ");
}

// for debugging
//$paramsStr='{"user_id":"yourday","fcm_key":"23213131312312313"}';
//$paramsStr = '{"user_id":"tlog","fcm_key":"23213131312312313"}';

$params = json_decode(str_replace("\\", "", $paramsStr));

$validPdaCnt = 10;
$sql = "select * from gncode where fld_id = 'pda_cnt'";
$mdata = sql_fetch($sql);
if($mdata){
    $validPdaCnt = $mdata['fld_code'];
}



///////////////////////////////////////////////////////////////////////////

$sql = "select * from pda_devices where dev_id = '".$params->dev_uid."' ";
$data = sql_fetch($sql);
if($data){

    // 임시처리 /////////////////////////////////////////////////////////////////////
    ajaxEchoJson(true,"승인 완료된 장치입니다.");
    exit;

    if($data['is_valid'] == "Y"){

        @sql_query("update pda_devices set login_date = sysdate where dev_id = '".$params->dev_uid."'");
        ajaxEchoJson(true,"승인 완료된 장치입니다.");
        exit;
    } else {
        ajaxExitJson("미승인 장치입니다. ");
    }

} else {

    $sql = "insert into pda_devices(dev_id,upd_date) values('".$params->dev_uid."',sysdate)";
    sql_query($sql);

    // 임시처리 /////////////////////////////////////////////////////////////////////
    ajaxEchoJson(true,"승인 완료된 장치입니다.");
    exit;


    ajaxExitJson("승인을 기다려주세요.(*최초등록)");

}

?>
