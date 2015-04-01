<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '提现支付';
$this->registerJsFile('js/wallet.js', ['position'=>yii\web\View::POS_END]);
?>
<div class="wallet-to-pay">

    <h1><?= Html::encode($this->title) ?></h1>
    <!--?php  echo $this->render('_search', ['model' => $searchModel]); ?-->
    <div class="wallet-apply-list" style="padding: 25px">

        <?php $form = ActiveForm::begin([
            'action' => ['to-pay'],
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
        )->input('text',['placeholder'=>'请输入用户账号...','style'=>'width:400px'])->label('用户账号')?>

        <div class="form-group" style="padding-top: 25px">
            <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <p>
        <!--?= Html::a('Create Wallet User Detail', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'header'=>'申请时间',
                'attribute'=>'time_apply',
            ],
            [
                'header'=>'用户账号',
                'attribute'=>'uid',
                'value'=>function($model){
                    return User::findOne(['id'=>$model->uid])?User::findOne(['id'=>$model->uid])->mobile:"";
                },
            ],
            [
                'attribute'=>'money',
                'value'=>function($model){
                    return $model->money;
                }
            ],
            'remark_apply',
            [
                'header'=>'审核时间',
                'attribute'=>'time_audit',
            ],
            'remark_audit',
            [
                'header'=>'付款状态',
                'attribute'=>'status',
                'value'=>function($model){
                    if($model->status == '3') {
                        return '已付款';
                    }elseif($model->status == '2'){
                        return '待付款';
                    }
                },
            ],
            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                    'buttons' => [
                    'pay' => function ($url, $model) {
                        return $model->status==2?Html::button('付款', [
                            'title' => Yii::t('yii', '付款'),
                            'class' => 'btn btn-default jspay',
                            'data-url'=>$url,
                        ]):"";
                    },
                ],
                'template'=>'{pay}',
            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'showFooter'=>true
        ],
    ]); ?>

</div>
