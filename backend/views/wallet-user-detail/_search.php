<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\WalletUserDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wallet-user-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'detail_id') ?>

    <?= $form->field($model, 'detail_id_no') ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'order_no') ?>

    <?= $form->field($model, 'worker_id') ?>

    <?php // echo $form->field($model, 'uid') ?>

    <?php // echo $form->field($model, 'detail_money') ?>

    <?php // echo $form->field($model, 'detail_type') ?>

    <?php // echo $form->field($model, 'wallet_money') ?>

    <?php // echo $form->field($model, 'detail_time') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'pay_from') ?>

    <?php // echo $form->field($model, 'extract_to') ?>

    <?php // echo $form->field($model, 'admin_uid') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
