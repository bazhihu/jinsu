<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use backend\models\Hospitals;

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

            [
                'attribute'=>'certificate',
                'value'=>\backend\Models\Worker::getCertificateName($model->certificate)
            ],

            'phone1',

            'phone2',

            [
                'attribute'=>'level',
                'value'=>\backend\Models\Worker::getWorkerLevel($model->level,'view')
            ],

            'price',

            [
                'attribute'=>'status',
                'value'=>$model->status==1?'在职':'离职'
            ],

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

            [
                'attribute'=>'nation',
                'value'=>\backend\Models\Worker::getNation($model->nation,'view')
            ],

            [
                'attribute'=>'birth_place',
                'value'=>\backend\models\City::getCityName($model->birth_place)
            ],

            [
                'attribute'=>'hospital_id',
                'value'=>Hospitals::getHospitalsName($model->hospital_id)
            ],

            [
                'attribute'=>'office_id',
                'value'=>\backend\models\Departments::getDepartmentName($model->office_id)
            ],


            [
                'attribute'=>'good_at',
                'value'=>\backend\models\Departments::getDepartmentName($model->good_at)
            ],

            'total_score',

            'star',

            'total_order',

            'good_rate',

            'total_comment',

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
                'value'=>($model->adder)? \backend\models\AdminUser::findOne(['admin_uid',$model->adder])->username :null,
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

            [
                'attribute'=>'editer',
                'value'=>($model->editer)? \backend\models\AdminUser::findOne(['admin_uid',$model->editer])->username : null,
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
