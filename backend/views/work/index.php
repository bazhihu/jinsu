<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\AdminUser;
use common\models\Order;
use backend\models\Hospitals;

/* @var $this yii\web\View */
/* @var $searchModel backend\Models\WorkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '工单列表';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="work-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增工单', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'work_id',
                'format'=>'raw',
                'value'=>function ($model) {
                    return Html::a($model->work_id, Yii::$app->urlManager->createUrl(['work/view','id'=>$model->work_id]));
                },
            ],
            [
                'attribute'=>'order_no',
                'format'=>'raw',
                'value'=>function ($model) {
                    return Html::a($model->order_no, Yii::$app->urlManager->createUrl(['order/view','id'=>$model->order_id]));
                },
            ],
            'worker_id',
            'worker_name',
            'mobile',
            'user_name',
            'from_where',
             'add_date',
            [
                'attribute'=>'adder',
                'value'=> function ($model) {
                    return ($model->adder) ? AdminUser::findOne(['admin_uid', $model->adder])->username : null;
                }
            ],
             'solve_date',
             'solver',
            [
                'attribute'=>  'status',
                'value'=> function ($model) {
                    if ($model->status==1)
                        return '未解决';
                    elseif ($model->status==2)
                        return '已解决';
                    elseif ($model->status==3)
                        return '关闭';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{solve}&nbsp;{user}&nbsp;{office}',
                'buttons' => [
                    'solve' => function ($url, $model) {
                        return Html::button('解决', [
                            'class'=>'btn btn-sm btn-primary jsSolveOrder',
                            'solve-url'=>Yii::$app->urlManager->createUrl([
                                'work/view',
                                'id' => $model->work_id,
                                'create'=>1
                            ])
                        ]);
                    },
                    'user' => function ($url, $model) {
                        //判断是否是TQ
                        $juese = \backend\models\AdminUser::findOne(['admin_uid'=>Yii::$app->user->id])->staff_role;
                        if($juese=='客服') {
                            return Html::button('呼出用户', [
                                'title' => '呼出用户',
                                'class' => 'btn btn-sm btn-primary jsUser',
                                'callid' => $model->mobile
                            ]);
                        }else{
                            return '';
                        }
                    },
                    'office' => function ($url, $model) {
                        //判断是否是TQ
                        $juese = \backend\models\AdminUser::findOne(['admin_uid'=>Yii::$app->user->id])->staff_role;
                        if($juese=='客服') {
                            $hospital_id = Order::findOne($model->order_id)['hospital_id'];
                            return Html::button('呼出办公室', [
                                'title' => '呼出办公室',
                                'class' => 'btn btn-sm btn-primary jsBan',
                                'callid' => Hospitals::getHospitalPhone($hospital_id)
                                //'callid'=>\backend\models\Hospitals::findOne(['id'=>$model->hospital_id])->phone
                            ]);
                        }else{
                            return '';
                        }
                    },
                ],
            ],
        ]
    ]);
    ?>
    <script language="javascript">
        //评价
        $('body').on('click', 'button.jsSolveOrder', function () {
            var button = $(this);
            var url = $(this).attr('solve-url');
            location.href=url;
        });
    </script>
</div>