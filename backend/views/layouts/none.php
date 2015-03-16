<?php
use backend\assets\AppAsset;
use yii\helpers\Html;


/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<?= $content ?>
<?php $this->endPage() ?>