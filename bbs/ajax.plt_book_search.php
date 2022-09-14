<?php
@header('Content-Type: application/json');
//ini_set("display_errors", 1);
include_once("./_common.php");
if(!$_SESSION['ss_mb_id']){
    ajaxExitJson("로그인 정보가 존재하지 않습니다.");
}


/**
 *  서가 적취 >  바코드 - 도서검색
 *
 */

$_REQUEST = array_map_deep('iconv_euckr', $_REQUEST);
$code = clean_xss_tags(get_text($_REQUEST['code']));

//$code = "9788932016511";

if(!empty($code)){
    $code = filteringEanCode($code);
}

if(empty($code)){
    ajaxExitJson("필수 인자가 누락되었습니다. ");
}


//1 row return
$sql = "begin PKGMHPDA.PROC_PLTINSELBOOK(:p_bar_cd,:cur_bk); end; ";
$stmt = sql_query_parse($sql);

oci_bind_by_name($stmt, ':p_bar_cd', $code) ; //in

//oci_bind_by_name($result, ':cur_bk', $output) ;
//But BEFORE statement, Create your cursor
$cursor = oci_new_cursor($g5['connect_db']);
// On your code add the latest parameter to bind the cursor resource to the Oracle argument
oci_bind_by_name($stmt,":cur_bk", $cursor,-1,OCI_B_CURSOR);

// Execute the statement as in your first try
sql_query_execute($stmt);
sql_query_execute($cursor);

/*
// 1 row return __________________________________________
$result = "";
while ($row = oci_fetch_array($cursor, OCI_RETURN_LOBS )) {
    $row = array_map_deep('iconv_utf8', $row);
    $row = array_change_key_case($row,CASE_LOWER);
    $result = $row;
}



$result['move_loc_cd']=wellKnownLocFormat($result['loc_cd']);

//multiBasicLocCus(tax_no)
$mdata = sql_result("select fld_code from gncode where fld_id = 'location_multiple'
                  and fld_code is not null and fld_code = '{$result['tax_no']}' ");

$result['multi_loc_cd'] = "{$mdata}"; //이중 적치 허용출판사 > 현재 1곳  / 0459

echo json_encode($result);
**/


//multiBasicLocCus(tax_no)
$mdata = sql_result("select fld_code from gncode where fld_id = 'location_multiple'
                  and fld_code is not null and fld_code = '{$result['tax_no']}' ");

$multiLocCode = $mdata; //이중 적치 허용출판사 > 현재 1곳  / 0459


ob_start();
echo'<table id="dt_bk_list" class="table  table-hover">
    <thead>
    <tr>
        <th scope="col">로케이션</th>
        <th scope="col">단가</th>
        <th scope="col">정품재고</th>
        <th scope="col">반품재고</th>
    </tr>
    </thead>
    <tbody>
';




$seq=0;

while ($row = oci_fetch_array($cursor, OCI_RETURN_LOBS )) {
    $row = array_map_deep('iconv_utf8', $row);
    $row = array_change_key_case($row,CASE_LOWER);


    $row['move_loc_cd']=wellKnownLocFormat($row['loc_cd']);
    $row['multi_loc_cd'] = "{$multiLocCode}";

    $hidData = json_encode($row);

    $seq++;

    $rowUid = $row['bk_cd']."_".$row['tax_no']; //primary key 돌겠다 ㅡㅡ;

    echo"
      <tr id='row_bk_id_{$rowUid}' class='book_sel_row' data = '{$hidData}'>
        <td class='td_left  border-top border-primary' colspan='4' >{$row['bk_nm']}</td>
      </tr>

      <tr id='row_bk_id_{$rowUid}' class='book_sel_row' data = '{$hidData}'>
      <td class='td_center'>".wellKnownLocFormat($row['loc_cd'])."</td>
      <td class='td_price'>".number_format($row['out_danga'])."</td>
      <td class='td_qty_m'>".number_format($row['a_qty'])."</td>
      <td class='td_qty_m'>".number_format($row['x_qty'])."</td>
    </tr>
    ";
}

if($seq == 0) {
    echo'<tr><td colspan="3" class="text-center p-3"> *조회된 정보가 없습니다. </td></tr>';
}

echo"</tbody></table>";
?>

    <script>

        $('#dt_bk_list > tbody > tr').click(function() {

            var $this = $(this);
            var selData = $(this).attr('data');


            if ($this.hasClass('clicked')){

                $this.removeClass('clicked');
                //here is your code for double click
                selectBook(selData); //도서 선택 & 창닫기

            }else{

                $this.addClass('clicked');
                setTimeout(function() {
                    if ($this.hasClass('clicked')){

                        $this.removeClass('clicked');

                        //your code for single click

                        showBookDetail(selData); //도서 상세보기


                    }
                }, 500);
            }


        });



    </script>

<?php

if($seq == 1){
    echo"<script>
            setTimeout(function(){
            var selData = $('#row_bk_id_{$rowUid}').attr('data');
              selectBook(selData);
            },300);
        </script>
    ";
}

$content = ob_get_contents();
ob_end_clean();
echo $content;


/***
 * {
bk_cd: "15002",
bk_nm: "탈출기",
tax_no: "0037",
cust_nm: "문학과지성사",
out_danga: "11000",
jg_qty: "0",
a_qty: "0",
avg_qty: "10", //권장재고
loc_cd: "A33422",
chul_qty: "0",
max_qty: "40",
ipsu_qty: "30",
loc_cd1: "A30000", //bksbjg.loc_cd > cur_loc_cd
x_qty: "0"
}
 **************/