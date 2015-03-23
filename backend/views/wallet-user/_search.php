<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\WalletUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wallet-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'money') ?>

    <?= $form->field($model, 'money_pay') ?>

    <?= $form->field($model, 'money_pay_s') ?>

    <?= $form->field($model, 'money_consumption') ?>

    <?php // echo $form->field($model, 'money_extract') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
