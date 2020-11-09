<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Contest;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $solution app\models\Solution */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $data array */

$this->title = $model->title;
$this->params['model'] = $model;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contest'), 'url' => ['/contest/index']];
$this->params['breadcrumbs'][] = $this->title;

$problems = $model->problems;
$loginUserProblemSolvingStatus = $model->getLoginUserProblemSolvingStatus();
$submissionStatistics = $model->getSubmissionStatistics();
?>

<div class="card bg-secondary text-white">
    <div class="card-body">
        <h3><?= $model->title ?></h3>
    </div>
</div>
<p></p>

<?php if ($model->description):?>
<div class="card">
    <div class="card-body">
        <?= Yii::$app->formatter->asMarkdown($model->description) ?>
    </div>
</div>
<p></p>
<?php endif;?>

<div class="row">
    <div class="col-md-8 col-lg-9">
        <div class="list-group">
            <?php if ($model->type == Contest::TYPE_OI && $model->getRunStatus() == Contest::STATUS_RUNNING): ?>
            <?php foreach ($problems as $key => $p): ?>
            <?php if (!isset($loginUserProblemSolvingStatus[$p['problem_id']])): ?>
            <?= Html::a(chr(65 + $key) . '. ' . $p['title'] . '<span class="float-right">' . $submissionStatistics[$p['problem_id']]['submit'] . ' 提交</span>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'list-group-item list-group-item-action']) ?>
            <?php else: ?>
            <?= Html::a(chr(65 + $key) . '. ' . $p['title'] . '<span class="float-right">' . $submissionStatistics[$p['problem_id']]['submit'] . ' 提交</span>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'list-group-item list-group-item-action list-group-item-warning']) ?>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php else: ?>
            <?php foreach ($problems as $key => $p): ?>
            <?php if (!isset($loginUserProblemSolvingStatus[$p['problem_id']])): ?>
            <?= Html::a(chr(65 + $key) . '. ' . $p['title'] . '<span class="float-right">' . $submissionStatistics[$p['problem_id']]['solved'] . ' 通过 / ' . $submissionStatistics[$p['problem_id']]['submit'] . ' 提交</span>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'list-group-item list-group-item-action']) ?>
            <?php elseif ($loginUserProblemSolvingStatus[$p['problem_id']] == \app\models\Solution::OJ_AC): ?>
            <?= Html::a(chr(65 + $key) . '. ' . $p['title'] . '<span class="float-right">' . $submissionStatistics[$p['problem_id']]['solved'] . ' 通过 / ' . $submissionStatistics[$p['problem_id']]['submit'] . ' 提交</span>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'list-group-item list-group-item-action list-group-item-success']) ?>
            <?php elseif ($loginUserProblemSolvingStatus[$p['problem_id']] < 4): ?>
            <?= Html::a(chr(65 + $key) . '. ' . $p['title'] . '<span class="float-right">' . $submissionStatistics[$p['problem_id']]['solved'] . ' 通过 / ' . $submissionStatistics[$p['problem_id']]['submit'] . ' 提交</span>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'list-group-item list-group-item-action list-group-item-warning']) ?>
            <?php else: ?>
            <?= Html::a(chr(65 + $key) . '. ' . $p['title'] . '<span class="float-right">' . $submissionStatistics[$p['problem_id']]['solved'] . ' 通过 / ' . $submissionStatistics[$p['problem_id']]['submit'] . ' 提交</span>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'list-group-item list-group-item-action list-group-item-danger']) ?>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <p></p>
    </div>

    <div class="col-md-4 col-lg-3">
        <!-- <p></p> -->
        <div class="list-group">
            <div class="list-group-item"><?= Yii::t('app', 'Current time') ?><span
                    class="text-secondary float-right" id="nowdate"><?= date("Y-m-d H:i:s") ?></span></div>
            <div class="list-group-item"><?= Yii::t('app', 'Start time') ?><span
                    class="text-secondary float-right"><?= $model->start_time ?></span></div>
            <div class="list-group-item"><?= Yii::t('app', 'End time') ?><span
                    class="text-secondary float-right"><?= $model->end_time ?></span></div>
            <div class="list-group-item"><?= Yii::t('app', 'Type') ?><span
                    class="text-secondary float-right"><?= $model->getType() ?></span></div>
            <div class="list-group-item"><?= Yii::t('app', 'Status') ?><span
                    class="text-secondary float-right"><?= $model->getRunStatus(true) ?></span></div>
        </div>
        <p></p>

        <?php
        if ($dataProvider->count > 0) {
        echo '<div class="table-responsive">';
            echo GridView::widget([
            'layout' => '{items}{pager}',
            // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'table-responsive'],
            'columns' => [
            [
            'attribute' => Yii::t('app', 'Announcement'),
            'value' => function ($model, $key, $index, $column) {
            return $model->content;
            },
            'format' => 'html',
            'enableSorting' => false
            ],
            ],
            'pager' => [
            'linkOptions' => ['class' => 'page-link text-dark'],
            ]
            ]);
            echo '</div>';
        }
        ?>

    </div>

</div>