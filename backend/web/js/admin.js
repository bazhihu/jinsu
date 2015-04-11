//关闭帐号
$('body').on('click', 'span.glyphicon-remove', function () {
    if(!confirm('确认执行此操作吗？')){
        return false;
    }
    var num = $(this);
    var key = num.parent().parent().parent().attr('data-key');
    var url = $(this).parent().attr('data-url');
    $.ajax({
        type    :'POST',
        cache   : false,
        url     : url,
        data    : {'id':key},
        dataType : 'json' ,
        success : function(response) {
            if(response.code=='200'){
                if(num.hasClass('glyphicon-remove'))
                {
                    num.parent().parent().parent().find('.glyphicon-ok').removeClass('glyphicon-ok').addClass('glyphicon-remove');
                    num.removeClass();
                    num.addClass('glyphicon col-md-offset-4 glyphicon-ok text-success');
                }
                else
                {
                    num.parent().parent().parent().find('.glyphicon-remove').removeClass('glyphicon-remove').addClass('glyphicon-ok');
                    num.removeClass('glyphicon-ok').addClass('glyphicon-remove');
                }
            }else{
                alert(response.message);
            }
        }
    });
    return false;
});
//恢复帐号
$('body').on('click', 'span.glyphicon-ok', function () {
    if(!confirm('确认执行此操作吗？')){
        return false;
    }
    var num = $(this);
    var key = num.parent().parent().parent().attr('data-key');
    var url = $(this).parent().attr('data-url');
    $.ajax({
        type    :'POST',
        cache   : false,
        url     : url,
        data    : {'id':key},
        dataType : 'json' ,
        success : function(response) {
            if(response.code == '200'){
                if(num.hasClass('glyphicon-ok'))
                {
                    num.parent().parent().parent().find('.glyphicon-remove').removeClass('glyphicon-remove').addClass('glyphicon-ok');
                    num.removeClass();
                    num.addClass('glyphicon col-md-offset-4 glyphicon-remove');
                }
                else
                {
                    num.parent().parent().parent().find('.glyphicon-ok').removeClass('glyphicon-ok').addClass('glyphicon-remove');
                    num.removeClass('glyphicon-remove').addClass('glyphicon-ok');
                }
            }else{
                alert(response.message);
            }
        }
    });
    return false;
});
//所属医院隐藏
$('body').on('change', 'select#adminuser-staff_role', function () {
    var role = $(this).val();
    if(role == '内勤人员'){
        $('.hospitals_hide').removeClass('hide');
    }else{
        $('.hospitals_hide').addClass('hide');
    }

});