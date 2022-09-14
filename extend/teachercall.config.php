<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////
//상수 정의 //////////////////////////////////////////////////////////////////////////////////////////////

define('G5_APP_VERSION', '1.0'); //어플 버젼_____________________________
define('G5_GMEMBER_MAX_COUNT', 200); //한 학교 발급가능한 선생님수 제한

define('G5_NODE_SERVER_URL', "https://teachercall.kr:8443"); // real node server (CS Center)
define('G5_CALAMASI_SERVER', "27.255.97.30"); // 깔라만시 TM 솔루션 >  서버 아이피________

define('G5_FCM_TOPIC', "notification"); // 전회원 푸쉬 전송시 활용 (FCM > TOPIC 구독 )

///////////////////////////  회원 레벨  /////////////////////////////////////////////////////////////////////////////
define('G5_MEMBER_ADMIN_LV', 10); //본사 관리자 (최고 관리자)

// TM(cs) 관리자 회원
define('G5_MEMBER_CS1_LV', 9); //CS MASTER
define('G5_MEMBER_CS2_LV', 8); //CS SLAVE


//영업 관리 회원
define('G5_MEMBER_SALES_ORG_LV', 7); //대행사 레벨___
define('G5_MEMBER_DISTRIBUTOR_LV', 6); //총판 레벨___
define('G5_MEMBER_AGENCY_LV',5); //대리점 레벨__

//일반 학교 관련 회원
//define('G5_MEMBER_ASSOC_LV', 6); //교원 단체
//define('G5_MEMBER_SCHOOL_LV', 5); //학교회원
//define('G5_MEMBER_TEACHER_LV', 3); //교직원 회원

define('G5_MEMBER_ASSOC_LV', 4); //교원 단체
define('G5_MEMBER_SCHOOL_LV', 3); //학교회원
define('G5_MEMBER_TEACHER_LV', 2); //교직원 회원

//define('G5_MGR_MEMBERS','tlog,test_seo,distor_jeju,distor_gsndw,distor_seoul'); //"관리자>관리권한설정" 에서 권한 추가된 회원~
define('G5_MMS_DATA_DIR',       'mms_tccall');
define('G5_050_HEAD',       '0508');
define('G5_050_MAX_PERIOD',       150); //티콜(tcall)에서만 사용__

//부가세포함
define('G5_AGENCY_SMS_FEE',       1);
define('G5_AGENCY_LMS_FEE',       1);
define('G5_AGENCY_MMS_FEE',       1);

//학교회원 문자 사용료 (부가세제외)____
// kct 원가에서 각 3원식 수익
define('G5_SCHOOL_SMS_FEE',       11);
define('G5_SCHOOL_LMS_FEE',       28);
define('G5_SCHOOL_MMS_FEE',       63);
// 티콜 13, 30, 68


// teachercall
//FCM SERVER KEY _____________________________________________________  -----------------------------------
define('FCM_SERVER_KEY','AAAAGnFicEs:APA91bFEseaIwi8MwXnUuCG1ZhzFgfVMP-_D9CY7sFoGRpt3kVwrdfVbh5w89mk9txAnvgHMuqwVW46n_3493VbB0ZBo8w9JHNJOqvRIT2P0kpsu0ZsetTR3U9eC3_aq6yg_AxQDxYXP');
define('FCM_SENDER_ID','113571426379');


// TLOG 050 API SERVER _______________________________________-------------------------------------
define('G5_TLOG_SERVER_IP',       '203.239.40.230');
define('G5_TLOG_SERVER_PORT',       7123);

// 관리자 freepass  ------------------------------________________________________________
define('G5_FREEPASS_PWD',       'root@@!!');

//cs center tel number . 고객센터 전화번호
define('G5_CS_NUMBER',       '1877-2606'); //티처콜

//학교 회원 > 자동 발급되는 아이디 활용
define('G5_GROUP_HEAD_STR','tcc');


define('G5_SQL_DIR',        'sql');
define('G5_SQL_PATH',        G5_PATH.'/'.G5_SQL_DIR);
define('G5_SNMS_FEE', 50000); //안심번호 . 월 관리비 (*부가세제외)
define('G5_DIST_SNMS_FEE', 23000); //안심번호 . 월 관리비 - 단체당 총판 커미션 > 계약학교수 1000개이상부터 24000원

define('G5_MENT_COUNT', 10); //안심번호 멘트갯수 제한
define('G5_REST_TIME_COUNT', 10); //안심번호 휴식시간 제한
define('G5_TLOG_API_URL',        'http://27.255.100.84:7123');


define('G5_DEFAULT_FWD_MENTS',array(
    array("1501","학교 통화대기 안내멘트","ADMIN_20200827-6663.wav"),
    array("22","업무종료 안내멘트", "ADMIN_20200902-5448.wav"),
    array("74","점심시간(12시~1시) 안내멘트","ADMIN_20200902-4848.wav"),
    array("4530","휴식시간 안내멘트","ADMIN_20200902-3658.wav")
));

