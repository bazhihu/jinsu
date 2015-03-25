<?php

use yii\helpers\Html;
use kartik\grid\GridView;
//use yii\widgets\Pjax;
use common\models\Order;
use backend\models\OrderPatient;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\OrderSearch $searchModel
 */

$this->title = '订单管理';
//$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('js/order.js', ['position'=>yii\web\View::POS_END]);
?>
<div class="order-master-index">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php  //echo Html::a('新增订单', ['create'], ['class' => 'btn btn-success'])  ?>
    </p>

    <?php
    //Pjax::begin(['enablePushState'=>true,'timeout'=>5000]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => false, // pjax is set to always true for this demo
        'pjaxSettings'=>[
            'neverTimeout'=>true,
            //'beforeGrid'=>'My fancy content before.',
            //'afterGrid'=>'My fancy content after.',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'order_id',
            [
                'attribute'=>'order_no',
                'format'=>'raw',
                'vAlign'=>'middle',
                'value'=>function ($model) {
                    return Html::a($model->order_no, Yii::$app->urlManager->createUrl(['order/view','id' => $model->order_id]));

                },
            ],
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
                'header' => '订单操作',
                'template' => '{pay}{finish}{update}',
                'buttons' => [
                    'pay' => function ($url, $model) {
                        return Html::button('支付', [
                            'title' => '支付',


                        ]);
                    },
                    'finish' => function ($url, $model) {
                        return Html::button('完成', [
                            'title' => '完成',


                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::button(
                            '修改',
                            ['title'=>'修改','data-url'=>$url,'class'=>'jsUpdateOrder']
                        );
                    },
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '呼出操作',
                'template' => '{user}{office}',
                'buttons' => [
                    'user' => function ($url, $model) {
                        return Html::button('用户', [
                            'title' => '用户',
                        ]);
                    },
                    'office' => function ($url, $model) {
                        return Html::button('办公室', [
                            'title' => '办公室',


                        ]);
                    },
                ]
            ]
        ],
        //'export' => true,//是否显示导出
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
    //Pjax::end(); ?>

</div>