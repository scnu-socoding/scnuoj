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
    <div class="col">
        <div class="list-group">
            <?php if ($model->type == Contest::TYPE_OI && $model->getRunStatus() == Contest::STATUS_RUNNING) : ?>
                <?php foreach ($problems as $key => $p) : ?>

                    <?php
                    $problem_id = (sizeof($problems) > 26)
                        ? ('P' . str_pad($key + 1, 2, '0', STR_PAD_LEFT))
                        : chr(65 + $key);
                    ?>

                    <?php if (!isset($loginUserProblemSolvingStatus[$p['problem_id']])) : ?>
                        <?= Html::a('<b>Problem ' . $problem_id . '.</b> ' . Html::encode($p['title']), ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'list-group-item list-group-item-action']) ?>
                    <?php else : ?>
                        <?= Html::a('<b>Problem ' . $problem_id . '.</b> ' . Html::encode($p['title']), ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'list-group-item list-group-item-action list-group-item-warning']) ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <?php foreach ($problems as $key => $p) : ?>

                    <?php
                    $problem_id = (sizeof($problems) > 26)
                        ? ('P' . str_pad($key + 1, 2, '0', STR_PAD_LEFT))
                        : chr(65 + $key);
                    ?>

                    <?php
                    $problem_class = "list-group-item list-group-item-action ";
                    if (!isset($loginUserProblemSolvingStatus[$p['problem_id']])) {
                    } elseif ($loginUserProblemSolvingStatus[$p['problem_id']] == \app\models\Solution::OJ_AC) {
                        $problem_class .= "list-group-item-success";
                    } elseif ($loginUserProblemSolvingStatus[$p['problem_id']] < 4) {
                        $problem_class .= "list-group-item-warning";
                    } else {
                        $problem_class .= "list-group-item-danger";
                    }
                    ?>
                    <?= Html::a('<b>Problem ' . $problem_id . '.</b> ' . Html::encode($p['title']) . '<span class="float-right">' . $submissionStatistics[$p['problem_id']]['solved'] . ' 通过 / ' . $submissionStatistics[$p['problem_id']]['submit'] . ' 提交</span>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => $problem_class]) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <p></p>
        <?php
        if ($dataProvider->count > 0) {
            echo '<div class="table-responsive">';
            echo GridView::widget([
                'layout' => '{items}{pager}',
                'tableOptions' => ['class' => 'table'],
                'dataProvider' => $dataProvider,
                'rowOptions' => ['class' => ' animate__animated animate__fadeIn animate__faster'],
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
    </div>
</div>