<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\polygon\models\ProblemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Problems');
// $this->params['breadcrumbs'][]][] = ['label' => Yii::t('app', 'Polygon System'), 'url' => ['/polygon/default']];
// $this->params['breadcrumbs'][]][] = $this->title;
?>
<div class="problem-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Problem'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->id, ['problem/view', 'id' => $key]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'title',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->title), ['problem/view', 'id' => $key]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'created_by',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->user) {
                        return Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->user->id]);
                    }
                    return '';
                },
                'format' => 'raw'
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