define('G5_DEFAULT_RCV_MENTS',array(array("71","통화연결 안내멘트","ADMIN_20200827-6745.wav")));

define('G5_FWD_SAMPLE_MENT','ADMIN_20200827-6663.wav'); /// 통화대기 안내멘트 - 콜러(고객) 대상
define('G5_RCV_SAMPLE_MENT','ADMIN_20200827-6745.wav'); /// 통화연결 안내멘트 - 교사대상

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// KICC EasyPay PG 관련 parameters

//define('G5_PG_MALL_ID','T0010282'); // TeacherCall Testing Mall ID, T 로 시작하면 테스트 ID
define('G5_PG_MALL_ID','05547615'); // TeacherCall Real Mall ID


define('G5_PG_MALL_NAME','티처콜');
define('G5_PG_DIR',        'pg');
define('G5_PG_URL',        G5_URL.'/'.G5_PG_DIR);
define('G5_PG_PATH',        G5_PATH.'/'.G5_PG_DIR);

define('G5_PG_PC_DIR',        'pc');
define('G5_PG_PC_URL',        G5_PG_URL.'/'.G5_PG_PC_DIR);
define('G5_PG_MOBILE_DIR',        'mobile');
define('G5_PG_MOBILE_URL',        G5_PG_URL.'/'.G5_PG_MOBILE_DIR);


//결제 방법  ===============================================================
// -> 카드 , 가상계좌 만 사용중~
define('G5_PG_TYPE_CARD', '11'); //결제 방법 : 카드
define('G5_PG_TYPE_BANK_TRANS', '21'); //결제 방법 : 계좌이체
define('G5_PG_TYPE_BANK_VIR', '22'); //결제 방법 : 가상계좌(무통장)
define('G5_PG_TYPE_MOBILE', '31'); //결제 방법 : 휴대폰 소액결제


// 결제 상태 ===================================================
//PG_log. pg_stat
define('G5_PG_STAT_NON', '00'); //결제 상태 : 미결제 - Default
define('G5_PG_STAT_READY', '01'); //결제 상태 : 입금 대기
define('G5_PG_STAT_SUCC', '10'); //결제 상태 : 결제 성공
define('G5_PG_STAT_FAILED', '20'); //결제 상태 : 결제 실패
define('G5_PG_STAT_CANCEL', '80'); //결제 상태 : 결제 취소
define('G5_PG_STAT_REFUND', '90'); //결제 상태 : 결제 환불



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// DB Table Vars ////////////////////////////////////////////////////////////////////////////////////////////////
//bylee
$g5['member_group_table'] = G5_TABLE_PREFIX.'member_group'; // 회원 그룹(학교) 테이블
$g5['safety_meta_table'] = G5_TABLE_PREFIX.'safety_meta'; // 050번호 마스터 테이블
$g5['safety_number_table'] = G5_TABLE_PREFIX.'safety_number'; // 050번호 리스트 테이블
$g5['fcm_log'] = G5_TABLE_PREFIX.'fcm_log'; //api fcm request log table (call push)
$g5['adm_fcm_log'] = G5_TABLE_PREFIX.'adm_fcm_log'; // admin custom msg >  fcm request log table


//KCT sms module table
$g5['neo_msg_table'] = "neo_msg";
//$g5['neo_log_table'] = "neo_log";

//pg log 결제 기록
$g5['pg_log'] = G5_TABLE_PREFIX.'pg_log'; // fcm request log table
// 안심발신 통화 로그
$g5['tnms_log'] = G5_TABLE_PREFIX.'tnms_log'; // fcm request log table

// 발신 포인트 이체기록 테이블
$g5['point_transfer'] = G5_TABLE_PREFIX.'call_point_transfer';

//pg noti 로그(무통장 입금통보 테이블)
$g5['pg_noti'] = G5_TABLE_PREFIX.'pg_noti';

//pg cart table (학교회원 > 장바구니 (결제대항) )
$g5['pg_cart'] = G5_TABLE_PREFIX.'pg_cart';

//pg package table (학교회원> 포인트 충던된 결제한 대상회원)
$g5['pg_pkg'] = G5_TABLE_PREFIX.'pg_package';

//pg 환불 테이블
$g5['pg_refund'] = G5_TABLE_PREFIX.'pg_refund';
//pg 환불 예외 교직원 회원(*학교회원 환불시)
$g5['pg_refund_expt'] = G5_TABLE_PREFIX.'pg_refund_expt';

// 학교회원 > 월 요금명세서 테이블
$g5['gmember_charge'] = G5_TABLE_PREFIX.'group_charge';
$g5['gmember_charge_err'] = G5_TABLE_PREFIX.'group_charge_err';


