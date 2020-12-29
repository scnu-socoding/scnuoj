<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Contest;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contests');
?>
<div class="contest-index">

    <?= GridView::widget([
        'layout' => '{items}{pager}',
        // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'tableOptions' => ['class' => 'table'],
        'dataProvider' => $dataProvider,
        'options' => ['class' => 'table-responsive'],
        'columns' => [
            [
                'attribute' => 'title',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->title), ['/contest/view', 'id' => $key], ['class' => 'text-dark']) . '<span class="problem-list-tags">' . Html::a($model->getContestUserCount() . ' <i class="fas fa-sm fa-user"></i>', ['/contest/user', 'id' => $model->id], ['class' => 'btn-sm btn-secondary']) . '</span>';
                },
                'format' => 'raw',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'min-width:300px;']
            ],
            [
                'attribute' => 'status',
                'value' => function ($model, $key, $index, $column) {
                    $link = Html::a(Yii::t('app', 'Register »'), ['/contest/view', 'id' => $model->id]);
                    if (!Yii::$app->user->isGuest && $model->isUserInContest()) {
                        $link = '<span class="well-done">' . Yii::t('app', 'Registration completed') . '</span>';
                    }
                    if ($model->status == Contest::STATUS_VISIBLE &&
                        !$model->isContestEnd() &&
                        $model->scenario == Contest::SCENARIO_ONLINE) {
                        $column = $model->getRunStatus(true) . ' ' . $link;
                    } else {
                        $column = $model->getRunStatus(true);
                    }
                    $userCount = $model->getContestUserCount();
                    return $column;
                },
                'format' => 'raw',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'min-width:100px;']
            ],
            [
                'attribute' => 'start_time',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'min-width:180px;']
            ],
            [
                'attribute' => 'end_time',
                'value' => function ($model, $key, $index, $column) {
                    if (strtotime($model->end_time) >= 253370736000) {
                        $column = "一直开放";
                    } else {
                        $column = $model->end_time;
                    }
                    return $column;
                },
                'enableSorting' => false,
                'headerOptions' => ['style' => 'min-width:180px;']
            ]
        ],
        'pager' => [
            'linkOptions' => ['class' => 'page-link'],
            'maxButtonCount' => 5,
        ]
    ]); ?>
</div>
