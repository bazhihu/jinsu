getConfigs(function(configs) {
    var mobile = getUrlQueryString('mobile');
    var start_time = getUrlQueryString('start');
    var end_time = getUrlQueryString('end');
    var days = getUrlQueryString('days');
    var hospital_id = getUrlQueryString('hospital_id');
    var patient_state= getUrlQueryString('patient-status');
    var worker_level = getUrlQueryString('care-level');

    //常驻医院
    console.log(configs)
    var lenth =configs.hospitals.length;
    var data  = configs.hospitals;
    var hospitals_array = new Array();
    for(var i =0;i<=lenth-1;i++){
        var id = data[i]['id'];
        hospitals_array[id] = data[i]['name'];
    }
    var hospitals_name = hospitals_array[hospital_id]

    //护工级别
    var worker_level_lenth =configs.worker_levels.length;
    var worker_level_data  = configs.worker_levels;
    var worker_level_array = new Array();
    var worker_level_prirce_array = new Array();
    for(var j =0;j<=worker_level_lenth-1;j++){
        var id = data[j]['id'];
        worker_level_array[id] = worker_level_data[j]['name'];
        worker_level_prirce_array[id] = worker_level_data[j]['price'];
    }

    var worker_level_name = worker_level_array[worker_level]
    //基础价格
    var price = parseInt(worker_level_prirce_array[worker_level]);

    //病患状态
    var patient_states_lenth =configs.patient_states.length;
    var patient_states_data  = configs.patient_states;
    var patient_states_array = new Array();
    var patient_states_price_array =  new Array();
    for(var h =0;h<=patient_states_lenth-1;h++){
        var id = data[h]['id'];
        patient_states_array[id] = patient_states_data[h]['name'];
        patient_states_price_array[id] = patient_states_data[h]['price'];
    }
    var patient_states_name = patient_states_array[patient_state];
    var patient_state_coefficient = patient_states_price_array[patient_state];

    //假期
    var holidays_lenth =configs.holidays.length;
    var holidays_data  = configs.holidays;
    var has_holidays='';
    var has_holidays_num = 0;

    for(var k=0;k<=holidays_lenth-1;k++){
        var holidays = holidays_data[k];
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
        var has_holidays = has_holidays;
        var has_holidays_num = has_holidays_num;

        if(start_time && end_time)
            var days = getOrderCycle(start_time,end_time);
    }

    //获取余额
    var userInfo = getStatus(),
        orderCreate = orderUrl+'?access-token='+userInfo.token;
    balanceUrl = userUrl+'/'+userInfo.id+'?access-token='+userInfo.token;
    $.get(balanceUrl,function(response){
        if(response.code == 200){
            $('#money').html('&yen;'+response.data.wallet.money);
        }
    })

    var data = {
        'mobile':mobile,
        'start_time': start_time,
        'end_time': end_time,
        'days':days,
        'hospital_id':hospital_id,
        'hospitals_name':hospitals_name,
        'patient_state':patient_state,
        'patient_states_name':patient_states_name,
        'worker_level':worker_level,
        'worker_level_name':worker_level_name,
        'has_holidays':has_holidays,
        'has_holidays_num':has_holidays_num,
        'price':price,
        'patient_state_coefficient':patient_state_coefficient
    };

    var bodyHtml = template('bodyTemplate', data);
    $('#body').html(bodyHtml);
});

$('#confirm').on(CLICK, function(e){
    var param = {
        uid:userInfo.id,
        mobile:userInfo.name,
        start_time:$('#start_time').val(),
        end_time:$('#end_time').val(),
        hospital_id:$('#hospital_id').val(),
        department_id:$('#department_id').val(),
        patient_state:$('#patient_state').val(),
        worker_level:$('#worker_level').val(),
        //pay_way:$('#pay_way').val()
        pay_way:1
    };
    console.log(userInfo);
    $.post(orderCreate,param,function(response){
        //console.log($('#pay_way').val());
        if(response.code == 200){
            console.log('ok');
        }
    });
})