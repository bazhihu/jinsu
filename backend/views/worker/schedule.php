<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/6/8
 * Time: 12:20
 */
use yii\helpers\Html;
use kartik\widgets\DatePicker;
$this->title = '护工排期';

?>
<div class="worker-schedule">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div id="schedule">
    <?php
    echo DatePicker::widget([
        'name' => 'schedule',
        'type' => DatePicker::TYPE_INLINE,
        //'value' => 'Tue, 23-Feb-1982',
        'options' => ['style' => 'display:none'],
        'pluginOptions' => [
            'todayHighlight' => true,
            'onRender' => 'function(date){alert(date)}'
            //'format' => 'D, dd-M-yyyy',
        ]
    ]);
    ?>
    </div>
</div>
<script type="text/javascript">

</script>