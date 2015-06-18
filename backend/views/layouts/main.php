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


    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
    } else {
        $menuItems = [
            [
                'label' => '护工',
                'items' => [
                    ['label' => '添加', 'url' => ['/worker/create']],
                    ['label' => '列表', 'url' => ['/worker/index']],
                    ['label' => '请假', 'url' => ['/worker-leave/index']],
                    ['label' => '工资卡', 'url' => ['/worker-card/index']],
                ]
            ],
            [
                'label' => '订单',
                'items' => [
                    ['label' => '创建', 'url' => ['/order/create']],
                    ['label' => '列表', 'url' => ['/order/index']],
                    ['label' => '统计', 'url' => ['/order/chart']]
                ]
            ],
            [
                'label' => '用户',
                'url' => ['/user/index']
            ],
            [
                'label' => '评价',
                'url' => ['/comment/index']
            ],
            [
                'label' => '财务',
                'items' => [
                    ['label' => '提现申请', 'url' => ['/wallet/cash-list']],
                    ['label' => '提现支付', 'url' => ['/wallet/confirm-list']],
                    ['label' => '交易明细', 'url' => ['/wallet/debit-records']],
                    '<li class="divider"></li>',
                    ['label' => '护工账户', 'url' => ['/worker-account']],
                    ['label' => '护工账单', 'url' => ['/worker-bill']],
                    ['label' => '护工提现', 'url' => ['/worker-withdrawcash']],
                    ['label' => '护工工资卡', 'url' => ['/worker-card']],
                    ['label' => '护工请假列表', 'url' => ['/worker-card']],
                ]
            ],
            [
                'label' => '帐号',
                'url' => ['/admin-user/index']
            ],
            [
                'label' => '其它',
                'items' => [
                    ['label' => '医院管理', 'url' => ['/hospitals/index']],
                    ['label' => '科室管理', 'url' => ['/departments/index']],
                    ['label' => '节假日管理', 'url' => ['/holidays/index']]
                ]
            ]
        ];
        $menuItems[] = [
            'label' => Yii::$app->user->identity->username.'('.key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->getId())).')',
            'items' => [
                ['label' => '修改密码', 'url' => ['/admin-user/reset']],
                ['label' => '退出', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
            ]
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div class="container-fluid">
        <?= $content ?>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
