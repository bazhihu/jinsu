<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '交易明细';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .panel-body .form-group{
        float:left;
        margin:5px;
    }
    .field-walletuserdetailsearch-fromdate{
        width:270px
    }
    .field-walletuserdetailsearch-todate{
        width:270px
    }
</style>
<div class="wallet-user-detail-index">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <!-- start -->
    <div class="wallet-user-detail-search">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">检索</h3>
            </div>
            <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'action' => ['debit-records'],
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
                DateTimePicker::classname(),
                [
                    'options' => ['placeholder' => '请输入开始时间 ...'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'todayHighlight' => true,
                        'format' => 'yyyy-mm-dd hh:ii:ss'
                    ]
                ]
            )->label('起始时间');
            echo $form->field(
                $searchModel,
                'toDate'

            )->widget(
                DateTimePicker::classname(),
                [
                    'options' => ['placeholder' => '请输入结束时间 ...'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'todayHighlight' => true,
                        'format' => 'yyyy-mm-dd hh:ii:ss'
                    ]
                ]
            )->label('结束时间');

            echo $form->field($searchModel, 'mobile')
                ->input('text',['placeholder'=>'请输入用户账号...','style'=>'width:200px'])
                ->label('用户账号');

            echo $form->field($searchModel,'order_no')
                 ->input('text',['placeholder'=>'请输入订单编号...','style'=>'width:180px'])
                 ->label('订单编号');

            echo $form->field($searchModel,'detail_type')
                ->dropDownList(['1'=>'消费','2'=>'充值','3'=>'提现','4'=>'退款'],['prompt'=>'选择','style'=>'width:100px'])
                ->label('交易类型');

            echo $form->field($searchModel,'pay_from')
                ->dropDownList($searchModel::$payFromLabels,['prompt'=>'选择','style'=>'width:100px'])
                ->label('充值方式');
                ?>
            <div class="form-group" style="padding-top: 25px">
                <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <!-- end -->
    <p>
        <!--?= Html::a('Create Wallet User Detail', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'detail_time',
                'format' => 'text',
                'label' => '交易时间',
            ],
            [
                'attribute'=>'order_no',
                'format' => 'text',
                'label' => '订单编号',
            ],
            [
                'attribute'=>'mobile',
                'label' => '帐号',
                'value'=>function($model){
                    return $model->mobile?substr_replace($model->mobile,'****',3,4):'';
                }
            ],
            [
                'attribute'=>'detail_type',
                'format' => 'text',
                'label' => '交易类型',
                'value'=>function($model){
                    if($model->detail_type == 1){
                        return '消费';
                    }elseif($model->detail_type == 2){
                        return '充值';
                    }elseif($model->detail_type == 3){
                        return '提现';
                    }elseif($model->detail_type == 4){
                        return '退款';
                    }
                },
            ],
            [
                'attribute'=>'pay_from',
                'format' => 'text',
                'label' => '充值方式',
                'value' => function($model) {
                    return $model::$payFromLabels[$model->pay_from];
                }
            ],
            [
                'attribute'=>'detail_money',
                'label' => '金额(元)',
                'value'=>function($model){
                    /*if($model->detail_type == 1){
                        $symbol = '-';
                    }elseif($model->detail_type == 2){
                        $symbol = '+';
                    }elseif($model->detail_type == 3){
                        $symbol = '-';
                    }elseif($model->detail_type == 4){
                        $symbol = '+';
                    }*/
                    return /*$symbol.*/$model->detail_money;
                }
            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'showFooter'=>false
        ],
        'panelBeforeTemplate' => '<div class="pull-right"><div class="btn-toolbar kv-grid-toolbar" role="toolbar">{toolbar}</div></div><strong>合计：'.$searchModel->total.'元</strong><div class="clearfix"></div>'
    ]);
    ?>

</div>
