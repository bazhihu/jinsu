<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use backend\models\Worker;
use backend\models\Workerother;
use backend\models\Hospitals;
use backend\models\City;
use backend\models\Departments;
use backend\models\AdminUser;

/**
 * @var yii\web\View $this
 * @var backend\models\Worker $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Workers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$modelOther = Workerother::findAll(['worker_id'=>$model->worker_id]);

?>
<div class="worker-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
<?
//echo Html::img($model->pic?"uploads/".$model->pic:"uploads/no.jpg",['width'=>'213']);
?>
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
            [
                'attribute'=>'pic',
                'value'=> Html::img(Worker::workerPic($model->worker_id),['width'=>200,'height'=>200]),
                'format'=>'raw',
            ],
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
                'value'=>Worker::getEducationLevel($model->education,'view')
            ],

            [
                'attribute'=>'politics',
                'value'=>Worker::getPoliticsLevel($model->politics,'view')
            ],

            [
                'attribute'=>'chinese_level',
                'value'=>Worker::getChineseLevel($model->chinese_level,'view')
            ],

            [
                'attribute'=>'certificate',
                'value'=>Worker::getCertificateName($model->certificate)
            ],

            //'phone1',

           // 'phone2',

            [
                'attribute'=>'level',
                'value'=>Worker::getWorkerLevel($model->level,'view')
            ],

            [
                'attribute'=>'price',
                'value'=>$model->price."元/天"
            ],

            [
                'attribute'=>'status',
                'value'=>$model->status==1?'在职':'离职'
            ],

            [
                'attribute'=>'start_work',
                'value'=>$model->start_work=='0000-00-00'? "": str_replace('-','年',substr($model->start_work,0,7))."月"
            ],

//            [
//                'attribute'=>'start_work',
//                'format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'yyyy-MM-dd'],
//                'type'=>DetailView::INPUT_WIDGET,
//                'widgetOptions'=> [
//                    'class'=>DateControl::classname(),
//                    'type'=>DateControl::FORMAT_DATE
//                ]
//            ],

            'place',

            [
                'attribute'=>'nation',
                'value'=>Worker::getNation($model->nation,'view')
            ],

            [
                'attribute'=>'birth_place',
                'value'=>City::getCityName($model->birth_place)
            ],

            [
                'attribute'=>'hospital_id',
                'value'=>Hospitals::getHospitalsName($model->hospital_id)
            ],

            [
                'attribute'=>'office_id',
                'value'=>Departments::getDepartmentName($model->office_id)
            ],


//            [
//                'attribute'=>'good_at',
//                'value'=>Departments::getDepartmentName($model->good_at)
//            ],

            'total_score',

            'star',

            'total_order',

            'good_rate',

            'total_comment',
            'add_date',

//            [
//                'attribute'=>'add_date',
//                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'yyyy-MM-dd H:i:s'],
//                'type'=>DetailView::INPUT_WIDGET,
//                'widgetOptions'=> [
//                    'class'=>DateControl::classname(),
//                    'type'=>DateControl::FORMAT_DATETIME
//                ]
//            ],

            [
                'attribute'=>'adder',
                'value'=>($model->adder)? AdminUser::findOne(['admin_uid',$model->adder])->username :null,
            ],

            'edit_date',

//            [
//                'attribute'=>'edit_date',
//                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'yyyy-MM-dd H:i:s'],
//                'type'=>DetailView::INPUT_WIDGET,
//                'widgetOptions'=> [
//                    'class'=>DateControl::classname(),
//                    'type'=>DateControl::FORMAT_DATETIME
//                ]
//            ],

            [
                'attribute'=>'editer',
                'value'=>($model->editer)? AdminUser::findOne(['admin_uid',$model->editer])->username : null,
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

<!--其他信息-->
    <div class="workerother-form">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">工作经验</h3>
            </div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td><b>起止时间</b></td>
                        <td><b>工作单位</b></td>
                        <td><b>职务</b></td>
                        <td><b>主要职责与成绩</b></td>
                    </tr>
                    <tr>
                        <td>
                            <?

                                if(empty($modelOther))
                                    echo "";
                                elseif(1<strlen($modelOther[0]['ext1']) && strlen($modelOther[0]['ext1'])<13)
                                    echo $modelOther[0]['ext1']."-至今";
                                else
                                    echo $modelOther[0]['ext1'] ;?>
                        </td>
                        <td><?=empty($modelOther) ?"":$modelOther[0]['ext2']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[0]['ext3']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[0]['ext4']?></td>
                    </tr>
                    <tr>
                        <td>
                            <?
                            if(empty($modelOther))
                                echo "";
                            elseif(1<strlen($modelOther[1]['ext1']) && strlen($modelOther[1]['ext1'])<13)
                                echo $modelOther[1]['ext1']."-至今";
                            else
                                echo $modelOther[1]['ext1'] ;?>
                        </td>
                        <td><?=empty($modelOther) ?"":$modelOther[1]['ext2']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[1]['ext3']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[1]['ext4']?></td>
                    </tr>
                    <tr>
                        <td>
                            <?
                            if(empty($modelOther))
                                echo "";
                            elseif(1<strlen($modelOther[2]['ext1']) && strlen($modelOther[2]['ext1'])<13)
                                echo $modelOther[2]['ext1']."-至今";
                            else
                                echo $modelOther[2]['ext1'] ;?>
                        </td>
                        <td><?=empty($modelOther) ?"":$modelOther[2]['ext2']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[2]['ext3']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[2]['ext4']?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">自我介绍</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <tr>
                        <td>
                            <?=empty($modelOther) ?"":$modelOther[3]['ext1']?>
                        <td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">主要家庭成员</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <tr>
                        <td><b>与本人关系</b></td>
                        <td><b>姓名</b></td>
                        <td><b>职业</b></td>
                        <td><b>联系电话</b></td>
                    </tr>
                    <tr>
                        <td><?=empty($modelOther) ?"":$modelOther[4]['ext1']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[4]['ext2']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[4]['ext3']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[4]['ext4']?></td>
                    </tr>
                    <tr>
                        <td><?=empty($modelOther) ?"":$modelOther[5]['ext1']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[5]['ext2']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[5]['ext3']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[5]['ext4']?></td>
                    </tr>
                    <tr>
                        <td><?=empty($modelOther) ?"":$modelOther[6]['ext1']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[6]['ext2']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[6]['ext3']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[6]['ext4']?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">紧急联系人</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <tr>
                        <td><b>与本人关系</b></td>
                        <td><b>姓名</b></td>
                        <td><b>职业</b></td>
                        <td><b>联系方式</b></td>
                    </tr>
                    <tr>
                        <td><?=empty($modelOther) ?"":$modelOther[7]['ext1']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[7]['ext2']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[7]['ext3']?></td>
                        <td><?=empty($modelOther) ?"":$modelOther[7]['ext4']?></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>