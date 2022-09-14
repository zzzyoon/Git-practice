
var calamansi = {
    userId:'',
    userPw:'',
    extNum:'',
    serverIp:'',
    objectLog:'', //#event_log
    objectApiConn:'#Calamasi_API_conn', //login,out 표시
    objectApiLine:'#Calamasi_API_line',
    objectApiStat:'#Calamasi_API_stat',
    objectApiHold:'',
    objectApiMute:'',
    objectApiLive:'#Calamasi_API_live',
    initialize:function(){


        if(this.userId.length == 0 || this.userPw.length == 0
            || this.extNum.length == 0 || this.serverIp.length == 0){
            alert('깔라만시 솔루션 계정을 바르게 설정하세요.');
            return false;
        }


        this.login();

    },
    setConfig:function(_userId,_userPw,_extNum,_serverIp){
      this.userId = _userId;
      this.userPw =_userPw;
        this.extNum = _extNum;
        this.serverIp = _serverIp;

    },
    login:function(){
        if ($(this.objectApiConn).val() != "Login")
        {
            CalamansiAPI.LoginAgent(this.userId , this.userPw, this.extNum, this.serverIp );
        }
    },
    logout:function(){
        if ($(this.objectApiConn).val() == "Login") {
            $(this.objectApiConn).val('Logout');
            CalamansiAPI.DisconnectAgent(this.userId, this.extNum);
        }
    },
    reconnect:function(){
        if ($(this.objectApiConn).val() != "Login")
        {
            CalamansiAPI.Reconnect(this.userId , this.userPw, this.extNum, this.serverIp );
        }
    },
    destroy:function(){  //logout
        this.logout();
    },
    showMsg :function(msg){
        alert(msg);
    },
    click2Dial:function(phoneNumber){
        CalamansiAPI.Click2Call(phoneNumber, '', '');
    },
    addLog:function(msg){
        if(this.objectLog.length > 0) {
            var prevVal = $(this.objectLog).val();
            $(this.objectLog).val(prevVal+msg+"\n");
        }
    },
    clearLog:function(){
        if(this.objectLog.length > 0) {
            $(this.objectLog).val('');
        }
    },
    setConnMsg:function(msg){
        if(this.objectApiConn.length == 0)
            return;

        $(this.objectApiConn).val(msg);

        if(msg.toLowerCase() == "login"){
            $(this.objectApiConn).removeClass("bg-secondary").addClass("bg-info font-weight-bold");
        } else {

            $(this.objectApiConn).removeClass("bg-info font-weight-bold").addClass("bg-secondary");
        }


    },
    setStatMsg:function(msg){
        if(this.objectApiStat.length == 0)
            return;
        $(this.objectApiStat).val(msg);
    },
    setLineMsg:function(msg){
        if(this.objectApiLine.length == 0)
            return;
        $(this.objectApiLine).val(msg);
    },
    setHoldMsg:function(msg){
        if(this.objectApiHold.length == 0)
            return;

        $(this.objectApiHold).val(msg);
    },
    setMuteMsg:function(msg){
        if(this.objectApiMute.length == 0)
            return;
        $(this.objectApiMute).val(msg);
    },
    setLiveMsg:function(msg){
        if(this.objectApiLive.length == 0)
            return;
        $(this.objectApiLive).val(msg);
    },
    getLiveMsg:function(){
        if(this.objectApiLive.length == 0)
            return "";
        return $(this.objectApiLive).val();
    }
}






// 깔라만시 > 리로딩시  > onload > 로그인 시도  (*참고용)
/*
function Calamasi_Onload(){
    // =========== 로그인 후 재접속시 사용 바랍니다.================
    var fagentid = document.getElementById("agentid").value;
    var fagentpwd = document.getElementById("agentpwd").value;
    var fagentext = document.getElementById("agentext").value;
    var fagentip = document.getElementById("agentip").value;
    if (document.all['Calamasi_API_conn'].value != "Login")
    {
        CalamansiAPI.Reconnect ( fagentid , fagentpwd, fagentext, fagentip );
    }

    Calamasi_Live_Check();
}
*/

// ======== Calamansi OCX Close ===========================
/*
function Calamasi_OCX_Unload(){
    var fagentid = document.getElementById("agentid").value;
    var fagentext = document.getElementById("agentext").value;
    //if (document.all['Calamasi_API_conn'].value == "Login")
    //{
    CalamansiAPI.DisconnectAgent ( fagentid , fagentext );
    //}
    return ;
}
*/




// 인터넷 전화 라인 체크 //////////////////////////////////////////////
// 원소스에선 reloading > calamansi.reconnect > 함수 후  호출
function Calamasi_Live_Check(){
    //시간 비교후 팝업
    setTimeout(function () {
        if (calamansi.getLiveMsg() !=  "...")
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
                //document.all['Calamasi_API_live'].value = "...";
                calamansi.setLiveMsg("...");
                alert("서버와 접속이 끊어 졌습니다. 다시 로그인 바랍니다.(LiveCheck)");
                //location.reload(); //bylee
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

