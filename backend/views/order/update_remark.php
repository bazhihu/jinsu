<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/6/11
 * Time: 12:52
 */
use yii\helpers\Html;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;


$form = ActiveForm::begin([
    'type'=>ActiveForm::TYPE_HORIZONTAL
]);

echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'remark'=>[
            'type'=>Form::INPUT_TEXTAREA,
            'options'=>['rows'=>5]
        ]
    ]
]);

echo Html::button('确定', [
    'class'=>'btn btn-info js-update-remark',
    'data-url'=>Yii::$app->urlManager->createUrl([
        'order/update-remark',
        'id' => $model->order_id
    ])
]);
ActiveForm::end();
?>

<script type="text/javascript">
    $('body').on('click', 'button.js-update-remark', function () {
        var remark = $('#ordermaster-remark').val();
        if(remark.length <= 0){
            alert('备注不能为空。');
            return false;
        }

        var button = $(this);
        button.text('处理中...');
        button.attr('disabled', true);
        var url = $(this).attr('data-url');
        $.ajax({
            type: "POST",
            dataType: "json",
            async:false,
            cache:false,
            timeout:30000,
            url: url,
            data:{remark:remark},
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
                button.attr('disabled', false);
                button.text('确定');
            },
            success: function(json){
                alert(json.msg);
                if(json.code == '200'){
                    location.reload();
                }else{
                    button.attr('disabled', false);
                    button.text('确定');
                }
            }
        });
    });
</script>