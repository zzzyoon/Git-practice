<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

define('G5_CURL_TIMEOUT',  4);
define('G5_CURL_HOSTNAME',$_SERVER["SERVER_NAME"]);

$httpProtocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
define('G5_CURL_REFERER',sprintf("%s%s",$httpProtocol,$_SERVER["SERVER_NAME"]));

//request doc type > json
$curlHeaders = array("Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
    "Accept-Encoding:gzip, deflate, sdch",
    "Accept-Language:ko-KR,ko;q=0.8,en-US;q=0.6,en;q=0.4",
    "Cache-Control:no-cache",
    "Connection:keep-alive",
    "Host:".$hostName,
    "Pragma:no-cache",
    "Referer:".$curlReferer,
    "User-Agent:Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36");
define('G5_CURL_HEADER',$curlHeaders);

define('G5_CURL_USERAGENT',"Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");



function curlConvertPlainParams($params){

    $plainParam = "";

    if(is_array($params)) {

        foreach ($params as $key => $val) {
            if (!$plainParam)
                $plainParam = ($key . "=" . $val);
            else
                $plainParam .= "&" . ($key . "=" . $val);
        }

    } else if(is_object($params)){

        foreach($params as $property => &$value)
        {
            $val = &$value;
            if (!$plainParam)
                $plainParam = ($property . "=" . $val);
            else
                $plainParam .= "&" . ($property . "=" . $val);
        }

    } //end if


    return $plainParam;
} //end method ====================== = = = ==== ============================




//params is array
function curlRequest($url,$params)
{
    $reqUrl = $url;
    $reqUrl .= "?" . curlConvertPlainParams($params);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $reqUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, G5_CURL_TIMEOUT);  //타임아웃 시간.sec

    //OPTIONS
    curl_setopt ($ch, CURLOPT_USERAGENT, G5_CURL_USERAGENT); // User Browser Set

    $output = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    ob_start();
    if (curl_errno($ch)) {
        echo "{'result_stat':false,result_msg:'Request Error'} ";
    } else if ($httpCode != 200) {
        //echo "*Error : HTTP Response code : " . $httpCode;
        // echo $output;
        echo "{'result_stat':false,result_msg:'HTTP Response code : ".$httpCode."'} ";
    } else {
        echo $output;
    }

    $content = ob_get_contents();
    ob_end_clean();

    return json_decode($content);

} //end func=========================

function curlErrorCheck($resultObj){
    return isset($resultObj->result_stat) ? true:false;
}


function curlErrorGetMsg($resultObj){
    if(!isset($resultObj->result_msg)) {
        return "";
    }

    return $resultObj->result_msg;
}
?>