<?php
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    die("<strong>로그인 정보가 존재하지 않습니다. </strong>");
}

$dt_no = clean_xss_tags(get_text($_REQUEST['dt_no']));



$sql = "select * from {$g5['agency_table']} where dt_no  = '{$dt_no}'  ";
$sql.=" order by ag_no asc";
$result = sql_query($sql);


ob_start();
echo " <option value=''>대리점(선택)</option>";
while($row = sql_fetch_array($result)){
    echo"<option value='{$row['ag_no']}'>{$row['ag_name']}</option>";
}

$content = ob_get_contents();
ob_end_clean();
echo $content;