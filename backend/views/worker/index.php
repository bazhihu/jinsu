<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\Models\Worker;
use backend\models\Hospitals;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\Models\WorkerSearch $searchModel
 */

$this->title = '护工管理';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="worker-index">
    <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Worker', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'worker_id',

            'name',

            'gender',

            [
                'attribute'=>'birth',
                'label' => '年龄',
                'value'=> function ($model){
                    return $model->workerAge($model->birth);
                }
            ],

            //'native_province',

            [
                'attribute'=>'hospital_id',
                'value'=> function ($model){
                    return Hospitals::getHospitalsName($model->hospital_id);
                }
            ],

            [
                'attribute'=>'level',
                'value'=>function ($model){
                    return $model->level ? Worker::getWorkerLevel($model->level) : null;
                }
            ],

            /*[
                'attribute'=>  'status',
                'value'=> function ($model) {
                    if ($model->status==1)
                        return '在职';
                    elseif ($model->status==2)
                        return '离职';
                }
            ],*/

            'total_score',

            [
                'attribute'=>'star',
                'value'=>function ($model){

                    return $model->workerStar($model->star);
                }
            ],

            'total_order',

            'good_rate',

            'total_comment',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}&nbsp;&nbsp;{update}',
                'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['worker/update','id' => $model->worker_id]), [
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
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> 添加护工', ['create'], ['class' => 'btn btn-success']),
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
