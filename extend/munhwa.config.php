<?php

/*
public enum MovGubun { wareHouseing, pallet, bookShelf, highRac,moveAll }

public enum locGubun { yard, pallet,highRac, shelf,allLoc }
*/

define('MH_LOC_GB_YARD',0);
define('MH_LOC_GB_PALLET',1);
define('MH_LOC_GB_HIGHRAC',2);
define('MH_LOC_GB_SHELF',3);
define('MH_LOC_GB_ALLOC',4);

define('MH_MOV_GB_WAREHOUSE',0);
define('MH_MOV_GB_PALLET',1);
define('MH_MOV_GB_BOOKSHELF',2);
define('MH_MOV_GB_HIGHRAC',3);
define('MH_MOV_GB_MOVEALL',4);



//작업 타입 선택 유무
// A 정품, X 반품
function chooseWorkType(){

    return ($_SESSION['ss_work_type'])?true:false;

}


function filteringEanCode($code){

    if(!$code)
        return;

    $code = filteringCode($code);

    if(strlen($code) == 18){
        return strstr($code,0,13);
    } else {
        return $code;
    }

}


function filteringCode($code){
    $code =  trim(strtoupper(str_replace("-","",$code)));
    return preg_replace("/[^A-Za-z0-9]/", "", $code);
}



//  특수문자 및 공백
function filteringSpcChr($stx)
{
    $stx_pattern = array();
    $stx_pattern[] = '#\.*/+#';
    $stx_pattern[] = '#\\\*#';
    $stx_pattern[] = '#[<>\- \./\'\"%=*\#\(\)\|\+\&\!\$~\{\}\[\]`;:\?\^\,]+#';

    $stx_replace = array();
    $stx_replace[] = '';
    $stx_replace[] = '';
    $stx_replace[] = '';

    $stx = preg_replace($stx_pattern, $stx_replace, $stx);

    return $stx;
}


function wellKnownLocFormat($locCode)
{
    if (!preg_match('/^(\w{2})(\w{2})(\w{2})$/', $locCode, $match)) {
        return false;
    }

    return sprintf("%s-%s-%s",$match[1],$match[2],$match[3]);

}


function existLocCheck($locCode){

    global $g5;

    $sql = "SELECT LOC_CD FROM LOCATE WHERE LOC_CD = '{$locCode}' ";
    $data =sql_fetch($sql);
    if($data)
        return true;
    else
        return false;

}


function existPltCode($pltCode){
    $sql = "SELECT * FROM PALLET WHERE PLT_CD = '{$pltCode}' ";
    $data =sql_fetch($sql);

    if($data){
        return true;
    } else {
        return false;
    }
}


function validatePltCode($pltCode,$movGb,$isCombined=false){

    global $g5;

    $sql = "SELECT nvl(USE_YN,'N') as use_yn,nvl(LOCATION_YN,'N') as loc_yn FROM PALLET WHERE PLT_CD = '{$pltCode}' ";
    $data =sql_fetch($sql);

    if(!$data){
        return "등록되지 않는 파레트({$pltCode}) 입니다. ";
    }

    if($data['loc_yn'] == "Y"){
        return "이미 이동 적치된 파레트({$pltCode}) 입니다. ";
    }

    if($data['use_yn'] == "Y" && $movGb == MH_MOV_GB_PALLET && !$isCombined){
        return "사용중인 파레트({$pltCode})이므로, 합짐하셔야 합니다.  ";
    }

    return true;
}



function validateLocCode($moveLocCd,$locGb){

    $locHead = substr($moveLocCd,0,1);

    if(strlen($moveLocCd) != 6){
        return "로케이션[{$moveLocCd}] 형식이 아닙니다. ";
    }

    if($locHead != "A" && $locHead != "0" && $locGb == MH_LOC_GB_SHELF){
        return "서가 로케이션[{$moveLocCd}] 형식이 아닙니다. ";
    }


    if($locGb == MH_LOC_GB_ALLOC && $locHead == "P"){
        return "이동 할 수 있는  로케이션[{$moveLocCd}]이 아닙니다. ";
    }


    if($locGb == MH_LOC_GB_HIGHRAC &&  ($locHead == "A" ||  $locHead == "0")  ){
        return "하이랙 로케이션[{$moveLocCd}]이 아닙니다. ";
    }

    return true;

}


function getBookJgQty($befLoc,$goodCd,$sizeGb,$jgGb){
    if (substr($jgGb,0,1) == "5") {
        $sql = "select nvl(jg_qty,0) - nvl(medg_qty,0) from capo.locajg where good_cd = '{$goodCd}' and loc_cd = '{$befLoc}' and size_gb = '{$sizeGb}' and jg_gb = '{$jgGb}' ";
    }
    else {
        $sql = "select nvl(jg_qty,0) - nvl(medg_qty,0) from ucapo.locajg where good_cd = '{$goodCd}' and loc_cd = '{$befLoc}' and size_gb = '{$sizeGb}' and jg_gb = '{$jgGb}' ";
    }
    //echo"<hr> $sql";

    $realQty =  sql_result($sql);



    if(strlen($realQty) == 0)
        return 0;
    else
        return $realQty;
}

function getBookcd($sizeGb,$goodCd){

    global $g5;

    $sql = "";
//    if(strlen($goodCd) >= 13){
//        $sql = "SELECT a.*  FROM GOODCD a, GOODJG b WHERE a.good_cd = b.good_cd and b.BAR_CD = '{$goodCd}' ";
//    } else {
//        $sql = "SELECT *  FROM GOODCD WHERE GOOD_CD = '{$goodCd}'  and SIZE_GB = '{$sizeGb}' ";
//    }
    $sql = "SELECT *  FROM GOODCD WHERE GOOD_CD = '{$goodCd}' ";

    $data =sql_fetch($sql);

    return $data;
}

function getBookcdOld($bookCd){

    global $g5;

    $sql = "";
    if(strlen($bookCd) >= 13){
        $sql = "SELECT *  FROM BOOKCD WHERE BAR_CD = '{$bookCd}' ";
    } else {
        $sql = "SELECT *  FROM BOOKCD WHERE BK_CD = '{$bookCd}'   ";
    }


    $data =sql_fetch($sql);

    return $data;
}


function getCustcd($custNo){
    $sql =  "SELECT *  FROM CUSTCD WHERE TAX_NO = '{$custNo}' ";
    return sql_fetch($sql);
}


function echoComment($msg){
    echo "\n\n<!--    debug msg --- ---  \n ";
    echo $msg;
    echo " \n ---  --- debug msg -->\n\n";
}

function echoLine($msg){
    echo"<hr>$msg<hr>";
}

