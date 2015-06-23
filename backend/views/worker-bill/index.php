<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\WorkerBill;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WorkerBillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '护工账单';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="worker-bill-index">

    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'type',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>WorkerBill::$types,
                'filterInputOptions'=>['placeholder'=>'请选择'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                    'hideSearch'=>true,
                ],
                'value'=>function($model){
                    return WorkerBill::$types[$model->type];
                }
            ],
            [
                'attribute'=>'add_time',
            ],
            'worker_id',
            'worker_name',
            //'order_id',
            'order_no',
            [
                'attribute'=>'start_time'
            ],
            [
                'attribute'=>'end_time'
            ],
            'amount',

        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> 重置列表', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>true
        ],
        'panelBeforeTemplate' => '<div class="pull-right"><div class="btn-toolbar kv-grid-toolbar" role="toolbar">{toolbar}</div></div><strong>总收入：'.(int)$searchModel->total.'元</strong><div class="clearfix"></div>'
    ]); ?>

</div>
