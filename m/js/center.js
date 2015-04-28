/**
 * Created by HZQ on 2015/4/27.
 */
var user = getStatus(),
    logged = $('.account-intro'),
    unsigned = $('.unsignedin'),
    name = $('.name');
if(user){
    logged.attr('style', null);
    getUsers(user.id, user.token, function(back){
        if(back){
            //console.log(back);
            document.getElementById('name').innerHTML=back.mobile;
            if(back.order.in_service){
                $('.badge').attr('style',null);
                $('.badge').innerHTML=back.order.in_service;
            }
        }
    });
}else{
    unsigned.attr('style', null);
}
