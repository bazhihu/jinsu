/**
 * Created by HZQ on 2015/5/5.
 */
var user = getStatus(),
    menu = $('.detail');
if(user.id && user.token){
    getWallets(user.id, user.token, function(d){
        var i = 0,
            len = d.length,
            msg = new Array();
        document.getElementById('walletMoney').innerHTML = '&yen;'+ d[0].wallet_money;
        for(i;i<len;i++){
            var val = d[i],
                item = new Array();
            if(val.detail_type == 1){
                item.push('支付护理服务费');
                item.push('expenditure');
                item.push('-'+val.detail_money);
            }else if(val.detail_type == 2){
                item.push('充值');
                item.push('income');
                item.push(val.detail_money);
            }else if(val.detail_type == 3){
                item.push('余额提现');
                item.push('expenditure');
                item.push('-'+val.detail_money);
            }else if(val.detail_type == 4){
                item.push('退款');
                item.push('income');
                item.push(val.detail_money);
            }
            item.push(val.detail_time);
            item.push(val.detail_no);
            item.push(val.wallet_money);
            item.push(val.detail_type);
            msg.push(item);
        }
        var data = {
            title: '钱包明细',
            isAdmin: true,
            list: msg
        };
        var html = template('myWallet', data);
        document.getElementById('content').innerHTML = html;
    })
}
menu.live(CLICK, function(e){
    var here = $(this),
    url = here.find('.toDetail').attr('url-data');
    location.href = url;
});