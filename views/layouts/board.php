<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>
        <?= Html::encode($this->title) ?><?php if (Html::encode($this->title) != Yii::$app->setting->get('ojName')) echo " - " . Yii::$app->setting->get('ojName'); ?>
    </title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web') ?>/favicon.ico">
    <link href="<?= Yii::getAlias('@web') ?>/css/domjudge.css" rel="stylesheet">
    <script>
        function errorImg(img) {
            img.src = "<?= Yii::getAlias('@web') ?>/images/default.jpg";
            img.onerror = null;
        }
    </script>
</head>

<body>
    <?php $this->beginBody() ?>

    <div>
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->setting->get('ojName'),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-lg navbar-light fixed-top scnuoj-nav',
            ],
            'innerContainerOptions' => ['class' => 'container-fluid']
        ]);
        $menuItemsLeft = [
            [
                'label' => '<i class="fas fa-fw fa-book-open"></i> ' . Yii::t('app', 'Problems'),
                'url' => ['/problem/index'],
                'active' => Yii::$app->controller->id == 'problem',
            ],
            [
                'label' => '<i class="fas fa-fw fa-tasks"></i> ' . Yii::t('app', 'Status'),
                'url' => ['/solution/index'],
                'active' => Yii::$app->controller->id == 'solution'
            ],
            [
                'label' => '<i class="fas fa-fw fa-chart-line"></i> ' . Yii::t('app', 'Rating'),
                'url' => ['/rating/index'],
                'active' => Yii::$app->controller->id == 'rating'
            ],
            [
                'label' => '<i class="fas fa-fw fa-comment"></i> ' . Yii::t('app', 'Discuss'),
                'url' => ['/discuss/index'],
                'active' => Yii::$app->controller->id == 'discuss'
            ],
            [
                'label' => '<i class="fas fa-fw fa-users"></i> ' . Yii::t('app', 'Group'),
                'url' => Yii::$app->user->isGuest ? ['/group/index'] : ['/group/my-group'],
                'active' => Yii::$app->controller->id == 'group'
            ],
            [
                'label' => '<i class="fas fa-fw fa-trophy"></i> ' .  Yii::t('app', 'Contests'),
                'url' => ['/contest/index'],
                'active' => Yii::$app->controller->id == 'contest'
            ],
            [
                'label' => '<i class="fas fa-fw fa-file"></i> ' . Yii::t('app', 'Wiki'),
                'url' => ['/wiki/index'],
                'active' => Yii::$app->controller->id == 'wiki'
            ]
        ];

        if (Yii::$app->user->isGuest) {
            $menuItemsRight[] = [
                'label' => '<i class="fas fa-fw fa-sign-in-alt"></i> ' . Yii::t('app', 'Login'),
                'linkOptions' => [
                    'class' => 'badge badge-primary text-white',
                    'style' => 'font-size: 0.930125rem; padding-left:0.8rem; padding-right:0.8rem'
                ],
                'url' => ['/site/login']
            ];
        } else {
            $menuItemsRight[] =  [
                'label' => '<i class="fas fa-fw fa-user"></i> ' .  Html::encode(Yii::$app->user->identity->nickname),
                'items' => [
                    [
                        'label' => '<i class="fas fa-fw fa-sliders-h"></i> ' . Yii::t('app', 'Backend'),
                        'url' => ['/admin'],
                        'visible' => Yii::$app->user->identity->isAdmin()
                    ],
                    [
                        'label' => '<i class="fas fa-fw fa-sliders-h"></i> ' . Yii::t('app', 'Backend'),
                        'url' => ['/admin/problem'],
                        'visible' => Yii::$app->user->identity->isVip()
                    ],
                    [
                        'label' => '<i class="fas fa-fw fa-home"></i> ' . Yii::t('app', 'Profile'),
                        'url' => ['/user/view', 'id' => Yii::$app->user->id],
                    ],
                    [
                        'label' => '<i class="fas fa-fw fa-wrench"></i> ' . Yii::t('app', 'Setting'),
                        'url' => ['/user/setting', 'action' => 'default'],
                    ],
                    [
                        'label' => '<i class="fas fa-fw fa-sign-out-alt"></i> ' . Yii::t('app', 'Logout'),
                        'url' => ['/site/logout'],
                    ]
                ]
            ];
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav mr-auto'],
            'items' => $menuItemsLeft,
            'encodeLabels' => false,
            'activateParents' => true
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav '],
            'items' => $menuItemsRight,
            'encodeLabels' => false,
            'activateParents' => true
        ]);
        NavBar::end();
        ?>
        <div class="animate__animated animate__fadeIn animate__faster">
            <?= $content ?>
        </div>

        <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>