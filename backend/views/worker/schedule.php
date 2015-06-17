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
<style>

    .schedule{
        height: 570px;
        width: 800px;
        line-height: 50px;
        float: left;
    }
    .ui-datepicker {
        display: none;
        padding: 0.2em 0.2em 0;
        width: 800px;
    }
    .ui-datepicker table {
        border-collapse: collapse;
        font-size: 1em;
    }
    .ui-datepicker td a {
        text-align: center;
    }
    .schedule .leave a{
        background: #e0e0e0;
    }

    .schedule .service a{
        background: #2aabd2;
        color: #fff0f0;
    }

    .schedule .order a{
        background: #419641;
        color: #fff0f0;
    }
    .dl-horizontal dd {
        margin-left: 100px;
    }

</style>
<div class="worker-schedule">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div id="schedule" class="schedule"></div>
    <div style="float: left;margin-left: 50px;width: 300px;">
        <dl class="dl-horizontal">
            <dt style="width:80px;height: 30px;background: #e0e0e0;"></dt>
            <dd><strong>请假</strong></dd>
        </dl>
        <dl class="dl-horizontal">
            <dt style="width:80px;height: 30px;background: #419641;"></dt>
            <dd><strong>可预约</strong></dd>
        </dl>
        <dl class="dl-horizontal">
            <dt style="width:80px;height: 30px;background: #2aabd2;"></dt>
            <dd><strong>服务中</strong></dd>
        </dl>
    </div>
</div>

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

    var leave = <?php echo json_encode($leave)?>;
    var service = <?php echo json_encode($service)?>;
        $("#schedule").datepicker({
        beforeShowDay: function(date) {
           // console.log(date);
            var d = date.Format("yyyy-MM-dd");
            console.log(d);
            if($.inArray(d, leave) >= 0){
                return [true, 'leave','请假'];
            }else if($.inArray(d, service) >= 0){
                return [true, 'service','服务中'];
            }else{
                return [true, 'order', '可预约'];
            }

        }
    });


</script>