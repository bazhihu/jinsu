<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;


/**
 * @var yii\web\View $this
 * @var backend\models\AdminUser $model
 */

$this->title = '修改密码';
?>

<div class="panel panel-info" style="margin: 8%;">
    <div class="panel-body">
        <div class="admin-user-reset">
            <div class="page-header">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="admin-user-form">
                <?php
                $form = ActiveForm::begin([
                    'type'=>ActiveForm::TYPE_HORIZONTAL
                ]);
                echo Form::widget([
                    'model'         => $model,
                    'form'          => $form,
                    'columns'       => 1,
                    'attributes'    => [
                        'oldPwd'=>[
                            'type'=> Form::INPUT_PASSWORD,
                            'options'=>[
                                'placeholder'=>'原始密码',
                                'maxlength'=>255,
                                'id'=>'admin_username',
                            ],
                            'label'=>'原密码',
                        ],
                        'password'=>[
                            'type'=> Form::INPUT_PASSWORD,
                            'options'=>[
                                'placeholder'=>'请输入新密码',
                                'maxlength'=>255,
                                'minlength'=>6
                            ]
                        ],
                        'pwd'=>[
                            'type'=> Form::INPUT_PASSWORD,
                            'options'=>[
                                'placeholder'=>'请再次输入密码',
                                'maxlength'=>255,
                                'minlength'=>6
                            ]
                        ],
                    ]
                ]);
                ?>

                <?php
                echo Html::submitButton(Yii::t('app', '确认'), ['class' => $model->isNewRecord ? 'btn btn-lg btn-success col-sm-offset-2' : 'btn btn-lg btn-primary col-sm-offset-2']);
                ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
