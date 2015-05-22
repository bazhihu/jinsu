var sub = $('.signin-form'),
    code = $('.retrieve-button'),
    validCode = true;
var user = getStatus();
if(user){
    window.location.href = history.back();
}
function previous(){
    var previous = document.referrer,
        result ;
    result = previous.indexOf(window.location.host);
    if(result>0){
        return true;
    }else{
        return false;
    }
}
sub.submit(
    function(e){
        var data = $('form').serializeArray(),
            error = true;
        validateLogin(data, function(a){
            if(!a)error = false;
        });
        if(error){
            $.post(loginUrl,data,function(back){
                if(back.code == 200)
                {
                    setCookie(ID, back.data.uid);
                    setCookie(NAME, back.data.mobile);
                    setCookie(TOKEN, back.data.token);
                    if(previous()){
                        self.location=document.referrer;
                    }else{
                        window.location.href = host;
                    }
                }else{
                    alert(back.msg);
                }
            });
        }
        return false;
    }
);
code.on(CLICK,function(err){
    if(validCode){
        var time=60,
            button = $(this);
        validCode=false;
        var data = $('form').serializeArray(),
            error = true;
        validateSms(data, function(a){
            if(!a)
                error = false;
        });
        if(error){
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
    }
});
function validateLogin(date, callback){
    var phone = /^(1[3|5|7|8|][0-9]{9})$/,
        code = /\d{6}/,
        pass = true;
    $.map(date,function(item,index){
        if(item.name == 'mobile' && !phone.test(item.value)){
            alert('请输入正确的手机号码');
            callback(false);
            pass = false;
        }
        if(pass && item.name == 'authCode' && !code.test(item.value)){
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
