<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\Models\Workerother $model
 */

$this->title = '护工其他信息';
$this->params['breadcrumbs'][] = ['label' => 'Workerothers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="workerother-form">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">工作经验</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <td><b>起止时间</b></td>
                    <td><b>工作单位</b></td>
                    <td><b>职务</b></td>
                    <td><b>主要职责与成绩</b></td>
                </tr>
                <tr>
                    <td><?=$model[0]['ext1']?></td>
                    <td><?=$model[0]['ext2']?></td>
                    <td><?=$model[0]['ext3']?></td>
                    <td><?=$model[0]['ext4']?></td>
                </tr>
                <tr>
                    <td><?=$model[1]['ext1']?></td>
                    <td><?=$model[1]['ext2']?></td>
                    <td><?=$model[1]['ext3']?></td>
                    <td><?=$model[1]['ext4']?></td>
                </tr>
                <tr>
                    <td><?=$model[2]['ext1']?></td>
                    <td><?=$model[2]['ext2']?></td>
                    <td><?=$model[2]['ext3']?></td>
                    <td><?=$model[2]['ext4']?></td>
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
                        <?=$model[3]['ext1']?>
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
                    <td><?=$model[4]['ext1']?></td>
                    <td><?=$model[4]['ext2']?></td>
                    <td><?=$model[4]['ext3']?></td>
                    <td><?=$model[4]['ext4']?></td>
                </tr>
                <tr>
                    <td><?=$model[5]['ext1']?></td>
                    <td><?=$model[5]['ext2']?></td>
                    <td><?=$model[5]['ext3']?></td>
                    <td><?=$model[5]['ext4']?></td>
                </tr>
                <tr>
                    <td><?=$model[6]['ext1']?></td>
                    <td><?=$model[6]['ext2']?></td>
                    <td><?=$model[6]['ext3']?></td>
                    <td><?=$model[6]['ext4']?></td>
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
                    <td><?=$model[7]['ext1']?></td>
                    <td><?=$model[7]['ext2']?></td>
                    <td><?=$model[7]['ext3']?></td>
                    <td><?=$model[7]['ext4']?></td>
                </tr>
            </table>
        </div>
    </div>
