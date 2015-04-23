/**
 * Created by HZQ on 2015/4/23.
 */
(function(){
    //登录
    var submit = $('.submit'),
        code = $('.code'),
        postUrl = 'http://api.youaiyihu.com/v1/logins',
        getUrl = 'http://api.youaiyihu.com/v1/sms';

    submit.on('tap',function(e){
        var data = $('form').serializeArray();
        if(!validateLogin(data)){
            return false;
        }
        $.post(postUrl,data,function(response){
            console.log(response);
        });
    });
    //发送验证码
    code.on('tap',function(e){
        var data = $('form').serializeArray();return false;
        $.post(getUrl,data,function(response){
            console.log(response);
        });
    });
    //登录数据验证
    function validateLogin(date){
        $.map(date,function(item,index){
            if(!item.value){
                return false;
            }
        });
        return true;
    }
    //短信数据验证
    function validateSms(date){
        $.map(date,function(item,index){
            if(item){

            }
        });
    }
})(Zepto);