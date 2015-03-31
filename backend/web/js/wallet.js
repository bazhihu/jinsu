//申请同意
$('body').on('click', 'button.jsapplypass', function () {
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
//申请拒绝
$('body').on('click', 'button.jsapplynix', function () {
    if(!confirm('确认执行此操作吗？')){
        return false;
    }
    var button = $(this);
    var id = button.parent().parent().attr('data-key'),
        todo = 0;//拒绝
    var url = $(this).attr('data-url');
    $.ajax({
        type    : "POST",
        dataType: "json",
        async   :false,
        cache   :false,
        timeout :30000,
        url     : url,
        data    : {'id':id ,'todo':todo},
        success: function(json){
            if(json.code == '200'){
                button.parent().prev().html('已拒绝');
                button.parent().empty();
            }else{
                alert(json.msg);
            }
        }
    });
});
//申请拒绝
$('body').on('click', 'button.jspay', function () {
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
//充值
$('body').on('click', 'button.recharge', function () {

    var value = $('#recharge-money').val(),
        name = $('#recharge-uid').val();

    if(!confirm('确认给用户'+name+'：充值'+value+'人民币？')){
        return false;
    }
});
