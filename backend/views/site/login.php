<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '登录-优爱医护管理后台';
$this->params['breadcrumbs'][] = $this->title;
?>
<link href="/css/login.css" rel="stylesheet">
<div class="container">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <!--<p>Please fill out the following fields to login:</p>-->

    <?php $form = ActiveForm::begin([
        'id'=>'login-form',
        'layout'=>'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"form-group-lg col-sm-9\">{input}{error}{hint}</div>",
            'labelOptions' => ['class' => 'col-sm-3 control-label'],
        ],
    ]); ?>
    <?= $form->field($model, 'username')->label('用户名') ?>
    <?= $form->field($model, 'password')->passwordInput()->label('密码') ?>
    <?= $form->field($model, 'captcha',['options' => ['class' => 'form-group']])
        ->widget(Captcha::className(),[
            'template' => '<div class="row"><div class="col-xs-7">{input}</div><div class="col-xs-5">{image}</div></div>',

        ])->label('验证码'); ?>
    <?= $form->field($model, 'rememberMe')->checkbox()->label('记住我') ?>

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
