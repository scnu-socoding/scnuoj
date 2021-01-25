<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $provider yii\data\ActiveDataProvider */

$this->title = $model->title;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contests'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = Yii::t('app', 'User');
?>

<div class='user-index'>
    <?= GridView::widget([
        'layout' => '{items}{pager}',
        'dataProvider' => $provider,
        // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'tableOptions' => ['class' => 'table table-bordered'],
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
                    return Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->user->id], ['class' => 'text-dark']);
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