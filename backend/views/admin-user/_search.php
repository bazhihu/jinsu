<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var backend\models\AdminUserSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<style>
    .panel-body .form-group{
        float:left;
        margin:5px;
    }
</style>
<div class="admin-user-search" style="padding-bottom: 40px;border-bottom: 1px solid #eee;border-bottom-width: 1px;border-bottom-style: solid;border-bottom-color: rgb(238, 238, 238);">
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

            <?= $form->field(
                $model,
                'username'
            )->input('text',['placeholder'=>'请输入帐号...'])->label("帐号") ?>
            <?= $form->field(
                $model,
                'staff_name'
            )->input('text',['placeholder'=>'请输入员工姓名...'])->label("员工姓名") ?>
            <?= $form->field(
                $model,
                'staff_role'
            )->widget(Select2::classname(),
                [
                    'data' =>\backend\models\AdminUser::getRoles(),
                    'options' => [
                        'placeholder' => '请选择职位名称',
                        'style'=>'width:200px'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]
            )->label('员工职位');?>
            <?= $form->field(
                $model,
                'status'
            )->dropDownList(['10'=>'正常','0'=>'关闭'],['prompt'=>'选择'])->label("状态") ?>
            <?= $form->field(
                $model,
                'created_id'
            )->input('text',['placeholder'=>'请输入创建人...'])->label('管理员') ?>
            <div class="form-group" style="padding-top: 25px">
                <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>