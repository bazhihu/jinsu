<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\Order;
use backend\models\OrderPatient;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\OrderSearch $searchModel
 */

$this->title = '订单管理';
//$this->params['breadcrumbs'][] = $this->title;


?>
<div class="order-master-index">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Order Master', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php
    Pjax::begin(['enablePushState'=>false,'timeout'=>5000]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true, // pjax is set to always true for this demo
        'pjaxSettings'=>[
            'neverTimeout'=>true,
            //'beforeGrid'=>'My fancy content before.',
            //'afterGrid'=>'My fancy content after.',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'order_id',
            'order_no',
//            'uid',
            [
                'attribute'=>'start_time',
                'options' => [
                    'style' => 'width:100px',
                ],
                'format'=>['datetime','Y-MM-d']
            ],
            [
                'attribute'=>'end_time',
                'format'=>['datetime','Y-MM-d'],
                'options' => [
                    'style' => 'width:100px',
                ]
            ],
            [
                'attribute'=>'mobile',
                'options' => [
                    'style' => 'width:110px',
                ]
            ],
            'worker_no',
            'worker_name',
//            'base_price',
//            'disabled_amount', 
//            'holiday_amount',

            [
                'attribute'=>'patient_state',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>OrderPatient::$patientStateLabels,
                'filterInputOptions'=>['placeholder'=>'请选择'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                    'hideSearch'=>true,
                ],
                'value'=>function($model){
                    return OrderPatient::$patientStateLabels[$model->patient_state];
                },
                'format'=>'raw'
            ],
            [
                'attribute'=>'total_amount',
                'options' => [
                    'style' => 'width:110px',
                ]
            ],
//            'worker_level',
//            'customer_service_id', 
//            'operator_id',
//            ['attribute'=>'reality_end_time','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            ['attribute'=>'create_time','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            ['attribute'=>'pay_time','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            ['attribute'=>'confirm_time','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            ['attribute'=>'cancel_time','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 

            [
                'attribute'=>'order_status',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>Order::$orderStatusLabels,
                'filterInputOptions'=>['placeholder'=>'请选择'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                    'hideSearch'=>true,
                ],
                'value'=>function($model){
                    return Order::$orderStatusLabels[$model->order_status];
                },
                'format'=>'raw'
            ],
//            'create_order_ip', 
//            'create_order_sources', 
//            'create_order_user_agent',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['order/view','id' => $model->order_id,'edit'=>'t']), ['title' => Yii::t('yii', 'Edit'),]
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', '你确定要删除此项吗?'),
                            'data-method' => 'post',
                            'data-pjax' => 'w0',

                        ]);
                    }
                ],
            ],
        ],
        'export' => false,//是否显示导出
        'toggleData' => false,
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'bordered'=>false,
        'floatHeader'=>true,

        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> 新增订单', ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>true
        ],
    ]);
    Pjax::end(); ?>

</div>