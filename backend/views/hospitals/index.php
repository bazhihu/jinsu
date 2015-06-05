<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\models\City;

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


    <?php
    Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'id',
                'options' => [
                    'style' => 'width:150px',
                ],
            ],
            'name',
            [
                'attribute'=>'province_id',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>City::getList(1),
                'filterInputOptions'=>['placeholder'=>'请选择'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                    //'hideSearch'=>true,
                ],
                'options' => [
                    'style' => 'width:160px',
                ],
                'value'=>function ($model){
                    return $model->province_id ? City::getCityName($model->province_id) : null;
                }
            ],
            [
                'attribute'=>'city_id',
                'value'=>function ($model){
                    return $model->city_id ? City::getCityName($model->city_id) : null;
                }

            ],
            [
                'attribute'=>'area_id',
                'value'=>function ($model){
                    return $model->area_id ? City::getCityName($model->area_id) : null;
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
