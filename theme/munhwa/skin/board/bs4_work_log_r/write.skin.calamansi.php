<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//moment.js include
add_javascript('<script src="'.G5_JS_URL.'/moment-with-locales.min.js"></script>', 10);

//bylee . calamansi .js
add_javascript('<script src="'.$board_skin_url.'/calamansi.js"></script>', 11);

if ($is_category) {
    $ca_name = "";
    if (isset($write['ca_name']))
        $ca_name = $write['ca_name'];

    if($w == "")
        $ca_name = "기타";

    //$category_option = get_category_option($bo_table, $ca_name);
    $category_option = get_category_option_bs($ca_name,"btn-info");
}


if($w=="u" && $write['wr_1']){
    $group = get_member_group($write['wr_1']);
    $write['wr_1_nm'] = $group['mg_name'];
}

?>
<link href="<?php echo $board_skin_url ?>/style.css" rel="stylesheet">








<script type="text/javascript">
    $(document).ready(function () {
        /*
        // ====  Display Only=================/
        $( "#Calamasi_tabs" ).tabs();
        $( "#Calamasi_Combo_History" ).selectmenu();
        $( "#Calamasi_History_Sdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
        $( "#Calamasi_History_Edate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
        $( "#Calamasi_Combo_Misscall" ).selectmenu();
        $( "#Calamasi_MissCall_Sdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
        $( "#Calamasi_MissCall_Edate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
        $( "#Calamasi_Combo_Ltrans" ).selectmenu();
        $( "#Calamasi_Combo_M_History" ).selectmenu();
        $( "#Calamasi_M_History_Sdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
        $( "#Calamasi_M_History_Edate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });

        $( "#Calamasi_API_Status" ).controlgroup();
        // ====  Display Only=================/

*/
        // ======== Calamansi OCX 연동 ===========================
        // LoginAgent Method
        $("#Calamasi_Btn_LoginAgent" ).button();
        $("#Calamasi_Btn_LoginAgent").on('click', function () {
            var fagentid = document.getElementById("agentid").value;
            var fagentpwd = document.getElementById("agentpwd").value;
            var fagentext = document.getElementById("agentext").value;
            var fagentip = document.getElementById("agentip").value;
            if (document.all['Calamasi_API_conn'].value != "Login")
            {
                CalamansiAPI.LoginAgent ( fagentid , fagentpwd, fagentext, fagentip );
              //      calamansi.initialize();
            }
        });
        // DisconnectAgent Method
        $("#Calamasi_Btn_DisconnectAgent").button();
        $("#Calamasi_Btn_DisconnectAgent").on('click', function () {
            var fagentid = document.getElementById("agentid").value;
            var fagentext = document.getElementById("agentext").value;
            if (document.all['Calamasi_API_conn'].value == "Login")
            {
                document.all['Calamasi_API_conn'].value = "Logout";
                CalamansiAPI.DisconnectAgent ( fagentid , fagentext );
            }
        });
        // LoginManager Method
        $("#Calamasi_Btn_LoginManager" ).button();
        $("#Calamasi_Btn_LoginManager").on('click', function () {
            var fagentid = document.getElementById("agentid").value;
            var fagentpwd = document.getElementById("agentpwd").value;
            var fagentip = document.getElementById("agentip").value;
            if (document.all['Calamasi_API_conn'].value != "Login")
            {
                CalamansiAPI.LoginManager ( fagentid , fagentpwd, fagentip );
            }
        });
        // DisconnectManager Method
        $("#Calamasi_Btn_DisconnectManager").button();
        $("#Calamasi_Btn_DisconnectManager").on('click', function () {
            var fagentid = document.getElementById("agentid").value;
            if (document.all['Calamasi_API_conn'].value == "Login")
            {
                CalamansiAPI.DisconnectManager ( fagentid );
            }
        });
        //ReconnectAgent Method
        $("#Calamasi_Btn_ReconnectAgent" ).button();
        $("#Calamasi_Btn_ReconnectAgent").on('click', function () {
            var fagentid = document.getElementById("agentid").value;
            var fagentpwd = document.getElementById("agentpwd").value;
            var fagentext = document.getElementById("agentext").value;
            var fagentip = document.getElementById("agentip").value;
            if (document.all['Calamasi_API_conn'].value != "Login")
            {
                CalamansiAPI.Reconnect ( fagentid , fagentpwd, fagentext, fagentip );
            }
        });



        //Click2Call Method
        $("#Calamasi_Btn_Click2Call").button();
        $("#Calamasi_Btn_Click2Call").on('click', function () {
            var fcall_num = document.getElementById("call_num").value;
            CalamansiAPI.Click2Call(fcall_num, '', '');
        });
        //Answer Method
        $("#Calamasi_Btn_Answer").button();
        $("#Calamasi_Btn_Answer").on('click', function () {	CalamansiAPI.Answer(); });
        //Hangup Method
        $("#Calamasi_Btn_Hangup").button();
        $("#Calamasi_Btn_Hangup").on('click', function () {	CalamansiAPI.Hangup(); });
        //Hold  Method
        $("#Calamasi_Btn_Hold").button();
        $("#Calamasi_Btn_Hold").on('click', function () { CalamansiAPI.Hold(); });
        //Mute Method
        $("#Calamasi_Btn_Mute").button();
        $("#Calamasi_Btn_Mute").on('click', function () { CalamansiAPI.Mute(); });
        //Pickup Method
        $("#Calamasi_Btn_Pickup").button();
        $("#Calamasi_Btn_Pickup").on('click', function () {	CalamansiAPI.Pickup(''); });
        //Transfer Method
        $("#Calamasi_Btn_Transfer").button();
        $("#Calamasi_Btn_Transfer").on('click', function () {
            var ftans_num = document.getElementById("tans_num").value;
            CalamansiAPI.Transfer(ftans_num);
        });
        //SetCallerid Method
        $("#Calamasi_Btn_Setcid").button();
        $("#Calamasi_Btn_Setcid").on('click', function () {
            var fdnis_num = document.getElementById("dnis_num").value;
            CalamansiAPI.SetCallerid(fdnis_num);
        });
        //GetCallerid Method
        $("#Calamasi_Btn_Getcid" ).button();
        $("#Calamasi_Btn_Getcid").on('click', function () { CalamansiAPI.GetCallerid();});
        //SetForward Method 설정
        $("#Calamasi_Btn_SetForward_Set" ).button();
        $("#Calamasi_Btn_SetForward_Set").on('click', function () {
            var fforward_num = document.getElementById("forward_num").value;
            CalamansiAPI.SetForward('1',fforward_num);
        });
        //SetForward Method 해제
        $("#Calamasi_Btn_SetForward_Clean" ).button();
        $("#Calamasi_Btn_SetForward_Clean").on('click', function () {
            var fforward_num = document.getElementById("forward_num").value;
            CalamansiAPI.SetForward('0',fforward_num);
        });
        //GetForward Method
        $("#Calamasi_Btn_GetForward").button();
        $("#Calamasi_Btn_GetForward").on('click', function () {
            var fforward_num = document.getElementById("forward_num").value;
            CalamansiAPI.SetForward('2',fforward_num);
        });
        //GetPeerInfo Method
        $("#Calamasi_Btn_GetPeerInfo").button();
        $("#Calamasi_Btn_GetPeerInfo").on('click', function () {
            var fpeer_num = document.getElementById("peer_num").value;
            CalamansiAPI.GetPeerInfo(fpeer_num);
        });
        //GetCallHistory Method
        $("#Calamasi_Btn_GetCallHistory" ).button();
        $("#Calamasi_Btn_GetCallHistory").on('click', function () {
            var finout = document.getElementById("Calamasi_Combo_History").value;
            var fstart = document.getElementById("Calamasi_History_Sdate").value + ' ' + document.getElementById("Calamasi_History_Stime").value;
            var fend   = document.getElementById("Calamasi_History_Edate").value + ' ' + document.getElementById("Calamasi_History_Etime").value;
            var foption = document.getElementById("Calamasi_History_Num").value;
            CalamansiAPI.GetCallHistory(finout,fstart,fend,foption);
        });
        //GetMissCallHistory Method
        $("#Calamasi_Btn_GetMissCallHistory" ).button();
        $("#Calamasi_Btn_GetMissCallHistory").on('click', function () {
            var fminout = document.getElementById("Calamasi_Combo_Misscall").value;
            var fmstart = document.getElementById("Calamasi_MissCall_Sdate").value + ' ' + document.getElementById("Calamasi_MissCall_Stime").value;
            var fmend   = document.getElementById("Calamasi_MissCall_Edate").value + ' ' + document.getElementById("Calamasi_MissCall_Etime").value;
            var fmoption = document.getElementById("Calamasi_MissCall_Num").value;
            CalamansiAPI.GetMissCallHistory(fminout,fmstart,fmend,fmoption);
        });
        //SetLineTransfer Method
        $("#Calamasi_Btn_SetLineTransfer").button();
        $("#Calamasi_Btn_SetLineTransfer").on('click', function () {
            var fuse	 = document.getElementById("Calamasi_Combo_Ltrans").value;
            var fDnisNo	 = document.getElementById("Calamasi_LineTransfer_Dnis_Num").value;
            var fforwardcall = document.getElementById("Calamasi_LineTransfer_Called_Num").value;
            var fstarttime	 = document.getElementById("Calamasi_LineTransfer_Stime").value;
            var fendtime	 = document.getElementById("Calamasi_LineTransfer_Etime").value;
            CalamansiAPI.SetLineTransfer(fuse,fDnisNo,fforwardcall,fstarttime,fendtime);
        });
        //GetAllCallHistory Method
        $("#Calamasi_Btn_GetAllCallHistory" ).button();
        $("#Calamasi_Btn_GetAllCallHistory").on('click', function () {
            var finout = document.getElementById("Calamasi_M_Combo_History").value;
            var fstart = document.getElementById("Calamasi_M_History_Sdate").value + ' ' + document.getElementById("Calamasi_M_History_Stime").value;
            var fend   = document.getElementById("Calamasi_M_History_Edate").value + ' ' + document.getElementById("Calamasi_M_History_Etime").value;
            var foption = document.getElementById("Calamasi_M_History_Num").value;
            CalamansiAPI.GetAllCallHistory(finout,fstart,fend,foption);
        });
        //SetCallReject Method 설정
        $("#Calamasi_Btn_CallReject_Set" ).button();
        $("#Calamasi_Btn_CallReject_Set").on('click', function () {
            CalamansiAPI.SetCallReject('1');
        });
        //SetCallReject Method 해제
        $("#Calamasi_Btn_CallReject_Clean" ).button();
        $("#Calamasi_Btn_CallReject_Clean").on('click', function () {
            CalamansiAPI.SetCallReject('0');
        });
        //SetCallReject Method
        $("#Calamasi_Btn_CallReject").button();
        $("#Calamasi_Btn_CallReject").on('click', function () {
            CalamansiAPI.SetCallReject('2');
        });

        // ======== Calamansi OCX 연동 ===========================
    });

    // ======== Calamansi live Check ===========================
    function Calamasi_Onload(){
        /* =========== 로그인 후 재접속시 사용 바랍니다.================*/
        var fagentid = document.getElementById("agentid").value;
        var fagentpwd = document.getElementById("agentpwd").value;
        var fagentext = document.getElementById("agentext").value;
        var fagentip = document.getElementById("agentip").value;
        if (document.all['Calamasi_API_conn'].value != "Login")
        {
            CalamansiAPI.Reconnect ( fagentid , fagentpwd, fagentext, fagentip );
        }
        /**/
        Calamasi_Live_Check();
    }


    function Calamasi_Live_Check(){
        //시간 비교후 팝업
        setTimeout(function () {
            if (document.all['Calamasi_API_live'].value !=  "...")
            {
                var calamansi_date = new Date();
                var calamansi_time =  formatDate(calamansi_date);
                var calamansi_diff = hmsToSeconds(calamansi_time) - hmsToSeconds(document.all['Calamasi_API_live'].value);
                if (calamansi_diff < 0)
                {
                    calamansi_diff = calamansi_diff + 86400;
                }
                if (calamansi_diff > 10)
                {
                    document.all['Calamasi_API_live'].value = "...";
                    alert("서버와 접속이 끊어 졌습니다.다시 로그인 바랍니다....");
                    location.reload();
                }
            }
            Calamasi_Live_Check();
        }, 5000);
    }



    // ======== Calamansi live Check ===========================
    function formatDate(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();
        if (hours < 10) {
            hours = "0" + hours;
        }
        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        if (seconds < 10) {
            seconds = "0" + seconds;
        }
        var strTime = hours + ':' + minutes + ':' + seconds;
        return strTime;
    }

    function hmsToSeconds(s) {
        var b = s.split(':');
        return b[0]*3600 + b[1]*60 + (+b[2] || 0);
    }

    // ======== Calamansi OCX Close ===========================
    function Calamasi_OCX_Unload(){
        var fagentid = document.getElementById("agentid").value;
        var fagentext = document.getElementById("agentext").value;
        //if (document.all['Calamasi_API_conn'].value == "Login")
        //{
        CalamansiAPI.DisconnectAgent ( fagentid , fagentext );
        //}
        return ;
    }
