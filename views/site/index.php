<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $contests array */
/* @var $news app\models\Discuss */

$this->title = Yii::$app->setting->get('ojName');
?>
<div class="row">
    <div class="col"> 
        <div class="card">
            <div class="card-body">
                <center>
                    <h2>South China Normal University Online Judge</h2>
                    <h5>华南师范大学（软件学院）在线判题系统</h5>
                </center>
            </div>
        </div>
    </div>
</div>

<br />
<br />

<div class="row blog">
    <div class="col-md-8"> 
        <div class="blog-main">
            <?php foreach ($news as $v): ?>
                <div class="blog-post">
                    <h3 class="blog-post-title"><?= Html::a(Html::encode($v['title']), ['/site/news', 'id' => $v['id']]) ?></h3>
                    <p class="blog-post-meta">
                        <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asDate($v['created_at']) ?></p>
                </div>
            <?php endforeach; ?>
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $pages,
            ]); ?>
        </div>
    </div>
    <div class="col-md-4">
        <?php if (!empty($contests)): ?>
            <h3>最近比赛</h3>
            <ol class="list-unstyled">
                <?php foreach ($contests as $contest): ?>
                <li>
                    <?= Html::a(Html::encode($contest['title']), ['/contest/view', 'id' => $contest['id']]) ?>
                </li>
                <?php endforeach; ?>
            </ol>
        <!-- </div> -->
        <?php endif; ?>
        <?php if (!empty($discusses)): ?>
                <h3>最近讨论</h3>
                <ol class="list-unstyled">
                    <?php foreach ($discusses as $discuss): ?>
                        <li class="index-discuss-item">
                            <div>
                                <?= Html::a(Html::encode($discuss['title']), ['/discuss/view', 'id' => $discuss['id']]) ?>
                            </div>
                            <small class="text-muted">
                                <?= Html::a(Html::encode($discuss['nickname']), ['/user/view', 'id' => $discuss['username']]) ?>
                                <?= Yii::$app->formatter->asRelativeTime($discuss['created_at']) ?>
                                <?= Html::a(Html::encode($discuss['ptitle']), ['/problem/view', 'id' => $discuss['pid']]) ?>
                            </small>
                        </li>
                    <?php endforeach; ?>
                </ol>
        <?php endif; ?>
    </div>
</div>
