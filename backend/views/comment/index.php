<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\models\AdminUser;
use backend\models\User;
use kartik\widgets\Alert;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\CommentSearch $searchModel
 */
$this->registerJsFile('js/comment.js?v=20150404', ['position'=>yii\web\View::POS_END]);
$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;

if(Yii::$app->session->hasFlash('consol_v_error'))
  if(Yii::$app->session->getFlash('consol_v_error')){
    echo Alert::widget([
        'type' => Alert::TYPE_SUCCESS,
        'title' => 'Well done!',
        'icon' => 'glyphicon glyphicon-ok-sign',
        'body' => 'You successfully read this important alert message.',
        'showSeparator' => true,
        'delay' => 2000
    ]);
  }
?>

<div class="comment-index">
    <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('Create Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <form action="" method="post" name="comment" id="comment">
        <input type="hidden" value="" name="op" id="op">
    <?php
    $buttons ='<input type="button" name="audit_yes" id="audit_yes" value="审核通过" class="btn btn-success">';
    $buttons.= '&nbsp;&nbsp;<input type="button" name="audit_no" id="audit_no" value="审核未通过" class="btn btn-success">';

    Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            [
                'class'=>'kartik\grid\CheckboxColumn',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
            ],

            ['class' => 'yii\grid\SerialColumn'],
            'order_no',
            [
                'attribute'=>'uid',
                'value'=>function($model) {
                    return ($model->uid)? User::findOne(['id',$model->uid])['mobile'] :null;
                }
            ],
            'worker_id',
            'worker_name',
            'star',
            'content',
            [
                'attribute'=>'status',
                'value'=>function($model) {
                    if ($model->status ==1)
                        return '待审核';
                    elseif($model->status==2)
                        return '审核通过';
                    elseif($model->status==3)
                        return '审核未通过';
                }
            ],
            [
                'attribute'=>'adder',
                'value'=>function($model) {
                    return ($model->adder)? AdminUser::findOne(['admin_uid',$model->adder])['username'] :null;
                }
            ],
            'comment_date',
            [
                'attribute'=>'auditer',
                'value'=>function($model) {
                    return ($model->auditer)? AdminUser::findOne(['admin_uid',$model->auditer])['username'] :null;
                }
            ],
//            'edit_date',
            'audit_date',

//            [
//                'attribute'=>'editer',
//                'value'=>function($model) {
//                    return ($model->editer)? AdminUser::findOne(['admin_uid',$model->editer])['username'] :null;
//                }
//            ],

            'comment_ip',
            'type',
           /* [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;&nbsp;{delete}',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['comment/update','id' => $model->comment_id,'edit'=>'t']), [
                                                    'title' => Yii::t('yii', 'Edit'),
                                                  ]);}

                ],
            ],*/
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>$buttons,
            //'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]);
    echo '</form>';
    Pjax::end(); ?>
</div>