</script>
<!---Calamansi OCX 연동 Event----------->

<!-- bylee 로그인 결과 (LoginAgent method >  request > response)   ---->
<script language="javascript"  event="SendLoginResultEvent(evtdata)" for="CalamansiAPI">
    var jbSplit = evtdata.split('|');
    for ( var i in jbSplit ) {
        if (jbSplit[i] =='STATUS:1')
        {
            document.all['Calamasi_API_conn'].value = "Login";
        }
        if (jbSplit[i] =='STATUS:0')
        {
            document.all['Calamasi_API_conn'].value = "Login Fail";

        }
    }
    document.all['event_log'].value = "CalamasiAPI Start\n";
    document.all['event_log'].value += "SendLoginResultEvent = " + evtdata + "\n";
</script>

<!--- 통화 시도   -->
<script language="javascript"  event="SendRingEvent(evtdata)" for="CalamansiAPI">
    document.all['Calamasi_API_line'].value = "연결중";
    document.all['event_log'].value += "SendRingEvent  = " + evtdata + "\n";
</script>

<!-- bylee 통화시 호출   -->
<script language="javascript"  event="SendAnswerEvent(evtdata)" for="CalamansiAPI">
    var jbSplit = evtdata.split('|');
    for ( var i in jbSplit ) {
        if (i == 3) //GETCID
        {
            var jCidSplit = jbSplit[i].split(':');
            if (jCidSplit[0] == 'CALLER1ID')
            {
                document.all['ani_num'].value = jCidSplit[1];
            }
        }
    }
    document.all['Calamasi_API_line'].value = "통화중";
    document.all['event_log'].value += "SendAnwserEvent  = " + evtdata + "\n";
