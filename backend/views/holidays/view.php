<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Holidays $model
 */

$this->title = '查看节假日';
//$this->params['breadcrumbs'][] = ['label' => 'Holidays', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="holidays-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div style="display: table;margin-bottom: 15px;">
    <?php echo Html::a('继续添加', Yii::$app->urlManager->createUrl('holidays/create'), ['class'=>'btn btn-primary active','style'=>'float:right']);?>
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
            'id',
            [
                'attribute'=>'date',
                'format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATE
                ]
            ],
        ],
        'deleteOptions'=>[
        'url'=>['delete', 'id' => $model->id],
        'data'=>[
        'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
        'method'=>'post',
        ],
        ],
        'enableEditMode'=>true,
    ]) ?>
</div>
