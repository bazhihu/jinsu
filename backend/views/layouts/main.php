<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <?php
    NavBar::begin([
        'brandLabel' => '优爱医护',
        'brandUrl' => Yii::$app->homeUrl,
        'innerContainerOptions' =>[
            'class' => 'container-fluid'
        ],
        //'renderInnerContainer' => false,
        'options' => [
            'class' => 'navbar navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems = [
        ['label' => '节假日管理', 'url' => ['/holidays/index']],
        ['label' => '首页', 'url' => ['/site/index']],
        ['label' => '修改密码', 'url' => ['/admin-user/reset']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => '退出 (' . Yii::$app->user->identity->username . '|' . key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->getId())). ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1 sidebar">
                <?=Yii::$app->view->renderFile('@backend/views/pages/left-menu.php');?>
            </div>
            <div class="col-md-11 col-sm-offset-2 col-md-offset-1">
                <?= $content ?>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
