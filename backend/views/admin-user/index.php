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
$this->registerJsFile('js/admin.js', ['position'=>yii\web\View::POS_END]);
?>
<div class="admin-user-index">
    <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'hover'=>true,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn'
            ],
            'username',
            [
                'attribute'=>'密码',
                'value'=>function(){return '******';}
            ],
            'staff_id',
            'staff_name',
            'staff_role',
            [
                'attribute'=>'hospital',
                'value'=>
                    function($model){
                        return \backend\models\Hospitals::findOne(['id'=>$model->hospital])->name;
                    }
            ],
            [
                'attribute'=>'created_id',
                'value'=>
                    function($model){
                        return  \backend\models\AdminUser::getInfo($model->created_id);   //主要通过此种方式实现
                    },
            ],
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
                        return $model->status?Html::a(
                            '<span class="glyphicon col-md-offset-4 glyphicon-remove "></span>',
                            "#",
                            [
                                'title' => Yii::t('yii', '关闭'),
                            ]):
                            Html::a(
                            '<span class="glyphicon col-md-offset-4 glyphicon-ok"></span>',
                            '#',
                            [
                                'title' => Yii::t('yii', '恢复'),
                            ]
                        );
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
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> 新增帐号', ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>true
        ],
    ]); Pjax::end(); ?>

</div>
