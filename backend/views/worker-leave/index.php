<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '护工请假列表';
?>
<style>
    .panel-body .form-group{
        float:left;
        margin:5px;
    }
    .field-workerleavesearch-fromdate{
        width:250px
    }
    .field-workerleavesearch-todate{
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
                <h3 class="panel-title">检索</h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
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
                    'worker_name',
                    [
                        'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
                    ]
                )->input('text',['placeholder'=>'请输入护工姓名...'])->label('姓名') ?>
                <?= $form->field(
                    $searchModel,
                    'worker_id',
                    [
                        'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
                    ]
                )->input('text',['placeholder'=>'请输入护工编号...'])->label('工号') ?>
                <?= $form->field(
                    $searchModel,
                    'status'
                )->dropDownList(['1'=>'请假中','10'=>'请假结束'],['prompt'=>'选择'])->label("状态") ?>

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
            'worker_id',
            'worker_name',
            'start_time',
            'end_time',
            'real_end',
            'leave_cause',
            [
                'header'=>'状态',
                'attribute'=>'status',
                'value'=>function($model){
                    if($model->status==10){
                        return '请假结束';
                    } else {
                        return '请假中';
                    }
                }
            ],
            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'buttons' => [
                    'end' => function ($url, $model) {
                        return $model->status==10?"已结束":Html::button('结束', [
                                'title' => Yii::t('yii', '结束'),
                                'class' => 'btn btn-danger jsEndLeave',//jsNix
                                'data-url'=>$url,
                            ]);
                    },
                ],
                'template'=>'{end}',
            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            /*'before'=>
            Html::a('<i class="glyphicon glyphicon-plus"></i> 添加请假信息', ['worker-leave/create'], ['class' => 'btn btn-success'][
                'data-url'=>Yii::$app->urlManager->createUrl(['worker/leave-create']),
                'class'=>'btn btn-sm btn-success myModal jsLeaveCreate',
                'data-toggle'=>'modal',
                'data-target'=>'#myModal',
            ]),*/
            'showFooter'=>true
        ],
    ]); ?>
</div>
<?php \yii\bootstrap\Modal::begin([
    'header' => '<strong>结束请假</strong>',
    'id'=>'finishLeaveModal',
    'size'=>'modal-lg',
]);?>
<div id="finishLeaveModalContent">加载中...</div>
<?php \yii\bootstrap\Modal::end();?>

<script>
    //结束请假
    $('body').on('click', 'button.jsEndLeave', function () {
        var url = $(this).attr('data-url');
        $("#finishLeaveModalContent").load(url);
        $('#finishLeaveModal').modal({"show":true});
    });
</script>