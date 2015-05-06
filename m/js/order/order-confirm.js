var data = {
    'start_time': '2015-04-28',
    'end_time': '2015-05-28',
    'days':'30',
    'hospital_id':'1',
    'patient-status':'2'
};
var bodyHtml = template('bodyTemplate', data);
$('#body').html(bodyHtml);

//获取余额
var userInfo = getStatus(),
    orderCreate = orderUrl+'?access-token='+userInfo.token;
    balanceUrl = userUrl+'/'+userInfo.id+'?access-token='+userInfo.token;
$.get(balanceUrl,function(response){
    if(response.code == 200){
        console.log(response.data.wallet.money);
        console.log($('#money').html());
        $('#money').html(response.data.wallet.money);
    }
})

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