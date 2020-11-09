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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web') ?>/favicon.ico">
</head>

<body>
    <?php $this->beginBody() ?>

    <div>
        <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->setting->get('ojName'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-light fixed-top',
        ],
        'innerContainerOptions' => ['class' => 'container-fluid']
    ]);
    $menuItemsLeft = [
        ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
        [
            'label' => Yii::t('app', 'Problems'),
            'url' => ['/problem/index'],
            'active' => Yii::$app->controller->id == 'problem'
        ],
        ['label' => Yii::t('app', 'Status'), 'url' => ['/solution/index']],
        [
            'label' => Yii::t('app', 'Rating'),
            'url' => ['/rating/index'],
            'active' => Yii::$app->controller->id == 'rating'
        ],
        [
            'label' => Yii::t('app', 'Group'),
            'url' => Yii::$app->user->isGuest ? ['/group/index'] : ['/group/my-group'],
            'active' => Yii::$app->controller->id == 'group'
        ],
        [
            'label' => Yii::t('app', 'Contests'), 
            'url' => ['/contest/index'],
            'active' => Yii::$app->controller->id == 'contest'
        ],
        [
            'label' => Yii::t('app', 'Wiki'),
            'url' => ['/wiki/index'],
            'active' => Yii::$app->controller->id == 'wiki'
        ],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItemsRight[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
        $menuItemsRight[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    } else {
        if (Yii::$app->user->identity->isAdmin()) {
            $menuItemsRight[] = [
                'label' => Yii::t('app', 'Backend'),
                'url' => ['/admin'],
                'active' => Yii::$app->controller->module->id == 'admin'
            ];
        }
        if  (Yii::$app->user->identity->isVip()) {
            $menuItemsRight[] = [
                'label' => Yii::t('app', 'Backend'),
                'url' => ['/admin/problem'],
                'active' => Yii::$app->controller->module->id == 'admin'
            ];
        }
        // $menuItemsRight[] =  [
        //     'label' => Yii::$app->user->identity->nickname,
        //     'url' => ['/user/view', 'id' => Yii::$app->user->id],
        //     // 'items' => [
        //     //     ['label' => Yii::t('app', 'Profile'), 'url' => ['/user/view', 'id' => Yii::$app->user->id]],
        //     //     ['label' => Yii::t('app', 'Setting'), 'url' => ['/user/setting', 'action' => 'profile']],
        //     //     ['label' => Yii::t('app', 'Logout'), 'url' => ['/site/logout']],
        //     // ]
        // ];
        $menuItemsRight[] = [
            'label' => Yii::t('app', 'Logout'),
            'url' => ['/site/logout'],
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav mr-auto'],
        'items' => $menuItemsLeft,
        'encodeLabels' => false,
        'activateParents' => true
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItemsRight,
        'encodeLabels' => false,
        'activateParents' => true
    ]);
    NavBar::end();
    ?>
        <br />
        <p></p>



        <?php if ($this->title == "SCNU Online Judge"):?>
        <div class="jumbotron jumbotron-fluid bg-secondary text-white">
            <div class="text-center d-none d-md-block">
                <br />
                <h2>South China Normal University Online Judge</h2>
                <p>华南师范大学软件学院在线判题系统</p>
            </div>
            <div class="text-center d-md-none">
                <br />
                <h2>SCNU Online Judge</h2>
                <p>华南师范大学软件学院在线判题系统</p>
            </div>
        </div>
        <?php else: ?>
        <br />
        <p></p>
        <?php endif?>



        <?php
    if (!Yii::$app->user->isGuest && Yii::$app->setting->get('mustVerifyEmail') && !Yii::$app->user->identity->isVerifyEmail()) {
        $a = Html::a('个人设置', ['/user/setting', 'action' => 'account']);
        echo "<div class=\"container\"><p class=\"bg-danger\">请前往设置页面验证您的邮箱：{$a}</p></div>";
    }
    ?>

        <div class="container-fluid">
            <div class="col-lg-10 offset-lg-1">
                <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'itemTemplate' => "<li class=\"breadcrumb-item\">{link}</li>\n",
            'activeItemTemplate' => "<li class=\"breadcrumb-item active\">{link}</li>\n"
        ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </div>
    <br />

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>