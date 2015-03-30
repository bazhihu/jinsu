<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\WalletUserDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wallet-user-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['pay-index'],
        'method' => 'get',

        'type' => ActiveForm::TYPE_INLINE,
        'formConfig'=>[
            'labelSpan'=>1
        ],
    ]); ?>
    <?php
    echo $form->field(
        $model,
        'fromDate',
        [
            'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
        ]
    )->widget(
        DateTimePicker::classname(),
        [
            'options' => ['placeholder' => 'Enter event time ...','style'=>'width:300px'],
            'pluginOptions' => ['autoclose' => true]
        ]
    )->label('起始时间');
    echo $form->field(
        $model,
        'toDate',
        [
            'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
        ]
    )->widget(
        DateTimePicker::classname(),
        [
            'options' => ['placeholder' => 'Enter event time ...','style'=>'width:300px'],
            'pluginOptions' => ['autoclose' => true]
        ]
    )->label('结束时间');
    ?>
    <?= $form->field(
        $model,
        'uid',
        [
            'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
        ]
    )->input('text',['placeholder'=>'请输入用户账号...','style'=>'width:300px'])->label('用户账号')?>
    <?= $form->field(
        $model,
        'pay_from',
        [
            'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
        ]
    )->dropDownList(['1'=>'线下支付','2'=>'微信支付','3'=>'支付宝'],['prompt'=>'选择','style'=>'width:300px'])->label('支付渠道') ?>

    <div class="form-group" style="padding-top: 25px">
        <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
