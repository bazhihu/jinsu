var userInfo = getStatus(),
    orderCreate = orderUrl+'?access-token='+userInfo.token;
console.log(userInfo);

var data = {mobile:userInfo.name};
var bodyHtml = template('bodyTemplate', data);
$('#body').html(bodyHtml);

$('.care-level input[type="radio"]').on('click', function () {
    [].forEach.call(this.form.elements[this.name], function (radio) {
        $(radio).parent()[radio === this ? 'addClass' : 'removeClass']('checked');
    }, this);
});

$('#act').on(CLICK, function(e){
    console.log('1');
//            var mobile = $('#mobile').val();
//            var start_time = $('#start_time').val();
//            var end_time = $('#end_time').val();
//            var hospital_id = $('#hospital_id').val();
//            var department_id = $('#department_id').val();
//            var patient_state = $('#patient_state').val();
    $('#order-quick').hide();
    $("#order-confirm").show();

    //获取余额
    balanceUrl = userUrl+'/'+userInfo.id+'?access-token='+userInfo.token;
    $.get(balanceUrl,function(response){
        if(response.code == 200){
            console.log(response.data.wallet.money);
            console.log($('#money').html());
            $('#money').html(response.data.wallet.money);
        }
    })
})

$('#hospitals_load').load("hospitals.html");