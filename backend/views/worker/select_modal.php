<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/6/9
 * Time: 11:57
 */
use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\Worker;
use backend\models\Hospitals;
use backend\models\City;

$this->title = '选择护工';
if(empty($searchModel->isWorking)){
    $searchModel->isWorking = 0;
}
?>
<div class="worker-index">
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
                ]
            ],
            [
                'attribute'=>'birth',
                'label' => '年龄',

                'value'=> function ($model){
                    return $model->workerAge($model->birth);
                }
            ],
            [
                'attribute'=>'city_id',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>City::getList(null, true),
                'filterInputOptions'=>['placeholder'=>'请选择','style' => 'display:none'],

                'value'=> function ($model){
                    return City::getCityName($model->city_id);
                }
            ],
            [
                'attribute'=>'hospital_id',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>Hospitals::getList(0, $cityId),
                'filterInputOptions'=>['placeholder'=>'请选择','style'=>'width:220px'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>[
                        'allowClear'=>true
                    ]
                ],
                'value'=> function ($model){
                    return Hospitals::getHospitalsName($model->hospital_id);
                }
            ],
            [
                'attribute'=>'level',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>Worker::$workerLevelLabel,
                'filterInputOptions'=>['placeholder'=>'请选择'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                    'hideSearch'=>true,
                ],
                'value'=>function ($model){
                    return $model->level ? Worker::getWorkerLevel($model->level) : null;
                }
            ],
            'price',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{select}',
                'buttons' => [
                    'select' => function ($url, $model) {
                        return Html::button('选择护工',[
                            'class'=>'btn btn-primary js-confirm-select-worker',
                            'worker_id'=>$model->worker_id,
                            'worker_name'=>$model->name,
                            'price'=>$model->price,
                            'level'=>$model->level
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
        var params = $('input,select').serialize();
        location.href='<?php echo Yii::$app->urlManager->createUrl([
        'worker/select',
        'template'=>$template,
        'order_id'=>$orderId,
        'start_time'=>$startTime,
        'city_id'=>$cityId])?>&'+params;
    });

    $('.js-confirm-select-worker').on('click', function(){
        var parentFrom = $('#w0', window.parent.document);
        var workerNo = $(this).attr('worker_id');
        var workerName = $(this).attr('worker_name');
        var price = $(this).attr('price');
        var level = $(this).attr('level');

        //向父窗口添加护工Id和name
        var workerNoInput = '<input id="ordermaster-worker_no" name="OrderMaster[worker_no]" type="hidden" value="'+workerNo+'">';
        var workerNameInput = '<input id="ordermaster-worker_name" name="OrderMaster[worker_name]" type="hidden" value="'+workerName+'">';
        parentFrom.find('#ordermaster-worker_no').remove();
        parentFrom.find('#ordermaster-worker_name').remove();
        parentFrom.find('#ordermaster-worker_level').val(level);
        var workerLevelName = parentFrom.find('#ordermaster-worker_level').find('option:selected').text();
        parentFrom.find('#select2-chosen-4').text(workerLevelName);
        parentFrom.find('#ordermaster-base_price').val(price);
        parentFrom.append(workerNoInput);
        parentFrom.append(workerNameInput);
        parentFrom.find('#worker-name').text(workerName).parent().show();

        //关闭modal窗口
        $(window.parent.document).find('#selectWorkerModal').hide();
    });



</script>