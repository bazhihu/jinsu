<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use backend\models\User;
use backend\models\AdminUser;
use backend\models\WalletUser;
use backend\models\WalletWithdrawcash;

/**
 * @var yii\web\View $this
 * @var backend\models\User $model
 */

$this->title = $this->title = '查看用户信息';;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header"> </div>
<div class="user-view">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">操作</h3>
        </div>
        <div class="panel-body">
            <?
            echo Html::a('<span class="btn  btn-primary">充值</span>', Yii::$app->urlManager->createUrl(['wallet/recharge','uid' => $model->id]), ['title' => '充值']);
            if(WalletUser::findOne(['uid'=>$model->id])){
                $finace_status = WalletWithdrawcash::getWalletStatusByUid($model->id);
                if($finace_status['code']==200 || $finace_status['code']==3|| $finace_status['code']==1){
                    echo  "&nbsp;&nbsp;&nbsp;&nbsp;".Html::a('<span class="btn btn btn-primary">提现</span>', Yii::$app->urlManager->createUrl(['wallet/cash','uid' => $model->id]), ['title' =>'提现']);
                }
            }

            echo "&nbsp;&nbsp;&nbsp;&nbsp;".Html::a('<span class="btn  btn-primary">下单</span>', Yii::$app->urlManager->createUrl(['order/create','uid' => $model->id]), ['title' => '下单']);

            ?>
        </div>
    </div>

    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'id',
            'mobile',
            'nickname',
            'name',
            'gender',
            'type',
            [
                'attribute'=>'status',
                'value'=> ($model->status==User::STATUS_NORMAL) ? '正常':'禁用',
            ],
            'login_ip',
            [
                'attribute'=>'login_time',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'register_time',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'adder',
                'value'=>($model->adder)? AdminUser::findOne(['admin_uid',$model->adder])->username :null,
            ],
            [
                'attribute'=>'edit_time',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'editer',
                'value'=>($model->editer)? AdminUser::findOne(['admin_uid',$model->editer])->username : null,
            ],
        ],
        'deleteOptions'=>[
        'url'=>['delete', 'id' => $model->id],
        'data'=>[
        'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
        'method'=>'post',
        ],
        ],
        'enableEditMode'=>false,
    ]) ?>
</div>