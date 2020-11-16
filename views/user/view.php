<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $contests array */
/* @var $contestCnt integer */

$this->title = $model->nickname;
$solutionStats = $model->getSolutionStats();
$recentSubmission = $model->getRecentSubmission();
?>
<div class="card bg-secondary text-white">
    <div class="card-body">
        <h3><?= $model->getColorName() ?></h3>
    </div>
</div>
<p></p>
<?php if ($model->role != \app\models\User::ROLE_PLAYER): ?>
<div class="row">
    <div class="col-md-4 col-lg-3">
        <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'username',
                        'nickname',
                        [
                            'attribute' => Yii::t('app', 'Major'),
                            'value' => function ($model, $widget) {
                                return Html::encode($model->profile->major);
                            },
                            'format' => 'raw'
                        ],
                        [
                            'attribute' => Yii::t('app', 'Student Number'),
                            'value' => function ($model, $widget) {
                                return $model->profile->student_number;
                            },
                            'format' => 'raw'
                        ],
                        [
                            'attribute' => '积分',
                            'value' => function ($model, $widget) {
                                return isset($model->rating)?$model->rating:'Unrated';
                            },
                            'format' => 'raw'
                        ]
                    ],
                ]) ?>
    </div>
    <div class="col-md-8 col-lg-9">
        <?php if($model->profile->personal_intro != ''):?>
        <div class="card">
            <div class="card-body">
                <?= Yii::$app->formatter->asMarkdown($model->profile->personal_intro) ?>
            </div>
        </div>
        <p></p>
        <?php endif;?>
        <?php if(!empty($recentSubmission)):?>
            <div class="card">
                <div class="card-body">
                    <h3 style="margin-bottom:0">最近提交</h3>
                </div>
            </div>
            <p></p>
            <div class="list-group">
                <?php foreach ($recentSubmission as $submission): ?>
                <a href="<?= \yii\helpers\Url::toRoute(['/solution/detail', 'id' => $submission['id']]) ?>"
                    class="list-group-item list-group-item-action">
                    <span>
                        <?= Html::encode($submission['problem_id'] . '. '. $submission['title']) ?>
                    </span>
                    <span style="float: right">
                        <?= \app\models\Solution::getResultList($submission['result']) ?>
                        <?= Yii::$app->formatter->asRelativeTime($submission['created_at']) ?>
                    </span>
                </a>
                <?php endforeach; ?>
            </div>
        <?php endif;?>
    </div>
</div>
<hr>
<h3>已解答 <small>(<?= count($solutionStats['solved_problem']) ?>)</small></h3>
<!-- <ul> -->
<?php foreach ($solutionStats['solved_problem'] as $p): ?>
<?= Html::a($p, ['/problem/view', 'id' => $p], ['class' => 'badge badge-secondary']) ?>
<?php endforeach; ?>
<!-- </ul> -->
<hr>
<h3>未解答 <small>(<?= count($solutionStats['unsolved_problem']) ?>)</small></h3>
<!-- <ul> -->
<?php foreach ($solutionStats['unsolved_problem'] as $p): ?>
<?= Html::a($p, ['/problem/view', 'id' => $p], ['class' => 'badge badge-secondary']) ?>
<?php endforeach; ?>
<!-- </ul> -->

<hr>
<h2>统计</h2>
<div class="row">
    <div class="left-list col-md-6">
        <ul class="stat-list">
            <li>
                <strong>提交总数</strong><span> <?= $solutionStats['all_count'] ?></span>
            </li>
            <li>
                <strong>通过</strong><span> <?= $solutionStats['ac_count'] ?></span>
            </li>
            <li>
                <strong>通过率</strong>
                <span>
                    <?= $solutionStats['all_count'] == 0 ? 0 : number_format($solutionStats['ac_count'] / $solutionStats['all_count'] * 100, 2) ?>
                    %
                </span>
            </li>
        </ul>
    </div>
    <div class="right-list col-md-6">
        <ul class="stat-list">
            <li>
                <strong>错误解答</strong><span> <?= $solutionStats['wa_count'] ?></span>
            </li>
            <li>
                <strong>时间超限</strong><span> <?= $solutionStats['tle_count'] ?></span>
            </li>
            <li>
                <strong>编译错误</strong><span> <?= $solutionStats['ce_count'] ?></span>
            </li>
        </ul>
    </div>
</div>
<?php else: ?>
<p>用户名：<?= Html::encode($model->username) ?></p>
<p>线下赛参赛账户．</p>
<?php endif; ?>
</div>