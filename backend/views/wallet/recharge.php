<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\WalletUserDetail */
if($userRow['username']){
    $this->title = '账号充值 用户名：'.$userRow['username'];
}else{
    $this->title = '账号充值';
}

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
        <?= $form->field($model, 'uid')->hiddenInput(
                [
                    'value'=>$userRow['uid'],
                    'name'=>$userRow['username']?$userRow['username']:''
                ]
            )->label("");
        ?>
        <?= $form->field($model, 'uid')
            ->textInput(
                [
                    'disabled'=>true,
                    'value'=>substr_replace($userRow['mobile'],'****',3,4),
                ]
            )->label('充值帐号') ?>

        <?= $form->field($model, 'money')->textInput()->label('充值金额') ?>
        <?= $form->field($model, 'admin_name')->textInput(
            [
                'disabled'=>true,
                'value'=>$userRow['admin_name'],
            ]
        )->label('经办人') ?>

        <div class="form-group">
            <?= Html::button(
                '充值',
                [
                    'class' =>'jsRecharge btn btn-info btn-lg col-sm-4 col-md-offset-4',
                    'data-url'=>Yii::$app->urlManager->createUrl(['wallet/ajax-recharge','uid' => $userRow['uid']]),
                    'jump-url'=>Yii::$app->urlManager->createUrl(['wallet/recharge-records','uid' => $userRow['uid']]),
                ]
            );
            ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
<script type="text/javascript">
    //充值
    $('body').on('click', 'button.jsRecharge', function () {

        var value = $('#recharge-money').val(),
            name = $('#recharge-uid').attr('name'),
            uid = $('#recharge-uid').val(),
            url = $(this).attr('data-url'),
            jump = $(this).attr('jump-url');

        if(value){
            if(!confirm('确认给'+name+'用户：充值'+value+'元人民币？')){
                return false;
            }
            $.ajax({
                type    : "POST",
                dataType: "json",
                async   :false,
                cache   :false,
                timeout :30000,
                url     : url,
                data    : {'money':value ,'uid':uid},
                success: function(json){
                    if(json.code == '200'){
                        alert(json.msg);
                        location.href = jump;
                        return true;
                    }
                }
            });
        }else{
            $('#recharge-money').prev().addClass('has-error');
            $('#recharge-money').next().html('money不能为空');
        }
    });
</script>