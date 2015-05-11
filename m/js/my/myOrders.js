loggedIn();
var access_token = getStatus(),
    url = orderUrl+'?access-token='+access_token.token,
    item = $('.menu');
$.getJSON(url,function(response){
    if(response.code == 200){
        var backData = response.data,
            lenth =backData['items'].length,
            msg = new Array();
        for(var i =0;i<=lenth-1;i++){
            var item = new Array(),
                value = backData['items'][i];
            if(value['start_time'] && value['end_time']){
                value['days'] = getOrderCycle(value['start_time'], value['end_time']);
            }
            else
                value['days']  ='';
            if(value['order_status'] == 'wait_pay'){
                value['order_status'] = '待支付';
                value['div_status'] = 'status-unpaid';
            }else if(value['order_status'] == 'wait_confirm'){
                value['order_status'] = '待服务';
                value['div_status'] = 'status-not-start';
            }else if(value['order_status'] == 'wait_service'){
                value['order_status'] = '待服务';
                value['div_status'] = 'status-not-start';
            }else if(value['order_status'] == 'in_service'){
                value['order_status'] = '服务中';
                value['div_status'] = 'status-being-services';
            }else if(value['order_status'] == 'end_service'){
                value['order_status'] = '结束服务';
                value['div_status'] = 'status-wait-review';
            }else if(value['order_status'] == 'cancel'){
                value['order_status'] = '取消订单';
                value['div_status'] = 'status-cancel';
            }else if(value['order_status'] == 'end_evaluate'){
                value['order_status'] = '结束评价';
                value['div_status'] = 'status-completed';
            }else if(value['order_status'] == 'wait_evaluate'){
                value['order_status'] = '待评价';
                value['div_status'] = 'status-wait-review';
            }
        }
        console.log(backData)
        var bodyHtml = template('bodyTemplate', backData);
        $('#body').html(bodyHtml);
    }
});
item.live(CLICK, function(e){
    var it = $(this),
        url = it.attr('data-url');
    if(url){
        location.href = url;
    }
});