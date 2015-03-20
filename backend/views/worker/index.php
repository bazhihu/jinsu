<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\Models\WorkerSearch $searchModel
 */

$this->title = '护工管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="worker-index">
    <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Worker', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'worker_id',
            'name',
            'gender',
            [
                'attribute'=>'birth',
                'label' => '年龄',
                'value'=> function ($model){
                    return $model->worker_age($model->birth);
                }
            ],
            'native_province',
            'hospital_id',
            [
                'attribute'=>  'status',
                'value'=> function ($model) {
                    if ($model->status==1)
                        return '在职';
                    elseif ($model->status==2)
                        return '离职';
                }
            ],
            'total_score',
            [
                'attribute'=>'star',
                'value'=>function ($model){
                    return $model->worker_star($model->star);
                }
            ],
            'total_order',
            'good_rate',
            'total_comment',
            [
                'attribute'=>'level',
                'value'=>function ($model){
                    return $model->worker_level($model->level);
                }
            ],

//            'native_province',
//            'nation',
//            'marriage', 
//            'education', 
//            'politics', 
//            'idcard', 
//            'chinese_level', 
//            'certificate', 
//            ['attribute'=>'start_work','format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y']], 
//            'place', 
//            'phone1', 
//            'phone2', 
//            'price', 
//            'hospital_id', 
//            'office_id', 
//            'good_at', 
//            ['attribute'=>'add_date','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            'adder', 
//            ['attribute'=>'edit_date','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            'editer', 
//            'total_score', 
//            'star', 
//            'total_order', 
//            'good_rate', 
//            'total_comment', 
//            'level', 
//            'status', 

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['worker/view','id' => $model->worker_id,'edit'=>'t']), [
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
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> 添加护工', ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
