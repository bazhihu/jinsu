<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\OrderSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="order-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'type' => ActiveForm::TYPE_VERTICAL,
        'formConfig' => [
            'showLabels' => true,
        ],
    ]); ?>


    <?= $form->field($model, 'order_no') ?>

    <?= $form->field($model, 'mobile') ?>

    <?= $form->field($model, 'base_price') ?>

    <?php // echo $form->field($model, 'disabled_amount') ?>

    <?php // echo $form->field($model, 'holiday_amount') ?>

    <?php // echo $form->field($model, 'total_amount') ?>

    <?php // echo $form->field($model, 'patient_state') ?>

    <?php // echo $form->field($model, 'worker_level') ?>

    <?php // echo $form->field($model, 'customer_service_id') ?>

    <?php // echo $form->field($model, 'operator_id') ?>

    <?php // echo $form->field($model, 'service_start_time') ?>

    <?php // echo $form->field($model, 'service_end_time') ?>

    <?php // echo $form->field($model, 'reality_end_time') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'pay_time') ?>

    <?php // echo $form->field($model, 'confirm_time') ?>

    <?php // echo $form->field($model, 'cancel_time') ?>

    <?php // echo $form->field($model, 'order_status') ?>

    <?php // echo $form->field($model, 'create_order_ip') ?>

    <?php // echo $form->field($model, 'create_order_sources') ?>

    <?php // echo $form->field($model, 'create_order_user_agent') ?>

    <div class="form-group">
        <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
