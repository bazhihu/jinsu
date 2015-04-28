var sub = $('.submit'),
    code = $('.retrieve-button'),
    validCode=true;
var user = getStatus();
if(user){
    window.location.href = history.go(-1);
}
sub.on(CLICK,function(err){
    var data = $('form').serializeArray(),
        error = true;
    validateLogin(data, function(a){
        if(!a)
            error = false;
    });
    if(!error)
        return false;
    $.post(loginUrl,data,function(back){
        if(back.code == 200)
        {
            setCookie(ID, back.data.uid);
            setCookie(TOKEN, back.data.token);
            window.location.href = history.go(-1);
        }else{

        }
    });
});
code.on(CLICK,function(err){
    var time=60;
    var button = $(this);
    if (validCode) {
        validCode=false;
        var data = $('form').serializeArray(),
            error = true;
        validateSms(data, function(a){
            if(!a)
                error = false;
        });
        if(!error)
            return false;
        $('.hide').attr('style', null);
        var t=setInterval(function  () {
            time--;
            button.html('('+time+")重新获取");
            if (time==0) {
                clearInterval(t);
                button.html("重新获取");
                validCode=true;
            }
        },1000);
        $.post(smsUrl,data,function(response){
            console.log(response);
        });
    }
});
function validateLogin(date, callback){
    var phone = /^(1[3|5|7|8|][0-9]{9})$/,
        code = /\d{6}/;
    $.map(date,function(item,index){
        if(item.name == 'mobile' && !phone.test(item.value)){
            alert('请输入正确的手机号码');
            callback(false);
        }
        if(item.name == 'authCode' && !code.test(item.value)){
            alert('请输入正确的验证码');
            callback(false);
        }
    });
}
function validateSms(date, callback){
    var phone = /^(1[3|5|7|8|][0-9]{9})$/;
    $.map(date,function(item,index){
        if(item.name == 'mobile' && !phone.test(item.value)){
            alert('请输入正确的手机号码');
            callback(false);
        }
    });
}
