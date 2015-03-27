<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\Models\Worker;
use backend\models\Hospitals;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\Models\WorkerSearch $searchModel
 */

$this->title = '选择护工';
?>
<div class="worker-index">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'worker_id',
            'name',
            [
                'attribute'=>'gender',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>['男'=>'男','女'=>'女'],
                'filterInputOptions'=>['placeholder'=>'请选择'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                    'hideSearch'=>true,
                ],
                'options' => [
                    'style' => 'width:90px',
                ]
            ],
            [
                'attribute'=>'birth',
                'label' => '年龄',

                'value'=> function ($model){
                    return $model->workerAge($model->birth);
                },
                'options' => [
                    'style' => 'width:90px',
                ]
            ],
            [
                'attribute'=>'hospital_id',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>Hospitals::getList(),
                'filterInputOptions'=>['placeholder'=>'请选择'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                    'hideSearch'=>true,
                ],
                'value'=> function ($model){
                    return Hospitals::getHospitalsName($model->hospital_id);
                },
                'options' => [
                    'style' => 'width:150px',
                ],
                'format'=>'raw'
            ],
            [
                'attribute'=>'level',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>Worker::getWorkerLevel(),
                'filterInputOptions'=>['placeholder'=>'请选择'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                    'hideSearch'=>true,
                ],
                'value'=>function ($model){
                    return $model->level ? Worker::getWorkerLevel($model->level) : null;
                }
            ],
            'total_score',
            [
                'attribute'=>'star',
                'value'=>function ($model){
                    return $model->workerStar($model->star);
                }
            ],
            'total_order',
            'good_rate',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{select}',
                'buttons' => [
                    'select' => function ($url, $model) {
                        return Html::button('选择护工',[
                            'class'=>'btn btn-primary jsSelectWorker',
                            'worker_id'=>$model->worker_id
                        ]);
                    }

                ],
            ],
        ],
        'export' => false,//是否显示导出
        'toggleData' => false,
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'primary',
            'showFooter'=>false
        ],
    ]);
    ?>

</div>
<script type="text/javascript">
    $('body').on('click', 'button.jsSelectWorker', function () {
        if(!confirm('确认选择此护工吗？')){
            return false;
        }
        var worker_id = $(this).attr('worker_id');
        var url = '<?php echo Yii::$app->urlManager->createUrl(['order/view','id'=>$orderId])?>';
        location.href=url+'&worker_id='+worker_id;
    });
</script>