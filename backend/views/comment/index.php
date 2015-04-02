<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\models\AdminUser;
use backend\models\User;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\CommentSearch $searchModel
 */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">
    <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Comment', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            [
                'class'=>'kartik\grid\CheckboxColumn',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
            ],

            ['class' => 'yii\grid\SerialColumn'],
            'order_no',
            [
                'attribute'=>'uid',
                'value'=>function($model) {
                    return ($model->uid)? User::findOne(['id',$model->uid])['username'] :null;
                }
            ],
            'worker_id',
            'worker_name',
            'star',
            'content',
            'status',
            'comment_date',
            'audit_time',
            [
                'attribute'=>'adder',
                'value'=>function($model) {
                    return ($model->adder)? AdminUser::findOne(['admin_uid',$model->adder])['username'] :null;
                }
            ],

            [
                'attribute'=>'auditer',
                'value'=>function($model) {
                    return ($model->auditer)? AdminUser::findOne(['admin_uid',$model->auditer])['username'] :null;
                }
            ],
            'type',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['comment/view','id' => $model->comment_id,'edit'=>'t']), [
                                                    'title' => Yii::t('yii', 'Edit'),
                                                  ]);}

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
            'before'=> Html::a('<span class="btn btn-sm btn-primary">审核通过</span>', Yii::$app->urlManager->createUrl('wallet/pay-create'), ['title' => '审核通过']),
                        Html::a('<span class="btn btn-sm btn-primary">审核未通过</span>', Yii::$app->urlManager->createUrl('wallet/pay-create'), ['title' => '审核未通过']),                                                                                                                                                         'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
