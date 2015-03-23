<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\AdminUserSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="admin-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
//        'fieldConfig'=>[
//            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
//        ],
    ]); ?>

    <!--?= $form->field($model, 'id') ?-->

    <?= $form->field($model, 'username')->input('text',['placeholder'=>'请输入帐号...','style'=>'width:50%']) ?>

    <?= $form->field($model, 'staff_name')->input('text',['placeholder'=>'请输入员工姓名...','style'=>'width:50%']) ?>

    <?= $form->field($model, 'staff_id')->input('text',['placeholder'=>'请输入员工号...','style'=>'width:50%']) ?>

    <?= $form->field($model, 'staff_role')->input('text',['placeholder'=>'请输入员工职位...','style'=>'width:50%']) ?>

    <?= $form->field($model, 'status')->dropDownList(['10'=>'正常','0'=>'关闭'],['prompt'=>'选择','style'=>'width:50%']) ?>

    <?= $form->field($model, 'created_id')->input('text',['placeholder'=>'请输入创建人...','style'=>'width:50%']) ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
