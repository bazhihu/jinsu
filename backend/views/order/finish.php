<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

$form = ActiveForm::begin([
    'type'=>ActiveForm::TYPE_HORIZONTAL,
    'method' => 'post',
]);

echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'reality_end_time'=>[
            'type'=>Form::INPUT_WIDGET,
            'widgetClass'=>'\kartik\widgets\DatePicker',
            'options'=>[
                'pluginOptions'=>[
                    'todayHighlight' => true,
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd 09:00:00'
                ]
            ]
        ],
    ]
]);

echo Html::button('确认', [
    'class'=>'btn btn-primary js-confirm-finish',
    'value'=>'true'
]);

ActiveForm::end();
?>
<script type="text/javascript">
    $('.js-confirm-finish').click(function(){
        var url='<?=Yii::$app->urlManager->createUrl(['order/finish', 'id'=>$model->order_id]);?>';
        var reality_end_time = $('#ordermaster-reality_end_time').val();
        $.ajax({
            type: "POST",
            dataType: "json",
            async:false,
            cache:false,
            timeout:30000,
            data:{reality_end_time:reality_end_time},
            url: url,
            error:function(jqXHR, textStatus, errorThrown){
                switch (jqXHR.status){
                    case(500):
                        alert("服务器系统内部错误");
                        break;
                    case(401):
                        alert("未登录");
                        break;
                    case(403):
                        alert("无权限执行此操作");
                        break;
                    case(408):
                        alert("请求超时");
                        break;
                    default:
                        alert("未知错误");
                }
            },
            success: function(json){
                alert(json.msg);
                if(json.code == '200'){
                    location.reload();
                }
            }
        });
    });

</script>