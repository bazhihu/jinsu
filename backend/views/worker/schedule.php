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
<div class="worker-schedule">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div id="schedule">

    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#schedule').datetimepicker({
            inline: true,
            sideBySide: true
        });
    });
</script>