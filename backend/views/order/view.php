<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use backend\models\OrderMaster;
use backend\models\OrderPatient;
use backend\models\Hospitals;
use backend\models\Departments;

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


    <?php
    echo DetailView::widget([
        'model' => $model,
        'condensed'=>false,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'用户信息',
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'uid',
            'mobile',
            'contact_name',
            'contact_telephone',
            'contact_address'
        ],
        'enableEditMode'=>false,
    ]);

    echo DetailView::widget([
        'model' => $orderPatientModel,
        'condensed'=>false,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'患者信息',
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'name',
            'gender',
            'age',
            'height',
            'weight',
            [
                'attribute'=>'patient_state',
                'type'=>DetailView::INPUT_WIDGET,
                'value'=>OrderPatient::$patientStateLabels[$model->patient_state]
            ],
            'in_hospital_reason',
            'admission_date',
            'room_no',
            'bed_no'
        ],
        'enableEditMode'=>false,
    ]);

    echo DetailView::widget([
        'model' => $model,
        'condensed'=>false,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'护工信息',
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'worker_no',
            'worker_name',
            'base_price',
            [
                'attribute'=>'worker_level',
                'type'=>DetailView::INPUT_WIDGET,
                'value'=>\backend\Models\Worker::$workerLevelLabel[$model->worker_level]
            ]
        ],
        'enableEditMode'=>false,
    ]);

    echo DetailView::widget([
        'model' => $model,
        'condensed'=>false,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'订单信息',
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'order_no',
            [
                'attribute'=>'order_status',
                'type'=>DetailView::INPUT_WIDGET,
                'value'=>OrderMaster::$orderStatusLabels[$model->order_status]
            ],
            'patient_state_coefficient',
            [
                'attribute'=>'total_amount'
            ],
            [
                'attribute'=>'hospital_id',
                'type'=>DetailView::INPUT_WIDGET,
                'value'=>Hospitals::getName($model->hospital_id)
            ],
            [
                'attribute'=>'department_id',
                'type'=>DetailView::INPUT_WIDGET,
                'value'=>Departments::getName($model->department_id)
            ],
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
                'label'=>'订单周期',
                'attribute'=>'orderCycle',
                'type'=>DetailView::INPUT_WIDGET,
                'value'=>OrderMaster::getOrderCycle($model->start_time, $model->reality_end_time).'天'
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
            'customer_service_id',
            'operator_id',
            'create_order_ip',
            [
                'attribute'=>'create_order_sources',
                'type'=>DetailView::INPUT_WIDGET,
                'value'=>OrderMaster::$orderSources[$model->create_order_sources]
            ],
            'create_order_user_agent',
        ],
        'enableEditMode'=>false,
    ]);
 ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">订单费用明细</h3>
        </div>
        <div class="panel-body">
            <?php
            $details = $model->calculateTotalPrice(true);
            ?>
            <table class="detail-view table table-hover table-bordered table-striped">
                <thead>
                <tr>
                    <th>日期</th>
                    <th>每天基础价格</th>
                    <th>不能自理加价</th>
                    <th>节假日加价</th>
                    <th>每天总价格</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($details['PriceDetail'] as $date => $item):?>
                <tr>
                    <td><div class="kv-attribute"><?php echo $date;?></div></td>
                    <td><div class="kv-attribute"><?php echo $item['basePrice'];?></div></td>
                    <td><div class="kv-attribute"><?php echo $item['disabledPrice'];?></div></td>
                    <td><div class="kv-attribute"><?php echo $item['holidayPrice'];?></div></td>

                    <td><div class="kv-attribute"><?php echo $item['dayPrice'];?></div></td>
                </tr>
                <?php endforeach;?>
                <tr class="warning">
                    <td>总额</td>
                    <td colspan="4" style="text-align: right"><?php echo $details['totalPrice'];?></td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
