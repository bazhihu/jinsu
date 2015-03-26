//更新订单
$('body').on('click', 'button.jsUpdateOrder', function () {
    var url = $(this).attr('data-url');
    location.href=url;
});

//支付
$('body').on('click', 'button.jsPayOrder', function () {
    var url = $(this).attr('data-url');
    $.ajax({
        type: "POST",
        url: url,
        //data: "name=John&location=Boston",
        success: function(msg){
            alert( "Data Saved: " + msg );
        }
    });
});