<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\WorkerAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="worker-account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'worker_id')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'worker_name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'city_id')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'hospital_id')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'balance')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'withdraw_amount')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'recommend_amount')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'order_amount')->textInput(['maxlength' => 10]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
