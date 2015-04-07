<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\models\AdminUser;
use yii\helpers\Url;
use backend\models\WalletUser;
use backend\models\WalletWithdrawcash;


/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\UserSearch $searchModel
 */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?php /* echo Html::a('Create User', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
     //   'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            //'mobile',
            [
                'attribute'=>'mobile',
                'format'=>'raw',
                'value'=>function ($model) {
                    return Html::a($model->mobile, Yii::$app->urlManager->createUrl(['user/view','id'=>$model->id]));
                },
                'options' => [
                    'style' => 'width:110px',
                ]
            ],
           // 'nickname',
            'name',
            'gender',
            'type',
            [
                'attribute'=>'status',
                'value'=>function($model) {
                    return ($model->status==1) ? '正常':'禁用';
                }
            ],
            //'finance_status',
            /*[
                'attribute'=>'finance_status',
                'value'=>function ($model){
                    return $model->level ? Worker::getWorkerLevel($model->level) : null;
                }
            ],*/
            'login_ip',
            'login_time',
            'register_time',
            [
                'attribute'=>'adder',
                'value'=>function($model) {
                    return ($model->adder) ? AdminUser::findOne(['admin_uid', $model->adder])->username : null;
                }
            ],
            'edit_time',
            [
                'attribute'=>'editer',
                'value'=>function($model) {
                    return ($model->editer) ? AdminUser::findOne(['admin_uid', $model->editer])->username : null;
                }
            ],
            [
                'attribute'=>'finance_status',
                'value'=>function($model) {
                    $finace_status = WalletWithdrawcash::getWalletStatusByUid($model->id);
                    return $finace_status['msg'];
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'财务操作',
               // 'template' => '{view}&nbsp;&nbsp;{update}',
                'template' => '{recharge}&nbsp;{cash}',
                'buttons' => [
                    'recharge' => function ($url, $model) {
                        return Html::a('<span class="btn btn-sm btn-primary">充值</span>',
                            Yii::$app->urlManager->createUrl(['wallet/recharge','uid' => $model->id]),
                            ['title' => '充值']
                        );
                    },

                    'cash' => function ($url, $model) {
                        if(WalletUser::findOne(['uid'=>$model->id])){
                            $finace_status = WalletWithdrawcash::getWalletStatusByUid($model->id);
                            if($finace_status['code']==200 || $finace_status['code']==3|| $finace_status['code']==1){
                                return Html::a('<span class="btn btn-sm btn-primary">提现</span>', Yii::$app->urlManager->createUrl(['wallet/cash','uid' => $model->id]), ['title' =>'提现']);
                           }
                        }
                    },
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{view}&nbsp;{update}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['user/update','id' => $model->id]), [
                            'title' => Yii::t('yii', 'Edit'),
                        ]);
                    }
                ],
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> 用户注册', ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>
</div>