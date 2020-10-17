<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $contests array */
/* @var $news app\models\Discuss */

$this->title = Yii::$app->setting->get('ojName');
?>



<p></p>
<div class="row">
    <div class="col-lg-9 col-md-8">
        <!-- <div class="d-none d-md-block">
    <h3>新闻与公告</h3>
    </div> -->
        <div>
            <?php foreach ($news as $v): ?>
            <div class="card">
                <div class="card-body">
                    <h3><?= Html::a(Html::encode($v['title']), ['/site/news', 'id' => $v['id']], ['class' => 'text-dark']) ?>
                    </h3>
                    <?= Yii::$app->formatter->asMarkdown($v['content']) ?>
                </div>
                <div class="card-footer">
                    <?= Yii::$app->formatter->asDate($v['created_at']) ?>
                </div>
            </div>
            <p></p>
            <?php endforeach; ?>
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $pages,
                'linkOptions' => ['class' => 'page-link text-dark'],
            ]); ?>
        </div>
        <p></p>
    </div>
    <div class="col-lg-3 col-md-4">

        <?php if (! Yii::$app->user->isGuest): ?>
        <ol class="list-group">
            <li class="list-group-item text-center"><i class="fas fa-fw fa-user"></i>个人中心</li>
            <?= Html::a(Yii::$app->user->identity->nickname, ['/user/view', 'id' => Yii::$app->user->id], ['class' => 'list-group-item list-group-item-action']) ?>
            <?= Html::a(Yii::t('app', 'Setting'), ['/user/setting', 'action' => 'profile'], ['class' => 'list-group-item list-group-item-action']) ?>
            <?= Html::a(Yii::t('app', 'Logout'), ['/site/logout'], ['class' => 'list-group-item list-group-item-action']) ?>
        </ol>
        <!-- </div> -->
        <p></p>
        <?php endif; ?>
        <?php if (!empty($contests)): ?>
        <ol class="list-group">
            <li class="list-group-item text-center"><i class="fas fa-fw fa-chart-line"></i>最近比赛</li>
            <?php foreach ($contests as $contest): ?>
            <?= Html::a(Html::encode($contest['title']), ['/contest/view', 'id' => $contest['id']], ['class' => 'list-group-item-action list-group-item']) ?>
            <?php endforeach; ?>
        </ol>
        <!-- </div> -->
        <p></p>
        <?php endif; ?>
        <?php if ((Yii::$app->setting->get('isDiscuss')) && (!empty($discusses))): ?>
        <ol class="list-group">
            <li class="list-group-item text-center"><i class="fas fa-fw fa-comment"></i>最近讨论</li>

            <?php foreach ($discusses as $discuss): ?>
            <?= Html::a(Html::encode($discuss['title']) . '<br /><small>' . Html::encode($discuss['nickname']) . ' ' . Yii::$app->formatter->asRelativeTime($discuss['created_at']) . ' ' . Html::encode($discuss['ptitle']) . '</small>', ['/discuss/view', 'id' => $discuss['id']], ['class' => 'list-group-item list-group-item-action']) ?>

            </li>
            <?php endforeach; ?>
        </ol>
        <?php endif; ?>
    </div>
</div>