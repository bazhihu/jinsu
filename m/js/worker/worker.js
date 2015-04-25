;(function($){
    $.getJSON('//sit.api.youaiyihu.com/v1/workers', function(back_data){
        var body_html = template('body_template', back_data);
        $('#body').html(body_html);
    })
})(Zepto);