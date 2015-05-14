var type = getUrlQueryString('type'),
    worker_no = getUrlQueryString('worker_no'),
    userInfo = getStatus(),
    orderCreate = orderUrl+'?access-token='+userInfo.token,
    userUrl = userUrl+'/'+userInfo.id+'?access-token='+userInfo.token;
getConfigs(function(configs) {
    //获取余额
    $.get(userUrl,function(response){
        if(response.code == 200){
            var blance= parseInt(response.data.wallet.money);
            var orderData = getCookie('orderData');
            var dataArray= orderData.split("#");
            var mobile = dataArray[0];
            var start_time = dataArray[1];
            var end_time = dataArray[2];
            var days = dataArray[3];
            var hospital_id = dataArray[4];
            var department_id = dataArray[5];
            var worker_level = dataArray[6];
            var patient_state= 1;

            //常驻医院
            var lenth =configs.hospitals.length;
            var data  = configs.hospitals;
            var hospitals_array = new Array();
            for(var i =0;i<=lenth-1;i++){
                var id = data[i]['id'];
                hospitals_array[id] = data[i]['name'];
            }
            var hospitals_name = hospitals_array[hospital_id];

            //常驻科室
            var departments_lenth =configs.departments.length;
            var departments_data  = configs.departments;
            var departments_array = new Array();
            for(var m =0;m<=departments_lenth-1;m++){
                var id = departments_data[m]['id'];
                departments_array[id] = departments_data[m]['name'];
            }
            var departments_name = departments_array[department_id];

            //护理员级别
            var worker_level_lenth =configs.worker_levels.length;
            var worker_level_data  = configs.worker_levels;
            var worker_level_array = new Array();
            var worker_level_prirce_array = new Array();

            for(var j =0;j<=worker_level_lenth-1;j++){
                var id = worker_level_data[j]['id'];
                worker_level_array[id] = worker_level_data[j]['name'];
                worker_level_prirce_array[id] = worker_level_data[j]['price'];
            }
            var worker_level_name = worker_level_array[worker_level];

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

            //挑选护理员
            if(type=='select'){
                $.get(workerUrl+"/"+worker_no,function(worker_back){
                    var price = parseInt(worker_back.data.price);
                    var worker_level = worker_back.data.level;

                    var worker_level_name = worker_level_array[worker_level];
                    var worker_name = worker_back.data.name;
                    var pic = worker_back.data.pic;

                    //实际支付
                    var true_pay = 0;
                    true_pay = price*days;
                    if(has_holidays)
                        true_pay = true_pay+price*has_holidays_num*2;
                    //if(patient_state==2)
                    //    true_pay = true_pay+(true_pay*patient_state_coefficient/100);

                    //还需支付
                    var need_pay = parseInt(true_pay-blance);
                    if(need_pay<0){
                        console.log(need_pay)
                        $("#pay_other").hide();
                    }
                    var data = {
                        'type':type,
                        'uid':userInfo.id,
                        'pic':pic,
                        'mobile':mobile,
                        'start_time': start_time,
                        'end_time': end_time,
                        'days':days,
                        'hospital_id':hospital_id,
                        'hospitals_name':hospitals_name,
                        'department_id':department_id,
                        'departments_name':departments_name,
                        'patient_state':1,
                        'patient_states_name':patient_states_name,
                        'worker_no':worker_no,
                        'worker_name':worker_name,
                        'worker_level':worker_level,
                        'worker_level_name':worker_level_name,
                        'has_holidays':has_holidays,
                        'has_holidays_num':has_holidays_num,
                        'price':price,
                        'patient_state_coefficient':patient_state_coefficient,
                        'true_pay':true_pay,
                        'blance':blance,
                        'need_pay':need_pay
                    };
                    var bodyHtml = template('bodyTemplate', data);
                    $('#body').html(bodyHtml);
                });
            }else{
                //快速下单
                //基础价格
                var price = parseInt(worker_level_prirce_array[worker_level]);

                //实际支付
                var true_pay = 0;
                true_pay = price*days;
                if(has_holidays)
                    true_pay = true_pay+price*has_holidays_num*2;
                //if(patient_state==2)
                //    true_pay = true_pay+(true_pay*patient_state_coefficient/100);

                //还需支付
                var need_pay = parseInt(true_pay-blance);
                if(need_pay<0){
                    $("#pay_other").hide();
                }

                var data = {
                    'type':type,
                    'uid':userInfo.id,
                    'mobile':mobile,
                    'start_time': start_time,
                    'end_time': end_time,
                    'days':days,
                    'hospital_id':hospital_id,
                    'hospitals_name':hospitals_name,
                    'department_id':department_id,
                    'departments_name':departments_name,
                    'patient_state':1,
                    'patient_states_name':patient_states_name,
                    'worker_no':worker_no,
                    'worker_level':worker_level,
                    'worker_level_name':worker_level_name,
                    'has_holidays':has_holidays,
                    'has_holidays_num':has_holidays_num,
                    'price':price,
                    'patient_state_coefficient':patient_state_coefficient,
                    'true_pay':true_pay,
                    'blance':blance,
                    'need_pay':need_pay
                };
                var bodyHtml = template('bodyTemplate', data);
                $('#body').html(bodyHtml);
            }

            //支付
            $("#pay").live('click', function () {
                var pay_way = $('input[name="pay_way"]:checked').val();
                var worker_level = $('#worker_level').val();
                var need_pay = $('#need_pay').val();
                if(need_pay<0){
                    var pay_way=1;
                    var url = "payOnline.html";
                }else{
                    if(pay_way==1) {
                        var url = "payOffline.html";
                    }else if(pay_way==2){
                        var url = "payOnline.html";
                    }else if(pay_way==3){
                        var url = "payOnline.html";
                    }
                }

                var post_data = {
                    'uid':userInfo.id,
                    'mobile':mobile,
                    'hospital_id':hospital_id,
                    'department_id':1,
                    'worker_level':worker_level,
                    'worker_no':worker_no,
                    'start_time': start_time,
                    'end_time': end_time,
                    'patient_state':1,
                    'pay_way':pay_way
                };

                $.post(orderCreate,post_data,function(response){
                    console.log(response.msg)
                    if(response.code == 200){
                        location.href=url;
                    }else if(response.code == 400){
                        alert('支付失败！');
                        location.href=url;
                    }else if(response.code == 500){
                        alert('支付失败！');
                        location.href=url;
                    }
                },"json");
            });
        }
    });
});

//选择支付方式
$('.menuitemradio input[type="radio"]').live('click', function () {
    [].forEach.call(this.form.elements[this.name], function (radio) {
        $(radio).parent()[radio === this ? 'addClass' : 'removeClass']('menuitemradio-checked');
    }, this);
});