//안심번호 설정
$g5['work_time'] = G5_TABLE_PREFIX.'work_time'; //업부시간 설정
$g5['rest_time'] = G5_TABLE_PREFIX.'rest_time'; //휴식시간 설정
$g5['call_ment'] = G5_TABLE_PREFIX.'call_ment'; //멘트 테이블


//안심번호 > 연결 휴대폰번호 변경로그 테이블
$g5['phone_number_log'] = G5_TABLE_PREFIX.'phone_number_log';

//총판 마스터 테이블
$g5['distributor_table'] = G5_TABLE_PREFIX.'distributor';

$g5['cron_log'] = G5_TABLE_PREFIX.'cron_log';

// 단체회원 > 서비스 중지 로그
$g5['expire_log'] = G5_TABLE_PREFIX.'group_expire_log';


// 조직관리 관련 테이블
$g5['sales_org_table'] = G5_TABLE_PREFIX.'sales_org';
$g5['distributor_table'] = G5_TABLE_PREFIX.'distributor';
$g5['agency_table'] = G5_TABLE_PREFIX.'agency';



$g5['auth_sample_table'] = G5_TABLE_PREFIX.'auth_sample'; // 관리권한 설정 테이블

//cs 직원 > 깔라만시 부가정보 테이블
$g5['calamasi_conf_table'] = G5_TABLE_PREFIX.'calamasi_conf'; // 관리권한 설정 테이블

// 환경 셋팅
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////



// 함수 영역 시작
////////////////////////////////////////////////////////////////////////////////////////////////////////

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function validateDatetime($date, $format = 'Y-m-d H:i:s')
{
    return validateDate($date,$format);
}

function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);

}




function expectMemberCallPoint($payAmt,$memCnt){

    if($payAmt == 0)
        return 0;

    return ceil($payAmt/$memCnt); //올림함수 적용
}


// 교직원 회원 >거래별 환불 금액 연산
function getRefundAmt($memUid,$memBfPoint,$pgAmt,$pgDatetime){

    global $g5;
    $sql = "select sum(cm_amt) from {$g5['tnms_log']} where mb_id = '{$memUid}' and  cm_datetime >= '{$pgDatetime}' ";
    $usedAmt =sql_result($sql);

    $refundAmt = 0;

    if($usedAmt<=$memBfPoint)
        $refundAmt = $pgAmt;
    else {
        $refundAmt = $usedAmt-$memBfPoint;
        $refundAmt -= $pgAmt;
    }

    if($refundAmt<0)
        return 0;
    else
        return $refundAmt;

} //end func=========== = = = ===


function sql_exists_table($tableName){

    global $g5;

    $sql="SHOW TABLES LIKE '{$tableName}' "; //테이블 존재 유무체크 쿼리
    $data = sql_fetch($sql);

    if($data)
        return true;
    else
        return false;
}

/// sms5_write
/// startYear 2019
/// endYear 2020
function sql_create_master_view($tableName,$startYear,$endYear){

    $viewName = sprintf("vw_%s_%s_%s",$tableName,$startYear,$endYear);

    if(sql_exists_table($viewName)){
        return $viewName;
    }

    $sYear=  (int)$startYear;
    $eYear =  (int)$endYear;
    $sql="";

    for($i=$sYear;$i<=$eYear;$i++){
        $vTableName = sprintf("%s_%d",$tableName,$i);
        if(!sql_exists_table($vTableName))
            continue;
        if(empty($sql))
            $sql=" create view {$viewName} as  select  * from {$vTableName}";
        else
            $sql.=" union select * from {$vTableName} ";
    } //end for___

    $res = sql_query($sql);
    if(!$res)
        return false;
    else
        return $viewName;

}


/// tableName
/// startMonth 202006
/// endMonth 202010
function sql_create_view($tableName,$startMonth,$endMonth){

    $year = substr($startMonth,0,4);
    $viewName = sprintf("vw_%s_%s_%s_%s",$tableName,$year,substr($startMonth,-2),substr($endMonth,-2));


    if(sql_exists_table($viewName)){
        return $viewName;
    }

    $sMonth =  (int)substr($startMonth,-2);
    $eMonth =  (int)substr($endMonth,-2);
    $sql="";
    for($i=$sMonth;$i<=$eMonth;$i++){
        $vTableName = sprintf("%s_%s%02d",$tableName,$year,$i);

        if(!sql_exists_table($vTableName))
            continue;

        if(empty($sql))
            $sql=" create view {$viewName} as  select  * from {$vTableName}";
        else
            $sql.=" union select * from {$vTableName} ";

    } //end for___


    $res = sql_query($sql);

    if(!$res)
        return false;
    else
        return $viewName;

}


/// 부가세포함 금액 연산
function getVATAmt($payAmt){
    $tax = 10;
    $taxAmt = $payAmt + getTaxAmt($payAmt);

    return floor($taxAmt/10)*10;
}

