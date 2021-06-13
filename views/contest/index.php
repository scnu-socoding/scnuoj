<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Contest;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contests');
?>
<div class="contest-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'layout' => '{items}{pager}',
        // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'tableOptions' => ['class' => 'table'],
        'dataProvider' => $dataProvider,
        'options' => ['class' => 'table-responsive'],
        'rowOptions' => ['class' => ' animate__animated animate__fadeIn animate__faster'],
        'columns' => [
            [
                'attribute' => 'title',
                'value' => function ($model, $key, $index, $column) {

                    $base_title = Html::a(Html::encode($model->title), ['/contest/view', 'id' => $key], ['class' => 'text-dark']);

                    if ($model->ext_link) {
                        if ($model->invite_code) {
                            return $base_title . '<span class="problem-list-tags"><span class="badge badge-secondary"><code class="text-white">' . $model->invite_code . '</code>' . '<i class="fas fa-sm fa-lock" style="margin-left:4px"></i></span> <span class="badge badge-warning"> 站外 <i class="fas fa-sm fa-rocket"></i>' . '</span></span>';
                        }
                        return $base_title . '<span class="problem-list-tags badge badge-warning"> 站外 <i class="fas fa-sm fa-rocket"></i>' . '</span>';
                    }

                    $stat = "";

                    if (!Yii::$app->user->isGuest && $model->isUserInContest()) {
                        $stat = '<span class="badge badge-success">参赛 <i class="fas fa-sm fa-check"></i></span> ';
                    }

                    $people_cnt = Html::a($model->getContestUserCount() . ' <i class="fas fa-sm fa-user"></i>', ['/contest/view', 'id' => $model->id], ['class' => 'badge badge-info']);

                    return $base_title . '<span class="problem-list-tags">' . $stat . $people_cnt . '</span>';
                },
                'format' => 'raw',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'min-width:400px;']
            ],
            [
                'attribute' => 'status',
                'value' => function ($model, $key, $index, $column) {
                    return $model->getRunStatus(true);
                },
                'format' => 'raw',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'width:120px;min-width:100px;']
            ],
            [
                'attribute' => 'start_time',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'width:180px;min-width:180px;']
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
                'headerOptions' => ['style' => 'width:180px;min-width:180px;']
            ]
        ],
        'pager' => [
            'linkOptions' => ['class' => 'page-link'],
            'maxButtonCount' => 5,
        ]
    ]); ?>
</div>