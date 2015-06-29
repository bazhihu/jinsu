<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SendMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '短信发送记录';
?>
<div class="send-message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('发送短信', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'subject',
            'receiver:ntext',
            'send_time',
            [
                'attribute'=>'operator_id',
                'value'=>
                    function($model){
                        return  \backend\models\AdminUser::getInfo($model->operator_id);   //主要通过此种方式实现
                    },
            ],
        ],
    ]); ?>

</div>
