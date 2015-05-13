<?php
/* @var $this yii\web\View */

$this->title = '优爱医护管理后台';
?>
<div class="page-header">
    <h1>仪表盘</h1>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">待办事项</h3>
            </div>
            <div class="panel-body">
                <ul role="tablist" class="nav">
                    <?php if($data['waitPayCount'] > 0):?>
                    <li>
                        <a href="<?=Yii::$app->urlManager->createUrl(['order/index','OrderSearch[order_status]' => 'wait_pay']);?>">
                            待支付订单 <span class="badge"><?=$data['waitPayCount']?></span>
                        </a>
                    </li>
                    <?php endif;?>

                    <?php if($data['waitConfirmCount'] > 0):?>
                    <li>
                        <a href="<?=Yii::$app->urlManager->createUrl(['order/index','OrderSearch[order_status]' => 'wait_confirm']);?>">
                            待确认订单 <span class="badge"><?=$data['waitConfirmCount']?></span>
                        </a>
                    </li>
                    <?php endif;?>

                    <?php if($data['waitServiceCount'] > 0):?>
                        <li>
                            <a href="<?=Yii::$app->urlManager->createUrl(['order/index','OrderSearch[order_status]' => 'wait_service']);?>">
                                待服务订单 <span class="badge"><?=$data['waitServiceCount']?></span>
                            </a>
                        </li>
                    <?php endif;?>

                    <?php if($data['waitFinishCount'] > 0):?>
                        <li>
                            <a href="<?=Yii::$app->urlManager->createUrl(['order/index','OrderSearch[order_status]'=>'in_service','OrderSearch[end_time]'=>date('Y-m-d 09:00:00')]);?>">
                                待完成订单 <span class="badge"><?=$data['waitFinishCount']?></span>
                            </a>
                        </li>
                    <?php endif;?>

                    <?php if($data['waitEvaluateCount'] > 0):?>
                        <li>
                            <a href="<?=Yii::$app->urlManager->createUrl(['order/index','OrderSearch[order_status]' => 'wait_evaluate']);?>">
                                待评价订单 <span class="badge"><?=$data['waitEvaluateCount']?></span>
                            </a>
                        </li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
    </div>

</div>
