/**
 * Created by HZQ on 2015/5/8.
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
Request.name = decodeURI(Request.name);
if(Request.no && Request.pic && Request.name){
    $('.nurses-photo').attr('style','background-image:url('+Request.pic+')');
    $('.nurses-name').html(Request.name);
    $('#orderNo').val(Request.no);
}
$('#comment').on(CLICK, function(e){
    var star,
        content = $('textarea').val(),
        orderNo = $('#orderNo').val(),
        user = getStatus();
    $('.rate').each(function(index){
        var it = $(this);
        if(it.hasClass('rated')){
            star = it.attr('data-value');
        }
    });
    if(star && orderNo && user.id && user.token){
        var url = commentUrl+'?access-token='+user.token;
        $.post(url, { star: star, content: content, order_no: orderNo, uid: user.id}, function(response){
            if(response.code == 200){
                location.href = '/my/orderDetail.html?order_no='+orderNo;
            }else{

            }
        })
    }
});