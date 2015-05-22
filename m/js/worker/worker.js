function getUrlQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}
//alert(ages("1963-08-14"));
function ages(str)
{
    var   r   =   str.match(/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/);
    if(r==null)return   false;
    var   d=new Date(r[1],r[3]-1, r[4]);
    if (d.getFullYear()==r[1]&&(d.getMonth()+1)==r[3]&&d.getDate()==r[4])
    {
        var   y=new Date().getFullYear();
        var years =y-r[1];
        if(years<1)
            years = 1;
        return years;
    }
    return(false);
}

//护理员等级
var worker_levels = new Array();
getConfigs(function(configs) {
    worker_levels=configs.worker_levels;
});
function get_workelist() {
    /*
    getConfigs(function(configs) {
        worker_levels=configs.worker_levels;
    });
    */
    var start_time = getUrlQueryString("start_time");
    var hospital_id = getUrlQueryString("hospital_id");
    var department_id = getUrlQueryString("department_id");
    var workerNewUrl=workerUrl+"?start_time="+start_time+"&hospital_id="+hospital_id+"&department_id="+department_id
    $.getJSON(workerNewUrl, function (response) {

        if (response.code == 200) {
            template.helper('dateFormat', function (n) {
                return ages(n);
            });
            template.helper('worker_levels', function (n) {
                return worker_levels[n-1].name;
            });
            template.helper('worker_star', function (n) {
               // return worker_levels[level-1].name;
                var str="";
                for(var i=0;i<n;i++){
                    str=str+"★";
                }
                return str;
            });
            var bodyHtml = template('bodyTemplate', response);
            $('#body').html(bodyHtml);
        }
    });

}

function get_workedetail() {
    var worker_id = getUrlQueryString("worker_id");
    var workeDetailUrl=workerUrl+"/"+worker_id;
    $.getJSON(workeDetailUrl, function (response) {
        if (response.code == 200) {
            template.helper('dateFormat', function (str) {
                return ages(str);
            });
            var bodyHtml = template('bodyTemplate', response);
            $('#nurses_detail').html(bodyHtml);
            $('#price').html(parseInt(response.data.price));

        }
    });
}