// 부가세 추출
function getTaxAmt($payAmt){
    $tax = 10;
    return ($payAmt*$tax)/100;
}


function isJsonString($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}



function isCSMember(){
    global $member;

    return ($member['mb_level'] >= G5_MEMBER_CS2_LV);
}


/**
 * 안심번호> 업무시간 >  기본멘트 이름 추출
 * @param $mentIdx
 * @return string
 */
function getDefaultMentName($mgNo,$mentIdx){

    global $g5,$member;


    //$ments=array_merge(G5_DEFAULT_FWD_MENTS,G5_DEFAULT_RCV_MENTS);  // merge 함수는 숫자형식의  index key를 숫자로 인식해서 초기화시킴 , 즉 0부터 할당하면서 합친다.
    //$ments=G5_DEFAULT_FWD_MENTS+G5_DEFAULT_RCV_MENTS;

    $ments = array();
    foreach(G5_DEFAULT_FWD_MENTS as $val){
        $ments[$val[0]] = "[공통] ".$val[1];
    }
    foreach(G5_DEFAULT_RCV_MENTS as $val){
        $ments[$val[0]] = "[공통] ".$val[1];
    }

    if(array_key_exists($mentIdx,$ments)) {
        return $ments[$mentIdx];
    }else{

        // 단체 멘트 공유
        $res = sql_fetch("select * from {$g5['call_ment']} where mg_no = '{$mgNo}' and cm_idx = '{$mentIdx}'");

        if($res)
            return $res['cm_name'];
        else
            return "알수 없는 멘트";
    }

}


// 결제 방법 이름
function getPaymentTypeName($typeCode){

    $typeName = "";

    switch($typeCode){
        case G5_PG_TYPE_CARD:
            $typeName="카드결제";
            break;
        case G5_PG_TYPE_BANK_TRANS:
            $typeName="계좌이체";
            break;
        case G5_PG_TYPE_BANK_VIR:
            $typeName="무통장(가상계좌)";
            break;
        case G5_PG_TYPE_MOBILE:
            $typeName="휴대폰 소액결제";
            break;
        default:
            $typeName="기타";

    }

    return $typeName;
}

// 결제 상태 이름
function getPaymentStateName($statCode){

    $statName = "";

    switch($statCode){
        case G5_PG_STAT_NON:
            $statName="미결제";
            break;
        case G5_PG_STAT_READY:
            $statName="입금대기";
            break;
        case G5_PG_STAT_SUCC:
            $statName="결제완료";
            break;
        case G5_PG_STAT_FAILED:
            $statName="결제실패";
            break;
        case G5_PG_STAT_CANCEL:
            $statName="결제취소";
            break;
        case G5_PG_STAT_REFUND:
            $statName="환불";
            break;
        default:
            $statName="기타";

    }
    return $statName;
}


////////////////////////////////////////////////////////////////////////////////////////////
//sms master table  체크 & 생성 ---------------------------------------------
// sms5_write_yyyy 년도별 생성
function getSmsWriteTable($target_date){
    global $g5;

    $smsWriteTableName = $g5['sms5_write_table']."_".substr($target_date,0,4);


    if(!sql_exists_table($smsWriteTableName) && substr($smsWriteTableName,0,3) != "vw_"){
        $file = file(G5_SQL_PATH.'/sql_sms_write.sql');
        $sql = implode($file, "\n");
        // sql_board.sql 파일의 테이블명을 변환
        $source = array('/__TABLE_NAME__/', '/;/');
        $target = array($smsWriteTableName, '');
        $sql = preg_replace($source, $target, $sql);
        sql_query($sql, FALSE);
    }

    return $smsWriteTableName;
}


////////////////////////////////////////////////////////////////////////////////////////////
//sms history table 체크 & 생성  -------------------------------------------
// sms5_write_yyyymm 월별생성
function getSmsHistoryTable($target_date){
    global $g5;

    $smsHistoryTableName = $g5['sms5_history_table']."_".str_replace("-","",substr($target_date,0,7));

    if(!sql_exists_table($smsHistoryTableName)  && substr($smsHistoryTableName,0,3) != "vw_"){
        $file = file(G5_SQL_PATH.'/sql_sms_history.sql');
        $sql = implode($file, "\n");
        // sql_board.sql 파일의 테이블명을 변환
        $source = array('/__TABLE_NAME__/', '/;/');
        $target = array($smsHistoryTableName, '');
        $sql = preg_replace($source, $target, $sql);
        sql_query($sql, FALSE);
    }

    return $smsHistoryTableName;

}



