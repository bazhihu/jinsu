/**
 * Created by HZQ on 2015/5/5.
 */
var url = location.search,
    Request = new Object();
if(url.indexOf("?")!=-1){
    var str = url.substr(1),
        strs = str.split('&');
    for(var i = 0;i<strs.length;i++){
        Request[strs[i].split('=')[0]] = unescape(strs[i].split("=")[1]);
    }
}
if(Request.detailMoney&&Request.detailType&&Request.detailTime&&Request.detailNo&&Request.wallet){
    document.getElementById('detailMoney').innerHTML = Request.detailMoney;
    if(Request.detailType == 1){
        document.getElementById('detailType').innerHTML = '支付护理服务费';
    }else if(Request.detailType == 2){
        document.getElementById('detailType').innerHTML = '充值';
    }else if(Request.detailType == 3){
        document.getElementById('detailType').innerHTML = '提现';
    }else if(Request.detailType == 4){
        document.getElementById('detailType').innerHTML = '退款';
    }
    document.getElementById('detailTime').innerHTML = Request.detailTime;
    document.getElementById('detailNo').innerHTML = Request.detailNo;
    document.getElementById('wallet').innerHTML = Request.wallet;
}else{
    location.href = '/my/myWallet.html';
}