$('.menuitemradio input[type="radio"]').on('click', function () {
    [].forEach.call(this.form.elements[this.name], function (radio) {
        $(radio).parent()[radio === this ? 'addClass' : 'removeClass']('menuitemradio-checked');
    }, this);
});

//$.get('/whatevs.html', function(response){
//    $(document.body).append(response)
//})


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