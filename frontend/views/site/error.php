<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<style>
    .line {border-top: 4px solid #2dcb9c; overflow: hidden; -webkit-background-size: cover; background-size: cover; }
    .express p{
        color: #334559;
        font-size: 20px;
        font-weight: 400;
        line-height: 32px;
    }
    h1{margin-bottom:10px}
</style>
<div class="line"></div>
<div class="express section clearfix">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>

</div>
