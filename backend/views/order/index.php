<?php

use yii\helpers\Html;
use kartik\grid\GridView;
//use yii\widgets\Pjax;
use backend\models\OrderMaster;
use backend\models\OrderPatient;
use backend\models\Hospitals;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\OrderSearch $searchModel
 */

$this->title = '订单管理';
//$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('js/order.js?v=20150330', ['position'=>yii\web\View::POS_END]);

?>
<style>
td .btn{margin: 2px}
.panel-body .form-group{
    float:left;
    margin:5px;
}
</style>
<div class="order-master-index">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    $columns = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute'=>'order_no',
            'format'=>'raw',
            //'vAlign'=>'middle',
            'value'=>function ($model) {
                return Html::a($model->order_no, Yii::$app->urlManager->createUrl(['order/view','id' => $model->order_id]));
            }
        ],
        [
            'label'=>'下单时间',
            'attribute'=>'create_time',
            'options' => [
                'style' => 'width:100px',
            ]
        ],
        [
            'attribute'=>'start_time',
            'options' => [
                'style' => 'width:100px',
            ],
            //'format'=>['datetime','yyyy-MM-dd']
        ],
        [
            'attribute'=>'end_time',
            //'format'=>['datetime','yyyy-MM-dd'],
            'options' => [
                'style' => 'width:100px',
            ]
        ],
        [
            'attribute'=>'reality_end_time',
            //'format'=>['datetime','yyyy-MM-dd'],
            'options' => [
                'style' => 'width:100px',
            ]
        ],
        [
            'attribute'=>'mobile',
            'format'=>'raw',
            'value'=>function ($model) {
                $mobile = substr_replace($model->mobile,'****',3,4);
                return Html::a($mobile, Yii::$app->urlManager->createUrl(['user/view','id'=>$model->uid]));
            },
            'options' => [
                'style' => 'width:110px',
            ]
        ],
        'worker_no',
        'worker_name',
        [
            'attribute'=>'hospital_id',
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>Hospitals::getList(),
            'filterInputOptions'=>['placeholder'=>'请选择'],
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true]
            ],
            'value'=>function($model){
                return Hospitals::getName($model->hospital_id);
            }
        ],
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
            }
        ],
        [
            'attribute'=>'total_amount',
            'options' => [
                'style' => 'width:110px',
            ]
        ],
        [
            'attribute'=>'order_status',
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>OrderMaster::$orderStatusLabels,
            'filterInputOptions'=>['placeholder'=>'请选择'],
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
                'hideSearch'=>true,
            ],
            'value'=>function($model){
                return OrderMaster::$orderStatusLabels[$model->order_status];
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '订单操作',
            'template' => '{pay}{confirm}{update}{begin_service}{evaluate}{finish}{continue}{cancel}',
            'buttons' => [
                'pay' => function ($url, $model) {
                    if(OrderMaster::checkOrderStatusAction($model->order_status, 'pay')){
                        return Html::button('支付',[
                            'data-url'=>$url, 'class'=>'btn btn-sm btn-primary jsPayOrder'
                        ]);
                    }
                },
                'confirm' => function ($url, $model) {
                    if(OrderMaster::checkOrderStatusAction($model->order_status, 'confirm')){
                        return Html::button('确认', [
                            'data-url'=>$url,
                            'class'=>'btn btn-sm btn-primary jsConfirmOrder',
                            'select-worker-url'=>Yii::$app->urlManager->createUrl([
                                'worker/select',
                                'order_id' => $model->order_id,
                                'start_time' => $model->start_time,
                                'hospital_id' => $model->hospital_id
                            ])
                        ]);
                    }
                },
                'begin_service' => function ($url, $model) {
                    if(OrderMaster::checkOrderStatusAction($model->order_status, 'begin_service')){
                        return Html::button('开始服务', [
                            'data-url'=>$url, 'class'=>'btn btn-sm btn-primary jsBeginServiceOrder'
                        ]);
                    }
                },
                'finish' => function ($url, $model) {
                    if(OrderMaster::checkOrderStatusAction($model->order_status, 'finish')){
                        return Html::button('完成', [
                            'data-url'=>$url, 'class'=>'btn btn-sm btn-primary jsFinishOrder'
                        ]);
                    }
                },
                'update' => function ($url, $model) {
                    if(OrderMaster::checkOrderStatusAction($model->order_status, 'update')){
                        return Html::button('修改',[
                                'data-url'=>$url,'class'=>'btn btn-sm btn-primary jsUpdateOrder']
                        );
                    }
                },
                'continue' => function ($url, $model) {
                    if(OrderMaster::checkOrderStatusAction($model->order_status, 'continue')){
                        return Html::button('续单', [
                            'data-url'=>$url, 'class'=>'btn btn-sm btn-primary jsContinueOrder'
                        ]);
                    }
                },
                'cancel' => function ($url, $model) {
                    if(OrderMaster::checkOrderStatusAction($model->order_status, 'cancel')){
                        return Html::button('取消', [
                            'data-url'=>$url, 'class'=>'btn btn-sm btn-primary jsCancelOrder'
                        ]);
                    }
                },
                'evaluate' => function ($url, $model) {
                    if(OrderMaster::checkOrderStatusAction($model->order_status, 'evaluate')){
                        return Html::button('评价', [
                            'class'=>'btn btn-sm btn-primary jsEvaluateOrder',
                            'evaluate-url'=>Yii::$app->urlManager->createUrl([
                                'comment/create',
                                'order_no' => $model->order_no
                            ])
                        ]);
                    }
                },
            ]
        ]
    ];

    //判断是否是TQ
    $juese = \backend\models\AdminUser::findOne(['admin_uid'=>Yii::$app->user->id])->staff_role;
    if($juese=='客服'){
        $columns[] = [
            'class' => 'yii\grid\ActionColumn',
            'header' => '呼出操作',
            'template' => '{user}{office}',
            'buttons' => [
                'user' => function ($url, $model) {
                    return Html::button('用户', [
                        'title' => '用户',
                        'class' => 'btn btn-sm btn-primary jsUser',
                        'callid' =>$model->mobile
                    ]);
                },
                'office' => function ($url, $model) {
                    return Html::button('办公室', [
                        'title' => '办公室',
                        'class'=>'btn btn-sm btn-primary jsBan',
                        'callid'=>Hospitals::getHospitalPhone($model->hospital_id)
                        //'callid'=>\backend\models\Hospitals::findOne(['id'=>$model->hospital_id])->phone
                    ]);
                },
            ]
        ];
    }

    //Pjax::begin(['enablePushState'=>true,'timeout'=>5000]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => $columns,
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
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> 新增订单', ['create'], ['class' => 'btn btn-success']),
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> 重置列表', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>true
        ],
    ]);
    //Pjax::end(); ?>

</div>
<script type="text/javascript">
    setInterval(function(){
        window.location.reload();
    },60000)
</script>