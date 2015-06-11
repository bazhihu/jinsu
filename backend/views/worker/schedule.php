<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/6/8
 * Time: 12:20
 */
use yii\helpers\Html;
$this->title = '护工排期';

?>
<link rel="stylesheet" href="/js/jquery-ui/jquery-ui.min.css">
<script type="text/javascript" src="/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui/datepicker-zh-TW.js"></script>
<div class="worker-schedule">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div id="schedule"></div>
</div>
<style>
    body{line-height: 5}
    .ui-datepicker {
        display: none;
        padding: 0.2em 0.2em 0;
        width: 1024px;
    }
    .ui-datepicker table {
        border-collapse: collapse;
        font-size: 1em;
    }
    .ui-state-highlight-leave{
        padding:2px;
        background: #ff0000;
        color: #fff;
    }

</style>
<script type="text/javascript">
    Date.prototype.Format = function (fmt) { //author: meizz
        var o = {
            "M+": this.getMonth() + 1, //月份
            "d+": this.getDate(), //日
            "h+": this.getHours(), //小时
            "m+": this.getMinutes(), //分
            "s+": this.getSeconds(), //秒
            "q+": Math.floor((this.getMonth() + 3) / 3), //季度
            "S": this.getMilliseconds() //毫秒
        };
        if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    }

    var leave = ['2015-06-01','2015-06-02','2015-06-03'];
    $("#schedule").datepicker({
        beforeShowDay: function(date) {
           // console.log(date);
            var d = date.Format("yyyy-MM-dd");
            console.log(d);
            if($.inArray(d, leave) >= 0){
                return [false, 'ui-state-highlight-leave','请假'];
            }
            return [true, '', ''];
        }
    });


</script>