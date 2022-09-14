/**
 * Created by admin on 2021-02-24.
 */


function playBeepSound(){
    if(window.hasOwnProperty("Android")){
        window.Android.playBeepSound();
    }
}

function hideAndroidKeyboard(){
    if(window.hasOwnProperty("Android")){
        window.Android.setKeyboardHide(true);
    }
}

var DashBoard={
    searchStat:false,
    processStat:false,
    setSearchStat:function(stat){
        this.searchStat=stat;
    },
    isSearching:function(){
        return this.searchStat;
    },
    setProcessStat:function(stat){
        this.processStat=stat;
    },
    isProcessing:function(){
        return this.processStat;
    }

}


$(document).on('focus', '.text-select',  function(e){
    //console.log("focused on " + e.target.id);
    $(this).select();
});

$(document).on('keyup', '.text-select',  function(e){
    if(e.keyCode == 13) {
        hideAndroidKeyboard();
    }
});

$(function() {

    // 입력필드에 커서 이동시, text  선택되게
    /*
    $('.text-select').focus(function () {
        $(this).select();
    })


    // 데이터 처리 후, 키보드 사라지게
    $('.hide-keyboard').keyup(function (e) {
         if(e.keyCode == 13) {
            hideAndroidKeyboard();
        }
    })

     */

});