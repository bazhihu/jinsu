<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\AdminUserSearch $searchModel
 */

$this->title = '帐号列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-user-index">
    <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Admin User', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'hover'=>true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'admin_uid',
            'username',
            //'password_hash',
            ['attribute'=>'密码','value'=>function(){return '******';}],
            'staff_id',
            'staff_name',
            'staff_role',
            'hospital',
            'created_id',
            [
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'status',
                'vAlign'=>'middle',
            ],
            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil "></span>', $url, [
                            'title' => Yii::t('yii', '修改'),
                            'data-pjax'=>'w0',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return $model->status?Html::a('<span class="glyphicon col-md-offset-4 glyphicon-remove"></span>', $url, [
                            'title' => Yii::t('yii', '关闭'),
                            'data-pjax'=>'w0',
                        ]):Html::a('<span class="glyphicon col-md-offset-4 glyphicon-ok"></span>',
                            $url, ['title' => Yii::t('yii', '恢复'),
                            'data-pjax'=>'w0',
                        ]);
                    },
                ],
                'template'=>'{update}{delete}',
            ],
        ],
        //'responsive'=>true,
        //'hover'=>true,
        //'condensed'=>true,
        //'floatHeader'=>true,

        'panel' => [
            //'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            //'type'=>'info',
            //'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            //'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
