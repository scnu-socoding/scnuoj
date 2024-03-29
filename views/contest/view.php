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

$problems = $model->problems;
$loginUserProblemSolvingStatus = $model->getLoginUserProblemSolvingStatus();
$submissionStatistics = $model->getSubmissionStatistics();
?>



<div class="row animate__animated animate__fadeIn animate__faster">
    <div class="col-lg-8">
        <div class="alert alert-light">
            <i class="fas fa-fw fa-info-circle"></i>
            <?php if (strtotime($model->end_time) >= Contest::TIME_INFINIFY) : ?>
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
            <p></p>
        <?php else : ?>
            <div class="card">
                <div class="card-body text-secondary">
                    管理员还没有上传比赛描述信息哦。
                </div>
            </div>
            <p></p>
        <?php endif; ?>
        <?php
        if ($dataProvider->count > 0) {
            echo '<div class="table-responsive">';
            echo GridView::widget([
                'layout' => '{items}{pager}',
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
                    'linkOptions' => ['class' => 'page-link'],
                    'maxButtonCount' => 5,
                ]
            ]);
            echo '</div>';
        }
        ?>
        <p></p>
    </div>
    <div class="col-lg-4">
        <div class="list-group">
            <div class="list-group-item"><?= Yii::t('app', 'Current time') ?><span class="text-secondary float-right" id="nowdate"><?= date("Y-m-d H:i:s") ?></span></div>
            <div class="list-group-item"><?= Yii::t('app', 'Start time') ?><span class="text-secondary float-right"><?= $model->start_time ?></span></div>
            <div class="list-group-item"><?= Yii::t('app', 'End time') ?>
                <?php if (strtotime($model->end_time) >= Contest::TIME_INFINIFY) : ?>
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

</div>