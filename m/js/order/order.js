;(function($){
    $.getJSON('//sit.api.youaiyihu.com', function(data){
        var html = template('test', data);
        document.getElementById('content').innerHTML = html;
    })
})(Zepto);