<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '护工提现';
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
                    'action' => ['index'],
                    'method' => 'get',

                    'type' => ActiveForm::TYPE_VERTICAL,
                    'formConfig' => [
                        'showLabels' => true,
                    ],
                ]); ?>
                <?php
                echo $form->field($searchModel,'fromDate')->widget(
                    DatePicker::classname(),
                    [
                        'options' => ['placeholder' => '请输入开始时间 ...','style'=>'width:130px'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]
                )->label('时间范围');

                echo $form->field($searchModel,'toDate')->widget(DatePicker::classname(),
                    [
                        'options' => ['placeholder' => '请输入结束时间 ...','style'=>'width:130px'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]
                )->label('至');
                ?>
                <?= $form->field($searchModel,'worker_name')
                    ->input('text',['placeholder'=>'请输入姓名...','style'=>'width:110px'])
                    ->label('姓名')
                ?>

                <?= $form->field($searchModel,'worker_id')
                    ->input('text',['placeholder'=>'请输入编号...','style'=>'width:110px'])
                    ->label('编号') ?>

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
                <?= $form->field(
                    $searchModel,
                    'status'
                )->dropDownList(['0'=>'待审核','1'=>'已拒绝','2'=>'待付款','3'=>'已付款'],['prompt'=>'选择'])->label("状态") ?>
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
            [
                'class'=>'kartik\grid\CheckboxColumn',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
            ],
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
            /*'payee_id_card',
            'payee_bank_card',
            'payee_bank_sub',*/
            'money',
            'time_apply',
            'time_audit',
            [
                'header'=>'审核者',
                'attribute'=>'admin_uid_audit',
                'value'=>function($model){
                    return $model->admin_uid_audit?\backend\models\AdminUser::getInfo($model->admin_uid_audit):'';
                },
            ],
            [
                'header'=>'付款者',
                'attribute'=>'admin_uid_payment',
                'value'=>function($model){
                    return $model->admin_uid_payment?\backend\models\AdminUser::getInfo($model->admin_uid_payment):'';
                },
            ],
            'time_payment',
            'remark_audit',
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
            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'buttons' => [
                    'agree' => function ($url, $model) {
                        return $model->status==0?Html::button('同意', [
                                'title' => Yii::t('yii', '同意'),
                                'class' => 'btn btn-primary jsAgree',
                                'data-url'=>Yii::$app->urlManager->createUrl(['worker-withdrawcash/agree']),
                            ]).Html::button('拒绝', [
                                'title' => Yii::t('yii', '拒绝'),
                                'class' => 'btn btn-danger myModal',
                                'data-url'=>Yii::$app->urlManager->createUrl(['worker-withdrawcash/refuse']),
                                'data-toggle'=>'modal',
                                'data-target'=>'#myModal',
                            ]):"";
                    },
                ],
                'template'=>'{agree}',
            ],
        ],
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
                <button type="button" class="btn btn-primary jsRefuse">保存</button>
            </div>
        </div>
    </div>
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
                    alert('操作成功');
                    location.reload();
                }else{
                    alert(json.msg);
                }
            }
        });
    });
    //拒绝申请
    $('body').on('click', 'button.jsRefuse', function () {
        var id = $('.refusal').val(),
            url = $('.refusal').attr('data-url'),
            reason = $('.rejectReason').val();
        $.ajax({
            type    : "POST",
            dataType: "json",
            async   :false,
            cache   :false,
            timeout :30000,
            url     : url,
            data    : {'id':id,'reason':reason},
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
    });
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
    $('body').on('click', 'button.myModal', function () {
        var myModal = $(this);

        var dataUrl = myModal.attr('data-url'),
            uid = myModal.parent().parent().attr('data-key');

        $('.refusal').val(uid);
        $('.refusal').attr('data-url',dataUrl);
    });
</script>