<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WorkerBillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '护工账单';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="worker-bill-index">

    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'worker_id',
            'worker_name',
            //'order_id',
             'order_no',
             'start_time',
             'end_time',
             'amount',
             'add_time',
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> 重置列表', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>true
        ],
        'panelBeforeTemplate' => '<div class="pull-right"><div class="btn-toolbar kv-grid-toolbar" role="toolbar">{toolbar}</div></div><strong>订单收入：'.$searchModel->total.'元</strong><div class="clearfix"></div>'
    ]); ?>

</div>