</script>

<!-- 전화 통화 종료 및 통화 대기중 종료시 호출 -->
<script language="javascript"  event="SendHangupEvent(evtdata)" for="CalamansiAPI">
    document.all['Calamasi_API_line'].value = "DISCONNECT";
    document.all['event_log'].value += "SendHangupEvent  = " + evtdata + "\n";
</script>

<script language="javascript"  event="SendCommandResultEvent (evtdata)" for="CalamansiAPI">
    var Calamasi_flag  = 0; // 1:HOLD, 2:MUTE,3:GETCALLERID, 4:GetForward
    var jbSplit = evtdata.split('|');
    for ( var i in jbSplit ) {
        if (jbSplit[i] =='CMD:HOLD') { Calamasi_flag = 1; }
        if (jbSplit[i] =='CMD:MUTE') { Calamasi_flag = 2; }
        if (jbSplit[i] =='CMD:GETCALLERID') { Calamasi_flag = 3; }
        if (jbSplit[i] =='CMD:SETFORWORD') { Calamasi_flag = 4;	}
        if (jbSplit[i] =='CMD:SETCALLREJECT') { Calamasi_flag = 5;	}
        if (Calamasi_flag == 1 && i == 4) //HOLD
        {
            if (jbSplit[i] =='ACT:HOLD')
            {
                document.all['Calamasi_API_hold'].value = "HOLD";
            }
            if (jbSplit[i] =='ACT:UNHOLD')
            {
                document.all['Calamasi_API_hold'].value = "UNHOLD";
            }
        }
        if (Calamasi_flag == 2 && i == 4) //MUTE
        {
            if (jbSplit[i] =='ACT:MUTE')
            {
                document.all['Calamasi_API_mute'].value = "MUTE";
            }
            if (jbSplit[i] =='ACT:TALK')
            {
                document.all['Calamasi_API_mute'].value = "UNMUTE";
            }
        }
        if (Calamasi_flag == 3 && i == 4) //GETCALLERID
        {
            var jCidSplit = jbSplit[i].split(':');
            if (jCidSplit[0] == 'CID')
            {
                document.all['dnis_num'].value = jCidSplit[1];
            }
        }
        if (Calamasi_flag == 4 && i == 4) //GetForward
        {
            var jCidSplit = jbSplit[i].split(':');
            if (jCidSplit[0] == 'PHONE')
            {
                document.all['forward_num'].value = jCidSplit[1];
            }
        }
        if (Calamasi_flag == 4 && i == 5) //GetForward
        {
            if (jbSplit[i] =='ACT:1')
            {
                document.all['forward_stat'].value = "Enable";
            }
            if (jbSplit[i] =='ACT:0')
            {
                document.all['forward_stat'].value = "Disable";
            }
        }
        if (Calamasi_flag == 5 && i == 4) //SetCallReject
        {
            if (jbSplit[i] =='ACT:1')
            {
                document.all['CallReject_stat'].value = "Enable";
            }
            if (jbSplit[i] =='ACT:0')
            {
                document.all['CallReject_stat'].value = "Disable";
            }
        }
    }

    document.all['event_log'].value += "SendCommandResultEvent  = " + evtdata +"\n";
