<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $contests array */
/* @var $news app\models\Discuss */

$this->title = Yii::$app->setting->get('ojName');
?>
<div class="row">
    <div class="col"> 
        <div class="card bg-secondary text-white">
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

<div class="row">
    <div class="col-md-8"> 
    <h3>新闻与公告</h3>
        <div>
            <?php foreach ($news as $v): ?>
                <div class="card">
                    <div class="card-body">
                        <h3><?= Html::a(Html::encode($v['title']), ['/site/news', 'id' => $v['id']], ['class' => 'text-dark']) ?></h3>
                        <?= Yii::$app->formatter->asMarkdown($v['content']) ?>
                    </div>
                    <div class="card-footer">
                        <?= Yii::$app->formatter->asDate($v['created_at']) ?>
                    </div>
                </div>
                <p></p>
            <?php endforeach; ?>
            <?= \yii\bootstrap4\LinkPager::widget([
                'pagination' => $pages,
                'linkOptions' => ['class' => 'page-link text-dark'],
            ]); ?>
        </div>
    </div>
    <div class="col-md-4">
        <?php if (!empty($contests)): ?>
            <h3>最近比赛</h3>
            <ol class="list-group">
                <?php foreach ($contests as $contest): ?>
                <li class="list-group-item">
                    <?= Html::a(Html::encode($contest['title']), ['/contest/view', 'id' => $contest['id']], ['class' => 'text-dark']) ?>
                </li>
                <?php endforeach; ?>
            </ol>
        <!-- </div> -->
            <br />
        <?php endif; ?>
        <?php if (!empty($discusses)): ?>
                <h3>最近讨论</h3>
                <ol class="list-group">
                    <?php foreach ($discusses as $discuss): ?>
                        <li class="list-group-item">
                            <div>
                                <?= Html::a(Html::encode($discuss['title']), ['/discuss/view', 'id' => $discuss['id']], ['class' => 'text-dark']) ?>
                            </div>
                            <small class="text-muted">
                                <?= Html::a(Html::encode($discuss['nickname']), ['/user/view', 'id' => $discuss['username']], ['class' => 'text-dark']) ?>
                                <?= Yii::$app->formatter->asRelativeTime($discuss['created_at']) ?>
                                <?= Html::a(Html::encode($discuss['ptitle']), ['/problem/view', 'id' => $discuss['pid']], ['class' => 'text-dark']) ?>
                            </small>
                        </li>
                    <?php endforeach; ?>
                </ol>
        <?php endif; ?>
    </div>
</div>
