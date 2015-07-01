var orderDate = getLocal(orderDate),
    date =  JSON.parse(orderDate),
    type = getUrlQueryString('type'),
    worker_no = date.workerId,
    userInfo = getStatus(),
    orderCreate = orderUrlV2+'?access-token='+userInfo.token,
    userUrl = userUrl+'/'+userInfo.id+'?access-token='+userInfo.token,
    careMsg = date.patient;
    //病患信息
    careInfo = JSON.parse(careMsg);

loggedIn();
if(!date || !careInfo){
    location.href = '/';
}

var walletMoney=0;
getConfigs(function(configs) {
    //获取余额
    $.get(userUrl,function(response){
        if(response.code == 200){
            var blance= parseInt(response.data.wallet.money),
                mobile =userInfo.name,
                start_time = date.startData,
                end_time = date.endData,
                hospital_id = date.serviceSite,
                department_id = date.disease,
                misc = date.misc,
                patient_state= 1;
            walletMoney=blance;

            //常驻医院
            var lenth = configs.hospitals.length;
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

            //病患状态
            var patient_states_lenth =1;


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

            $.get(workerUrl+"/"+worker_no,function(worker_back){
                var price = parseInt(worker_back.data.price);
                var worker_level = worker_back.data.level;

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
                    $("#pay_other").hide();
                }

                //是否在微信访问
                if(navigator.userAgent.toLowerCase().match(/MicroMessenger/i)=="micromessenger") {
                    var  wechat_acess = 1,
                        alipay_access = 0;
                }else{
                    var  wechat_acess = 0,
                        alipay_access = 1;
                }
                var startData = start_time.substr(5,2)+'月'+start_time.substr(8,2)+'日',
                    endData = end_time.substr(5,2)+'月'+end_time.substr(8,2)+'日',
                    time  = startData+'-'+endData,
                    locations = hospitals_name+'/'+departments_name;
                /*if(room != ''){
                    locations = hospitals_name+'/'+departments_name+'/'+room;
                }else{
                    locations = hospitals_name+'/'+departments_name;
                }*/
                var data = {
                    'type':type,
                    'uid':userInfo.id,
                    'pic':pic,
                    'mobile':mobile,
                    'careName':careInfo.name,
                    'careGender':careInfo.gender,
                    'careAge':careInfo.age,
                    'careHeight':careInfo.height,
                    'careWeight':careInfo.weight,
                    'time':time,
                    'start_time': start_time,
                    'end_time': end_time,
                    'days':days,
                    'locations':locations,//服务地点
                    //'room':room,
                    'remark':misc,
                    'hospital_id':hospital_id,
                    'hospitals_name':hospitals_name,
                    'department_id':department_id,
                    'departments_name':departments_name,
                    'patient_state':1,
                    'worker_no':worker_no,
                    'worker_name':worker_name,
                    'worker_level':worker_level,
                    'worker_level_name':worker_level_name,
                    'has_holidays':has_holidays,
                    'has_holidays_num':has_holidays_num,
                    'price':price,
                    'true_pay':true_pay,
                    'blance':blance,
                    'need_pay':need_pay,
                    'wechat_acess':wechat_acess,
                    'alipay_access':alipay_access
                };
                var bodyHtml = template('bodyTemplate', data);
                $('#body').html(bodyHtml);
            });

            //支付
            $("#pay").live('click', function () {
                var pay_way = $('input[name="pay_way"]:checked').val();
                var worker_level = $('#worker_level').val();
                var need_pay = $('#need_pay').val();

                var careName = $('input[name="careName"]').val();
                var careGender = $('input[name="careGender"]').val();
                var careAge = $('input[name="careAge"]').val();
                var careHeight = $('input[name="careHeight"]').val();
                var careWeight = $('input[name="careWeight"]').val();
                //var room = $('input[name="room"]').val();
                var remark = $('input[name="remark"]').val();
                var department_id = $('input[name="department_id"]').val();
                if(need_pay<0) {
                    var pay_way = 1;
                }

                //当面支付或者余额支付
                if(pay_way==1) {
                    var post_data = {
                        'uid':userInfo.id,
                        'mobile':mobile,
                        'hospital_id':hospital_id,
                        'department_id':department_id,
                        'worker_level':worker_level,//注视
                        'worker_no':worker_no,
                        'start_time': start_time,
                        'end_time': end_time,
                        'patient_state':1,
                        'pay_way':pay_way,

                        //add Huzq
                        'name':careName,
                        'gender':careGender,
                        'age':careAge,
                        'height':careHeight,
                        'weight':careWeight,
                        //'room_no':room,
                        'remark':remark
                    };

                    $.post(orderCreate,post_data,function(post_response){
                        if(post_response.code == 200){
                            if(need_pay<0) {
                                location.href= "../payOnline.html?order_no="+post_response.data.order.order_no;
                            }else{
                                location.href= "../payOffline.html?order_no="+post_response.data.order.order_no;
                            }
                        }else{
                            alert('支付失败！');
                        }
                    },"json");
                }else if(pay_way==2){
                    //支付宝支付
                    //var url = "../payOnline.html";
                    $.ajax({
                        type: 'POST',
                        url: orderCreate,
                        data:{
                            'uid':userInfo.id,
                            'mobile':mobile,
                            'hospital_id':hospital_id,
                            'department_id':department_id,
                            'worker_level':worker_level,
                            'worker_no':worker_no,
                            'start_time': start_time,
                            'end_time': end_time,
                            'patient_state':1,
                            'pay_way':pay_way,
                            'action':'payment',

                            //add Huzq
                            'name':careName,
                            'gender':careGender,
                            'age':careAge,
                            'height':careHeight,
                            'weight':careWeight,
                            //'room_no':room,
                            'remark':remark
                        },
                        dataType: 'json',
                        async:false,
                        cache:false,
                        crossDomain:true,
                        timeout:30000,
                        success: function(data){
                            if(data.code ==200){
                                self.location = '/wapalipay/alipayapi.php?orderNo='+data.data.payment.transaction_no+'&totalAmount='+data.data.order.total_amount+'&walletMoney='+walletMoney+'&nonce_str='+data.data.payment.nonce_str+'&gmt_create='+data.data.payment.gmtCreate;
                                //window.open('/wapalipay/alipayapi.php?orderNo='+data.data.payment.transaction_no+'&totalAmount='+data.data.order.total_amount+'&walletMoney='+walletMoney+'&nonce_str='+data.data.payment.nonce_str+'&gmt_create='+data.data.payment.gmtCreate,'_blank');
                            }
                        },
                        error: function(xhr, type){
                            alert('网络超时!')
                        }
                    })
                }else if(pay_way==3){
                    //微信支付
                    $.ajax({
                        type: 'POST',
                        url: orderCreate,
                        data:{
                            'uid':userInfo.id,
                            'mobile':mobile,
                            'hospital_id':hospital_id,
                            'department_id':department_id,
                            'worker_level':worker_level,
                            'worker_no':worker_no,
                            'start_time': start_time,
                            'end_time': end_time,
                            'patient_state':1,
                            'pay_way':pay_way,
                            'action':'payment',
                            'trade_type':'JSAPI',

                            //add Huzq
                            'name':careName,
                            'gender':careGender,
                            'age':careAge,
                            'height':careHeight,
                            'weight':careWeight,
                            //'room_no':room,
                            'remark':remark
                        },
                        dataType: 'json',
                        async:false,
                        cache:false,
                        crossDomain:true,
                        timeout:30000,
                        success: function(data){
                            if(data.code ==200){
                                self.location = '/my/wechat.php??orderNo='+data.data.payment.transaction_no+'&totalAmount='+data.data.order.total_amount+'&walletMoney='+walletMoney+'&nonce_str='+data.data.payment.nonce_str+'&gmt_create='+data.data.payment.gmtCreate;
                            }
                        },
                        error: function(xhr, type){
                            alert('网络超时!')
                        }
                    });
                }
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