var submit = $('.submit'),
    code = $('.code');
var user = getStatus();
submit.on(CLICK,function(err){
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
        }
    });
});
code.on(CLICK,function(err){
    var data = $('form').serializeArray(),
        error = true;
    validateSms(data, function(a){
        if(!a)
            error = false;
    });
    if(!error)
        return false;
    $.post(smsUrl,data,function(response){
        console.log(response);
    });
});
function validateLogin(date, callback){
    var phone = /^(1[3|5|7|8|][0-9]{9})$/,
        code = /^d{6}$/;
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