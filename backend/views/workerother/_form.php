<?php

use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use frontend\widgets;
use kartik\builder\Form;

/**
 * @var yii\web\View $this
 * @var backend\models\Workerother $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="workerother-form">
    <?php $form = ActiveForm::begin([
            'type'=>ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'options' => ['enctype' => 'multipart/form-data']
        ]
    );?>
    <input type="hidden" name="worker_id" value="<?=(int)$_GET['worker_id']?>">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">工作经验</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped" style="border: :1px">
                <tr>
                    <td  align="left"><b>开始时间</b></td>
                    <td align="left"><b>截止时间</b></td>
                    <td  align="left"><b>工作单位</b></td>
                    <td  align="left"><b>职务</b></td>
                    <td  align="left"><b>主要职责与成绩</b></td>
                </tr>
                <tr>
                    <td  align="left">
                        <input id="begin_dt0" name="begin_dt0" class="time" type="text" value=<?=empty($model[0]['ext1']) ? "": substr($model[0]['ext1'],0,12)?>>
<!--                        --><?//
//                        echo DateControl::widget([
//                            'name'=>'begin_dt0',
//                            'value'=>isset($model[0]['ext1'])? substr($model[0]['ext1'],0,10):"",
//                            'type'=>DateControl::FORMAT_DATE,
//                            'displayFormat' => 'yyyy-MM-dd',
//                            'options'=>["options"=>[ 'style'=>'width:60%']],
//                            'pluginOptions'=>['todayHighlight' => true, 'autoclose' => true, 'inline'=>true],
//                        ]);?>
                    </td>
                    <td  align="left">
                        <input id="end_dt0" name="end_dt0" class="time" type="text" value=<?=empty($model[0]['ext1']) ? "": substr($model[0]['ext1'],13,24)?>>
<!--                        --><?//
//                        echo DateControl::widget([
//                            'name'=>'end_dt0',
//                            'value'=>isset($model[0]['ext1'])? substr($model[0]['ext1'],13,10):"",
//                            'type'=>DateControl::FORMAT_DATE,
//                            'displayFormat' => 'yyyy-MM-dd',
//                            'options'=>["options"=>[ 'style'=>'width:60%']],
//                            'pluginOptions'=>['todayHighlight' => true, 'autoclose' => true, 'inline'=>true],
//                        ]);?>
                    </td>
                    <td  align="left"><input name="ext2_1[]" value="<?=empty($model) ?"":$model[0]['ext2']?>"></td>
                    <td  align="left"><input name="ext3_1[]" value="<?=empty($model) ?"":$model[0]['ext3']?>"></td>
                    <td  align="left"><input name="ext4_1[]" value="<?=empty($model) ?"":$model[0]['ext4']?>"></td>
                </tr>
                <tr>
                    <td>
                        <input id="begin_dt1" name="begin_dt1" class="time" type="text" value=<?=empty($model[1]['ext1']) ? "": substr($model[1]['ext1'],0,12)?>>
<!--                        --><?//
//                        echo DateControl::widget([
//                            'name'=>'begin_dt1',
//                            'value'=>isset($model[1]['ext1'])? substr($model[1]['ext1'],0,10):"",
//                            'type'=>DateControl::FORMAT_DATE,
//                            'displayFormat' => 'yyyy-MM-dd',
//                            'options'=>["options"=>[ 'style'=>'width:60%']],
//                            'pluginOptions'=>['todayHighlight' => true, 'autoclose' => true,'style'=>'width:100px'],
//                        ]);?>
                    </td>
                    <td align="left">
                        <input id="end_dt1" name="end_dt1" class="time" type="text" value=<?=empty($model[1]['ext1']) ? "": substr($model[1]['ext1'],13,24)?>>
<!--                        --><?//
//                        echo DateControl::widget([
//                            'name'=>'end_dt1',
//                            'value'=>isset($model[1]['ext1'])? substr($model[1]['ext1'],13,10):"",
//                            'type'=>DateControl::FORMAT_DATE,
//                            'displayFormat' => 'yyyy-MM-dd',
//                            'options'=>["options"=>[ 'style'=>'width:60%']],
//                            'pluginOptions'=>['todayHighlight' => true, 'autoclose' => true],
//                        ]);?>
                    </td>
                    <td><input name="ext2_1[]" value="<?=empty($model) ?"":$model[1]['ext2']?>"></td>
                    <td><input name="ext3_1[]" value="<?=empty($model) ?"":$model[1]['ext3']?>"></td>
                    <td><input name="ext4_1[]" value="<?=empty($model) ?"":$model[1]['ext4']?>"></td>
                </tr>
                <tr>
                    <td>
                        <input id="begin_dt2" name="begin_dt2" class="time" type="text" value=<?=empty($model[2]['ext1']) ? "": substr($model[2]['ext1'],0,12)?>>
<!--                        --><?//
//                        echo DateControl::widget([
//                            'name'=>'begin_dt2',
//                            'value'=>isset($model[2]['ext1'])? substr($model[2]['ext1'],0,10):"",
//                            'type'=>DateControl::FORMAT_DATE,
//                            'displayFormat' => 'yyyy-MM-dd',
//                            'options'=>["options"=>[ 'style'=>'width:60%']],
//                            'pluginOptions'=>['todayHighlight' => true, 'autoclose' => true],
//                        ]);?>
                    </td>
                    <td  align="left">
                        <input id="end_dt2" name="end_dt2" class="time" type="text" value=<?=empty($model[2]['ext1']) ? "": substr($model[2]['ext1'],13,24)?>>
<!--                        --><?//
//                        echo DateControl::widget([
//                            'name'=>'end_dt2',
//                            'value'=>isset($model[2]['ext1'])? substr($model[2]['ext1'],13,10):"",
//                            'type'=>DateControl::FORMAT_DATE,
//                            'displayFormat' => 'yyyy-MM-dd',
//                            'options'=>["options"=>[ 'style'=>'width:60%']],
//                            'pluginOptions'=>['todayHighlight' => true, 'autoclose' => true],
//                        ]);?>
                    </td>
                    <td><input name="ext2_1[]" value="<?=empty($model) ?"":$model[2]['ext2']?>"></td>
                    <td><input name="ext3_1[]" value="<?=empty($model) ?"":$model[2]['ext3']?>"></td>
                    <td><input name="ext4_1[]" value="<?=empty($model) ?"":$model[2]['ext4']?>"></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">自我介绍</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <td>
                        <textarea style="width: 100%;height: 200px" name="ext1_2[]"><?=empty($model) ? "":$model[3]['ext1']?></textarea>
                    <td>
                </tr>
            </table>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">主要家庭成员</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <td><b>与本人关系</b></td>
                    <td><b>姓名</b></td>
                    <td><b>职业</b></td>
                    <td><b>联系电话</b></td>
                </tr>
                <tr>
                    <td><input name="ext1_3[]" value="<?=empty($model) ?"":$model[4]['ext1']?>"></td>
                    <td><input name="ext2_3[]" value="<?=empty($model) ?"":$model[4]['ext2']?>"></td>
                    <td><input name="ext3_3[]" value="<?=empty($model) ?"":$model[4]['ext3']?>"></td>
                    <td><input name="ext4_3[]" value="<?=empty($model) ?"":$model[4]['ext4']?>"></td>
                </tr>
                <tr>
                    <td><input name="ext1_3[]"  value="<?=empty($model) ?"":$model[5]['ext1']?>"></td>
                    <td><input name="ext2_3[]"  value="<?=empty($model) ?"":$model[5]['ext2']?>"></td>
                    <td><input name="ext3_3[]"  value="<?=empty($model) ?"":$model[5]['ext3']?>"></td>
                    <td><input name="ext4_3[]"  value="<?=empty($model) ?"":$model[5]['ext4']?>"></td>
                </tr>
                <tr>
                    <td><input name="ext1_3[]"  value="<?=empty($model) ?"":$model[6]['ext1']?>"></td>
                    <td><input name="ext2_3[]"  value="<?=empty($model) ?"":$model[6]['ext2']?>"></td>
                    <td><input name="ext3_3[]"  value="<?=empty($model) ?"":$model[6]['ext3']?>"></td>
                    <td><input name="ext4_3[]"  value="<?=empty($model) ?"":$model[6]['ext4']?>"></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">紧急联系人</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <td><b>与本人关系</b></td>
                    <td><b>姓名</b></td>
                    <td><b>职业</b></td>
                    <td><b>联系方式</b></td>
                </tr>
                <tr>
                    <td><input name="ext1_4[]" value="<?=empty($model) ?"":$model[7]['ext1']?>"></td>
                    <td><input name="ext2_4[]" value="<?=empty($model) ?"":$model[7]['ext2']?>"></td>
                    <td><input name="ext3_4[]" value="<?=empty($model) ?"":$model[7]['ext3']?>"></td>
                    <td><input name="ext4_4[]" value="<?=empty($model) ?"":$model[7]['ext4']?>"></td>
                </tr>
            </table>
        </div>
    </div>
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
        <input type="submit" class="btn btn-success" value="保存">
    <?//php echo Html::submitButton($model->isNewRecord ? Yii::t('app', '保存') : Yii::t('app', '保存'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>
</div>
<script type="text/javascript" >
    $(document).ready(function(){
        $('#begin_dt0').unbind('focus');
        $('#begin_dt0').bind('focus',function(){WdatePicker({skin:'whyGreen',dateFmt:'yyyy年MM月'});});
        $('#end_dt0').unbind('focus')
        $('#end_dt0').bind('focus',function(){WdatePicker({skin:'whyGreen',dateFmt:'yyyy年MM月',minDate:'#F{$dp.$D(\'begin_dt0\')}'});});

        $('#begin_dt1').unbind('focus');
        $('#begin_dt1').bind('focus',function(){WdatePicker({skin:'whyGreen',dateFmt:'yyyy年MM月'});});
        $('#end_dt1').unbind('focus')
        $('#end_dt1').bind('focus',function(){WdatePicker({skin:'whyGreen',dateFmt:'yyyy年MM月',minDate:'#F{$dp.$D(\'begin_dt1\')}'});});

        $('#begin_dt2').unbind('focus');
        $('#begin_dt2').bind('focus',function(){WdatePicker({skin:'whyGreen',dateFmt:'yyyy年MM月'});});
        $('#end_dt2').unbind('focus')
        $('#end_dt2').bind('focus',function(){WdatePicker({skin:'whyGreen',dateFmt:'yyyy年MM月',minDate:'#F{$dp.$D(\'begin_dt2\')}'});});
    });
</script>
<script type="text/javascript" src="/js/wdatepicker/wdatepicker.js"></script>