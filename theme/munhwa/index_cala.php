<?php
define('_INDEX_', true);
ini_set("display_errors", 1);

if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/head.php');
?>

<?php if (!defined("_INDEX_")) { ?>
    <h2 id="container_title">
        <span title="<?php echo get_text($g5['title']); ?>"><?php echo get_head_title($g5['title']); ?></span>
    </h2>
<?php } ?>



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
            <li>상담원ID : <input name="agentid" type="text" class="input" id="agentid" size="20" maxlength="15"   value = "agt_0801" ></li></br>
            <li>패스워드 : <input name="agentpwd" type="text" class="input" id="agentpwd" size="20" maxlength="15"  value = "0801" ></li></br>
            <li>내선번호 : <input name="agentext" type="text" class="input" id="agentext" size="20" maxlength="8"  value ="0801"></li></br>
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

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>