<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '护工提现支付';
?>
<style>
    .panel-body .form-group{
        float:left;
        margin:5px;
    }
    .field-workerwithdrawcashsearch-paystartdate{
        width:250px
    }
    .field-workerwithdrawcashsearch-payenddate{
        width:250px
    }
</style>
<div class="worker-withdrawcash-index">

    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="worker-withdrawcash-list">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">检索</h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['payment'],
                    'method' => 'get',

                    'type' => ActiveForm::TYPE_VERTICAL,
                    'formConfig' => [
                        'showLabels' => true,
                    ],
                ]); ?>
                <?php
                echo $form->field(
                    $searchModel,
                    'payStartDate'
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
                    'payEndDate'
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
                    'status'
                )->dropDownList(['2'=>'待付款','3'=>'已付款'],['prompt'=>'选择'])->label("状态") ?>

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

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class'=>'kartik\grid\CheckboxColumn',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
            ],
            ['class' => 'yii\grid\SerialColumn'],
            'time_audit',
            'worker_id',
            'worker_name',
            'money',
            [
                'header'=>'所属医院',
                'attribute'=>'payee_hospital',
                'value'=>function($model){
                    return $model->payee_hospital?\backend\models\Hospitals::getName($model->payee_hospital):'';
                },
            ],
            'payee_bank_card',
            'payee_id_card',
            [
                'header'=>'状态',
                'attribute'=>'status',
                'value'=>function($model){
                    if($model->status ==3){
                        return '已付款';
                    }else{
                        return '待付款';
                    }
                },
            ],
            'remark_apply'
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'showFooter'=>true,
            'before'=>
                Html::button('付款', [
                    'title' => Yii::t('yii', '付款'),
                    'class' => 'btn btn-success jsPay',
                    'data-url'=>Yii::$app->urlManager->createUrl(['worker-withdrawcash/pay']),
                ]),
        ],
    ]); ?>
</div>

<script>
    $('body').on('click', 'button.jsPay', function () {
        var it = $(this),
            url = it.attr('data-url'),
            id = it.parent().parent().attr('data-key'),
            box = $("input[name='selection[]']:checked"),
            arr = new Array();
            box.each(function(){
                var it = $(this);
                arr.push(it.val());
            });
        if(arr.length != 0){
            $.ajax({
                 type    : "POST",
                 dataType: "json",
                 async   :false,
                 cache   :false,
                 timeout :30000,
                 url     : url,
                 data    : {'id':arr},
                 error:function(jqXHR, textStatus, errorThrown){
                     switch (jqXHR.status){
                         case(500):
                            alert("服务器系统内部错误");
                            break;
                         case(401):
                            alert("未登录");
                            break;
                         case(403):
                            alert("无权限执行此操作");
                            break;
                         case(408):
                            alert("请求超时");
                            break;
                         default:
                            alert("未知错误");
                         }
                     },
                     success: function(json){
                     if(json.code == '200'){
                         alert('操作成功');
                         location.reload();
                     }else{
                         alert(json.msg);
                     }
                 }
             });
        }else{
            alert('无任何勾选！');
        }
    });
</script>