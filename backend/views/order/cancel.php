<?php
use yii\helpers\Html;
?>

<?php echo Html::beginForm('', 'post', ['class'=>'form-horizontal']);?>
<div class="row">
	<div class="col-sm-12">
        <div class="form-group">
            <label for="reason" class="col-md-2 control-label">取消原因</label>
            <div class="col-md-10">
                <textarea name="reason" class="form-control" id="reason" rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="reason" class="col-md-2 control-label"></label>
            <div class="col-md-10">
                <?php echo Html::button('确认取消', ['class'=>'btn btn-primary js-confirm-cancel']);?>
            </div>
        </div>
	</div>
</div>
<?php echo Html::endForm();?>

<script type="text/javascript">
    $('.js-confirm-cancel').click(function(){
        var url='<?=Yii::$app->urlManager->createUrl(['order/cancel', 'id'=>$model->order_id]);?>';
        var reason = $('#reason').val();
        if(reason.length <= 0){
            alert('取消原因不能为空');
            $('#reason').focus();
            return false;
        }
        $.ajax({
            type: "POST",
            dataType: "json",
            async:false,
            cache:false,
            timeout:30000,
            data:{reason:reason},
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