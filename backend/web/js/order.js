//更新订单
$('body').on('click', 'button.jsUpdateOrder', function () {
    var url = $(this).attr('data-url');
    location.href=url;
});

//支付
$('body').on('click', 'button.jsPayOrder', function () {
    var button = $(this);
    button.attr('disabled', true);
    var url = $(this).attr('data-url');
    $.ajax({
        type: "POST",
        dataType: "json",
        async:false,
        cache:false,
        timeout:30000,
        url: url,
        data: "name=bobo",
        success: function(json){
            alert(json.msg);
            if(json.code == '200'){
                location.reload();
            }else{
                button.attr('disabled', false);
            }
        }
    });
});

//确认订单
$('body').on('click', 'button.jsConfirmOrder', function () {
    var button = $(this);
    button.attr('disabled', true);
    var url = $(this).attr('data-url');
    var selectWorkerUrl = $(this).attr('select-worker-url');
    $.ajax({
        type: "POST",
        dataType: "json",
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
            }
        }
    });
});