<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Hospitals $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Hospitals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hospitals-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            //'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'id',
            'name',
            [
                'attribute'=>'province_id',
                'value'=>$model->province_id?\backend\models\City::findOne(['id'=>$model->province_id])->name:"",
            ],
            [
                'attribute'=>'city_id',
                'value'=>$model->city_id?\backend\models\City::findOne(['id'=>$model->city_id])->name:"",
            ],
            [
                'attribute'=>'area_id',
                'value'=>$model->area_id?\backend\models\City::findOne(['id'=>$model->area_id])->name:"",
            ],
            'phone',
            'pinyin',
        ],
        'deleteOptions'=>[
        'url'=>['delete', 'id' => $model->id],
        'data'=>[
        'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
        'method'=>'post',
        ],
        ],
        'enableEditMode'=>false,
    ]) ?>

</div>
