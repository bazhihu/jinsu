<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/5/12
 * Time: 15:13
 */
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use miloschuman\highcharts\Highcharts;

$categories = $series = [];

$startDate = strtotime($model->start_time);
$endDate = strtotime($model->end_time);
$datetime = $startDate;
while($datetime <= $endDate){
    $categories[] = date('Y-m-d', $datetime);
    $datetime = $datetime+86400;
}

$data = [];
foreach($dataProvider as $key => $items){
    $data[$key] = \yii\helpers\ArrayHelper::map($items, 'date', 'total');
}
//print_r($data);
foreach($categories as $datetime){
    if(isset($data['all'][$datetime])){
        $series['all'][] = (int)$data['all'][$datetime];
    }else{
        $series['all'][] = 0;
    }

    if(isset($data['mobile'][$datetime])){
        $series['mobile'][] = (int)$data['mobile'][$datetime];
    }else{
        $series['mobile'][] = 0;
    }

    if(isset($data['service'][$datetime])){
        $series['service'][] = (int)$data['service'][$datetime];
    }else{
        $series['service'][] = 0;
    }
}
$this->title = '数据统计';
?>
<style>
    .panel-body .form-group{
        float:left;
        margin:5px;
    }
    .field-ordersearch-start_time{
        float:left;width:210px
    }
    .field-ordersearch-end_time{
        float:left;width:210px
    }
</style>
<div class="order-chart-index">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">统计条件</h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'type' => ActiveForm::TYPE_VERTICAL,
                'formConfig' => [
                    'showLabels' => true,
                ],
            ]); ?>

            <?= $form->field($model, 'start_time')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'ajaxConversion'=>false,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ],
                    'options'=>['style'=>'width:130px']
                ]
            ])->label('统计时间范围'); ?>

            <?= $form->field($model, 'end_time')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'ajaxConversion'=>false,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ],
                    'options'=>['style'=>'width:130px']
                ]
            ])->label('至'); ?>

            <div class="form-group" style="margin-top: 30px">
                <?= Html::submitButton('确定', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php

echo Highcharts::widget([
    'options' => [
        'title' => ['text' => '日订单量统计'],
        'xAxis' => [
            'categories' => $categories
        ],
        'yAxis' => [
            'title' => ['text' => '订单数']
        ],
        'series' => [
            ['name' => '全部', 'data' => $series['all']],
            ['name' => '移动端', 'data' => $series['mobile']],
            ['name' => '后台', 'data' => $series['service']],
        ]
    ]
]);