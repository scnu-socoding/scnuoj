<?php

/* @var $this \yii\web\View */

/* @var $content string */
/* @var $model app\models\Contest */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\widgets\Alert;
use app\models\Contest;

AppAsset::register($this);

$this->registerJsFile('/js/jquery.countdown.min.js', ['depends' => 'yii\web\JqueryAsset']);
$model = $this->params['model'];
$status = $model->getRunStatus();
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
    <style>
        .progress-bar {
            transition: none !important;
        }
    </style>
</head>

<body>



    <?php $this->beginBody() ?>

    <div>

        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->setting->get('ojName'),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-lg navbar-light fixed-top',
                'style' => 'background: #e9ecef;border-bottom: 2px solid #D50000;'
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
        <br />
        <p></p>

        <br />
        <p></p>

        <div class="container-xl">
            <div class="col">

                <?php if (Yii::$app->setting->get('notice')) : ?>
                    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> <?= Html::encode(Yii::$app->setting->get('notice')) ?></div>
                <?php endif; ?>

                <h3><?= Html::encode($model->title) ?></h3>
                <?= Alert::widget() ?>

                <?php if (!$model->canView()) : ?>
                    <?= $content ?>
                <?php elseif ($status == $model::STATUS_NOT_START) : ?>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="alert alert-light">
                                <i class="fas fa-fw fa-info-circle"></i>
                                <?php if (strtotime($model->end_time) >= 253370736000) : ?>
                                    <b>永久开放的题目集</b> 任何时候均可进行作答。
                                <?php else : ?>
                                    <b>限时开放的题目集</b> 只有在规定时间内的作答才会被计入比赛正式榜单。
                                <?php endif; ?>
                            </div>
                            <p></p>
                            <?php if ($model->description) : ?>
                                <div class="card">
                                    <div class="card-body" style="padding-bottom: 0.25rem;">
                                        <?= Yii::$app->formatter->asMarkdown($model->description) ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <p></p>
                            <div class="card">
                                <div class="card-header">
                                    距离题目集开放
                                </div>
                                <div class="card-body text-center">
                                    <h1 id="countdown"></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="list-group">
                                <div class="list-group-item"><?= Yii::t('app', 'Current time') ?><span class="text-secondary float-right" id="nowdate"><?= date("Y-m-d H:i:s") ?></span>
                                </div>
                                <div class="list-group-item"><?= Yii::t('app', 'Start time') ?><span class="text-secondary float-right"><?= $model->start_time ?></span></div>
                                <div class="list-group-item"><?= Yii::t('app', 'End time') ?>
                                    <?php if (strtotime($model->end_time) >= 253370736000) : ?>
                                        <span class="text-secondary float-right">一直开放</span>
                                </div>
                            <?php else : ?>
                                <span class="text-secondary float-right"><?= $model->end_time ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="list-group-item"><?= Yii::t('app', 'Type') ?><span class="text-secondary float-right"><?= $model->getType() ?></span></div>
                        <div class="list-group-item"><?= Yii::t('app', 'Status') ?><span class="text-secondary float-right"><?= $model->getRunStatus(true) ?></span></div>
                        </div>
                    </div>


                <?php else : ?>
                    <div>
                        <?php
                        $menuItems = [
                            [
                                'label' => Yii::t('app', 'Information'),
                                'url' => ['contest/view', 'id' => $model->id],
                            ],
                            [
                                'label' => Yii::t('app', 'Problem'),
                                'url' => ['contest/problem', 'id' => $model->id],
                            ],
                            [
                                'label' => Yii::t('app', 'Status'),
                                'url' => ['contest/status', 'id' => $model->id],
                            ],
                            [
                                'label' => Yii::t('app', 'Standing'),
                                'url' => ['contest/standing', 'id' => $model->id],
                            ],
                            [
                                'label' => Yii::t('app', 'Clarification'),
                                'url' => ['contest/clarify', 'id' => $model->id],
                            ],
                        ];
                        if (($model->scenario == $model::SCENARIO_OFFLINE || $model->enable_print == 1) && $model->getRunStatus() == $model::STATUS_RUNNING) {
                            $menuItems[] = [
                                'label' => '打印服务',
                                'url' => ['/contest/print', 'id' => $model->id],

                            ];
                        }
                        if ($model->isContestEnd()) {
                            $menuItems[] = [
                                'label' => '<span class="glyphicon glyphicon-info-sign"></span> ' . Yii::t('app', 'Editorial'),
                                'url' => ['contest/editorial', 'id' => $model->id],
                            ];
                        }
                        echo Nav::widget([
                            'items' => $menuItems,
                            'options' => ['class' => 'nav nav-pills hidden-print', 'style' => 'margin-bottom: 15px'],
                            'encodeLabels' => false
                        ]) ?>
                        <?= $content ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <br />
    <?php $this->endBody() ?>
    <script>
        var client_time = new Date();
        var diff = new Date("<?= date("Y/m/d H:i:s") ?>").getTime() - client_time.getTime();
        var start_time = new Date("<?= $model->start_time ?>");
        var end_time = new Date("<?= $model->end_time ?>");
        $("#countdown").countdown(start_time.getTime() - diff, function(event) {
            $(this).html(event.strftime('%D:%H:%M:%S'));
            if ($(this).html() == "00:00:00:00") location.reload();
        });

        function clock() {
            var h, m, s, n, y, mon, d;
            var x = new Date(new Date().getTime() + diff);
            y = x.getYear() + 1900;
            if (y > 3000) y -= 1900;
            mon = x.getMonth() + 1;
            d = x.getDate();
            h = x.getHours();
            m = x.getMinutes();
            s = x.getSeconds();

            n = y + "-" + (mon >= 10 ? mon : "0" + mon) + "-" + (d >= 10 ? d : "0" + d) + " " + (h >= 10 ? h : "0" + h) +
                ":" + (m >= 10 ? m : "0" + m) + ":" + (s >= 10 ?
                    s : "0" + s);
            if (document.getElementById('nowdate')) {
                document.getElementById('nowdate').innerHTML = n;
            }

            var now_time = new Date(n);
            if (now_time < end_time) {
                var rate = (now_time - start_time) / (end_time - start_time) * 100;
                // document.getElementById('contest-progress').style.width = rate + "%";
            } else {
                // document.getElementById('contest-progress').style.width = "100%";
            }
            setTimeout("clock()", 1000);
        }
        clock();

        $(document).ready(function() {
            // 连接服务端
            var socket = io(document.location.protocol + '//' + document.domain + ':2120');
            var uid = '<?= Yii::$app->user->isGuest ? session_id() : Yii::$app->user->id ?>';
            // 连接后登录
            socket.on('connect', function() {
                socket.emit('login', uid);
            });
            // 后端推送来消息时
            socket.on('msg', function(msg) {
                alert(msg);
            });

            $('.pre p').each(function(i, block) { // use <pre><p>
                hljs.highlightBlock(block);
            });
        });
    </script>
</body>

</html>
<?php $this->endPage() ?>