var access_token = getStatus(),
    url = orderUrl+'?access-token='+access_token.token;

$.getJSON(url,function(response){
    if(response.code == 200){
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

/**
 * 时间差days
 * @param startTime
 * @param endTime
 * @returns {number}
 */
function getOrderCycle(startTime,endTime){
    var year1 =  startTime.substr(0,4);
    var year2 =  endTime.substr(0,4);
    var month1 = startTime.substr(5,2);
    var month2 = endTime.substr(5,2);
    var day1 = startTime.substr(8,2);
    var day2 = endTime.substr(8,2);
    var date1=new Date(year1,month1,day1);    //开始时间
    var date2=new Date(year2,month2,day2);    //结束时间
    var date3=date2.getTime()-date1.getTime()  //时间差的毫秒数
    var days=Math.floor(date3/(24*3600*1000));
    return days;
}
