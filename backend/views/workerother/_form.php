<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\Models\Workerother $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="workerother-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);?>
    <form action="" method="post">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">工作经验</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <td><b>起止时间</b><td>
                    <td><b>工作单位</b><td>
                    <td><b>职务</b><td>
                    <td><b>主要职责与成绩</b><td>
                </tr>
                <tr>
                    <td><input name="ext1_1"><td>
                    <td><input name="ext2_1"><td>
                    <td><input name="ext3_1"><td>
                    <td><input name="ext4_1"><td>
                </tr>
                <tr>
                    <td><input name="ext1_1"><td>
                    <td><input name="ext2_1"><td>
                    <td><input name="ext3_1"><td>
                    <td><input name="ext4_1"><td>
                </tr>
                <tr>
                    <td><input name="ext1_1"><td>
                    <td><input name="ext2_1"><td>
                    <td><input name="ext3_1"><td>
                    <td><input name="ext4_1"><td>
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
                        <textarea style="width: 100%;height: 200px" name="ext1_2"></textarea>
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
                    <td><b>与本人关系</b><td>
                    <td><b>姓名</b><td>
                    <td><b>职业</b><td>
                    <td><b>联系电话</b><td>
                </tr>
                <tr>
                    <td><input name="ext1_3[]" value=""><td>
                    <td><input name="ext2_3[]"><td>
                    <td><input name="ext3_3[]"><td>
                    <td><input name="ext4_3[]"><td>
                </tr>
                <tr>
                    <td><input name="ext1_3[]"><td>
                    <td><input name="ext2_3[]"><td>
                    <td><input name="ext3_3[]"><td>
                    <td><input name="ext4_3[]"><td>
                </tr>
                <tr>
                    <td><input name="ext1_3[]"><td>
                    <td><input name="ext2_3[]"><td>
                    <td><input name="ext3_3[]"><td>
                    <td><input name="ext4_3[]"><td>
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
                    <td><b>与本人关系</b><td>
                    <td><b>姓名</b><td>
                    <td><b>职业</b><td>
                    <td><b>联系方式</b><td>
                </tr>
                <tr>
                    <td><input name="ext1_4"><td>
                    <td><input name="ext2_4"><td>
                    <td><input name="ext3_4"><td>
                    <td><input name="ext4_4"><td>
                </tr>
            </table>
        </div>
    </div>
    <?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', '保存') : Yii::t('app', '保存'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>
    </form>
</div>
