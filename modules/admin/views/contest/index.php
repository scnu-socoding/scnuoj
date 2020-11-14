<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contests');
?>
<div class="contest-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Contest'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->id, ['contest/view', 'id' => $key]);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'title',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->title), ['contest/view', 'id' => $key]);
                },
                'format' => 'raw'
            ],
            'start_time',
            'end_time',
            [
                'attribute' => 'status',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->status == $model::STATUS_VISIBLE) {
                        return Yii::t('app', 'Public');
                    } else if ($model->status == $model::STATUS_PRIVATE) {
                        return Yii::t('app', 'Private');
                    } else {
                        return Yii::t('app', 'Hidden');
                    }
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'scenario',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->scenario == $model::SCENARIO_ONLINE) {
                        return Yii::t('app', 'Online');
                    } else {
                        return Yii::t('app', 'Offline');
                    }
                },
                'format' => 'raw',
            ],
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('yii', 'View'),
                        'aria-label' => Yii::t('yii', 'View'),
                        'class' => 'text-dark'
                    ];
                    return Html::a('<i class="fas fa-sm fa-eye"></i>', $url, $options);
                },
                'update' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('yii', 'Update'),
                        'aria-label' => Yii::t('yii', 'Update'),
                        'class' => 'text-dark'
                    ];
                    return Html::a('<i class="fas fa-sm fa-pen"></i>', $url, $options);
                },
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'Delete'),
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'class' => 'text-dark'
                    ];
                    return Html::a('<span class="fas fa-sm fa-trash"></span>', $url, $options);
                }
            ]]
        ],
    ]); ?>
</div>
