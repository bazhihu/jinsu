<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use backend\models\OrderMaster;
use backend\models\OrderPatient;
use backend\models\Hospitals;
use backend\models\Departments;
use backend\models\Worker;

/**
 * @var yii\web\View $this
 * @var backend\models\OrderMaster $model
 */

$this->title = '订单详情';
//$this->params['breadcrumbs'][] = ['label' => 'Order Masters', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('js/order.js?v=20150330', ['position'=>yii\web\View::POS_END]);
?>
<style>
    .btn{margin:5px}
</style>

<div class="order-master-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <!--订单操作-->
    <?php if($model->order_status != OrderMaster::ORDER_STATUS_END_SERVICE && $model->order_status != OrderMaster::ORDER_STATUS_CANCEL):?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">订单操作</h3>
        </div>
        <div class="panel-body">
            <?php
            if(OrderMaster::checkOrderStatusAction($model->order_status, 'pay')){
                echo Html::button('支付',[
                    'data-url'=>Yii::$app->urlManager->createUrl(['order/pay', 'id'=>$model->order_id]),
                    'class'=>'btn btn-primary jsPayOrder'
                ]);
            }
            if(OrderMaster::checkOrderStatusAction($model->order_status, 'confirm')){
                echo Html::button('确认', [
                    'data-url'=>Yii::$app->urlManager->createUrl(['order/confirm', 'id'=>$model->order_id]),
                    'class'=>'btn btn-primary jsConfirmOrder',
                    'select-worker-url'=>Yii::$app->urlManager->createUrl([
                        'worker/select',
                        'order_id' => $model->order_id,
                        'start_time' => $model->start_time,
                        'hospital_id' => $model->hospital_id
                    ])
                ]);
            }
            if(OrderMaster::checkOrderStatusAction($model->order_status, 'begin_service')){
                echo Html::button('开始服务', [
                    'data-url'=>Yii::$app->urlManager->createUrl(['order/begin_service', 'id'=>$model->order_id]),
                    'class'=>'btn btn-primary jsBeginServiceOrder'
                ]);
            }
            if(OrderMaster::checkOrderStatusAction($model->order_status, 'finish')){
                echo Html::button('完成', [
                    'data-url'=>Yii::$app->urlManager->createUrl(['order/finish', 'id'=>$model->order_id]),
                    'class'=>'btn btn-primary jsFinishOrder'
                ]);
            }
            if(OrderMaster::checkOrderStatusAction($model->order_status, 'update')){
                echo Html::button('修改',[
                        'data-url'=>Yii::$app->urlManager->createUrl(['order/update', 'id'=>$model->order_id]),
                        'class'=>'btn btn-primary jsUpdateOrder'
                    ]
                );
            }
            if(OrderMaster::checkOrderStatusAction($model->order_status, 'continue')){
                echo Html::button('续单', [
                    'data-url'=>Yii::$app->urlManager->createUrl(['order/continue', 'id'=>$model->order_id]),
                    'class'=>'btn btn-primary jsContinueOrder'
                ]);
            }
            if(OrderMaster::checkOrderStatusAction($model->order_status, 'cancel')){
                echo Html::button('取消', [
                    'data-url'=>Yii::$app->urlManager->createUrl(['order/cancel', 'id'=>$model->order_id]),
                    'class'=>'btn btn-primary jsCancelOrder'
                ]);
            }
            if(OrderMaster::checkOrderStatusAction($model->order_status, 'evaluate')){
                echo Html::button('评价', [
                    'evaluate-url'=>Yii::$app->urlManager->createUrl([
                        'comment/create',
                        'order_no' => $model->order_no
                    ]),
                    'class'=>'btn btn-primary jsEvaluateOrder'
                ]);
            }

            ?>
        </div>
    </div>
    <?php endif;?>

    <?php
    if($model->order_status == OrderMaster::ORDER_STATUS_WAIT_PAY){
        $payButton = Html::button(
            '充值',
            ['class'=>'btn btn-info js-recharge']
        );
    }else{
        $payButton = null;
    }

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
                'value'=>'<font style="font-weight: bold;color: #aa0000">'.OrderMaster::$orderStatusLabels[$model->order_status].'</font> '.$payButton,
                'format'=>'raw'
            ],
            'patient_state_coefficient',
            [
                'attribute'=>'total_amount'
            ],
            [
                'attribute'=>'real_amount',
                'value'=>'<font style="font-weight: bold;color: #aa0000">'.$model->real_amount.'</font>',
                'format'=>'raw'
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
            'start_time',
            'end_time',
            'reality_end_time',
            [
                'label'=>'订单周期',
                'attribute'=>'orderCycle',
                'type'=>DetailView::INPUT_WIDGET,
                'value'=>OrderMaster::getOrderCycle($model->start_time, $model->reality_end_time).'天'
            ],
            'create_time',
            'pay_time',
            'confirm_time',
            'begin_service_time',
            'cancel_time',
            [
                'attribute'=>'customer_service_id',
                'value'=>\backend\models\AdminUser::getInfo($model->customer_service_id, 'staff_name').'('.$model->operator_id.')'
            ],
            'remark',
            [
                'attribute'=>'operator_id',
                'value'=>\backend\models\AdminUser::getInfo($model->operator_id, 'staff_name').'('.$model->operator_id.')'
            ],
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
            [
                'attribute'=>'mobile',
                'value'=>$model->formatMobile()
            ],
            'contact_name',
            'contact_telephone',
            'contact_address'
        ],
        'enableEditMode'=>false,
    ]);

    if(!empty($orderPatientModel)):
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
            [
                'attribute'=>'gender',
                'type'=>DetailView::INPUT_WIDGET,
                'value'=>$orderPatientModel->gender?OrderPatient::$genderLabels[$orderPatientModel->gender]:''
            ],
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
    endif;

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
                'value'=>Worker::$workerLevelLabel[$model->worker_level]
            ]
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
                    <td><h4>总额（元）</h4></td>
                    <td colspan="4" style="text-align: right">
                        <h4><span class="label label-danger"><?php echo $details['totalPrice'];?></span></h4>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
<?php
\yii\bootstrap\Modal::begin([
    'header' => '<strong>充值</strong>',
    'id'=>'rechargeModal',
    'size'=>'modal-lg',
]);
echo '<div id="rechargeModalContent"></div>';

\yii\bootstrap\Modal::end();

//完成订单
\yii\bootstrap\Modal::begin([
    'header' => '<strong>完成订单</strong>',
    'id'=>'finishOrderModal',
    'size'=>'modal-lg',
]);
echo '<div id="finishOrderModalContent"></div>';

\yii\bootstrap\Modal::end();
?>
<script type="text/javascript">
    $('body').on('click', '.panel-heading', function () {
        $(this).siblings().toggle();
    });
    $('.js-recharge').click(function(){
        <?php $url = Yii::$app->urlManager->createUrl(['order/recharge', 'id'=>$model->order_id]);?>

        $("#rechargeModalContent").load(
            '<?php echo $url;?>'
        );

        jQuery('#rechargeModal').modal({"show":true});
    });

</script>