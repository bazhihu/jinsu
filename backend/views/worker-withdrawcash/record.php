<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '护工提现记录';
?>
<style>
    .panel-body .form-group{
        float:left;
        margin:5px;
    }
    .field-workerwithdrawcashsearch-fromdate{
        width:250px
    }
    .field-workerwithdrawcashsearch-todate{
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
                    'action' => ['record'],
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
                )->input('text',['placeholder'=>'请输入护工编号...'])->label('姓名') ?>

                <?= $form->field($searchModel, 'city_id')->widget(\kartik\widgets\Select2::classname(),[
                    'data' => \backend\models\City::getList(null, 3),
                    'options' => ['placeholder' => '请选择','style'=>'width:110px'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('城市')?>

                <?= $form->field($searchModel, 'payee_hospital')->widget(\kartik\depdrop\DepDrop::className(),[
                    'type' => \kartik\depdrop\DepDrop::TYPE_SELECT2,
                    'data'=> $searchModel->city_id ? \backend\models\Hospitals::getList(0, $searchModel->city_id):[''=>'请选择'],
                    'options' => ['placeholder' => '请选择','style'=>'width:280px'],
                    'pluginOptions'=>[
                        'depends'=>['workerwithdrawcashsearch-city_id'],
                        'placeholder'=>'请选择',
                        'url'=>\yii\helpers\Url::to(['hospitals/list/']),
                    ]
                ])?>

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
            'withdrawcash_no',
            'worker_id',
            'worker_name',
            [
                'header'=>'所属医院',
                'attribute'=>'payee_hospital',
                'value'=>function($model){
                    return $model->payee_hospital?\backend\models\Hospitals::getName($model->payee_hospital):'';
                },
            ],
            'money',
            [
                'header'=>'状态',
                'attribute'=>'status',
                'value'=>function($model){
                    if($model->status ==0){
                        return '待审核';
                    }else if($model->status ==1){
                        return '已拒绝';
                    }else if($model->status ==2){
                        return '已同意';
                    }else if($model->status ==3){
                        return '已付款';
                    }
                }
            ],
            'time_apply',
            /*['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'buttons' => [
                    'pay' => function ($url, $model) {
                        return $model->status==0?Html::button('同意', [
                            'title' => Yii::t('yii', '同意'),
                            'class' => 'btn btn-default jsAgree',
                            'data-url'=>Yii::$app->urlManager->createUrl(['worker-withdrawcash/agree']),
                        ]).Html::button('拒绝', [
                            'title' => Yii::t('yii', '拒绝'),
                            'class' => 'btn btn-default jsRefuse',
                            'data-url'=>Yii::$app->urlManager->createUrl(['worker-withdrawcash/refuse']),
                        ]):"";
                    },
                ],
                'template'=>'{pay}',
            ],*/
            'remark_apply'
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'showFooter'=>true
        ],
    ]); ?>
</div>

<script>
    //同意申请
    $('body').on('click', 'button.jsAgree', function () {
        var it = $(this),
            url = it.attr('data-url'),
            id = it.parent().parent().attr('data-key');
        $.ajax({
            type    : "POST",
            dataType: "json",
            async   :false,
            cache   :false,
            timeout :30000,
            url     : url,
            data    : {'id':id},
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
                    it.parent().prev().html('已同意');
                    it.parent().empty();
                }else{
                    alert(json.msg);
                }
            }
        });
    });
    //拒绝申请
    $('body').on('click', 'button.jsRefuse', function () {
        var it = $(this),
            url = it.attr('data-url'),
            id = it.parent().parent().attr('data-key');
        $.ajax({
            type    : "POST",
            dataType: "json",
            async   :false,
            cache   :false,
            timeout :30000,
            url     : url,
            data    : {'id':id},
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
                    it.parent().prev().html('已拒绝');
                    it.parent().empty();
                }else{
                    alert(json.msg);
                }
            }
        });
    });
</script>