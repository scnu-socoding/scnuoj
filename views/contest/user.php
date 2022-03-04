<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $provider yii\data\ActiveDataProvider */

$this->title = $model->title;
?>

<div class='user-index'>
    <?= GridView::widget([
        'layout' => '{items}{pager}',
        'dataProvider' => $provider,
        // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'tableOptions' => ['class' => 'table table-bordered'],
        'rowOptions' => ['class' => ' animate__animated animate__fadeIn animate__faster'],
        'options' => ['class' => 'table-responsive'],
        'columns' => [
            [
                'label' => '　',
                'value' => function ($model, $key, $index, $column) {
                    if (isset($model->userProfile->student_number)) {
                        return Html::a(Html::encode($model->userProfile->student_number), ['/user/view', 'id' => $model->user->id], ['class' => 'text-dark']);
                    } else {
                        return "";
                    }
                },
                'format' => 'raw',
                'enableSorting' => false,
                'options' => ['style' => 'width:8rem;']
            ],
            [
                'label' => '　',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->user->nickname ?? '临时用户'), ['/user/view', 'id' => $model->user->id], ['class' => 'text-dark']);
                },
                'format' => 'raw',
                'enableSorting' => false
            ],
        ],
        'pager' => [
            'linkOptions' => ['class' => 'page-link'],
            'maxButtonCount' => 5,
        ]
    ]); ?>
</div>