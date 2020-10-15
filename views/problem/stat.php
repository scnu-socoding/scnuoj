<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap4\Modal;
use app\models\Solution;

/* @var $this yii\web\View */
/* @var $model app\models\Problem */
/* @var $searchModel app\models\SolutionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Stats');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['problem/index']];
$this->params['breadcrumbs'][] = ['label' => Html::encode($model->id . ' - ' . $model->title), 'url' => ['problem/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Stats');

$stats = $model->getStatisticsData();
?>

<div class="card bg-secondary text-white">
    <div class="card-body">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
</div>
<p></p>
<hr>
<div class="stats-content" style="padding: 0 50px">
    <h2>提交统计</h2>
    <div class="row">
        <div class="left-list col-md-6">
            <ul class="stat-list">
                <li>
                    <strong>提交总数</strong><span> <?= $stats['submission_count'] ?></span>
                </li>
                <li>
                    <strong>通过总数</strong><span> <?= $stats['accepted_count'] ?></span>
                </li>
                <li>
                    <strong>通过率</strong><span> <?= $stats['submission_count'] == 0 ? 0 : number_format($stats['accepted_count'] / $stats['submission_count'] * 100, 2) ?> %</span>
                </li>
                <li>
                    <strong>参与作者</strong><span> <?= $stats['user_count'] ?></span>
                </li>
            </ul>
        </div>
        <div class="right-list col-md-6">
            <ul class="stat-list">
                <li>
                    <strong>通过总数</strong><span> <?= $stats['accepted_count'] ?></span>
                </li>
                <li>
                    <strong>错误解答</strong><span> <?= $stats['wa_submission'] ?></span>
                </li>
                <li>
                    <strong>时间超限</strong><span> <?= $stats['tle_submission'] ?></span>
                </li>
                <li>
                    <strong>编译错误</strong><span> <?= $stats['ce_submission'] ?></span>
                </li>
            </ul>
        </div>
    </div>
</div>

<hr>
<div class="solution-index" style="padding: 0 50px">
    <h2>提交排行</h2>
    <?= GridView::widget([
        'layout' => '{items}{pager}',
        'dataProvider' => $dataProvider,
        'options' => ['class' => 'table-responsive'],
        // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'tableOptions' => ['class' => 'table'],
        'columns' => [
            [
                'attribute' => 'who',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->username, ['/user/view', 'id' => $model->created_by]);
                },
                'format' => 'raw',
                'enableSorting' => false
            ],
            [
                'attribute' => 'result',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->result == $model::OJ_CE || $model->result == $model::OJ_WA
                        || $model->result == $model::OJ_RE) {
                        return Html::a($model->getResult(),
                            ['/solution/result', 'id' => $model->solution_id],
                            ['onclick' => 'return false', 'data-click' => "solution_info"]
                        );
                    } else {
                        return $model->getResult();
                    }
                },
                'format' => 'raw',
                'enableSorting' => false
            ],
            [
                'attribute' => 'time',
                'value' => function ($model, $key, $index, $column) {
                    return $model->time . ' MS';
                },
                'format' => 'raw',
                'enableSorting' => false
            ],
            [
                'attribute' => 'memory',
                'value' => function ($model, $key, $index, $column) {
                    return $model->memory . ' KB';
                },
                'format' => 'raw',
                'enableSorting' => false
            ],
            [
                'attribute' => 'language',
                'value' => function ($model, $key, $index, $column) {
                    return $model->getLang();
                },
                'format' => 'raw',
                'enableSorting' => false
            ],
            [
                'attribute' => 'code_length',
                'enableSorting' => false
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model, $key, $index, $column) {
                    return Html::tag('span', Yii::$app->formatter->asRelativeTime($model->created_at), ['title' => $model->created_at]);
                },
                'format' => 'raw',
                'enableSorting' => false
            ]
        ],
    ]); ?>
</div>
