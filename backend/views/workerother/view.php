<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\Models\Workerother $model
 */

$this->title = $model->worker_id;
$this->params['breadcrumbs'][] = ['label' => 'Workerothers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workerother-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'worker_id',
            'ext1',
            'ext2',
            'ext3',
            'ext4',
            'info_type',
        ],
        'deleteOptions'=>[
        'url'=>['delete', 'id' => $model->worker_id],
        'data'=>[
        'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
        'method'=>'post',
        ],
        ],
        'enableEditMode'=>true,
    ]) ?>

</div>
