<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $provider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'User');
?>

<div class="contest-index">
    <?= GridView::widget([
        'layout' => '{items}{pager}',
        'dataProvider' => $provider,
        // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'tableOptions' => ['class' => 'table'],
        'options' => ['class' => 'table-responsive'],
        'columns' => [
            [
                'attribute' => 'participants',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->user->id]);
                },
                'format' => 'raw',
                'enableSorting' => false
            ],
        ],
        'pager' => [
            'linkOptions' => ['class' => 'page-link text-dark'],
        ]
    ]); ?>
</div>
