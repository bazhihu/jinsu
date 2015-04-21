<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '提现申请';
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
<div class="wallet-user-detail-index">

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
                    'action' => ['cash-list'],
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
                        'options' => [
                            'placeholder' => '请输入开始时间 ...',
                        ],
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
                        'options' => [
                            'placeholder' => '请输入结束时间 ...',
                        ],
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
                <?= $form->field(
                    $searchModel,
                    'status',
                    [
                        'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
                    ]
                )->dropDownList(['0'=>'提现申请中','1'=>'已拒绝','2'=>'已同意'],['prompt'=>'选择','style'=>'width:280px'])->label('申请状态') ?>

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
            'time_apply',
            [
                'header'=>'用户账号',
                'attribute'=>'mobile',
                'value'=>function($model){
                    return $model->mobile?substr_replace($model->mobile,'****',3,4):'';
                }
            ],
            [
                'attribute'=>'money',
                'value'=>function($model){
                    return $model->money;
                }
            ],
            [
                'header'=>'申请状态',
                'attribute'=>'status',
                'value'=>function($model){
                    if($model->status == '3') {
                        return '已同意';
                    }elseif($model->status == '2'){
                        return '已同意';
                    }elseif($model->status == '1'){
                        return '已拒绝';
                    }else{
                        return '待审核';
                    }
                },
            ],
            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                    'buttons' => [
                    'apply' => function ($url, $model) {
                        return $model->status?"":Html::button('同意', [
                            'title' => Yii::t('yii', '同意'),
                            'class' => 'btn btn-default jsPass',
                            'data-url'=>Yii::$app->urlManager->createUrl(['wallet/ajax-cash','uid' => $model->uid]),
                        ]).Html::button('拒绝', [
                            'title' => Yii::t('yii', '拒绝'),
                            'class' => 'btn btn-danger myModal',//jsNix
                            'data-url'=>Yii::$app->urlManager->createUrl(['wallet/ajax-cash','uid' => $model->uid]),
                            'data-toggle'=>'modal',
                            'data-target'=>'#myModal',
                        ]);
                    },
                ],
                'template'=>'{apply}',
            ],
            [
                'header'=>'操作人',
                'attribute'=>'admin_uid_audit',
                'value'=>function($model){
                    return \backend\models\AdminUser::getInfo($model->admin_uid_audit);
                },
            ],
            'remark_audit',
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'showFooter'=>true
        ],
    ]); ?>

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">拒绝原因</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" class="refusal" data-url="">
                <textarea class="form-control rejectReason" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary jsNix">保存</button>
            </div>
        </div>
    </div>
</div>