</script>

<script language="javascript"  event="SendCmdErrorEvent (evtdata,evtmsg)" for="CalamansiAPI">
    document.all['event_log'].value += "SendCmdErrorEvent(Function)  = " + evtdata +  "\n";
    document.all['event_log'].value += "SendCmdErrorEvent(Messages)  = " + evtmsg + "\n";
</script>

<script language="javascript"  event="SendPhoneStatEvent(evtdata)" for="CalamansiAPI">
    document.all['Calamasi_API_stat'].value = evtdata;
    if (evtdata == "TIMEOUT")
    {
        alert("단말기와 접속이 끊어 졌습니다.다시 로그인 바랍니다....");
        location.reload();
    }
</script>

<script language="javascript"  event="SendNetworkEvent(evtdata)" for="CalamansiAPI">
    var jbSplit = evtdata.split('|');
    for ( var i in jbSplit ) {
        if (jbSplit[i] =='CMD:DISCONNECTAGENT')
        {
            document.all['Calamasi_API_conn'].value = "Logout";
            document.all['Calamasi_API_live'].value = "...";
        }
        if (jbSplit[i] =='CMD:DISCONNECTMANAGER')
        {
            document.all['Calamasi_API_conn'].value = "Logout";
            document.all['Calamasi_API_live'].value = "...";
        }
    }
    document.all['event_log'].value += "SendNetworkEvent  = " + evtdata + "\n";
