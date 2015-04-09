<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '充值记录';
?>
<div class="wallet-rechargeRecords">

    <h1><?= Html::encode($this->title) ?></h1>
    <!-- 搜索START -->
    <div class="wallet-user-detail-search" style="padding: 25px">

        <?php $form = ActiveForm::begin([
            'action' => ['recharge-records'],
            'method' => 'get',

            'type' => ActiveForm::TYPE_INLINE,
            'formConfig'=>[
                'labelSpan'=>1
            ],
        ]); ?>
        <?php
        echo $form->field(
            $searchModel,
            'fromDate',
            [
                'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
            ]
        )->widget(
            DatePicker::classname(),
            [
                'options' => ['placeholder' => 'Enter event time ...','style'=>'width:300px'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'todayHighlight' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]
        )->label('起始时间');
        echo $form->field(
            $searchModel,
            'toDate',
            [
                'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
            ]
        )->widget(
            DatePicker::classname(),
            [
                'options' => ['placeholder' => 'Enter event time ...','style'=>'width:300px'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'todayHighlight' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]
        )->label('结束时间');
        ?>
        <?= $form->field(
            $searchModel,
            'mobile',
            [
                'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
            ]
        )->input('text',['placeholder'=>'请输入用户账号...','style'=>'width:300px'])->label('用户账号')?>
        <?= $form->field(
            $searchModel,
            'pay_from',
            [
                'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
            ]
        )->dropDownList(['backend'=>'线下支付','wechat'=>'微信支付','alipay'=>'支付宝'],['prompt'=>'选择','style'=>'width:300px'])->label('支付渠道') ?>

        <div class="form-group" style="padding-top: 25px">
            <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <!-- 搜索END -->

    <!-- 列表START -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'detail_no',
            'detail_time',
            'mobile',
            [
                'attribute'=>'pay_from',
                'value'=>function($model){
                    if($model->pay_from == 'backend')
                    {
                        return '现金支付';
                    }elseif($model->pay_from == 'alipay'){
                        return '支付宝';
                    }elseif($model->pay_from == 'wechat'){
                        return '微信支付';
                    }
                }
            ],
            'detail_money',
            'wallet_money',
            [
                'attribute'=>'admin_uid',
                'value'=>function($model){
                    return \backend\models\AdminUser::getInfo($model->admin_uid);
                }
            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'showFooter'=>true
        ],
    ]);?>
    <!-- 列表END -->
</div>
