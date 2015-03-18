<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\OrderMaster $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="order-master-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'order_no'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 订单编号...', 'maxlength'=>50]], 

'mobile'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 下单手机号...', 'maxlength'=>11]], 

'base_price'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 护工的基础价格...', 'maxlength'=>10]], 

'worker_level'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 护工等级...']], 

'service_start_time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'service_end_time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'reality_end_time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'create_time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'create_order_ip'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 创建订单的IP...', 'maxlength'=>255]], 

'create_order_sources'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 创建订单来源...', 'maxlength'=>255]], 

'create_order_user_agent'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 创建订单时客户端user agent...', 'maxlength'=>500]], 

'uid'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 用户ID...', 'maxlength'=>11]], 

'patient_state'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 患者健康情况...']], 

'customer_service_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 下单客服ID...', 'maxlength'=>11]], 

'operator_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 订单操作者ID...', 'maxlength'=>11]], 

'disabled_amount'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 不能自理所加金额...', 'maxlength'=>10]], 

'holiday_amount'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 节假日所加金额...', 'maxlength'=>10]], 

'total_amount'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 订单总金额...', 'maxlength'=>10]], 

'pay_time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'confirm_time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'cancel_time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'order_status'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 订单状态...', 'maxlength'=>255]], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
