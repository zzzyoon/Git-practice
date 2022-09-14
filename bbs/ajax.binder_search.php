<?php
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    die("<strong>로그인 정보가 존재하지 않습니다. </strong>");
}
$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$code = clean_xss_tags(get_text($_REQUEST['code']));
$name = clean_xss_tags(get_text($_REQUEST['name']));
if(empty($code) && empty($name)){
    alert("필수 인자가 누락되었습니다. ");
}


$sql = "select metax_no,mecust_nm from custme  where cust_gb = '92'  ";
if(!empty($code)){
    $sql.=" and  metax_no like '{$code}%' ";
} else {
    $sql.=" and  mecust_nm like '%{$name}%' ";
}

$sql.=" and  rownum <= 10";
$result = sql_query($sql);


ob_start();
echo'<table  class="table  table-hover">
    <thead>
    <tr>
        <th scope="col">No</th>
        <th scope="col">코드</th>
        <th scope="col">이름</th>
    </tr>
    </thead>
    <tbody>
';


$seq=0;
while($row = sql_fetch_array($result)){
    $seq++;
    echo"
      <tr onclick=\"selectBinder('{$row['metax_no']}','{$row['mecust_nm']}')\">
      <th scope='row'>$seq</th>
      <td>{$row['metax_no']}</td>
      <td>{$row['mecust_nm']}</td>
    </tr>
    ";
}

if($seq == 0) {
    echo'<tr><td colspan="3" class="text-center p-3"> *조회된 정보가 없습니다. </td></tr>';
}

echo"</tbody></table>";


if($seq == 1){
    echo"<script>
            setTimeout(function(){
                selectBinderSingleRow();
            },500);
        </script>
    ";
}

$content = ob_get_contents();
ob_end_clean();
echo $content;