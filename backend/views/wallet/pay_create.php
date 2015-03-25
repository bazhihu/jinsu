<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;
use kartik\widgets\Growl;

/* @var $this yii\web\View */
/* @var $model backend\models\WalletUserDetail */
$this->title = '账号充值 用户ID：'.$userRow['uid'];
?>
<div class="panel panel-success" style="margin: 100px 300px 100px 300px;">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="panel-body">

        <?php $form = ActiveForm::begin(
            [
                'type'=>ActiveForm::TYPE_VERTICAL,
                'formConfig'=>[
                    'showLabels' => true,
                    'showErrors' => true,
                ]
            ]
        ); ?>
        <?= $form->field($model, 'uid')
            ->textInput(
                [
                    'disabled'=>true,
                    'value'=>$userRow['mobile'],
                ]
            )->label('充值帐号') ?>

        <?= $form->field($model, 'detail_money')->textInput()->label('充值金额') ?>
        <?= $form->field($model, 'mobile')->textInput(
            [
                'disabled'=>true,
                'value'=>$userRow['admin_name'],
            ]
        )->label('经办人') ?>

        <div class="form-group">
            <?= Html::submitButton(
                '充值',
                [
                    'class' =>'btn btn-info btn-lg col-sm-4 col-md-offset-4',
                    'onclick'=>"
                        var value = $('#walletuserdetail-detail_money').val(),
                        name = $('#walletuserdetail-uid').val();
                        if(!value){
                            alert('请输入充值金额！');
                            return false;
                        }
                        alert('确认给用户'+name+'：充值'+value+'人民币？');
                        return true;
                    ",
                ]
            ) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
