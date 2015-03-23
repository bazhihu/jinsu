<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\OrderSearch $searchModel
 */

$this->title = '订单管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-master-index">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Order Master', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'order_id',
            'order_no',
            'uid',
            'mobile',
            'base_price',
//            'disabled_amount', 
//            'holiday_amount', 
//            'total_amount', 
//            'patient_state', 
//            'worker_level', 
//            'customer_service_id', 
//            'operator_id', 
            [
                'attribute'=>'start_time',
                'format'=>[
                    'datetime',
                    (isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'Y-m-d H:i:s'
                ]
            ],
//            ['attribute'=>'service_end_time','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            ['attribute'=>'reality_end_time','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            ['attribute'=>'create_time','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            ['attribute'=>'pay_time','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            ['attribute'=>'confirm_time','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            ['attribute'=>'cancel_time','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            'order_status', 
//            'create_order_ip', 
//            'create_order_sources', 
//            'create_order_user_agent', 

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span>',
                        Yii::$app->urlManager->createUrl(['order/view','id' => $model->order_id,'edit'=>'t']), ['title' => Yii::t('yii', 'Edit'),]
                    );
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
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
