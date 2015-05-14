loggedIn();
var order_no = getUrlQueryString('orderNo'),
    total_amount = getUrlQueryString('totalAmount'),
    user = getStatus(),
    wei = isWeiXn(),
    alipay = $('#alipay'),
    wechat = $('#wechat'),
    pay = $('#pay');
if(user.id && user.name && user.token){
    getUsers(user.id, user.token, function(back){
        if(total_amount>back.wallet.money){
            var needPay;
            $('.payments').attr('style',null);
            needPay = total_amount-back.wallet.money;
            if(needPay){
                document.getElementById('needPay').innerHTML = needPay;
                document.getElementById('payMoney').value = needPay;
            }
        }
        document.getElementById('total').innerHTML  = '&yen;'+total_amount;
        document.getElementById('balance').innerHTML    = '&yen;'+back.wallet.money;
    });
}
pay.on(CLICK, function(){
    var orderUrls = orderUrl+'/'+order_no+'?access-token='+user.token,
        payWay = $('input[name=payment]:checked').val();
    if(payWay == '3'){
        //openId = getOpenID();
        openId = '';
        if(!openId){
            //var notifyUrl = url+'wechat/notify';
            var notifyUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx35492d0f3afac96b&redirect_uri=http%3A%2F%2Fuat.api.youaiyihu.com%2Fwechat%2Fnotify&response_type=code&scope=snsapi_base&state=STATE&connect_redirect=1#wechat_redirect';
            $.ajax({
                type: 'GET',
                url: notifyUrl,
                data: {},
                dataType: 'json',
                timeout: 3000,
                success: function(data){
                    if(data){
                        $.ajax({
                            type: 'PUT',
                            url: orderUrls,
                            data: {'action':'payment', 'pay_way':payWay, 'openId':data},
                            dataType: 'json',
                            timeout: 3000,
                            success: function(data){
                                if(data.code ==200){
                                    self.location=document.referrer;
                                }
                            },
                            error: function(xhr, type){
                                alert('网络超时!')
                            }
                        })
                    }
                },
                error: function(xhr, type){
                    alert('网络超时!')
                }
            })
        }
    }else if(payWay == '2'){
        alert('暂时没有支付宝支付');
        return;
    }else{
        $.ajax({
            type: 'PUT',
            url: orderUrls,
            data: {'action':'payment','pay_way':payWay},
            dataType: 'json',
            timeout: 3000,
            success: function(data){
                if(data.code ==200){
                    self.location=document.referrer;
                }
            },
            error: function(xhr, type){
                alert('网络超时!')
            }
        })
    }
});
if(wei)
    alipay.attr('style','display:none');
else
    wechat.attr('style','display:none');
function isWeiXn(){
    var ua = navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i)=="micromessenger")
        return true;
    else
        return false;
}