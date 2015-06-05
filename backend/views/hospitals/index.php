<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\HospitalsSearch $searchModel
 */

$this->title = '医院管理';
?>
<div class="hospitals-index">
    <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute'=>'province_id',
                'value'=>
                    function($model){
                        return \backend\models\City::getCity($model->province_id)->name;
                    }
            ],
            [
                'attribute'=>'city_id',
                'value'=>
                    function($model){
                        return \backend\models\City::getCity($model->city_id)->name;
                    }
            ],
            [
                'attribute'=>'area_id',
                'value'=>
                    function($model){
                        return \backend\models\City::getCity($model->area_id)->name;
                    }
            ],
//            'phone', 

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['hospitals/create','id' => $model->id,'edit'=>'t']), [
                                                    'title' => Yii::t('yii', 'Edit'),
                                                  ]);}

                ],
                'template'=>'{update}{delete}',
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,




        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> 添加', ['create'], ['class' => 'btn btn-success']),
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> 重置列表', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
