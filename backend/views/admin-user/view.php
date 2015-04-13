<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var backend\models\AdminUser $model
 */

$this->title = $model->username;

?>
<div class="admin-user-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title); ?></h1>
    </div>
    <?= DetailView::widget([
            'model'     => $model,
            'condensed' =>false,
            'hover'     =>true,
            'mode'      =>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel'     =>[
            'heading'   =>$this->title,
            'type'      =>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'username',
            ['label'=>'密码','value'=>'******'],
            'staff_role',
            ['label'=>'状态','value'=>$model->status?'正常':'关闭'],
            [
                'attribute'=>'created_at',
            ],
            [
                'attribute'=>'created_id',
                'label'=>'创建人',
                'value'=>\backend\models\AdminUser::getInfo($model->created_id),
            ]
        ],
        'deleteOptions'=>[
            'url'=>['delete', 'id' => $model->id],
            'data'=>[
            'confirm'=>Yii::t('app', '确定要操作这个用户的权限？'),
            'method'=>'post',
            ],
        ],
        'enableEditMode'=>false,
    ]);
    ?>
    <?= Html::a('完成',
        Yii::$app->urlManager->createUrl(['admin-user/index']),
        [
            'class' =>'btn btn-success'
        ]
    );?>
</div>
