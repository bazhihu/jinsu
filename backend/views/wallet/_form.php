<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\WalletUserDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wallet-user-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'detail_no')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'order_no')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'worker_id')->textInput() ?>

    <?= $form->field($model, 'uid')->textInput() ?>

    <?= $form->field($model, 'detail_money')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'detail_type')->textInput() ?>

    <?= $form->field($model, 'wallet_money')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'detail_time')->textInput() ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'pay_from')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'extract_to')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'admin_uid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
