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

<div class="admin-user-search" style="padding-bottom: 40px;border-bottom: 1px solid #eee;border-bottom-width: 1px;border-bottom-style: solid;border-bottom-color: rgb(238, 238, 238);">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',

        'type' => ActiveForm::TYPE_INLINE,
        'formConfig'=>[
            'labelSpan'=>1
        ],
    ]); ?>

    <?= $form->field(
        $model,
        'username',
        [
            'labelOptions'=>['class'=>'col-sm-4 col-md-4 col-lg-4']
        ]
    )->input('text',['placeholder'=>'请输入帐号...'])->label("帐号") ?>
    <?= $form->field(
        $model,
        'staff_name',
        [
            'labelOptions'=> ['class'=>'col-sm-4 col-md-4 col-lg-4']
        ]
    )->input('text',['placeholder'=>'请输入员工姓名...'])->label("员工姓名") ?>
    <!--?= $form->field(
        $model,
        'staff_id',
        [
            'labelOptions'=> ['class'=>'col-sm-4 col-md-4 col-lg-4']
        ]
    )->input('text',['placeholder'=>'请输入员工号...'])->label("员工号") ?-->
    <?= $form->field(
        $model,
        'staff_role',
        [
            'labelOptions'=> ['class'=>'col-sm-4 col-md-4 col-lg-5']
        ]
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
        'status',
        [
            'labelOptions'=> ['class'=>'col-sm-5 col-md-5 col-lg-5']
        ]
    )->dropDownList(['10'=>'正常','0'=>'关闭'],['prompt'=>'选择'])->label("状态") ?>
    <?= $form->field(
        $model,
        'created_id',
        [
            'labelOptions'=> ['class'=>'col-sm-4 col-md-4 col-lg-4']
        ]
    )->input('text',['placeholder'=>'请输入创建人...'])->label('管理员') ?>
    <div class="form-group" style="padding-top: 25px">
        <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
