<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var backend\models\AdminUser $model
 */

$this->title = '编辑用户: ' . ' ' . $model->username;
$this->registerJsFile('js/admin.js', ['position'=>yii\web\View::POS_END]);
?>

<div class="panel panel-info"  style="margin: 8%;">
    <div class="panel-heading">
        <h3 class="panel-title"></h3>
    </div>
    <div class="panel-body">
        <div class="admin-user-update">

            <h1><?= Html::encode($this->title) ?></h1>
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
                        'created_id'=>[
                            'type'=> Form::INPUT_HIDDEN,
                            'label'=>false,
                        ],
                        'username'=>[
                            'type'=> Form::INPUT_TEXT,
                            'options'=>[
                                'placeholder'=>'请输入帐号',
                                'maxlength'=>255,
                                'id'=>'admin_username',
                                'readonly'=>'readonly'
                            ]
                        ],
                        'staff_name'=>[
                            'type'=> Form::INPUT_TEXT,
                            'options'=>[
                                'placeholder'=>'请输入员工姓名',
                                'maxlength'=>255 ,
                                'readonly'=>'readonly'
                            ]
                        ],
                        'created_name'=>[
                            'type'=> Form::INPUT_TEXT,
                            'options'=>[
                                'maxlength'=>255 ,
                                'readonly'=>'readonly',
                            ],
                            'label'=>'创建人',
                        ],
                        'staff_role'=>[
                            'type'=> Form::INPUT_DROPDOWN_LIST,
                            'items'=>\backend\models\AdminUser::getRoles($model->admin_uid),
                            'options'=>[
                                'prompt'=>'选择'
                            ]
                        ],
                       /*'hospital_id'=>[
                            'type'=> Form::INPUT_DROPDOWN_LIST,
                            'items'=>\backend\models\Hospitals::getList(),
                            'options'=>[
                                'prompt'=>'选择',
                            ]
                        ],*/
                    ]
                ]);?>
                <div class="hospitals_hide
                    <?php if($model->staff_role != \backend\models\AdminUser::BACKOFFICESTAFF){echo 'hide';}?>">
                <?php
                echo $form->field($model, 'hospital_id')->widget(Select2::classname(), [
                    'data' => \backend\models\Hospitals::getList(),
                    'options' => [
                        'placeholder' => '请选择医院',
                        'style'=>'width:100%;'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);?>
            </div>
                <?php
                echo $form->field($model, 'phone', [
                    'addon' => [
                        'prepend' => [
                            'content'=>'<i class="glyphicon glyphicon-phone"></i>'
                        ],
                        'options'=>[
                            'placeholder'=>'请输入手机号',
                            'maxlength'=>11
                        ]
                    ],
                ]);
                echo Html::submitButton($model->isNewRecord ? Yii::t('app', '注册') : Yii::t('app', '修改'), ['class' => $model->isNewRecord ? 'btn btn-lg btn-success col-sm-offset-2' : 'btn btn-lg btn-primary col-sm-offset-2']);
                echo Html::resetButton('重置', ['class' => 'btn btn-primary btn-lg col-sm-offset-6', 'name' => 'reset-button']);
                ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

