<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SendMessage */

$this->title = '短信详情';
?>
<div class="send-message-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'subject',
            'receiver:ntext',
            'send_time',
            [
                'attribute'=>'operator_id',
                'value'=>\backend\models\AdminUser::getInfo($model->operator_id),
            ]
        ],
    ]) ?>

</div>
