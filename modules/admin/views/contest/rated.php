<?php

use yii\helpers\Html;
use app\models\Contest;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contests'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
?>
<div class="contest-view">

    <p class="lead">为比赛 <?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?> 参赛选手计算积分。</p>

    <?php if ($model->getRunStatus() == Contest::STATUS_ENDED) : ?>
        <?= Html::a('计算积分', ['rated', 'id' => $model->id, 'cal' => 1], ['class' => 'btn btn-outline-primary btn-block']) ?>
        <p></p>
        <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 计算出来的积分用于在排行榜排名，重复点击会多次计算积分。</div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}{pager}',
            'options' => ['class' => 'table-responsive'],
            'tableOptions' => ['class' => 'table table-bordered'],
            'columns' => [
                [
                    'attribute' => 'who',
                    'value' => function ($model, $key, $index, $column) {
                        return Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->user->id]);
                    },
                    'format' => 'raw'
                ],
                [
                    'attribute' =>  'rating_change',
                    'enableSorting' => false,
                ]
            ],
        ]); ?>

    <?php else : ?>
        <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 比赛尚未结束，请在比赛结束后再来计算积分。</div>
    <?php endif; ?>
</div>