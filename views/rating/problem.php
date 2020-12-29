<?php

use app\models\User;

/* @var $users \app\models\User */
/* @var $top3users \app\models\User */
/* @var $pages \yii\data\Pagination */
/* @var $currentPage integer */
/* @var $defaultPageSize integer */

use yii\bootstrap4\Nav;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Rating');
?>

<?= Nav::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'Rank by Rating'),
            'url' => ['rating/index'],
            'linkOptions' => ['class' => 'text-dark'],
        ],
        [
            'label' => Yii::t('app', 'Rank by Solved Problems'),
            'url' => ['rating/problem'],
            'linkOptions' => ['class' => 'text-dark'],
        ]
    ],
    'options' => ['class' => 'nav-tabs', 'style' => 'margin-bottom: 15px']
]) ?>

<div class="row">
    <div class="col-lg-9 col-md-8">
        <div class="rating-index">         
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Who</th>
                        <th>Solved</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $k => $user): ?>
                        <?php $num = $k + $currentPage * $defaultPageSize + 1; ?>
                        <tr>
                            <th scope="row"><?= $num ?></th>
                            <td>
                                <?= Html::a(User::getColorNameByRating($user['nickname'], $user['rating']), ['/user/view', 'id' => $user['id']], ['class' => 'text-dark']) ?>
                            </td>
                            <td>
                                <?= $user['solved'] ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?= \yii\widgets\LinkPager::widget(
                [
                    'pagination' => $pages,
                    'linkOptions' => ['class' => 'page-link'],
                    'maxButtonCount' => 5,
                ]
            ) ?>
        </div>
        <p></p>
    </div>
    <div class="col-lg-3 col-md-4">
        <div class="card text-dark">
            <div class="card-body">
                <h3>关于积分</h3>
                <p>在参加比赛之后，参赛者将根据排名得到一定积分。如果参加了比赛但没有通过任何题目，不会计算比赛积分。</p>
                <p>积分计算采用 Elo Ranking 算法，起始分为 1149。该算法已被牛客竞赛等多个知名判题系统采用。想要了解该算法的更多信息，请查看 <a href="https://en.wikipedia.org/wiki/Elo_rating_system" target="_blank" class="text-dark"> Wikipedia 相关词条</a>。</p>
                <p>积分一定程度上反映了参赛者的程序设计能力，可供各位同学找准自己的定位。</p>
            </div>
        </div>
        <p></p>
        <div class="card text-dark">
            <div class="card-body">
                <h3>关于做题量</h3>
                <p>做题量计算规则已经更新，在小组练习、公共比赛和题库、管理员后台做题均计入做题量排行。</p>
            </div>
        </div>
    </div>
</div>
</div>