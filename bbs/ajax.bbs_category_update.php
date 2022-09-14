<?php
@header('Content-Type: application/json');
include_once('./_common.php');
///////////////////////////////////////////////////////////
//통신이용 증명원 게시판에서 호출 bo_table : certi
////////////////////////////////////////////////////////

if(!$is_member){
    ajaxExitJson("로그인 정보가 존재하지 않습니다. ");
}


$_REQUEST    = array_map_deep('clean_xss_tags',  $_REQUEST);
$_REQUEST    = array_map_deep('trim',  $_REQUEST);
//$_POST    = array_map_deep('get_search_string',  $_POST);
//@extract($_POST);

$wr_id = $_REQUEST['wr_id'];
$bo_table = $_REQUEST['bo_table'];
$ca_name = $_REQUEST['ca_name'];

if(empty($wr_id) || empty($bo_table) || empty($ca_name)){
    ajaxExitJson("필수 정보가 누락되었습니다. ");
}


$wr = get_write($write_table, $wr_id);
if (!$wr['wr_id']) {
    ajaxEchoJson("글이 존재하지 않습니다.\\n글이 삭제되었거나 이동하였을 수 있습니다.");
}

// 실제 처리 프로세스 ____________-------------------------------------------------------------------------------------
$sql = " update {$write_table}
                set
            ca_name= '{$ca_name}',
            wr_3 = '".G5_TIME_YMDHIS."', wr_2 = '{$member['mb_id']}'
              where wr_id = '{$wr['wr_id']}' ";

$res = sql_query($sql);

$resObj = new stdClass();
$resObj->wr_6=$wr_6;

if($res) {
    $resObj->result_stat=true;
    $resObj->result_msg="분류수정이 완료되었습니다.  ";
    $resObj->wr_7 = $member['mb_id'];
    $resObj->wr_7_nm = $member['mb_name'];
    $resObj->wr_8 = G5_TIME_YMDHIS;
} else {
    $resObj->result_stat=false;
    $resObj->result_msg="분류수정시 오류가 발생했습니다.  ";

}


echo json_encode($resObj);
