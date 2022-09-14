<?php
require_once G5_PATH."/vendor/autoload.php";
use \Monolog\Logger as Logger;
use \Monolog\Handler\StreamHandler;
use \Monolog\Formatter\LineFormatter;


function initializeMonoLogger($channelName="",$logLevel=100){ //100 = Debug

    $dateFormat = "Y-m-d H:i:s / D";
    $output = "● %datetime% > %channel% > %level_name% :: %message% ▶ %context%\n";
    $formatter = new LineFormatter($output, $dateFormat);


   //핸들러 생성 (* log/your.log 파일에 로그 생성. 로그 레벨은 Info )
    $logFilePath = sprintf("%s/monolog/kicc_%s.log",G5_PG_PATH,date("Ymd"));  //C:/WWW/teachercall.kr/html/pg/monolog/kicc_20200523.log
    $logHandler = new StreamHandler($logFilePath, $logLevel);
    $logHandler->setFormatter($formatter); // 핸들러 -> 포맷터 할당

    // 로거 채널 생성
    //$logDefChannel=basename(__FILE__,".php"); // 함수정의된 파일명
    $logDefChannel=basename(debug_backtrace()[0]['file'],".php"); // 함수 호출되는 파이명 추출 & basename
    if(empty($channelName))
        $channelName=$logDefChannel;
    else
        $channelName=sprintf("%s (%s)",$channelName,$logDefChannel);

    $log =  new Logger($channelName); // fullpath 에서 확장자 제거 > 파일이름 얻기 > 채널로 활용
    $log->pushHandler($logHandler);

    return $log;
}



function convToEucKr($vars){
    if(!is_array($vars))
        return $vars;

    $retVal = array();
    foreach($vars as $key=>$val){
        $retVal[$key]=iconv_euckr($val);
    }
    return $retVal;
}

function convToUtf8($vars){
    if(!is_array($vars))
        return $vars;

    $retVal = array();
    foreach($vars as $key=>$val){
        $retVal[$key]=iconv_utf8($val);
    }
    return $retVal;
}


function convToUrlDecode($vars){
    if(!is_array($vars))
        return $vars;

    $retVal = array();
    foreach($vars as $key=>$val){
        $retVal[$key]=urldecode($val);
    }
    return $retVal;
}
?>