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
<div class="contest-overview center-block">

    <div class="table-responsive well">
        <table class="table table-overview">
            <tbody>
            <tr>
                <th><?= Yii::t('app', 'Start time') ?></th>
                <td><?= $model->start_time ?></td>
                <th><?= Yii::t('app', 'Type') ?></th>
                <td><?= $model->getType() ?></td>
            </tr>
            <tr>
                <th><?= Yii::t('app', 'End time') ?></th>
                <td><?= $model->end_time ?></td>
                <th><?= Yii::t('app', 'Status') ?></th>
                <td><?= $model->getRunStatus(true) ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="contest-desc">
        <?= Yii::$app->formatter->asMarkdown($model->description) ?>
    </div>
    <hr>
    <div class="col col-md-10 offset-md-1">
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
    </div>


    </div>
    <?php
    if ($dataProvider->count > 0) {
        echo '<hr>';
        echo '<div class="table-responsive">';
        echo GridView::widget([
            'layout' => '{items}{pager}',
            // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'table-responsive', 'style' => 'margin:0 auto;width:50%;min-width:600px;text-align: left;'],
            'columns' => [
                [
                    'attribute' => 'created_at',
                    'options' => ['width' => '150px'],
                    'format' => 'datetime',
                    'enableSorting' => false
                ],
                [
                    'attribute' => Yii::t('app', 'Announcement'),
                    'value' => function ($model, $key, $index, $column) {
                        return Yii::$app->formatter->asMarkdown($model->content);
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
