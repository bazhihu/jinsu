var order_no = getUrlQueryString('order_no'),
    access_token = getStatus(),
    url = orderUrl+"/"+order_no+'?access-token='+access_token.token;

//$.getJSON(configUrl,function(response){
//    if(response.code == 200){
//        console.log(response.data.hospitals[2]);
//
//        var lenth =response.data.hospitals.length;
//        console.log(lenth)
//        for(var i =0;i<=lenth-1;i++){
//            var worker_level = backData['items'][i]['worker_level'];
//            if(backData['items'][i]['start_time'] && backData['items'][i]['end_time']){
//                backData['items'][i]['days'] = getOrderCycle(backData['items'][i]['start_time'],backData['items'][i]['end_time']);
//            }
//            else
//                backData['items'][i]['days']  ='';
//        }
//    }
//})



$.getJSON(url,function(response){
    if(response.code == 200){ console.log(response)
        var hospital_id =  response.data.hospital_id;
        var worker_level =  response.data.worker_level;
        var patient_state =  response.data.patient_state;
        getConfigs(function(configs) {
            //常驻医院
            var lenth =configs.hospitals.length;
            var data  = configs.hospitals;
            var hospitals_array = new Array();
            for(var i =0;i<=lenth-1;i++){
                var id = data[i]['id'];
                hospitals_array[id] = data[i]['name'];
            }
            response.data.hospitals_name = hospitals_array[hospital_id]

            //护工级别
            var worker_levels_lenth =configs.worker_levels.length;
            var worker_levels_data  = configs.worker_levels;
            var worker_levels_array = new Array();
            for(var j =0;j<=worker_levels_lenth-1;j++){
                var id = data[j]['id'];
                worker_levels_array[id] = worker_levels_data[j]['name'];
            }
            response.data.worker_levels_name = worker_levels_array[worker_level]

            //病患状态
            var patient_states_lenth =configs.patient_states.length;
            var patient_states_data  = configs.patient_states;
            var patient_states_array = new Array();
            for(var h =0;h<=patient_states_lenth-1;h++){
                var id = data[h]['id'];
                patient_states_array[id] = patient_states_data[h]['name'];
            }
            response.data.patient_states_name = patient_states_array[patient_state]

            //假期
            var holidays_lenth =configs.holidays.length;
            var holidays_data  = configs.holidays;
            var has_holidays='';
            var has_holidays_num = 0;

            for(var k=0;k<=holidays_lenth-1;k++){
                var holidays = holidays_data[k];
                var start_time = response.data.start_time;
                var end_time =  response.data.end_time;
                start_time = start_time.substr(0,10);
                end_time = end_time.substr(0,10);

                if(holidays>=start_time && holidays<=end_time){
                    if(has_holidays)
                        has_holidays= has_holidays+"、"+holidays.substr(5,5);
                    else{
                        has_holidays= holidays.substr(5,5);
                    }
                    has_holidays_num++
                }
                response.data.has_holidays = has_holidays;
                response.data.has_holidays_num = has_holidays_num;
            }

        });

        response.data.order_des = getStatusDes(response.data);
        if(response.data.start_time && response.data.end_time)
            response.data.days = getOrderCycle(response.data.start_time,response.data.end_time);

        var bodyHtml = template('bodyTemplate', response);
        $('#body').html(bodyHtml);
    }
})

function getStatusDes(order) {
    var time = new Date();
    var time = time.format("yyyy-MM-dd");

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
        return "服务已完成，请对服务做出评价";
    } else if (order.order_status=='end_evaluate') {
        return "服务已完成，感谢您的信任";
    } else if (order.order_status=='cancel') {
        return "该订单已被取消";
    } else {
        return "订单正在处理中";
    }
}


/**
 * 时间差days
 * @param startTime
 * @param endTime
 * @returns {number}
 */
function getOrderCycle(startTime,endTime){
    var year1 =  startTime.substr(0,4);
    var year2 =  endTime.substr(0,4);
    var month1 = startTime.substr(5,2);
    var month2 = endTime.substr(5,2);
    var day1 = startTime.substr(8,2);
    var day2 = endTime.substr(8,2);
    var date1=new Date(year1,month1,day1);    //开始时间
    var date2=new Date(year2,month2,day2);    //结束时间
    var date3=date2.getTime()-date1.getTime()  //时间差的毫秒数
    var days=Math.floor(date3/(24*3600*1000));
    return days;
}