// SMS 현재월 총 사용금액 추출 ///////////////////////////////////////////////
function getSmsUsedCharge($grp_no,$target_month){

    global $g5;

    if(strlen($target_month)!=7){
        die("get_sms_used_fee func /  parameter error");
    }

    // 20200727 추가/ history 월별 로그테이블
    /*
    $smsHistoryTableName = $g5['sms5_history_table']."_".date("Ym");

    // sms5_history table생성______---------------
    if(!sql_exists_table($smsHistoryTableName)){
        $file = file(G5_SQL_PATH.'/sql_sms_history.sql');
        $sql = implode($file, "\n");
        // sql_board.sql 파일의 테이블명을 변환
        $source = array('/__TABLE_NAME__/', '/;/');
        $target = array($smsHistoryTableName, '');
        $sql = preg_replace($source, $target, $sql);
        sql_query($sql, FALSE);
    }
    */

    //테이블 체크 & 이름 추출
    $smsHistoryTableName = getSmsHistoryTable($target_month);


    $sfl_start_date = $target_month;//date("Y-m");
    $sfl_end_date = $target_month;//date("Y-m");

    //해당 월의 일수로 마지막일자구함
    $day_count = date('t', strtotime($sfl_end_date."-01"));

    $sfl_start_datetime=$sfl_start_date."-01 00:00:00";
    $sfl_end_datetime=$sfl_end_date."-".$day_count." 23:59:59";


    $logTableName = "neo_log_".str_replace("-","",$target_month);
    if(!tableExists($logTableName))
        $logTableName = "neo_log";


    // 전송완료 테이블 - neo_log_yyyymm
    $sql = "SELECT SUM(SMS_ROW)*".G5_SCHOOL_SMS_FEE." AS sms_amt,SUM(lms_row)*".G5_SCHOOL_LMS_FEE." AS lms_amt,SUM(mms_row)*".G5_SCHOOL_MMS_FEE." AS mms_amt
            FROM(
	 SELECT a.msg_type IN ('1') AS sms_row,
		  a.msg_type IN ('2') AS lms_row,
		  a.msg_type IN ('4') AS mms_row
        FROM {$smsHistoryTableName} a
         JOIN g5_member b ON (a.mb_id = b.mb_id)
         JOIN {$logTableName} c ON (c.MSGKEY = a.msg_key)
         WHERE hs_send_timestamp BETWEEN unix_timestamp('{$sfl_start_datetime}') AND unix_timestamp('{$sfl_end_datetime}')
         AND b.mb_1 = '{$grp_no}'
         and c.status = '".G5_MEMBER_TEACHER_LV."' and c.rslt in ('100','101')
         ) AS t1
    ";


    $data = sql_fetch($sql);
    if(!$data)
        $totalFee = 0;
    else
        $totalFee = (float)$data['sms_amt'] + (float)$data['lms_amt'] + (float)$data['mms_amt'];




    //대기테이블 조회 - neo_msg
    $sql = "SELECT SUM(SMS_ROW)*".G5_SCHOOL_SMS_FEE." AS sms_amt,SUM(lms_row)*".G5_SCHOOL_LMS_FEE." AS lms_amt,SUM(mms_row)*".G5_SCHOOL_MMS_FEE." AS mms_amt
            FROM(
	 SELECT a.msg_type IN ('1') AS sms_row,
		  a.msg_type IN ('2') AS lms_row,
		  a.msg_type IN ('4') AS mms_row
        FROM {$smsHistoryTableName} a
         JOIN neo_msg c ON (c.MSGKEY = a.msg_key)
         WHERE hs_send_timestamp BETWEEN unix_timestamp('{$sfl_start_datetime}') AND unix_timestamp('{$sfl_end_datetime}')
          AND EXISTS(SELECT 1 FROM g5_member WHERE mb_1 = '{$grp_no}' AND mb_id = a.mb_id)
         ) AS t1
    ";




    $data1 = sql_fetch($sql);
    if($data1) {
        $stanbyFee = (float)$data1['sms_amt'] + (float)$data1['lms_amt'] + (float)$data1['mms_amt'];
        $totalFee+=$stanbyFee;
    }


    return $totalFee;

} //end func ============================== =============================================


// 초 -> 00:00 타입 리턴
function wellKnownSecondsTime($pureSec){

    if(!$pureSec)
        return "00:00초";

    $callTime="";
    if($pureSec<60) {
        $callTime = sprintf("%02d:%02d초", 0, $pureSec);
    } else if($pureSec >= 3600 ){
        $hour = floor($pureSec/3600);
        $leftSec = $pureSec - ($hour*3600);
        $min = floor($leftSec/60);
        $sec = $leftSec%60;
        $callTime = sprintf("%02d시간 %02d:%02d초",$hour,$min,$sec);
    } else {
        $min = floor($pureSec/60);
        $sec = $pureSec%60;
        $callTime = sprintf("%02d:%02d초",$min,$sec);
    }

    return $callTime;
}



