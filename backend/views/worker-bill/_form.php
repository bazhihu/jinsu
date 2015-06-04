<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\WorkerBill */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="worker-bill-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'worker_id')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'worker_name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'order_id')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'order_no')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'start_time')->textInput() ?>

    <?= $form->field($model, 'end_tme')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'add_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
