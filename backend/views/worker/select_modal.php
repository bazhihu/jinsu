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
                'filterInputOptions'=>['placeholder'=>'请选择'],
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

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{select}',
                'buttons' => [
                    'select' => function ($url, $model) {
                        return Html::button('选择护工',[
                            'class'=>'btn btn-primary js-confirm-select-worker',
                            'worker_id'=>$model->worker_id,
                            'worker_name'=>$model->name
                        ]);
                    }

                ],
            ],
        ],
        'export' => false,//是否显示导出

    ]);
    ?>

</div>
<script type="text/javascript">
    $('.js-confirm-select-worker').on('click', function(){
        var parentFrom = $('#w0', window.parent.document);

        //向父窗口添加护工Id和name

        //关闭modal窗口

    });



</script>