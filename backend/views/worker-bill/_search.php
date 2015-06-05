<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model backend\models\WorkerBillSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .panel-body .form-group{
        float:left;
        margin:5px;
    }
</style>
<div class="worker-bill-search">

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">检索</h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]); ?>

            <?= $form->field($model, 'type')
                ->dropDownList(\backend\models\WorkerBill::$types, ['prompt'=>'请选择','style'=>'width:90px']);
            ?>

            <?= $form->field($model, 'worker_id')
                ->input('text',['placeholder'=>'护工编号...','style'=>'width:130px']) ?>


            <?= $form->field($model, 'worker_name')
                ->input('text',['placeholder'=>'护工姓名...','style'=>'width:130px'])?>

            <?php echo $form->field($model, 'order_no')
                ->input('text',['placeholder'=>'订单编号...','style'=>'width:130px'])?>

            <?= $form->field($model, 'start_time')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATETIME,
                'ajaxConversion'=>false,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ],
                    'options'=>['style'=>'width:170px']
                ]
            ])->label('订单时间范围'); ?>

            <?= $form->field($model, 'end_time')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATETIME,
                'ajaxConversion'=>false,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ],
                    'options'=>['style'=>'width:170px']
                ]
            ])->label('至'); ?>

            <?php echo $form->field($model, 'add_time') ?>

            <div class="form-group" style="margin-top: 30px">
                <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
