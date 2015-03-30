<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '充值记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallet-user-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <!-- 搜索START -->
    <div class="wallet-user-detail-search" style="padding: 25px">

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
            $searchModel,
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
            $searchModel,
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
            $searchModel,
            'uid',
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
        )->dropDownList(['1'=>'线下支付','2'=>'微信支付','3'=>'支付宝'],['prompt'=>'选择','style'=>'width:300px'])->label('支付渠道') ?>

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
            [
                'attribute'=>'uid',
                'value'=>function($model){
                    return \backend\Models\User::findOne(['id'=>$model->uid])->username;
                },
            ],
            [
                'attribute'=>'pay_from',
                'value'=>function($model){
                    if($model->pay_from == '1')
                    {
                        return '现金支付';
                    }elseif($model->pay_from == '2'){
                        return '支付宝';
                    }elseif($model->pay_from == '3'){
                        return '微信支付';
                    }
                }
            ],
            'detail_money',
            'wallet_money',
            [
                'attribute'=>'admin_uid',
                'value'=>function($model){
                    return \backend\models\AdminUser::findOne(['admin_uid'=>$model->admin_uid])->username;
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
