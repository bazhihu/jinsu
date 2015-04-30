/*;(function($){
    $.getJSON(orderUrl, function(back_data){
        var body_html = template('body_template', back_data);
        $('#body').html(body_html);
    })
})(Zepto);*/
var user = getStatus(),
    notLogin = $('.notLogin'),
    hasLogin = $('.hasLogin');
if(user){
    hasLogin.attr('style',null);
    getUsers(user.id, user.token, function(back){
        if(back){
            document.getElementById('contact').innerHTML=back.mobile;
        }
    });
}else{
    notLogin.attr('style',null);
}