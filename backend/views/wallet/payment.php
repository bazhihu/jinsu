<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '提现记录';
$this->registerJsFile('js/wallet.js', ['position'=>yii\web\View::POS_END]);
?>
<div class="wallet-user-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <!--?php  echo $this->render('_search', ['model' => $searchModel]); ?-->
    <div class="wallet-apply-list" style="padding: 25px">

        <?php $form = ActiveForm::begin([
            'action' => ['payment'],
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
        )->input('text',['placeholder'=>'请输入用户账号...','style'=>'width:400px'])->label('用户账号')?>

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
                'header'=>'交易流水号',
                'attribute'=>'withdrawcash_no',
            ],
            [
                'header'=>'用户账号',
                'attribute'=>'uid',
                'value'=>function($model){
                    return \backend\Models\User::findOne(['id'=>$model->uid])?\backend\Models\User::findOne(['id'=>$model->uid])->mobile:"";
                },
            ],
            [
                'header'=>'医院名称',
                'attribute'=>'payee_hospital',
                'value'=>function($model){
                    return \backend\models\Hospitals::findOne(['id'=>$model->payee_hospital])->name;
                },
            ],
            [
                'header'=>'姓名',
                'attribute'=>'payee_name',
            ],
            [
                'header'=>'身份证号码',
                'attribute'=>'payee_id_card',
            ],
            [
                'header'=>'提现金额',
                'attribute'=>'money',
            ],
            [
                'header'=>'申请状态',
                'attribute'=>'status',
                'value'=>function($model){
                    if($model->status == '3') {
                        return '已付款';
                    }elseif($model->status == '2'){
                        return '待付款';
                    }elseif($model->status == '1'){
                        return '已拒绝';
                    }else{
                        return '待审核';
                    }
                }
            ],
            [
                'header'=>'申请操作人',
                'attribute'=>'admin_uid_apply',
                'value'=>function($model){
                    return \backend\models\AdminUser::findOne(['admin_uid'=>$model->admin_uid_apply])->username;
                }
            ],
            [
                'header'=>'申请时间',
                'attribute'=>'time_apply',

            ],
            [
                'header'=>'确认人',
                'attribute'=>'admin_uid_audit',
                'value'=>function($model){
                    return \backend\models\AdminUser::findOne(['admin_uid'=>$model->admin_uid_audit])->username;
                }
            ],[
                'header'=>'确认时间',
                'attribute'=>'time_audit',
            ],[
                'header'=>'付款人',
                'attribute'=>'admin_uid_payment',
                'value'=>function($model){
                    return \backend\models\AdminUser::findOne(['admin_uid'=>$model->admin_uid_payment])->username;
                }
            ],[
                'header'=>'付款时间',
                'attribute'=>'time_payment',
            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'showFooter'=>true
        ],
    ]); ?>

</div>
