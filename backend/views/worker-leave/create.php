<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

$this->title = '新增请假信息';
?>
<style>
    .admin-user-form{
        padding: 0 15% 0 0;
    }
</style>
<div style="margin: 2% 8% 0 8%;">
    <div class="worker-leave-list">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">护工信息</h3>
            </div>
            <div class="panel-body">
                <span class="btn-lg">姓名：<?=$worker->name?></span>
                <span class="btn-lg">工号：<?=$worker->worker_id?></span>
            </div>
        </div>
    </div>
    <div class="worker-leave-list">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">护工信息</h3>
            </div>
            <div class="panel-body">
                <div class="admin-user-create">
                    <div class="page-header">
                        <h1><?= Html::encode($this->title) ?></h1>
                    </div>
                    <div class="admin-user-form">
        <?php
            $form = ActiveForm::begin([
                    'type'=>ActiveForm::TYPE_HORIZONTAL]
            );
            echo Form::widget([
                'model'         => $model,
                'form'          => $form,
                'columns'       => 1,
                'attributes'    => [
                    'start_time'=>[
                        'type'=>Form::INPUT_WIDGET,
                        'widgetClass'=>'\kartik\widgets\DateTimePicker',
                        'options'=>[
                            'pluginOptions'=>[
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd hh:ii:ss'
                            ]
                        ]
                    ],
                    'end_time'=>[
                        'type'=>Form::INPUT_WIDGET,
                        'widgetClass'=>'\kartik\widgets\DateTimePicker',
                        'options'=>[
                            'pluginOptions'=>[
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd hh:ii:ss'
                            ]
                        ]
                    ],
                    'leave_cause'=>[
                        'type'=> Form::INPUT_TEXTAREA,
                        'options'=>[
                            'placeholder'=>'请输入请假原因...',
                            'maxlength'=>255
                        ]
                    ],
                ]
            ]);
            ?>
                        <input type="hidden" id="workerleave-worker_id" class="form-control" name="WorkerLeave[worker_id]" value="<?=$worker->worker_id?>">
                        <input type="hidden" id="workerleave-worker_name" class="form-control" name="WorkerLeave[worker_name]" value="<?=$worker->name?>">
        <?php
        echo Html::submitButton( '提交', ['class' => 'btn btn-lg btn-success jsSubmitCreate']);
        ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>