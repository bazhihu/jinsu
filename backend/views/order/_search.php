<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use backend\models\Departments;
use backend\models\OrderMaster;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\OrderSearch $model
 * @var yii\widgets\ActiveForm $form
 */
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
<div class="order-master-search">

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">检索</h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'type' => ActiveForm::TYPE_VERTICAL,
                'formConfig' => [
                    'showLabels' => true,
                ],
            ]); ?>

            <?= $form->field($model, 'order_no')->input('text',['placeholder'=>'请输入订单编号...','style'=>'width:135px']) ?>

            <?= $form->field($model, 'mobile')->input('text',['placeholder'=>'请输入手机号...','style'=>'width:125px']) ?>

            <?= $form->field($model, 'worker_name')->input('text',['placeholder'=>'请输入护工姓名...','style'=>'width:135px']) ?>

            <?= $form->field($model, 'patient_name')->input('text',['placeholder'=>'请输入患者姓名...','style'=>'width:135px']) ?>

            <?= $form->field($model, 'department_id')
                ->dropDownList(Departments::getList(),['prompt'=>'请选择','style'=>'width:110px']);
            ?>
            <?= $form->field($model, 'order_status')
                ->dropDownList(OrderMaster::$orderStatusLabels,['prompt'=>'请选择']);
            ?>
            <?= $form->field($model, 'customer_service_id')->widget(\kartik\widgets\Select2::classname(),[
                'data' => \backend\models\AdminUser::getService(),
                'options' => ['placeholder' => '请选择','style'=>'width:110px'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('客服');?>

            <?= $form->field($model, 'create_order_sources')
                ->dropDownList(OrderMaster::$orderSources,['prompt'=>'请选择'])
                ->label('订单来源');
            ?>

            <?= $form->field($model, 'start_time')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'ajaxConversion'=>false,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ],
                    'options'=>['style'=>'width:130px']
                ]
            ])->label('订单时间范围'); ?>

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
                <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
