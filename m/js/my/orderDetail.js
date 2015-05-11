loggedIn();
var order_no = getUrlQueryString('order_no'),
    access_token = getStatus(),
    getOrderUrl = orderUrl+"/"+order_no+'?access-token='+access_token.token,
    cancel = $('.cancel'),
    pay = $('.pay'),
    evaluate = $('.evaluate');
    evaluateUrl = orderUrl+'',
    toggle = $('.toggle');
//订单记录隐藏
toggle.live(CLICK, function(){
    $(this).toggleClass('toggle-expanded');
    $('#history').toggleClass('expanded');
});
function map(data ,key, val){
    var len = data.length,
        map = new Array();
    for(var i=0;i<len;i++){
        map[data[i][key]] = data[i][val];
    }
    return map;
}
$.getJSON(getOrderUrl,function(response){
    if(response.code == 200){
        var digital =  response.data;
        getConfigs(function(configs) {
            var hospitals = map(configs.hospitals, 'id', 'name'),
                sections = map(configs.departments, 'id', 'name'),
                worker_levels = map(configs.worker_levels, 'id', 'name'),
                patient_state = map(configs.patient_states, 'id', 'name'),
                hospitals_name = hospitals[digital.hospital_id],
                sections_name = sections[digital.department_id];

            digital.hospitals_name = hospitals_name+'/'+sections_name;
            digital.worker_levels_name = worker_levels[digital.worker_level];
            digital.patient_states_name = patient_state[digital.patient_state];

            //假期
            var holidays_lenth =configs.holidays.length,
                holidays_data  = configs.holidays,
                has_holidays='',
                has_holidays_num = 0;
            for(var k=0;k<holidays_lenth;k++){
                var holidays = holidays_data[k],
                    start_time = digital.start_time.substr(0,10),
                    end_time =  digital.end_time.substr(0,10);

                if(holidays>=start_time && holidays<=end_time){
                    if(has_holidays)
                        has_holidays= has_holidays+"、"+holidays.substr(5,5);
                    else
                        has_holidays= holidays.substr(5,5);
                    has_holidays_num++
                }
            }
            digital.has_holidays = has_holidays;
            digital.has_holidays_num = has_holidays_num;
            digital.order_des = getStatusDes(digital);
            if(digital.start_time && digital.end_time)
                digital.days = getOrderCycle(digital.start_time,digital.end_time);

            //基础价格
            digital.base_price = parseInt(digital.base_price);

            var ready = 1;
            digital.record = "";
            if(digital.evaluate_time){
                if(ready){
                    ready = 0;
                    digital.record += '<li><span class="completed status">评价完成,订单结束</span>'+digital.evaluate_time+'</li>';
                }
            }
            if(digital.reality_end_time && (digital.order_status=='wait_service')){
                if(ready){
                    ready = 0;
                    digital.record += '<li><span class="completed status">服务结束,等待评价</span>'+digital.reality_end_time+'</li>';
                }else
                    digital.record += '<li><span class="status">服务结束,等待评价</span>'+digital.reality_end_time+'</li>';
            }
            if(digital.begin_service_time){
                if(ready){
                    ready = 0;
                    digital.record += '<li><span class="completed status">服务开始</span>'+digital.begin_service_time+'</li>';
                }else
                    digital.record += '<li><span class="status">服务开始</span>'+digital.begin_service_time+'</li>';
            }
            if(digital.pay_time){
                if(ready){
                    ready = 0;
                    digital.record += '<li><span class="completed status">支付成功,等待服务</span>'+digital.pay_time+'</li>';
                }else{
                    digital.record += '<li><span class="status">支付成功,等待服务</span>'+digital.pay_time+'</li>';
                }
            }
            if(digital.cancel_time){
                if(ready){
                    ready = 0;
                    digital.record += '<li><span class="completed status">订单取消</span>'+digital.cancel_time+'</li>';
                }else
                    digital.record += '<li><span class="status">订单取消</span>'+digital.cancel_time+'</li>';
            }
            if(digital.create_time){
                if(ready)
                    digital.record += '<li><span class="completed status">下单成功,等待支付</span>'+digital.create_time+'</li>';
                else
                    digital.record += '<li><span class="status">下单成功,等待支付</span>'+digital.create_time+'</li>';
            }
            var bodyHtml = template('bodyTemplate', response);
            $('#body').html(bodyHtml);
        });
    }
});

function getStatusDes(order) {
    var time = new Date();
    time = time.format("yyyy-MM-dd");
    if (order.order_status=='wait_pay') {
        if(order.pay_way == 1){
            return "已提交现金支付申请，请等待工作人员上门收款或改用其他支付方式";
        }else{
            return "订单未支付,请尽快完成支付";
        }
    } else if ((order.order_status=='wait_confirm') || (order.order_status=='wait_service')) {
        var days = getOrderCycle(time,order.start_time);
        if (days > 0) {
            return "护工将在" + days + "天后提供服务";
        } else if (days == 0) {
            return "护工将在今天提供服务";
        } else {
            return "服务即将开始";
        }
    } else if (order.order_status=='in_service') {
        var days = getOrderCycle(time,order.reality_end_time);
        if (days > 0) {
            return "服务将在" + days + "天后结束";
        } else if (days == 0) {
            return "服务将在今天结束,若要续单请联系客服";
        } else {
            return "服务即将结束,若要续单请联系客服";
        }
    } else if (order.order_status=='end_service') {
        return "服务已完成，感谢您的信任";
    } else if (order.order_status=='end_evaluate') {
        return "服务已完成，感谢您的信任";
    } else if (order.order_status=='cancel') {
        return "该订单已被取消";
    } else if (order.order_status=='wait_evaluate') {
        return "服务已完成，请对服务做出评价";
    } else {
        return "订单正在处理中";
    }
}
cancel.live('click', function(){
    var isGo = confirm("您真的确定取消订单吗？取消后订单将无法恢复。");
    if(!isGo){
        return false;
    }
    var it = $(this),
        no = it.attr('data-no'),
        cancelUrl =url+'v1/orders/'+no+'?access-token='+access_token.token;
    $.ajax({
        data: {'action':'cancel'} ,
        type: "PUT",
        dataType: "json",
        url: cancelUrl,
        async:false,
        cache:false,
        crossDomain:true,
        timeout:30000,
        success: function(data){
            console.log(data);
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('网络超时!')
        }
    })
});
pay.live(CLICK, function(){

    location.href = '/my/payments.html';
});
evaluate.live(CLICK, function(){
    var it = $(this),
        no = it.attr('data-no'),
        pic = it.attr('data-pic'),
        name = it.attr('data-name');
    if(no && pic && name){
        location.href = '/my/review.html?no='+no+'&pic='+pic+'&name='+encodeURI(encodeURI(name));
    }
});
