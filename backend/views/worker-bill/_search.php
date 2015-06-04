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

            <?= $form->field($model, 'type') ?>

            <?= $form->field($model, 'worker_id') ?>

            <?= $form->field($model, 'worker_name') ?>

            <?php echo $form->field($model, 'order_no') ?>

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

            <?php echo $form->field($model, 'add_time') ?>

            <div class="form-group" style="margin-top: 30px">
                <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
