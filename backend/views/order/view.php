<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use kartik\datecontrol\DateControl;
use backend\models\OrderMaster;
use backend\models\OrderPatient;

/**
 * @var yii\web\View $this
 * @var backend\models\OrderMaster $model
 */

$this->title = '订单详情';
//$this->params['breadcrumbs'][] = ['label' => 'Order Masters', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-master-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
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
            'base_price',
            'patient_state_coefficient',
            'total_amount',
            [
                'attribute'=>'patient_state',
                'type'=>DetailView::INPUT_WIDGET,
                'value'=>OrderPatient::$patientStateLabels[$model->patient_state]
            ],
            'worker_level',
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
            'create_order_sources',
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
