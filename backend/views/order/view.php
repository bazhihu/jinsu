<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use kartik\datecontrol\DateControl;
use backend\models\OrderMaster;
use backend\models\OrderPatient;
use backend\models\Worker;

/**
 * @var yii\web\View $this
 * @var backend\models\OrderMaster $model
 */

$this->title = '订单详情';
//$this->params['breadcrumbs'][] = ['label' => 'Order Masters', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('js/order.js', ['position'=>yii\web\View::POS_END]);
?>
<style>
    .btn{margin:5px}
</style>

<div class="order-master-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <!--订单操作-->
    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">订单操作</h3>
        </div>
        <div class="panel-body">
            <?php
            if(OrderMaster::checkOrderStatusAction($model->order_status, 'pay')){
                echo Html::button('支付',[
                    'data-url'=>Yii::$app->urlManager->createUrl(['order/pay', 'id'=>$model->order_id]),
                    'class'=>'btn btn-warning jsPayOrder'
                ]);
            }

            if(OrderMaster::checkOrderStatusAction($model->order_status, 'confirm')){
                echo Html::button('确认', [
                    'data-url'=>Yii::$app->urlManager->createUrl(['order/confirm', 'id'=>$model->order_id]),
                    'class'=>'btn btn-warning jsConfirmOrder',
                    'select-worker-url'=>Yii::$app->urlManager->createUrl([
                        'worker/select',
                        'order_id' => $model->order_id,
                        'start_time' => $model->start_time
                    ])
                ]);
            }

            if(OrderMaster::checkOrderStatusAction($model->order_status, 'begin_service')){
                echo Html::button('开始服务', [
                    'data-url'=>Yii::$app->urlManager->createUrl(['order/begin_service', 'id'=>$model->order_id]),
                    'class'=>'btn btn-warning jsBeginServiceOrder'
                ]);
            }
            if(OrderMaster::checkOrderStatusAction($model->order_status, 'finish')){
                echo Html::button('完成', [
                    'data-url'=>Yii::$app->urlManager->createUrl(['order/finish', 'id'=>$model->order_id]),
                    'class'=>'btn btn-warning jsFinishOrder'
                ]);
            }
            if(OrderMaster::checkOrderStatusAction($model->order_status, 'update')){
                echo Html::button('修改',[
                        'data-url'=>Yii::$app->urlManager->createUrl(['order/update', 'id'=>$model->order_id]),
                        'class'=>'btn btn-warning jsUpdateOrder'
                    ]
                );
            }
            if(OrderMaster::checkOrderStatusAction($model->order_status, 'continue')){
                echo Html::button('续单', [
                    'data-url'=>Yii::$app->urlManager->createUrl(['order/continueOrder', 'id'=>$model->order_id]),
                    'class'=>'btn btn-warning jsContinueOrder'
                ]);
            }
            if(OrderMaster::checkOrderStatusAction($model->order_status, 'cancel')){
                echo Html::button('取消', [
                    'data-url'=>Yii::$app->urlManager->createUrl(['order/cancel', 'id'=>$model->order_id]),
                    'class'=>'btn btn-warning jsCancelOrder'
                ]);
            }
            if(OrderMaster::checkOrderStatusAction($model->order_status, 'evaluate')){
                echo Html::button('评价', [
                    'data-url'=>Yii::$app->urlManager->createUrl(['order/evaluate', 'id'=>$model->order_id]),
                    'class'=>'btn btn-warning jsEvaluateOrder'
                ]);
            }

            ?>
        </div>
    </div>
    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'order_id',
            'order_no',
            [
                'attribute'=>'order_status',
                'type'=>DetailView::INPUT_WIDGET,
                'value'=>OrderMaster::$orderStatusLabels[$model->order_status]

            ],
            'uid',
            'mobile',
            'worker_no',
            'worker_name',
            [
                'attribute'=>'worker_level',
                'type'=>DetailView::INPUT_WIDGET,
                'value'=>Worker::$workerLevelLabel[$model->worker_level]
            ],
            'base_price',
            'patient_state_coefficient',
            [
                'attribute'=>'total_amount',
            ],
            [
                'attribute'=>'patient_state',
                'type'=>DetailView::INPUT_WIDGET,
                'value'=>OrderPatient::$patientStateLabels[$model->patient_state]
            ],

            'customer_service_id',
            'operator_id',
            [
                'attribute'=>'start_time',
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'end_time',
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'reality_end_time',
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'create_time',
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'pay_time',
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'confirm_time',
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'cancel_time',
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            'create_order_ip',
            [
                'attribute'=>'create_order_sources',
                'type'=>DetailView::INPUT_WIDGET,
                'value'=>OrderMaster::$orderSources[$model->create_order_sources]
            ],
            'create_order_user_agent',
        ],
//        'deleteOptions'=>[
//            'url'=>['delete', 'id' => $model->order_id],
//            'data'=>[
//                'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
//                'method'=>'post',
//            ],
//        ],
        'enableEditMode'=>false,
    ]) ?>

</div>
