var access_token = getStatus(),
    url = orderUrl+'?access-token='+access_token.token;
    //url = orderUrl+'/'+access_token.id+'?access-token='+access_token.token;
console.log(url);
$.getJSON(url,function(response){
    if(response.code == 200){console.log(response);
        var backData = response.data;
        var lenth =backData['items'].length;
        for(var i =0;i<=lenth-1;i++){
            var worker_level = backData['items'][i]['worker_level'];
            if(backData['items'][i]['start_time'] && backData['items'][i]['end_time']){
                backData['items'][i]['days'] = getOrderCycle(backData['items'][i]['start_time'],backData['items'][i]['end_time']);
            }
            else
                backData['items'][i]['days']  ='';
        }
        var bodyHtml = template('bodyTemplate', backData);
        $('#body').html(bodyHtml);
    }
})