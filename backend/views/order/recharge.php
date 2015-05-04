<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(
    [
        'type'=>ActiveForm::TYPE_VERTICAL,
        'formConfig'=>[
            'showLabels' => true,
            'showErrors' => true,
        ]
    ]
); ?>

<?= $form->field($model, 'mobile')->textInput([
    'disabled'=>true,
    'value' => $order->mobile,
])->label('充值帐号') ?>

<?php
$needMoney = $order->total_amount-$balance;
echo $form->field($model, 'money')->textInput()->label('充值金额')->hint('当前余额：'.$balance.'元，需要充值：'.$needMoney.'元');
?>

<div class="form-group">
    <?= Html::button(
        '充值并支付',
        ['class'=>'btn btn-info js-recharge-submit']
    );
    ?>
</div>

<?php ActiveForm::end(); ?>
<script type="text/javascript">
    $('.js-recharge-submit').click(function(){
        var money = $('#recharge-money').val();
        var uid = <?=$order->uid?>;

        if(money<1){
            alert('请输入充值金额。');
            $('#recharge-money').focus();
            return false;
        }

        if(!confirm('确认给帐号：<?=$order->mobile?>充值'+money+'元？')){
            return false;
        }
        $.ajax({
            type    : "POST",
            dataType: "json",
            async   :false,
            cache   :false,
            timeout :30000,
            url     : '<?=Yii::$app->urlManager->createUrl(['order/recharge', 'id' => $order->order_id]);?>',
            data    : {'money':money ,'uid':uid},
            success: function(json){
                if(json.code == '200'){
                    alert(json.msg);
                    return true;
                }
            }
        });
    });
</script>