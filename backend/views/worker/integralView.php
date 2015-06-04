<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '护工积分列表';
?>
<style>
    .panel-body .form-group{
        float:left;
        margin:5px;
    }
    .field-workerintegralsearch-fromdate{
        width:250px
    }
    .field-workerintegralsearch-todate{
        width:250px
    }
</style>
<div class="worker-leave-index">

    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="worker-leave-list">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">护工信息</h3>
            </div>
            <div class="panel-body">
                <span class="btn-lg">姓名：<?=\backend\models\Worker::findOne(['worker_id'=>$id])->name?></span>
                <span class="btn-lg">工号：<?=$id?></span>
            </div>
        </div>
    </div>


        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">检索</h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['integral-view','id'=>$id],
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
                )->label('时间范围');
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
                )->label('至');
                ?>
                <?= $form->field(
                    $searchModel,
                    'type'
                )->dropDownList(\backend\models\WorkerIntegral::$IntegralType,['prompt'=>'选择'])->label("状态") ?>

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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'time',
            [
                'header'=>'类别',
                'attribute'=>'type',
                'value'=>function($model){
                    return \backend\models\WorkerIntegral::$IntegralType[$model->type];
                },
            ],
            'integral',
            'cumulative',
            'remarks',
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'showFooter'=>true
        ],
    ]); ?>
</div>