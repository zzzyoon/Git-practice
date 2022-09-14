<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$gm_skin_url.'/style.css">', 0);
//add_javascript('<script src="'.$sms_skin_url.'/skin.js"></script>', 10);
add_javascript('<script src="'.G5_JS_URL.'/jquery.mtz.monthpicker.js"></script>', 10);
//echoVarDump($write);
?>


<div class="section-header page d-none d-md-block">
    <h3><?php echo $g5['title'] ?></h3>
</div>

<form name="search_form" id="search_form"  action=<?php echo $_SERVER['SCRIPT_NAME'];?> class="local_sch01 local_sch" method="post">



<div class="row">
    <div class="col-md-6 col-12">

        <input type="text" name="sfl_start_month" value="<?php echo $sfl_start_month ?>" id="sfl_start_month" size="12" required readonly class="form-control required  text-center w-25 d-inline-block" >
        ~
        <input type="text" name="sfl_end_month" value="<?php echo $sfl_end_month ?>" id="sfl_end_month"  size="12" required readonly class="form-control required  text-center w-25 d-inline-block" >

        <button class="btn btn-secondary mb-1" type="submit">
            <i class="fas fa-search"></i>
        </button>

    </div>




</div>
</form>


<div>&nbsp;</div>

<div class="tbl_head01 tbl_wrap">


    <table>
        <caption><?php echo $g5['title']; ?> 목록</caption>
        <thead>
        <tr>
            <th scope="col" class="d-none d-md-table-cell">번호</th>
            <th scope="col">년월</th>
            <th scope="col">
                <span class="d-none  d-md-block">안심번호 관리요금</span> <!-- only pc -->
                <span class="d-block d-md-none">요금정보</span> <!-- only mobile -->
            </th>
            <th scope="col" class="d-none d-md-table-cell">SMS 이용요금</th>
            <th scope="col" class="d-none d-md-table-cell">안심발신 이용요금</th>
            <th scope="col" class="d-none d-md-table-cell">총 합계</th>
            <th scope="col" class="d-none d-md-table-cell">결제상태</th>
            <th scope="col" class="d-none d-md-table-cell">기타</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($list) == 0) { ?>
            <tr>
                <td colspan="<?php echo $colspan?>" class="empty_table text-center" >
                    <div class="alert alert-info m-2">
                        *데이터가 없습니다.
                    </div>
                </td>
            </tr>

            <?php
        }

        $seq = count($list);
        for ($i=0; $i<count($list); $i++) {

            $bg = 'bg'.($line++%2);
            $payStatus = "미결제";

            if($list[$i]['pg_no'] > 0){
                //결제
                $pdata =sql_fetch("select * from {$g5['pg_log']} where pg_type in ('11','22') and pg_no = {$list[$i]['pg_no']}
                                    and pg_res_cd = '0000' and pg_refund_id is null and pg_canc_date is null");

                //환불
                $rdata =sql_fetch("select * from {$g5['pg_log']} where pg_type ='99' and pg_no = {$list[$i]['pg_no']} and pg_res_cd = '0000' ");



                if($pdata && !$rdata) {
                    if($pdata['pg_type']=="11" || ($pdata['pg_type']=="22" && $pdata['pg_deposit_date']) )
                        $payStatus = "결제완료";
                    else if($pdata['pg_type']=="22")
                        $payStatus="입금대기";

                }
            }
            ?>


            <tr class="<?php echo $bg; ?>">
                <td class="td_num d-none d-md-table-cell"><?php echo  $seq?></td>
                <td class="td_num_c3 font-weight-bold"><?php echo  $list[$i]['gc_month']?>
                    <!-- for mobile -->
                    <div class="d-block d-md-none p-0 text-primary" >
                      [  <?php echo $payStatus ?> ]
                    </div>

                </td>
                <td class="td_numcoupon ">

                       <span class="d-none d-md-block">
                          <?php echo  number_format($list[$i]['gc_snms_amt'])?> 원
                       </span>

                    <!-- for mobile  screen      {    ----------------------->
                    <div class="d-block d-md-none p-0" >
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">안심번호 : <?php echo  number_format($list[$i]['gc_snms_amt'])?> 원 </li>
                            <li class="list-group-item">문자비 : <?php echo number_format($list[$i]['gc_sms_amt']) ?> 원 </li>
                            <li class="list-group-item">안심발신  : <?php echo  number_format($list[$i]['gc_tnms_amt'])?> 원</li>
                            <li class="list-group-item text-danger font-weight-bold bg-gray-lightest">*총합계  : <?php echo number_format($list[$i]['gc_total_amt']); ?> 원</li>
                            <li class="list-group-item"><a href="/bbs/gmember_charge_detail.php?gc_no=<?php echo $list[$i]['gc_no']?>" class="btn btn-sm btn-info">상세내역</a></li>
                        </ul>

                    </div>
                    <!----------------------------------- }   for mobile  screen      {    --->

                </td>
                <td class="td_numcoupon  d-none d-md-table-cell"><?php echo number_format($list[$i]['gc_sms_amt']) ?> 원   </td>
                <td class="td_numcoupon d-none d-md-table-cell"><?php echo  number_format($list[$i]['gc_tnms_amt'])?> 원</td>
                <td class="td_numcoupon  text-danger font-weight-bold d-none d-md-table-cell"><?php echo number_format($list[$i]['gc_total_amt']) ?>원</td>
                <td class="td_datetime text-primary d-none d-md-table-cell"><?php echo $payStatus ?></td>
                <td class="td_addr text-center d-none d-md-table-cell">
                    <a href="/bbs/gmember_charge_detail.php?gc_no=<?php echo $list[$i]['gc_no']?>" class="btn btn-sm btn-info">상세내역</a>
                </td>
            </tr>
        <?php
            $seq--;
        } ?>
        </tbody>
    </table>
</div>

<div class="alert alert-warning my-3">
    <strong>*참고 : 월 이용요금 납부알림 </strong><br>
     월별 이용금액에 대해서 "상세내역" 버튼을 클릭& 상세페이지로 이동해서  서비스 사용내역과 "총 월사용요금"을 확인 한 후 페이지 하단의 "결제하기" 기능을 이용해서 납부를 해주서야지만 저희 서비스를  지속적으로 이용가능합니다.
</div>
<?php
// 월별 통계 추출은 페이징하지, 않고 한 페이지 모두 출력해준다.
//echo get_paging(G5_IS_MOBILE ? $sconfig['sms_mobile_pages'] : $sconfig['sms_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME']."?st=$st&amp;sv=$sv&amp;page="); ?>
<div>&nbsp;</div>


<script>
    $(function() {


        var currentYear = (new Date()).getFullYear();
        var startYear = currentYear-3;

        var options = {
            startYear: startYear,
            finalYear: currentYear,
            pattern: 'yyyy-mm',
            monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월']

        };

        $("#sfl_start_month").monthpicker(options);
        $("#sfl_end_month").monthpicker(options);

    });

</script>