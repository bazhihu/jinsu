<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Worker;
use backend\models\Hospitals;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\WorkerSearch $searchModel
 */
$this->registerJsFile('js/worker.js?v=20150421', ['position'=>yii\web\View::POS_END]);
$this->title = '护工管理';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="worker-index">
    <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Worker', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <form action="" method="post" name="worker" id="worker">
        <input type="hidden" value="" name="op" id="op">
        <?php

        $role = key(Yii::$app->authManager->getRolesByUser(yii::$app->user->identity->getId()));
        if ($role=='系统管理员' || $role=='护工信息编辑'){
            $buttons ='<input type="button" name="audit_yes" id="audit_yes" value="上线" class="btn btn-success">';
            $buttons.= '&nbsp;&nbsp;<input type="button" name="audit_no" id="audit_no" value="下线" class="btn btn-success">';
        }else{
            $buttons="";
        }

        Pjax::begin();
        echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'class'=>'kartik\grid\CheckboxColumn',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
            ],
            ['class' => 'yii\grid\SerialColumn'],
            'worker_id',
            [
                'attribute'=>'name',
                'format'=>'raw',
                'value'=>function ($model) {
                    return Html::a($model->name, Yii::$app->urlManager->createUrl(['worker/view','id'=>$model->worker_id]));
                },
            ],
            'gender',
            [
                'attribute'=>'birth',
                'label' => '年龄',
                'value'=> function ($model){
                    return $model->workerAge($model->birth);
                }
            ],
            //'native_province',
            [
                'attribute'=>'hospital_id',
                'value'=> function ($model){
                    return Hospitals::getHospitalsName($model->hospital_id);
                }
            ],
            [
                'attribute'=>'level',
                'value'=>function ($model){
                    return Worker::getWorkerLevel($model->level);
                }
            ],
            'price',
            /*[
                'attribute'=>  'status',
                'value'=> function ($model) {
                    if ($model->status==1)
                        return '在职';
                    elseif ($model->status==2)
                        return '离职';
                }
            ],*/
            'total_score',
            [
                'attribute'=>'star',
                'value'=>function ($model){

                    return $model->workerStar($model->star);
                }
            ],
            'total_order',
            'good_rate',
            'total_comment',
            [
                'attribute'=>'audit_status',
                'value'=>function ($model){
                    return $model->audit_status == 1 ? '上线':'下线';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{calendar}&nbsp;&nbsp;{update}&nbsp;&nbsp;{card}&nbsp;&nbsp;{leave}',
                'buttons' => [
                    'calendar' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-calendar"></span>',
                            Yii::$app->urlManager->createUrl(['worker/schedule','id' => $model->worker_id]),
                            ['title' => '排期']
                        );
                    },
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['worker/update','id' => $model->worker_id]),
                            ['title' => '编辑']
                        );
                    },
                    'card' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-credit-card"></span>',
                            Yii::$app->urlManager->createUrl(['worker-card/create','id' => $model->worker_id]),
                            ['title' => '工资卡']
                        );
                    },
                    'leave' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-home"></span>',
                            Yii::$app->urlManager->createUrl(['worker-leave/create','id' => $model->worker_id]),
                            ['title' => '请假']
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
            'before'=>$buttons."&nbsp;&nbsp;".Html::a('<i class="glyphicon glyphicon-plus"></i> 添加护工', ['create'], ['class' => 'btn btn-success']),
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> 重置列表', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]);

     echo '</form>';
     Pjax::end(); ?>
</div>