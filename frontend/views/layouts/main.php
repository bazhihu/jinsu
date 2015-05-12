<?php
use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Html::encode($this->title) ?></title>
    <link href="/css/index.css?v=2015051201" rel="stylesheet" />
</head>
<body>
    <div id="header" class="section">
        <a class="invite" href="<?=Yii::$app->urlManager->createUrl(['site/about']);?>">关于我们</a>
        <a class="invite" href="#">招聘护理员：400-630-9860</a>
        <a class="logo" href="/"><h1 class="logo">优爱医护</h1></a>
    </div>

    <?php $this->beginBody() ?>
    <?= $content ?>
    <?= Yii::$app->view->render('@frontend/views/pages/footer.php') ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