// 기간 작업 공지  ///////////////////////////////////////////////////////////////////
// starDateTime : YmdHis
// endDateTime : YmdHis
function alertWithDatetime($startDateTime,$endDateTime,$msg){

    if(!$startDateTime || !$endDateTime)
        return;

    $startTime = strtotime($startDateTime);
    $endTime = strtotime($endDateTime);
    $curTime = time();


    if($curTime>=$startTime && $curTime<=$endTime){

        $msg.=sprintf(" \\n\\n (*기간 : %s ~ %s )",date("Y-m-d H시i분",$startTime),date("Y-m-d H시i분",$endTime));

        alert($msg,"/");
    }

}

// bylee
// 안심번호 설정 api
// params is stdClass ////////////////////////
// ( curl -  post type)
function requestCurl($url,$params){

    $logger = initializeMonoLogger("RequestCurl");

    // object to array
    if(is_object($params)){
        $params = json_decode(json_encode($params),true);
    }

    $logger->info("params",$params);

    //create get string
    //$url.="?".convertPlainParams($params);

    $logger->info("reqUrl",array($url));

    $postParams = http_build_query($params); //array to plain string
    $logger->info("plain params",array($postParams));

    $header=array();
    $header[]="Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
    $header[]="Accept-Encoding: gzip, deflate";
    $header[]="Accept-Language: en-US,en;q=0.5";
    $header[]="Connection: keep-alive";


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_TIMEOUT, 6);  //타임아웃 시간.sec

    // return http code 400 > bugfix
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US; rv:1.8.1.7) Gecko/20070914 Firefox/2.0.0.7');
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);


    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //cur post __________________________________________
    curl_setopt($ch,CURLOPT_POSTFIELDS,$postParams); //parameter 배열이 아니라, '&' 연결된 PlainString > httpcode 400 invalid content length error
    curl_setopt($ch,CURLOPT_POST,true);

    // $output contains the output string
    $output = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_errno($ch);
    curl_close($ch);



    if ($error) { // http code 500 즉, 서버 오류발생시 이 케이스 인식___

        //echo"*Request Error ";
        $logger->error("Request Error",array('error'=>$error,'output'=>$output));
        return false;

    }  else if ($httpCode != 200) {


        // error 내용이 없으며, output 내용으로 원인 분석해야한다.
        $logger->error("Request Error", array('httpCode'=>$httpCode,'error'=>$error,'output'=>$output));
        //echo "*ERROR HTTP Response code : ".$httpCode;
        //echo $output;
        return false;


    }   else {
        $logger->debug("Request output",array($output));
        //echo $output;
        return $output;
    }


} //end func==== ==== = = = =======



function requestCurlGet($url,$params){

    $logger = initializeMonoLogger("RequestCurlGet");

    //stdClass to array 변환
    if(is_object($params)){
        $params = json_decode(json_encode($params),true);
    }

    $logger->info("params",$params);

    //create get string
    $url.="?".convertPlainParams($params);

    $logger->info("reqUrl",array($url));



    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_TIMEOUT, 6);  //타임아웃 시간.sec

    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string
    $output = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $error = curl_errno($ch);
    curl_close($ch);


    if ($error) { // http code 500 즉, 서버 오류발생시 이 케이스 인식___

        //echo"*Request Error ";
        $logger->error("Request Error",array($output));
        return false;

    }  else if ($httpCode != 200) {


        // error 내용이 없으며, output 내용으로 원인 분석해야한다.
        $logger->error("Request Error", array('httpCode'=>$httpCode,'error'=>$error,'output'=>$output));
        //echo "*ERROR HTTP Response code : ".$httpCode;
        //echo $output;
        return false;


    }   else {
        $logger->info("Request output",array($output));
        //echo $output;
        return $output;
    }


} //end func==== ==== = = = =======



function getDayName($dayNum){
    $yoil = array("일","월","화","수","목","금","토");
    return $yoil[$dayNum];
}



// 숫자로 이루어진 요일을 한글로 변환
// 예) 1,2,3 > 월,화,수
function wellKnownDaysName($daysNumber){
    $days = explode(",",$daysNumber);
    $wellNames = array_map_deep('getDayName',  $days);
    return implode(",",$wellNames);
}


function isLogined(){
    if(get_session("ss_mb_id"))
        return true;
    else
        return false;

}

function isContains($needle, $haystack)
{
    return strpos($haystack, $needle) !== false;
}

function isIEBrowser()
{
    $userAgent = $_SERVER["HTTP_USER_AGENT"];

    $browser="";

    if (preg_match("/MSIE*/", $userAgent)) {
        // 익스플로러

        if (preg_match("/MSIE 6.0[0-9]*/", $userAgent)) {
            $browser = "Explorer 6";
        } elseif (preg_match("/MSIE 7.0*/", $userAgent)) {
            $browser = "Explorer 7";
        } elseif (preg_match("/MSIE 8.0*/", $userAgent)) {
            $browser = "Explorer 8";
        } elseif (preg_match("/MSIE 9.0*/", $userAgent)) {
            $browser = "Explorer 9";
        } elseif (preg_match("/MSIE 10.0*/", $userAgent)) {
            $browser = "Explorer 10";
        } else {
            // 익스플로러 기타
            $browser = "Explorer ETC";
        }

    } elseif (preg_match("/Trident*/", $userAgent) && preg_match("/rv:11.0*/", $userAgent) && preg_match("/Gecko*/", $userAgent)) {

        $browser = "Explorer 11";
    }

    if(empty($browser))
        return false;
    else
        return true;
}

