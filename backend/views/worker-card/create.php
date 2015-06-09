<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

$this->title = '新增银行卡';
?>
<style>
    .admin-user-form{
        padding: 0 15% 0 0;
    }
</style>
<div class="panel panel-info" style="margin: 8%;">
    <div class="panel-body">
        <div class="worker-leave-list">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">护工信息</h3>
                </div>
                <div class="panel-body">
                    <span class="btn-lg">姓名：<?=$name?></span>
                    <span class="btn-lg">工号：<?=$id?></span>
                </div>
            </div>
        </div>
        <div class="worker-leave-list">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">新增银行卡</h3>
                </div>
                <div class="panel-body">
                    <div class="worker-card-create">
                        <div class="worker-card-form">
                            <?php
                            $form = ActiveForm::begin([
                                    'type'=>ActiveForm::TYPE_HORIZONTAL]
                            );
                            echo Form::widget([
                                'model'         => $model,
                                'form'          => $form,
                                'columns'       => 1,
                                'attributes'    => [
                                    'worker_id'=>[
                                        'type'=> Form::INPUT_HIDDEN,
                                        'options'=>[
                                            'value'=>$id
                                        ],
                                        'label'=>false,
                                    ],
                                    'worker_name'=>[
                                        'type'=> Form::INPUT_HIDDEN,
                                        'options'=>[
                                            'value'=>$name
                                        ],
                                        'label'=>false,
                                    ],
                                    'identity_card'=>[
                                        'type'=> Form::INPUT_TEXT,
                                        'options'=>[
                                            'placeholder'=>'请输入身份证...',
                                            'maxlength'=>255,
                                        ]
                                    ],
                                    'bank'=>[
                                        'type'=> Form::INPUT_DROPDOWN_LIST,
                                        'items'=>\backend\models\WorkerCard::$_BANK,
                                        'options'=>[
                                            'prompt'=>'选择'
                                        ]
                                    ],
                                    'bank_card'=>[
                                        'type'=> Form::INPUT_TEXT,
                                        'options'=>[
                                            'placeholder'=>'请输入银行卡号...',
                                            'maxlength'=>255,
                                        ]
                                    ],
                                    'bank_sub_account'=>[
                                        'type'=> Form::INPUT_TEXT,
                                        'options'=>[
                                            'placeholder'=>'请输入子账户...',
                                            'maxlength'=>255,
                                        ]
                                    ],
                                ]
                            ]);
                            ?>
                            <?php
                            echo Html::submitButton( '提交', ['class' => 'btn btn-lg btn-success jsSubmitCreate']);
                            ActiveForm::end(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>