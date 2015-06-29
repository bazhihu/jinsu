<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SendMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '发送短信';
?>
<style>
    .worker-leave-list{float: left;width: 46%;margin: 2%;}
    li{cursor:pointer;padding:5px;}
</style>
<div class="panel panel-info">
    <div class="panel-body">
        <div class="worker-leave-list">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">发送短信</h3>
                </div>
                <div class="panel-body">
                    <?php
                    $form = ActiveForm::begin([
                            'type'=>ActiveForm::TYPE_HORIZONTAL]
                    );
                    echo Form::widget([
                        'model'         => $model,
                        'form'          => $form,
                        'columns'       => 1,
                        'attributes'    => [
                            'subject'=>[
                                'type'=> Form::INPUT_TEXTAREA,
                                'options'=>[
                                    'placeholder'=>'请输入发送内容...',
                                    'maxlength'=>255,
                                    'id'=>'talkBox'
                                ]
                            ],
                            'receiver'=>[
                                'type'=> Form::INPUT_TEXTAREA,
                                'options'=>[
                                    'placeholder'=>'请输入发送者...',
                                    'maxlength'=>255,
                                ]
                            ],
                        ]
                    ]);
                    ?>
                    <?php
                    echo Html::submitButton( '提交', ['class' => 'btn btn-lg btn-success jsSubmitCreate']);
                    ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="worker-leave-list">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">短信模板</h3>
                </div>
                <div class="panel-body">
                    <div class="worker-card-create">
                        <div class="worker-card-form">
                            <ul class="fast-link" id="fastList">
                                <span class="nav nav-tabs" onclick="chanTxt(0)">1、订单未支付</span><li onclick="chanTxt(0)">您预约的x月x日开始的x级陪护服务订单还没有支付，请尽快拨打客服热线：400-630-6340或使用优爱医护App完成支付。</li>
                                <span class="nav nav-tabs" onclick="chanTxt(1)">2、订单支付成功</span><li onclick="chanTxt(1)">您预约的x月x日开始的x级陪护服务已确认。您可以拨打客服热线：400-630-6340或在优爱医护App中追踪查看订单状态。</li>
                                <span class="nav nav-tabs" onclick="chanTxt(2)">3、服务结束前24小时</span><li onclick="chanTxt(2)">陪护服务将在x月x日9:00结束，如还需继续服务请在30分钟内拨打客服热线：400-630-6340或使用优爱医护App进行续单，否则服务将在指定时间结束。</li>
                                <span class="nav nav-tabs" onclick="chanTxt(3)">4、订单已取消</span><li onclick="chanTxt(3)">您预约的x月x日开始的x级陪护服务订单已取消，已支付金额会退回您优爱医护账号钱包，您可以拨打客服热线：400-630-6340申请提现。</li>
                                <span class="nav nav-tabs" onclick="chanTxt(4)">5、订单修改成功</span><li onclick="chanTxt(4)">您预约的陪护服务订单已成功修改为x月x日开始的x级陪护服务。您可以拨打客服热线：400-630-6340或使用优爱医护App追踪查看订单状态。</li>
                                <span class="nav nav-tabs" onclick="chanTxt(5)">6、订单已完成</span><li onclick="chanTxt(5)">您的x天x级陪护服务已完成，请使用优爱医护App对服务人员进行评价。如有问题请拨打客服热线：400-630-6340。</li>
                                <span class="nav nav-tabs" onclick="chanTxt(6)">7、提现申请</span><li onclick="chanTxt(6)">您有一笔XX元的提现申请已确认，请与X月X日X时到XX医院指定办公室办理提现手续，如有问题请拨打客服热线：400-630-6340。</li>
                                <span class="nav nav-tabs" onclick="chanTxt(7)">8、充值成功</span><li onclick="chanTxt(7)">已成功为账号XXXXXXXXXXX充值XX元，当前账号余额为：XXX元。您可以在优爱医护App“我的钱包”中随时查看消费记录。</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function chanTxt(i){
        var f	= document.getElementById('fastList'),
            t	= document.getElementById('talkBox'),
            l	= f.getElementsByTagName('li');
        var txt = l[i].innerHTML;
        t.value = txt;
    }
    /*$('form').submit(function(e){
        var receiver = $('#sendmessage-receiver').val(),
            talkBox = $('#talkBox').val(),
            tel = /^1[0-9]{10}$/;
        if(receiver && talkBox){
            var res = receiver.split(",");
            if(res.length){
                for(var i=0;i<res.length;i++){
                    if(!tel.test(res[i])){
                        alert('请输入正确的号码...');
                        return false;
                    }
                }
            }
        }
    });*/
</script>
<?php /*GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'subject',
            'receiver:ntext',
            'send_time',
            'operator_id',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);*/ ?>
