<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletUserDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wallet User Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallet-user-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!--?= Html::a('Create Wallet User Detail', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'detail_no',
            'detail_time',
            [
                'attribute'=>'uid',
                'value'=>function($model){
                    return \backend\Models\User::findOne(['id'=>$model->uid])->username;
                },
            ],
            [
                'attribute'=>'pay_from',
                'value'=>function($model){
                    if($model->pay_from == 'Backstage')
                    {
                        return '现金支付';
                    }elseif($model->pay_from == '2'){
                        return '支付宝';
                    }elseif($model->pay_from == '3'){
                        return '微信支付';
                    }
                }
            ],
            'detail_money',
            'wallet_money',
            [
                'attribute'=>'admin_uid',
                'value'=>function($model){
                    return \backend\models\AdminUser::findOne(['admin_uid'=>$model->admin_uid])->username;
                }
            ],
//            [
//                'class' => 'yii\grid\ActionColumn',
//                'template'=>'',
//            ],
        ],
    ]); ?>

</div>
