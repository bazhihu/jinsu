<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '护工工资卡';
//$this->registerJsFile('js/wallet.js', ['position'=>yii\web\View::POS_END]);
?>
<style>
    .panel-body .form-group{
        float:left;
        margin:5px;
    }
    .field-workercardsearch-fromdate{
        width:270px
    }
    .field-workercardsearch-todate{
        width:270px
    }
</style>
<div class="worker-card-index">

    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="worker-card-list">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">检索</h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['card-index'],
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
            'add_date',
            'worker_name',
            'identity_card',
            [
                'header'=>'开户行',
                'attribute'=>'bank',
                'value'=>function($model){
                    return \backend\models\WorkerCard::$_BANK[$model->bank];
                },
            ],
            'bank_card',
            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'buttons' => [
                    'apply' => function ($url, $model) {
                        return $model->status?"":Html::button('删除', [
                                'title' => Yii::t('yii', '删除'),
                                'class' => 'btn btn-danger myModal',//jsNix
                                'id' => 'cardDelete',
                                'data-url'=>Yii::$app->urlManager->createUrl(['worker/card-delete'],['id'=>$model->id]),
                                'data-toggle'=>'modal',
                                'data-target'=>'#myModal',
                            ]);
                    },
                ],
                'template'=>'{apply}',
            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'showFooter'=>true
        ],
    ]); ?>
</div>
<script>
    //关闭帐号
    $('body').on('click', '#cardDelete', function () {
        if(!confirm('确认执行此操作吗？')){
            return false;
        }
        var num = $(this);
        var key = num.parent().parent().attr('data-key');
        var url = $(this).attr('data-url');
        $.ajax({
            type    :'POST',
            cache   : false,
            url     : url,
            data    : {'id':key},
            dataType : 'json' ,
            success : function(response) {
                if(response.code=='200'){
                    location.reload();
                } else {
                    alert(response.message);
                }
            }
        });
        return false;
    });
</script>