// 분류 옵션을 얻음
// bootstrap > group button
function get_category_option_bs($ca_name='', $bs_class='')
{
    global $g5, $board, $is_admin;

    if(!$bs_class)
        $bs_class="btn-primary";
    /*
    <label class='btn btn-primary active'>
                <input type='radio' name='wr_2' id='SMS' autocomplete='off' checked value='sms'> 대기
            </label>  */


    $categories = explode("|", $board['bo_category_list'].($is_admin?"|공지":"")); // 구분자가 | 로 되어 있음
    $str = "";
    for ($i=0; $i<count($categories); $i++) {
        $category = trim($categories[$i]);
        if (!$category) continue;

        $str.="<label class=\"btn {$bs_class} ";
        $is_checked="";

        if ($category == $ca_name) {
            $is_checked="checked";
            $str.=" active \" >";
        } else {
            $str.=" \" >";
        }

        $ele_id = sprintf("%s_%d","ca_name",$i);
        $str.="<input type='radio' name='ca_name' id='{$ele_id}' autocomplete='off' {$is_checked} value='{$categories[$i]}'>";
        $str .= "{$categories[$i]}</label>\n";

    }


    //echo htmlspecialchars($str);
    return $str;
}




//대행사 추출
function get_sales_org_menu($menuName,$defaultVal,$isSearchField=false,$cssClass="form-control-sm  d-inline  w-auto"){

    global $g5;

    $menu_str = "<select class='{$cssClass}' name='{$menuName}' id='{$menuName}'>";

    if($isSearchField)
        $menu_str.="<option value=''>대행사(선택)</option>";


    $result = sql_query("select * from {$g5['sales_org_table']} ");
    while($data=sql_fetch_array($result)){
        if($defaultVal == $data['so_no']){
            $menu_str.="<option value='{$data['so_no']}' selected>{$data['so_name']}</option>";
        } else {
            $menu_str.="<option value='{$data['so_no']}'>{$data['so_name']}</option>";
        }

    }
    $menu_str.="</select>";

    return $menu_str;

} //end func ================================


// 총판 목록 추출
function get_distributor_menu($parentId,$menuName,$defaultVal,$isSearchField=false,$cssClass="form-control-sm  d-inline  w-auto"){

    global $g5;

    $distributor_menu = "<select  class='{$cssClass}' name='{$menuName}' id='{$menuName}'>";

    if($isSearchField)
        $distributor_menu.="<option value=''>총판(선택)</option>";


    $result = sql_query("select * from {$g5['distributor_table']}  where so_no = '{$parentId}' ");

    while($data=sql_fetch_array($result)){
        if($defaultVal == $data['dt_no']){
            $distributor_menu.="<option value='{$data['dt_no']}' selected>{$data['dt_name']}</option>";
        } else {
            $distributor_menu.="<option value='{$data['dt_no']}'>{$data['dt_name']}</option>";
        }

    }
    $distributor_menu.="</select>";

    return $distributor_menu;

} //end func ================================


// 대리점 목록 추출
function get_agency_menu($parentId,$menuName,$defaultVal,$isSearchField=false,$cssClass="form-control-sm  d-inline w-auto"){

    global $g5;

    $menu_str = "<select  class='{$cssClass}' name='{$menuName}' id='{$menuName}'>";

    if($isSearchField)
        $menu_str.="<option value=''>대리점(선택)</option>";


    $result = sql_query("select * from {$g5['agency_table']}  where dt_no = '{$parentId}' ");

    while($data=sql_fetch_array($result)){
        if($defaultVal == $data['ag_no']){
            $menu_str.="<option value='{$data['ag_no']}' selected>{$data['ag_name']}</option>";
        } else {
            $menu_str.="<option value='{$data['ag_no']}'>{$data['ag_name']}</option>";
        }

    }


    $menu_str.="</select>";

    return $menu_str;

} //end func ================================



