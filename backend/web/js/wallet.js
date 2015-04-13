//申请同意
$('body').on('click', 'button.jsPass', function () {
    if(!confirm('确认执行此操作吗？')){
        return false;
    }
    var button = $(this);
    var id = button.parent().parent().attr('data-key'),
        todo = 1;//同意

    var url = $(this).attr('data-url');

    $.ajax({
        type    : "POST",
        dataType: "json",
        async   :false,
        cache   :false,
        timeout :30000,
        url     : url,
        data    : {'id':id,'todo':todo},
        error:function(jqXHR, textStatus, errorThrown){
            switch (jqXHR.status){
                case(500):
                    alert("服务器系统内部错误");
                    break;
                case(401):
                    alert("未登录");
                    break;
                case(403):
                    alert("无权限执行此操作");
                    break;
                case(408):
                    alert("请求超时");
                    break;
                default:
                    alert("未知错误");
            }
            button.attr('disabled', false);
            button.text('同意');
        },
        success: function(json){
            if(json.code == '200'){
                button.parent().prev().html('已同意');
                button.parent().empty();
            }else{
                alert(json.msg);
            }
        }
    });
});

$('body').on('click', 'button.myModal', function () {
    var myModal = $(this);

    var dataUrl = myModal.attr('data-url'),
        uid = myModal.parent().parent().attr('data-key');

    $('.refusal').val(uid);
    $('.refusal').attr('data-url',dataUrl);
});

//申请拒绝
$('body').on('click', 'button.jsNix', function () {

    var id = $('.refusal').val(),
        todo = 0;//拒绝
    var url = $('.refusal').attr('data-url'),
        reason = $('.rejectReason').val();
    $.ajax({
        type    : "POST",
        dataType: "json",
        async   :false,
        cache   :false,
        timeout :30000,
        url     : url,
        data    : {'id':id ,'todo':todo ,'reason':reason},
        error:function(jqXHR, textStatus, errorThrown){
            switch (jqXHR.status){
                case(500):
                    alert("服务器系统内部错误");
                    break;
                case(401):
                    alert("未登录");
                    break;
                case(403):
                    alert("无权限执行此操作");
                    break;
                case(408):
                    alert("请求超时");
                    break;
                default:
                    alert("未知错误");
            }
            button.attr('disabled', false);
            button.text('拒绝');
        },
        success: function(json){
            if(json.code == '200'){
                location.reload();
            }else{
                alert(json.msg);
            }
        }
    });
});
//提现支付
$('body').on('click', 'button.jsPay', function () {
    if(!confirm('确认执行此操作吗？')){
        return false;
    }
    var button = $(this);
    var id = button.parent().parent().attr('data-key');

    var url = $(this).attr('data-url');
    $.ajax({
        type    : "POST",
        dataType: "json",
        async   :false,
        cache   :false,
        timeout :30000,
        url     : url,
        data    : {'id':id },
        error:function(jqXHR, textStatus, errorThrown){
            switch (jqXHR.status){
                case(500):
                    alert("服务器系统内部错误");
                    break;
                case(401):
                    alert("未登录");
                    break;
                case(403):
                    alert("无权限执行此操作");
                    break;
                case(408):
                    alert("请求超时");
                    break;
                default:
                    alert("未知错误");
            }
            button.attr('disabled', false);
            button.text('支付');
        },
        success: function(json){
            if(json.code == '200'){
                button.parent().prev().html('已付款');
                button.parent().empty();
            }else{
                alert(json.msg);
            }
        }
    });
});
