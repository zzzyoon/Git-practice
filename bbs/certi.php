<?php
include_once('./_common.php');

//학교회원 . 통신이용 증명원

if(!$_SESSION['ss_mb_id']){
    die("<strong>로그인 정보가 존재하지 않습니다. </strong>");
}

if(!$is_school_member)
    alert("접근 권한이 존재하지 않습니다. ");

$certiBoTable = "g5_write_certi";
//wr_1 = gmember.mg_no
$data = sql_fetch("select * from {$certiBoTable}  where wr_1 = '{$member['mg_no']}'  limit 1");
if(!$data) {
    // 글쓰기 란으로 이동
    goto_url("/bbs/write.php?bo_table=certi");
}else{
    // view 페이지 이동
    goto_url("/bbs/board.php?bo_table=certi&wr_id=".$data['wr_id']);
}



