<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\models\AdminUser;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\Models\UserSearch $searchModel
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
            'mobile',
            'nickname',
            'name',
            'gender',
            'type',
            [
                'attribute'=>'status',
                'value'=>function($model) {
                    return ($model->status) ? '正常':'禁用';
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
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}&nbsp;&nbsp;{update}',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['user/update','id' => $model->id]), [
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
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> 用户注册', ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>
</div>