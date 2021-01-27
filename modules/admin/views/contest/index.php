<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contests');
?>
<div>

    <p class="lead">创建和管理公共比赛与题目集。</p>


    <?= Html::a(Yii::t('app', 'Create Contest'), ['create'], ['class' => 'btn btn-outline-primary btn-block']) ?>
    <p></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-bordered'],
        'options' => ['class' => 'table-responsive'],
        'layout' => '{items}{pager}',
        'columns' => [
            [
                'attribute' => 'id',
                'label' => '#',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->id, ['contest/view', 'id' => $key]);
                },
                'format' => 'raw',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'title',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->title), ['contest/view', 'id' => $key]);
                },
                'format' => 'raw',
                'enableSorting' => false,
            ],
            [
                'attribute' =>'start_time',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'end_time',
                'enableSorting' => false,
            ],
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
                'enableSorting' => false,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
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
                ]
            ]
        ],
    ]); ?>
</div>