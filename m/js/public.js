$(document).ready(function(){
    var headHtml="<script id='headTemplate' type='text/html'><table><tr><td>this is head</td></tr></table></script>";
    $('#head').html(headHtml);

    var tongJi = '<script>var _hmt = _hmt || [];(function() {var hm = document.createElement("script");hm.src = "//hm.baidu.com/hm.js?d4b3728eb406c2be15b33b492cc55362";var s = document.getElementsByTagName("script")[0];s.parentNode.insertBefore(hm, s);})(); </script>';
    var footHtml="<script id='footTemplate' type='text/html'>"+tongJi+"</script>";
    $('#foot').html(footHtml);
});
var host = window.location.host,
    UA = window.navigator.userAgent,
    CLICK = 'click',
    url = 'http://api.youaiyihu.com/',
    version = 'v1/',
    ID = 'SID',
    TOKEN = 'youaiyihu',
    CONFIGS = 'configs',
    configUrl = url+version+'configs',
    loginUrl = url+version+'logins',
    commentUrl = url+version+'comments',
    orderUrl = url+version+'orders',
    payUrl = url+version+'pays',
    smsUrl = url+version+'sms',
    userUrl = url+version+'users',
    walletUrl = url+version+'wallets',
    workerUrl = url+version+'workers',
    urlToLogin = host+'/login.html',
    INDEX = host;
if(/ipad|iPhone|android/.test(UA)){
    CLICK = 'tap';
}
function getStatus() {
    var id = getCookie(ID);
    var token = encodeURIComponent(getCookie(TOKEN));
    if(!id||!token){
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

/**
 * 通过json方式获取借口数据
 * @param url：接口url
 */
function getDataJson(url){
    ;(function($){
        $.getJSON(url, function(backData){
            var bodyHtml = template('bodyTemplate', backData);
            $('#body').html(bodyHtml);
        })
    })(Zepto);
}
function delCookie(name) {
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null)
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
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
function postComment(param,callback){
    $.post(commentUrl,param,function(response){
        if(response.code == 200)
            callback(response.data);
        else
            callback(false);
    });
}
function getComment(workerId, callback){
    var user = getStatus();
    if(!user){
        var token = user.token,
            url = commentUrl+'/'+workerId+'?access-token='+token;
        $.getJSON(url, function (back){
            if(back.code ==200)
                callback(null,back.data);
        })
    }else{
        callback('error');
    }

}
function getConfigs(callback){
    var configs = JSON.parse(localStorage.getItem(CONFIGS));
    if(!configs){
        deploy(function(err,response){
            if(!err){
                callback(response);
                setConfigs(JSON.stringify(response));
            }
        });
    }else{
        callback(configs);
    }
}
function setConfigs(value){
    localStorage.setItem(CONFIGS,value);
}
function deploy(callback){
    $.getJSON(configUrl, function(e){
        if(e.code==200){
            callback(null, e.data);
        }else{
            callback("error")
        }
    })
}
function getUsers(id, token, callback){
    ;(function($){
        var url = userUrl+'/'+id+'?access-token='+token;
        $.getJSON(url, function(back){
            if(back.code==200)
                callback(back.data);
            else
                callback(false);
        })
    })(Zepto);
}
