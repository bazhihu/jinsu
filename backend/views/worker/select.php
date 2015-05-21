<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\Worker;
use backend\models\Hospitals;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\WorkerSearch $searchModel
 */

$this->title = '选择护工';
?>
<div class="worker-index">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?php
    if(empty($searchModel->isWorking)){
        $searchModel->isWorking = 0;
    }

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
            'before'=>Html::radioList('WorkerSearch[isWorking]', $searchModel->isWorking, Worker::$isWorkingLabel),
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'primary',
            'showFooter'=>false
        ],
    ]);
    ?>

</div>
<script type="text/javascript">
    //待岗，在岗
    $('body').on('click', 'input[name="WorkerSearch[isWorking]"]', function () {
        var params = $('input,select').serialize()
        location.href='<?php echo Yii::$app->urlManager->createUrl(['worker/select', 'order_id'=>$orderId,'start_time'=>$startTime])?>&'+params;
    });

    //选择护工
    $('body').on('click', 'button.jsSelectWorker', function () {
        if(!confirm('确认选择此护工吗？')){
            return false;
        }
        var worker_id = $(this).attr('worker_id');
        var order_id = '<?php echo $orderId;?>';
        var startTime = '<?php echo $startTime;?>';
        var url = '<?php echo Yii::$app->urlManager->createUrl('worker/select')?>';
        var orderViewUrl = '<?php echo  Yii::$app->urlManager->createUrl(['order/view', 'id'=>$orderId])?>';
        $.ajax({
            type: "POST",
            dataType: "json",
            async:false,
            cache:false,
            timeout:30000,
            url: url,
            data: "order_id="+order_id+"&worker_id="+worker_id+"&start_time="+startTime,
            success: function(json){
                alert(json.msg);
                if(json.code == '200'){
                    location.href=orderViewUrl;
                }
            }
        });
    });
</script>