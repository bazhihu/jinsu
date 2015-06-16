<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\AdminUser;

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
            'work_id',
            'worker_id',
            'worker_name',
            'mobile',
            'user_name',
            'content:ntext',
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
             'solver_content:ntext',
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
