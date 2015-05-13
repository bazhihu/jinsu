/**
 * Created by HZQ on 2015/4/27.
 */
var user = getStatus(),
    logged = $('.intro'),
    unsigned = $('.unsign'),
    name = $('.name'),
    quit = $('.quit');console.log(user.token);

if(user.id && user.name && user.token){
    logged.attr('style', null);
    getUsers(user.id, user.token, function(back){
        if(back){console.log(back);
            back.mobile = back.mobile.substr(0,3)+'****'+back.mobile.substr(7,4);
            document.getElementById('name').innerHTML=back.mobile;
            if(back.order.in_service>0){
                $('.badge').attr('style',null);
                $('.badge').html(back.order.in_service);
            }
        }
    });
}else{
    unsigned.attr('style', null);
}
quit.on(CLICK, function(){
    delCookie(TOKEN);
    delCookie(NAME);
    delCookie(ID);
    location.reload();
});