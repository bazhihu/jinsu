<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '提现支付';
$this->registerJsFile('js/wallet.js', ['position'=>yii\web\View::POS_END]);
?>
<style>
    .panel-body .form-group{
        float:left;
        margin:5px;
    }
    .field-walletwithdrawcashsearch-fromdate{
        width:270px
    }
    .field-walletwithdrawcashsearch-todate{
        width:270px
    }
</style>
<div class="wallet-to-pay">

    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="wallet-apply-list">

        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">检索</h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['confirm-list'],
                    'method' => 'get',

                    'type' => ActiveForm::TYPE_VERTICAL,
                    'formConfig' => [
                        'showLabels' => true,
                    ],
                ]); ?>
                <?php
                echo $form->field(
                    $searchModel,
                    'fromDate'
                )->widget(
                    DatePicker::classname(),
                    [
                        'options' => ['placeholder' => '请输入开始时间 ...'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]
                )->label('起始时间');
                echo $form->field(
                    $searchModel,
                    'toDate'
                )->widget(
                    DatePicker::classname(),
                    [
                        'options' => ['placeholder' => '请输入结束时间 ...'],
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
                    'mobile'
                )->input('text',['placeholder'=>'请输入用户账号...'])->label('用户账号')?>

                <div class="form-group" style="padding-top: 25px">
                    <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
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
                'attribute'=>'mobile'
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
                            'class' => 'btn btn-default jsPay',
                            'data-url'=>Yii::$app->urlManager->createUrl(['wallet/ajax-confirm','id' => $model->withdrawcash_id]),
                        ]):"";
                    },
                ],
                'template'=>'{pay}',
            ],
            [
                'header'=>'操作人',
                'attribute'=>'admin_uid_payment',
                'value'=>function($model){
                    return \backend\models\AdminUser::getInfo($model->admin_uid_payment);
                },
            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'showFooter'=>true
        ],
    ]); ?>

</div>