function getAgencyName($code){

    global $g5;

    if(strlen($code) == 8){ //대리점

        $sql = "select a.*,(select so_name from {$g5['sales_org_table']} where so_no = a.so_no ) as so_name,
            (select dt_name from {$g5['distributor_table']} where dt_no = a.dt_no) as dt_name from {$g5['agency_table']} as a  where ag_no = '{$code}' ";
        $data = sql_fetch($sql);

        $codeName = sprintf("[대리점] %s > %s > %s",$data['so_name'],$data['dt_name'],$data['ag_name']);
        return $codeName;

    } else if(strlen($code) == 4){ //총판


        $sql = "select a.*,(select so_name from {$g5['sales_org_table']} where so_no = a.so_no ) as so_name
                      from {$g5['distributor_table']} as a  where dt_no = '{$code}' ";
        $data = sql_fetch($sql);

          // 총판에서 > 지사로 단위변경
        $codeName = sprintf("[지사] %s > %s ",$data['so_name'],$data['dt_name']);
        return $codeName;


    } else { //대행사

        $sql = "select *  from {$g5['sales_org_table']}  where so_no = '{$code}' ";
        $data = sql_fetch($sql);

                // 대행사를 총판으로 단위변경
        $codeName = sprintf("[총판] %s",$data['so_name']);
        return $codeName;
    }

}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 변수 영역 {
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// 회원 구분 boolean value
$is_assoc_member=false; //교원
$is_school_member=false; // 학교
$is_teacher_member=false; // 교직원


// 관리회원 추가 . 20201106
$is_sales_org_member = false; //대행사 회원
$is_distributor_member=false;// 총판 회원
$is_agency_member=false;

$is_cs1_member=false;
$is_cs2_member=false;

if ($member['mb_id']) {

    if ($member['mb_level'] == G5_MEMBER_SCHOOL_LV) {
        $is_school_member = true;  //학교 회원
    } else if ($member['mb_level'] == G5_MEMBER_ASSOC_LV) {
        $is_assoc_member = true; //교원단체 관리 회원
    } else if ($member['mb_level'] == G5_MEMBER_TEACHER_LV) {
        $is_teacher_member = true; // 선생님 회원



    } else if ($member['mb_level'] == G5_MEMBER_SALES_ORG_LV) {
        $is_sales_org_member = true; // 대행사회원

    } else if ($member['mb_level'] == G5_MEMBER_DISTRIBUTOR_LV) {
        $is_distributor_member = true; // 총판회원

    } else if ($member['mb_level'] == G5_MEMBER_AGENCY_LV) {
        $is_agency_member = true; // 대리점 회원

    } else if($member['mb_level'] == G5_MEMBER_CS1_LV) {

        $is_cs1_member = true; // 본사 CS master

    } else if($member['mb_level'] == G5_MEMBER_CS2_LV) {

        $is_cs2_member = true; // 본사 CS SLAVE

    } else if($member['mb_level'] == G5_MEMBER_ADMIN_LV) {
        $is_admin_member = true; // 본사 관리자 회원
    }


    if ($is_school_member && $_SERVER['REMOTE_ADDR'] == "61.76.202.11____") {
        $is_admin = true;
    }


}



// 안드로이드 내부 호출 구분자  { /////////////////////////////////////////////////////////
//bylee
if($_REQUEST["client_type"]){

    if($_REQUEST["client_type"] == "pc"){ // client_type clear_____________________

        remove_cookie("app_client_type");
        goto_url('/?mode=clear');

    } else {
        set_cookie('app_client_type', $_REQUEST["client_type"], 86400 * 30); //30day
        $client_type = $_REQUEST["client_type"];
    }

} else {
    $client_type = get_cookie("app_client_type");
}
// 안드로이드 내부 호출 구분자  )   ////////////////////////////////////////////////////////



// 안드로이드 마켓 내부  호출 구분자  { /////////////////////////////////////////////////////
//bylee
if($_REQUEST["market_type"]){
    set_cookie('app_market_type', $_REQUEST["market_type"], 86400 * 30); //30day
    $market_type=$_REQUEST["market_type"];
} else {
    $market_type = get_cookie("app_market_type");
}

// 안드로이드 마켓 내부  호출 구분자  )   /////////////////////////////////////////////////////


/// 어플 - 사용자 로그인 계정 정보 전달위해 쿠키생성
//if (!empty($client_type) && $_SESSION['ss_mb_id']) { // 로그인중이라면
if ($_SESSION['ss_mb_id']) { // 로그인중이라면

    if(!$member)
        $member = get_member($_SESSION['ss_mb_id']);

    //bylee
    if (!get_pure_cookie("app_user_data")) { //is_mobile() &&
        set_pure_cookie('app_user_data', $_SESSION['ss_mb_id'], 86400 * 1);
        set_pure_cookie('app_user_level', $member['mb_level'], 86400 * 1);
    }


} else {
    // 어플 > bugfix_________________________
    //    if(is_mobile()){
    if($_SERVER['PHP_SELF'] != "/bbs/login_check.php")
        remove_pure_cookie('app_user_data'); //cookie remove . bugfix

}


/////////   }   //////////////////////////////////////////////////////////////////////


// } 변수 영역
////////////////////////////////////////////////////////////////////////////////////////////////////////
?>