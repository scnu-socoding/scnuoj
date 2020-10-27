<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $contests array */
/* @var $news app\models\Discuss */

$this->title = Yii::$app->setting->get('ojName');
?>



<p></p>
<div class="row">
    <div class="col-md-8">
    <!-- <div class="d-none d-md-block">
    <h3>新闻与公告</h3>
    </div> -->
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
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $pages,
                'linkOptions' => ['class' => 'page-link text-dark'],
            ]); ?>
        </div>
    </div>
    <div class="col-md-4 d-none d-md-block">
        <?php if (!empty($contests)): ?>
            <ol class="list-group">
                <li class="list-group-item text-center"><i class="fas fa-fw fa-chart-line"></i>最近比赛</li>
                <?php foreach ($contests as $contest): ?>
                <li class="list-group-item">
                    <?= Html::a(Html::encode($contest['title']), ['/contest/view', 'id' => $contest['id']], ['class' => 'text-dark']) ?>
                </li>
                <?php endforeach; ?>
            </ol>
        <!-- </div> -->
            <p></p>
        <?php endif; ?>
        <?php if (!empty($discusses)): ?>
                <ol class="list-group">
                    <li class="list-group-item text-center"><i class="fas fa-fw fa-comment"></i>最近讨论</li>
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
