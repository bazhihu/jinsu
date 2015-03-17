<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '登录-优爱医护管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<link href="/css/login.css" rel="stylesheet">
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>

    <!--<p>Please fill out the following fields to login:</p>-->

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username')->label('用户名') ?>
                <?= $form->field($model, 'password')->passwordInput()->label('密码') ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>

</div>
