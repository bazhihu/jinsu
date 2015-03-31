//更新订单
$('body').on('click', 'button.jsUpdateOrder', function () {
    var url = $(this).attr('data-url');
    location.href=url;
});

//支付
$('body').on('click', 'button.jsPayOrder', function () {
    if(!confirm('确认执行此操作吗？')){
        return false;
    }
    var button = $(this);
    button.text('处理中...');
    button.attr('disabled', true);
    var url = $(this).attr('data-url');
    $.ajax({
        type: "POST",
        dataType: "json",
        async:false,
        cache:false,
        timeout:30000,
        url: url,
        success: function(json){
            alert(json.msg);
            if(json.code == '200'){
                location.reload();
            }else{
                button.attr('disabled', false);
                button.text('支付');
            }
        }
    });
});

//确认订单
$('body').on('click', 'button.jsConfirmOrder', function () {
    if(!confirm('确认执行此操作吗？')){
        return false;
    }
    var button = $(this);
    button.text('处理中...');
    button.attr('disabled', true);
    var url = $(this).attr('data-url');
    var selectWorkerUrl = $(this).attr('select-worker-url');
    $.ajax({
        type: "POST",
        dataType: "json",
        async:false,
        cache:false,
        timeout:30000,
        url: url,
        //data: "name=John&location=Boston",
        success: function(json){
            alert(json.msg);
            if(json.code == '200'){
                location.reload();
            }else if(json.code == '202'){
                //选护工
                location.href = selectWorkerUrl;
            }else{
                button.attr('disabled', false);
                button.text('确认');
            }
        }
    });
});

//开始服务
$('body').on('click', 'button.jsBeginServiceOrder', function () {
    if(!confirm('确认执行此操作吗？')){
        return false;
    }
    var button = $(this);
    button.text('处理中...');
    button.attr('disabled', true);
    var url = $(this).attr('data-url');
    $.ajax({
        type: "POST",
        dataType: "json",
        async:false,
        cache:false,
        timeout:30000,
        url: url,
        success: function(json){
            alert(json.msg);
            if(json.code == '200'){
                location.reload();
            }else{
                button.attr('disabled', false);
                button.text('开始服务');
            }
        }
    });
});

//完成订单
$('body').on('click', 'button.jsFinishOrder', function () {
    if(!confirm('确认执行此操作吗？')){
        return false;
    }
    var button = $(this);
    button.text('处理中...');
    button.attr('disabled', true);
    var url = $(this).attr('data-url');
    var selectWorkerUrl = $(this).attr('select-worker-url');
    $.ajax({
        type: "POST",
        dataType: "json",
        async:false,
        cache:false,
        timeout:30000,
        url: url,
        success: function(json){
            alert(json.msg);
            if(json.code == '200'){
                location.reload();
            }else{
                button.attr('disabled', false);
                button.text('完成');
            }
        }
    });
});

//取消订单
$('body').on('click', 'button.jsCancelOrder', function () {
    if(!confirm('确认执行此操作吗？')){
        return false;
    }
    var button = $(this);
    button.text('处理中...');
    button.attr('disabled', true);
    var url = $(this).attr('data-url');
    $.ajax({
        type: "POST",
        dataType: "json",
        async:false,
        cache:false,
        timeout:30000,
        url: url,
        success: function(json){
            alert(json.msg);
            if(json.code == '200'){
                location.reload();
            }else{
                button.attr('disabled', false);
                button.text('取消');
            }
        }
    });
});
//续单
$('body').on('click', 'button.jsContinueOrder', function () {
    var button = $(this);
    button.text('处理中...');
    button.attr('disabled', true);
    var url = $(this).attr('data-url');
    location.href=url;

});
//外呼
$('body').on('click','button.jsUser',function(){
    var button = $(this);
    var callid = $(this).attr('callid');
    try{window.navigate("app:1234567@"+callid+""); } catch(e){};
});
$('body').on('click','button.jsBan',function(){
    var button = $(this);
    var callid = $(this).attr('callid');
    try{window.navigate("app:1234567@"+callid+""); } catch(e){};
});

