<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;


/* @var $this yii\web\View */
/* @var $model backend\models\WalletUserDetail */

$this->title = '申请提现确认-用户信息核对';
?>
<div class="wallet-user-detail-create">

    <div class="panel panel-info" style="margin: 111px">
        <div class="panel-heading">
            <h1 class="panel-title" id="panel-title"><?= Html::encode($this->title) ?><a class="anchorjs-link" href="#panel-title"><span class="anchorjs-icon"></span></a></h1>
        </div>
        <div class="panel-body">
            <label><big>用户信息</big></label><br/>


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
                    'money'=>[
                        'type'=> Form::INPUT_TEXT,
                        'options'=>[
                            'placeholder'=>'输入金额...',
                            'maxlength'=>10
                        ]
                    ],
                    'payee_type'=>[
                        'type'=> Form::INPUT_DROPDOWN_LIST,
                        'items'=>array(
                            '0'=>'现金',
                        ),
                    ],
                    'payee_time'=>[
                        'type'=> Form::INPUT_WIDGET,
                        'widgetClass'=>DateControl::classname(),
                        'options'=>[
                            'type'=>DateControl::FORMAT_DATETIME
                        ]
                    ],
                    'payee_hospital'=>[
                        'type'=> Form::INPUT_TEXT,
                        'options'=>[
                            'placeholder'=>'输入将要提现的医院...',
                            'maxlength'=>255
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
            echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
            ActiveForm::end(); ?>
        </div>
    </div>
</div>
