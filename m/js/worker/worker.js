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
        return y-r[1];
    }
    return(false);
}
//护工等级
var worker_levels = new Array();
function get_workelist() {
    $.getJSON(configUrl, function (response) {
        if (response.code == 200) {
            //alert(response.data.worker_levels[0].name);
            worker_levels=response.data.worker_levels;
        };
    });
    $.getJSON(workerUrl, function (response) {
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
    //alert(workeDetailUrl);
    $.getJSON(workeDetailUrl, function (response) {
        if (response.code == 200) {
            template.helper('dateFormat', function (str) {
                return ages(str);
            });
            var bodyHtml = template('bodyTemplate', response);
            $('#nurses_detail').html(bodyHtml);

            $('#price').html(response.data.price);

        }
    });
}