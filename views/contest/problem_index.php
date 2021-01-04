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
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contest'), 'url' => ['/contest/index']];
// $this->params['breadcrumbs'][] = $this->title;

$problems = $model->problems;
$loginUserProblemSolvingStatus = $model->getLoginUserProblemSolvingStatus();
$submissionStatistics = $model->getSubmissionStatistics();
?>



<div class="row">
    <div class="col">
        <div class="list-group">
            <?php if ($model->type == Contest::TYPE_OI && $model->getRunStatus() == Contest::STATUS_RUNNING): ?>
            <?php foreach ($problems as $key => $p): ?>
            <?php if (!isset($loginUserProblemSolvingStatus[$p['problem_id']])): ?>
            <?= Html::a('Problem ' . chr(65 + $key) . '. ' . $p['title'] . '<span class="float-right">' . $submissionStatistics[$p['problem_id']]['submit'] . ' 提交</span>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'list-group-item list-group-item-action']) ?>
            <?php else: ?>
            <?= Html::a('Problem ' . chr(65 + $key) . '. ' . $p['title'] . '<span class="float-right">' . $submissionStatistics[$p['problem_id']]['submit'] . ' 提交</span>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'list-group-item list-group-item-action list-group-item-warning']) ?>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php else: ?>
            <?php foreach ($problems as $key => $p): ?>
            <?php if (!isset($loginUserProblemSolvingStatus[$p['problem_id']])): ?>
            <?= Html::a('Problem ' . chr(65 + $key) . '. ' . $p['title'] . '<span class="float-right">' . $submissionStatistics[$p['problem_id']]['solved'] . ' 通过 / ' . $submissionStatistics[$p['problem_id']]['submit'] . ' 提交</span>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'list-group-item list-group-item-action']) ?>
            <?php elseif ($loginUserProblemSolvingStatus[$p['problem_id']] == \app\models\Solution::OJ_AC): ?>
            <?= Html::a('Problem ' . chr(65 + $key) . '. ' . $p['title'] . '<span class="float-right">' . $submissionStatistics[$p['problem_id']]['solved'] . ' 通过 / ' . $submissionStatistics[$p['problem_id']]['submit'] . ' 提交</span>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'list-group-item list-group-item-action list-group-item-success']) ?>
            <?php elseif ($loginUserProblemSolvingStatus[$p['problem_id']] < 4): ?>
            <?= Html::a('Problem ' . chr(65 + $key) . '. ' . $p['title'] . '<span class="float-right">' . $submissionStatistics[$p['problem_id']]['solved'] . ' 通过 / ' . $submissionStatistics[$p['problem_id']]['submit'] . ' 提交</span>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'list-group-item list-group-item-action list-group-item-warning']) ?>
            <?php else: ?>
            <?= Html::a('Problem ' . chr(65 + $key) . '. ' . $p['title'] . '<span class="float-right">' . $submissionStatistics[$p['problem_id']]['solved'] . ' 通过 / ' . $submissionStatistics[$p['problem_id']]['submit'] . ' 提交</span>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'list-group-item list-group-item-action list-group-item-danger']) ?>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <p></p>
    </div>
</div>