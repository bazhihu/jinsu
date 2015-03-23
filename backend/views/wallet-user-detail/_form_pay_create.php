<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\WalletUserDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wallet-user-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tel')->textInput(['value'=>''.$userRow['tel'].'','disabled'=>'disabled'])->label('充值账号') ?>

    <?= $form->field($model, 'detail_money')->textInput(['maxlength' => 10])->label('充值金额') ?>

    <?= $form->field($model, 'detail_type')->radioList(['2'=>'现金充值','3'=>'POS机刷卡'],['value'=>'2','checked'=>'true'])->label('充值类型')?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
