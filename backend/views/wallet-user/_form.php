<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\WalletUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wallet-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'uid')->textInput() ?>

    <?= $form->field($model, 'money')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'money_pay')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'money_pay_s')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'money_consumption')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'money_extract')->textInput(['maxlength' => 10]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
