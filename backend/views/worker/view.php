<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\Models\Worker $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Workers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="worker-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'worker_id',
            'name',
            'idcard',
            'gender',
            [
                'attribute'=>'birth',
                'format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'yyyy-MM-dd'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATE
                ]
            ],

            'birth_place',

            //[
              //  'attribute'=>'native_province',
            [
                'attribute'=>'nation',
                'value'=>\backend\Models\Worker::getNation($model->nation,'view')
            ],
            [
                'attribute'=>'marriage',
                'value'=>$model->marriage==1?'已婚':'未婚'
            ],

            [
                'attribute'=>'education',
                'value'=>\backend\Models\Worker::getEducationLevel($model->education,'view')
            ],

            [
                'attribute'=>'politics',
                'value'=>\backend\Models\Worker::getPoliticsLevel($model->politics,'view')
            ],

            [
                'attribute'=>'chinese_level',
                'value'=>\backend\Models\Worker::getChineseLevel($model->chinese_level,'view')
            ],

            'certificate',
            [
                'attribute'=>'start_work',
                'format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'yyyy-MM-dd'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATE
                ]
            ],
            'place',
            'phone1',
            'phone2',
            'price',
            'hospital_id',
            'office_id',
            'good_at',
            [
                'attribute'=>'add_date',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'yyyy-MM-dd H:i:s'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],

            [
                'attribute'=>'adder',
                'value'=>yii::$app->user->identity->username
            ],

            [
                'attribute'=>'edit_date',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'yyyy-MM-dd H:i:s'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            'editer',
            'total_score',
            'star',
            'total_order',
            'good_rate',
            'total_comment',

            [
                'attribute'=>'level',
                'value'=>\backend\Models\Worker::getWorkerLevel($model->level,'view')
            ],

            [
                'attribute'=>'status',
                'value'=>$model->status==1?'在职':'离职'
            ],
        ],
        'deleteOptions'=>[
        'url'=>['delete', 'id' => $model->worker_id],
        'data'=>[
        'confirm'=>Yii::t('app', '确定要删除吗?'),
        'method'=>'post',
        ],
        ],
        'enableEditMode'=>false,
    ]) ?>

</div>
