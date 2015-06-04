<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\Hospitals;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WorkerAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '护工账户';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="worker-account-index">

    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'id',
            'worker_id',
            'worker_name',
            'city_id',
            [
                'attribute'=>'hospital_id',
                'value'=>function($model){
                    return Hospitals::getName($model->hospital_id);
                }
            ],
            'balance',
            'withdraw_amount',
            'recommend_amount',
            [
                'attribute'=>'order_amount',
                'format'=>'raw',
                'value'=>function ($model) {
                    return Html::a($model->order_amount, Yii::$app->urlManager->createUrl(['worker-bill/index','WorkerBillSearch[worker_id]' => $model->worker_id]));
                }
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{withdraw}',
                'buttons' => [
                    'withdraw' => function ($url, $model) {
                        return Html::button('提现',[
                            'data-url'=>$url,
                            'class'=>'btn btn-sm btn-primary jsPayOrder'
                        ]);

                    },
                ]
            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> 重置列表', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>true
        ],
    ]); ?>

</div>
