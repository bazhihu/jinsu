<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;
use kartik\detail\DetailView;


/* @var $this yii\web\View */
/* @var $model backend\models\WalletUserDetail */

$this->title = '申请提现确认-用户信息核对';
?>
<div class="wallet-user-detail-create">

    <div class="panel panel-info" style="margin: 50px 200px 0 200px">
        <div class="panel-heading">
            <h1 class="panel-title" id="panel-title"><?= Html::encode($this->title) ?><a class="anchorjs-link" href="#panel-title"><span class="anchorjs-icon"></span></a></h1>
        </div>
        <div class="panel-body">
            <label><big>用户信息</big></label><br/>
            <?= DetailView::widget([
                'model'=>$user,
                'condensed'=>true,
                'hover'=>true,
                'mode'=>DetailView::MODE_VIEW,
                'attributes'=>[
                    [
                        'attribute'=>'uid',
                        'value'=>$user->uid?\backend\models\User::findOne(['id'=>$user->uid])->mobile:'无',
                    ],
                    [
                        'attribute'=>'money',
                        'value'=>$user->money?$user->money.'元人民币':'0'.'元人民币',
                    ],
                ]
            ]);?>

        </div>
        <div class="panel-body">
            <label><big>取款信息</big></label>
            <?php
            $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);

            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 1,
                'attributes' => [
                    'uid'=>[
                        'type'=> Form::INPUT_HIDDEN,
                        'options'=>[
                            'value'=>$user->uid,
                        ],
                        'label'=>false,
                    ],
                    'money'=>[
                        'type'=> Form::INPUT_TEXT,
                        'options'=>[
                            'value'=>$user->money?$user->money:0,
                            'disabled'=>true,
                        ]
                    ],
                    'money'=>[
                        'type'=> Form::INPUT_HIDDEN,
                        'options'=>[
                            'value'=>$user->money?$user->money:0,
                        ],
                        'label'=>false,
                    ],
                    'payee_type'=>[
                        'type'=> Form::INPUT_DROPDOWN_LIST,
                        'items'=>array(
                            '0'=>'现金',
                        ),
                    ],
                    'payee_time'=>[
                        'type'=>Form::INPUT_WIDGET,
                        'widgetClass'=>'\kartik\widgets\DatePicker',
                        'hint'=>'请输入提现时间',
                        'options'=>[
                            'options'=>['placeholder'=>'开始时间...'],
                            'pluginOptions'=>[
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]
                    ],
                    'payee_name'=>[
                        'type'=> Form::INPUT_TEXT,
                        'options'=>[
                            'placeholder'=>'输入收款人姓名...',
                            'maxlength'=>50
                        ]
                    ],
                    'payee_id_card'=>[
                        'type'=> Form::INPUT_TEXT,
                        'options'=>[
                            'placeholder'=>'输入收款人身份证...',
                            'maxlength'=>50
                        ]
                    ],
                ]
            ]);
            echo $form->field($model, 'payee_hospital')->widget(Select2::classname(), [
                'data' => \backend\models\Hospitals::getList(),
                'options' => [
                    'placeholder' => '请选择医院',
                    'style'=>'width:100%'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('医院');
            echo Html::submitButton(Yii::t('app', '完成'), ['class' => 'btn btn-success btn-lg col-sm-offset-6']);
            ActiveForm::end(); ?>
        </div>
    </div>
</div>
