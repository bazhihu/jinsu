//更新订单
$('body').on('click', 'button.jsUpdateOrder', function () {
    var url = $(this).attr('data-url');
    location.href=url;
});

//支付
