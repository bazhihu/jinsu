$(document).ready(function(){
    var headHtml="<script id='headTemplate' type='text/html'></script>";
    $('#head').html(headHtml);

    var tongJi = '<script>var _hmt = _hmt || [];(function() {var hm = document.createElement("script");hm.src = "//hm.baidu.com/hm.js?d4b3728eb406c2be15b33b492cc55362";var s = document.getElementsByTagName("script")[0];s.parentNode.insertBefore(hm, s);})(); </script>';
    var footHtml="<script id='footTemplate' type='text/html'>"+tongJi+"</script>";
    $('#foot').html(footHtml);
});

var host = "http://"+window.location.host,
    UA = window.navigator.userAgent,
    CLICK = 'click',
    url = 'http://api.youaiyihu.com/',
    version = 'v1/',
    ID = 'SID',
    NAME = 'name',
    TOKEN = 'youaiyihu',
    CONFIGS = 'configs',
    CYCLE = 'cycle',
    configUrl = url+version+'configs',
    loginUrl = url+version+'logins',
    commentUrl = url+version+'comments',
    orderUrl = url+version+'orders',
    payUrl = url+version+'pays',
    walletsUrl = url+version+'wallets',
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
    var name = getCookie(NAME);
    var token = encodeURIComponent(getCookie(TOKEN));
    if(!id||!token||!name){
        return false;
    }
    return JSON.parse('{"id":"'+id+'","name":"'+name+'","token":"'+token+'"}');
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
function cycles(){
    var cycle = getCookie(CYCLE),
        time = new Date().getTime(),
        interval = 24*60*60;
    if(!cycle){
        setCookie(CYCLE, time);
        return true;
    }else if(Number(cycle)+Number(interval)<Number(time)){
        setCookie(CYCLE, time);
        return true;
    }
    return false;
}
function getConfigs(callback){
    var configs = JSON.parse(localStorage.getItem(CONFIGS)),
        cycle = cycles();
    if(!configs || cycle){
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
function getWallets(id, token, callback){
    ;(function($){
        var url = walletUrl+'/'+id+'?access-token='+token;
        $.getJSON(url, function(back){
            if(back.code==200)
                callback(back.data);
            else
                callback(false);
        })
    })(Zepto);
}
function getUser(id, token, callback){
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
/**
 * 获取url 参数
 * @param name
 * @returns {*}
 */
function getUrlQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}

function getLocal(){
    var configs = localStorage.getItem(CONFIGS);
    return configs;
}
function setLocal(value){
    localStorage.setItem(CONFIGS,value);
}

/**
 * 时间差days
 * @param startTime
 * @param endTime
 * @returns {number}
 */
function getOrderCycle(startTime,endTime){
    var year1 =  startTime.substr(0,4),
        year2 =  endTime.substr(0,4),
        month1 = startTime.substr(5,2),
        month2 = endTime.substr(5,2),
        day1 = startTime.substr(8,2),
        day2 = endTime.substr(8,2),
        date1=new Date(year1,month1,day1),    //开始时间
        date2=new Date(year2,month2,day2),    //结束时间
        date3=date2.getTime()-date1.getTime(), //时间差的毫秒数
        days=parseInt(date3/(24*3600*1000));
    if(days>=1)
        days = days;
    else
        days = 0;

    return days;
}
/**
 * 时间对象的格式化
 */
Date.prototype.format = function(format)
{
    /*
     * format="yyyy-MM-dd hh:mm:ss";
     */
    var o = {
        "M+" : this.getMonth() + 1,
        "d+" : this.getDate(),
        "h+" : this.getHours(),
        "m+" : this.getMinutes(),
        "s+" : this.getSeconds(),
        "q+" : Math.floor((this.getMonth() + 3) / 3),
        "S" : this.getMilliseconds()
    }

    if (/(y+)/.test(format))
    {
        format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4
        - RegExp.$1.length));
    }

    for (var k in o)
    {
        if (new RegExp("(" + k + ")").test(format))
        {
            format = format.replace(RegExp.$1, RegExp.$1.length == 1
                ? o[k]
                : ("00" + o[k]).substr(("" + o[k]).length));
        }
    }
    return format;
}
