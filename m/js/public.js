$(document).ready(function(){
    var head_html="<script id='head_template' type='text/html'><table><tr><td>this is head</td></tr></table></script>";
    document.getElementById('head').innerHTML = head_html;

    var tongji = '<script>var _hmt = _hmt || [];(function() {var hm = document.createElement("script");hm.src = "//hm.baidu.com/hm.js?d4b3728eb406c2be15b33b492cc55362";var s = document.getElementsByTagName("script")[0];s.parentNode.insertBefore(hm, s);})(); </script>';
    var foot_html="<script id='foot_template' type='text/html'> <table ><tr><td>this is foot</td> </tr></table>"+tongji+"</script>";
    document.getElementById('foot').innerHTML = foot_html;
});

var UA = window.navigator.userAgent;
var CLICK = 'click';
if(/ipad|iPhone|android/.test(UA)){
    CLICK = 'tap';
}
var url = 'http://api.youaiyihu.com/',
    version = 'v1/',
    ID = 'SID',
    TOKEN = 'youaiyihu';
var configUrl = url+version+'configs',
    loginUrl = url+version+'logins',
    commentUrl = url+version+'comments',
    orderUrl = url+version+'orders',
    payUrl = url+version+'pays',
    smsUrl = url+version+'sms',
    userUrl = url+version+'users',
    walletUrl = url+version+'wallets',
    workerUrl = url+version+'workers',
    urlToLogin = '#';
function getStatus() {
    var id = getCookie(ID);
    var token = getCookie(TOKEN);
    if(!id||!token){
        window.location.href = urlToLogin;
        return false;
    }
    return JSON.parse('{"id":"'+id+'","token":"'+token+'"}');
}
function setCookie(name,value) {
    var Days = 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name) {
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
}
function delCookie(name) {
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null)
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
function getConfigs(callback){
    $.getJSON(configUrl, function(e){
        if(e.code==200){
            callback(null, e.data);
        }else{
            callback("error")
        }
    })
}
function getComments(id, callback){
    $.getJSON(commentUrl+'/'+id, function(e){
        if(e.code==200){
            callback(null, e.data);
        }else{
            callback("error")
        }
    })
}
function postComments(){

}
//例子
/*getConfigs(function(err, data){
    if(err){
        return console.log(err);
    }
    console.log(data);
});*/