</script>

<script language="javascript"  event="SendLiveEvent(evtdata)" for="CalamansiAPI">
    var calamansi_date = new Date();
    var calamansi_time =  formatDate(calamansi_date);
    document.all['Calamasi_API_live'].value = calamansi_time;
    //document.all['event_log'].value += "SendLiveEvent[" + calamansi_time + ']=' + evtdata + "\n";
</script>








<!-- html area   ------------------------------------------------------------------------------------------------->

<section id="calamansi_sample">



    <h1>
        <OBJECT classid="clsid:6D7C1184-B072-432C-828E-8ACEFAA69833" codebase="http://KCT/Calamansi_OCX.ocx#version=1,0,0,0"
                width=50
                height=50
                align=center hspace=0 vspace=0 id="CalamansiAPI">
        </OBJECT>
        Welcome to KCT Calamansi OCX Sample !</h1>
    <!-- Status -->
    <fieldset>
        <legend>OCX 상태</legend>
        <div id="Calamasi_API_Status">
            <label for="Calamasi_API_conn" class="ui-controlgroup-label">CONN</label>
            <input id="Calamasi_API_conn" class="ui-spinner-input" size="14" value="Logout">
            <label for="Calamasi_API_stat" class="ui-controlgroup-label">STAT</label>
            <input id="Calamasi_API_stat" class="ui-spinner-input" size="14" value="...">
            <label for="Calamasi_API_line" class="ui-controlgroup-label">LINE</label>
            <input id="Calamasi_API_line" class="ui-spinner-input" size="14" value="...">
            <label for="Calamasi_API_hold" class="ui-controlgroup-label">HOLD</label>
            <input id="Calamasi_API_hold" class="ui-spinner-input" size="14" value="UNHOLD">
            <label for="Calamasi_API_mute" class="ui-controlgroup-label">MUTE</label>
            <input id="Calamasi_API_mute" class="ui-spinner-input" size="14" value="UNMUTE">
            <label for="Calamasi_API_live" class="ui-controlgroup-label">LIVE</label>
            <input id="Calamasi_API_live" class="ui-spinner-input" size="14" value="...">
        </div>
    </fieldset>
    <br>
    <!-- Tabs -->

    <div id="Calamasi_tabs">
        <ul>
            <li><a href="#Calamasi_tabs-1">로그인/로그아웃</a></li>
            <li><a href="#Calamasi_tabs-2">전화제어</a></li>
            <li><a href="#Calamasi_tabs-3">전화설정</a></li>
            <li><a href="#Calamasi_tabs-4">내선조회</a></li>
            <li><a href="#Calamasi_tabs-5">통화내역</a></li>
            <li><a href="#Calamasi_tabs-6">미연결콜</a></li>
            <li><a href="#Calamasi_tabs-7">전체착신설정</a></li>
            <li><a href="#Calamasi_tabs-8">관리자통화내역</a></li>
            <li><a href="#Calamasi_tabs-9">수신거부</a></li>
        </ul>
        <div id="Calamasi_tabs-1">
            <li>상담원ID : <input name="agentid" type="text" class="input" id="agentid" size="20" maxlength="15"   value = "agt_0802" ></li></br>
            <li>패스워드 : <input name="agentpwd" type="text" class="input" id="agentpwd" size="20" maxlength="15"  value = "0802" ></li></br>
            <li>내선번호 : <input name="agentext" type="text" class="input" id="agentext" size="20" maxlength="8"  value ="0802"></li></br>
            <li>서버IP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input name="agentip" type="text" class="input" id="agentip" size="20" maxlength="20" value = "27.255.97.30"></li></br>
            <li>Login/Logout :
                <button id="Calamasi_Btn_LoginAgent">로그인</button>
                <button id="Calamasi_Btn_DisconnectAgent">로그아웃</button>
                <button id="Calamasi_Btn_LoginManager">관리자로그인</button>
                <button id="Calamasi_Btn_DisconnectManager">관리자로그아웃</button>
                <button id="Calamasi_Btn_ReconnectAgent">상담원다시접속</button>
            </li>
        </div>
        <div id="Calamasi_tabs-2">
            <li>Click2Dial 착신번호 : <input name="call_num" type="text" class="input" id="call_num" size="20" maxlength="15" > <button id="Calamasi_Btn_Click2Call">전화걸기</button></li></br>
            <li>SetCID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 발신번호 : <input name="dnis_num" type="text" class="input" id="dnis_num" size="20" maxlength="15" > <button id="Calamasi_Btn_Setcid">발신번호설정</button><button id="Calamasi_Btn_Getcid">설정확인</button></li></br>
            <li>Answer/Pickup 고객번호(ANI) : <input name="ani_num" type="text" class="input" id="ani_num" size="20" maxlength="15" > <button id="Calamasi_Btn_Answer">ANSWER</button>
                <button id="Calamasi_Btn_Pickup">PICKUP</button></li></br>
            <li>Transfer 전화번호 : <input name="tans_num" type="text" class="input" id="tans_num" size="20" maxlength="15" > <button id="Calamasi_Btn_Transfer">호전환</button></li></br>
            <li>Hangup/Hold/Mute :
                <button id="Calamasi_Btn_Hangup">전화끊기</button>
                <button id="Calamasi_Btn_Hold">Hold</button>
                <button id="Calamasi_Btn_Mute">Mute</button>
            </li>
        </div>
        <div id="Calamasi_tabs-3">
            <li>SetForwarding 착신상태 : <input name="forward_stat" type="text" class="input" id="forward_stat" size="20" maxlength="15" ></li></br>
            <li>SetForwarding 착신번호 : <input name="forward_num" type="text" class="input" id="forward_num" size="20" maxlength="15" ></li></br>
            <li>SetForwarding :
                <button id="Calamasi_Btn_GetForward">착신확인</button>
                <button id="Calamasi_Btn_SetForward_Set">착신설정</button>
                <button id="Calamasi_Btn_SetForward_Clean">착신해제</button>
            </li>
        </div>
        <div id="Calamasi_tabs-4">
            <li>등록된전화기 정보 조회 (조회하려는 내선번호들을 입력해주세요. </li></br>
            <li>(예 하나는 '5001', 다수 전화기는 '5001,5002,5003')</li></br>
            <li>GetPeerInfo Data :
                <input name="peer_num" type="text" class="input" id="peer_num" size="20" maxlength="64" >
                <button id="Calamasi_Btn_GetPeerInfo">정보조회</button>
            </li>
        </div>
        <div id="Calamasi_tabs-5">
            <li>수신/발신 :
                <select id="Calamasi_Combo_History">
                    <option selected="selected" value="0">수신</option>
                    <option value="1">발신</option>
                </select>
            </li></br>
            <li>시작일자 : <input name="Calamasi_History_Sdate" type="text" class="input" id="Calamasi_History_Sdate" size="12" maxlength="15" >
                시간 : <input name="Calamasi_History_Stime" type="text" class="input" id="Calamasi_History_Stime" size="12" maxlength="15" value="00:00:00">(24H:mm:dd)
            </li></br>
            <li>종료일자 : <input name="Calamasi_History_Edate" type="text" class="input" id="Calamasi_History_Edate" size="12" maxlength="15" >
                시간 : <input name="Calamasi_History_Etime" type="text" class="input" id="Calamasi_History_Etime" size="12" maxlength="15" value="23:59:59">(24H:mm:dd)
            </li></br>
            <li>전화번호 : <input name="Calamasi_History_Num" type="text" class="input" id="Calamasi_History_Num" size="20" maxlength="15" ></li></br>
            <li><button id="Calamasi_Btn_GetCallHistory">정보조회</button></li>
        </div>
        <div id="Calamasi_tabs-6">
            <li>수신/발신 :
                <select id="Calamasi_Combo_Misscall">
                    <option selected="selected" value="0">수신</option>
                    <option value="1">발신</option>
                </select>
            </li></br>
            <li>시작일자 : <input name="Calamasi_MissCall_Sdate" type="text" class="input" id="Calamasi_MissCall_Sdate" size="12" maxlength="15" >
                시간 : <input name="Calamasi_MissCall_Stime" type="text" class="input" id="Calamasi_MissCall_Stime" size="12" maxlength="15" value="00:00:00">(24H:mm:dd)
            </li></br>
            <li>종료일자 : <input name="Calamasi_MissCall_Edate" type="text" class="input" id="Calamasi_MissCall_Edate" size="12" maxlength="15" >
                시간 : <input name="Calamasi_MissCall_Etime" type="text" class="input" id="Calamasi_MissCall_Etime" size="12" maxlength="15" value="23:59:59">(24H:mm:dd)
            </li></br>
            <li>전화번호 : <input name="Calamasi_MissCall_Num" type="text" class="input" id="Calamasi_MissCall_Num" size="20" maxlength="15" ></li></br>
            <li><button id="Calamasi_Btn_GetMissCallHistory">정보조회</button></li>
        </div>
        <div id="Calamasi_tabs-7">
            <li>SetLineTransfer 설정/해제 :
                <select id="Calamasi_Combo_Ltrans">
                    <option selected="selected" value="1">설정</option>
                    <option value="0">해제</option>
                </select>
            </li></br>
            <li>SetLineTransfer DNIS : <input name="Calamasi_LineTransfer_Dnis_Num" type="text" class="input" id="Calamasi_LineTransfer_Dnis_Num" size="20" maxlength="15" ></li></br>
            <li>SetLineTransfer 착신번호 : <input name="Calamasi_LineTransfer_Called_Num" type="text" class="input" id="Calamasi_LineTransfer_Called_Num" size="20" maxlength="15" ></li></br>
            <li>SetLineTransfer 시작시간 : <input name="Calamasi_LineTransfer_Stime" type="text" class="input" id="Calamasi_LineTransfer_Stime" size="12" maxlength="15" value="0000">(24Hmm)</li></br>
            <li>SetLineTransfer 종료시간 : <input name="Calamasi_LineTransfer_Etime" type="text" class="input" id="Calamasi_LineTransfer_Etime" size="12" maxlength="15" value="2359">(24Hmm)</li></br>
            <li><button id="Calamasi_Btn_SetLineTransfer">SetLineTransfer</button></li>
        </div>
        <div id="Calamasi_tabs-8">
            <li>수신/발신 :
                <select id="Calamasi_Combo_M_History">
                    <option selected="selected" value="0">수신</option>
                    <option value="1">발신</option>
                </select>
            </li></br>
            <li>시작일자 : <input name="Calamasi_M_History_Sdate" type="text" class="input" id="Calamasi_M_History_Sdate" size="12" maxlength="15" >
                시간 : <input name="Calamasi_M_History_Stime" type="text" class="input" id="Calamasi_M_History_Stime" size="12" maxlength="15" value="00:00:00">(24H:mm:dd)
            </li></br>
            <li>종료일자 : <input name="Calamasi_M_History_Edate" type="text" class="input" id="Calamasi_M_History_Edate" size="12" maxlength="15" >
                시간 : <input name="Calamasi_M_History_Etime" type="text" class="input" id="Calamasi_M_History_Etime" size="12" maxlength="15" value="23:59:59">(24H:mm:dd)
            </li></br>
            <li>전화번호 : <input name="Calamasi_M_History_Num" type="text" class="input" id="Calamasi_M_History_Num" size="20" maxlength="15" ></li></br>
            <li><button id="Calamasi_Btn_GetAllCallHistory">관리자정보조회</button></li>
        </div>
        <div id="Calamasi_tabs-9">
            <li>SetCallReject 상태 : <input name="CallReject_stat" type="text" class="input" id="CallReject_stat" size="20" maxlength="15" ></li></br>
            <li>SetCallReject :
                <button id="Calamasi_Btn_CallReject">SetCallReject확인</button>
                <button id="Calamasi_Btn_CallReject_Set">SetCallReject설정</button>
                <button id="Calamasi_Btn_CallReject_Clean">SetCallReject해제</button>
            </li>
        </div>
    </div>
    <div>
        <h2 class="demoHeaders">Event Log</h2>
        <textarea name="event_log" cols="215" rows="20" class="input" id="event_log"></textarea>
    </div>





</section>



<script>
$(function() {

   calamansi.setConfig('<?=$mansi['cc_user_id']?>', '<?=$mansi['cc_user_pw']?>', '<?=$mansi['cc_extension_number']?>', '<?=G5_CALAMASI_SERVER?>');
//calamansi.initialize();

});


</script>