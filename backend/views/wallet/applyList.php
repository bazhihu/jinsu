<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '提现申请';
$this->registerJsFile('js/wallet.js', ['position'=>yii\web\View::POS_END]);
?>
<div class="wallet-user-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <!--?php  echo $this->render('_search', ['model' => $searchModel]); ?-->
    <div class="wallet-apply-list" style="padding: 25px">

        <?php $form = ActiveForm::begin([
            'action' => ['apply-list'],
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
            'status',
            [
                'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
            ]
        )->dropDownList(['0'=>'提现申请中','1'=>'已同意','2'=>'已拒绝'],['prompt'=>'选择','style'=>'width:300px'])->label('申请状态') ?>

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
            [
                'header'=>'申请状态',
                'attribute'=>'status',
                'value'=>function($model){
                    if($model->status == '3') {
                        return '付款成功';
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
                            'class' => 'btn btn-default jsapplypass',
                            'data-url'=>$url,
                        ]).Html::button('拒绝', [
                            'title' => Yii::t('yii', '拒绝'),
                            'class' => 'btn btn-danger jsapplynix',
                            'data-url'=>$url,
                        ]);
                    },
                ],
                'template'=>'{apply}',
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
