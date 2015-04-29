var access_token = getStatus(),
    url = orderUrl+'?access-token='+access_token.token;

$('.menuitemradio input[type="radio"]').on('click', function () {
    [].forEach.call(this.form.elements[this.name], function (radio) {
        $(radio).parent()[radio === this ? 'addClass' : 'removeClass']('menuitemradio-checked');
    }, this);
});

$.get('/whatevs.html', function(response){
    $(document.body).append(response)
})


$('#confirm').on(CLICK, function(e){
    var start_time = $('#start_time').val();
    var end_time = $('#end_time').val();
    var hospital_id = $('#hospital_id').val();
    var department_id = $('#department_id').val();
    var patient_state = $('#patient_state').val();
    var worker_level = $('#worker_level').val();
    console.log(start_time);
    var param = {
        start_time:start_time,
        end_time:end_time,
        hospital_id:hospital_id,
        department_id:department_id,
        patient_state:patient_state,
        worker_level:worker_level
    };
    $.post(url,param,function(response){
        console.log(param);
        if(response.code == 200){
            console.log('ok');
        }
    });
})