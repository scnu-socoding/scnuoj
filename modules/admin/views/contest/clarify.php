<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $new_clarify app\models\Discuss */

$this->title = Html::encode($model->title);
$this->params['model'] = $model;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contests'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clarification'), 'url' => ['clarify', 'id' => $model->id]];

if ($discuss != null) {
    echo $this->render('_clarify_view', [
        'clarify' => $discuss,
        'new_clarify' => $new_clarify
    ]);
    return;
}
?>
<p class="lead">比赛 <?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?> 答疑。</p>
<div>

    <?= GridView::widget([
        'dataProvider' => $clarifies,
        'tableOptions' => ['class' => 'table table-bordered'],
        'options' => ['class' => 'table-responsive'],
        'layout' => '{items}{pager}',
        'columns' => [
            [
                'attribute' => 'who',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->user->id]);
                },
                'label' => '昵称',
                'format' => 'raw'
            ],
            [
                'attribute' => 'title',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->title, [
                        'contest/clarify',
                        'id' => $model->entity_id,
                        'cid' => $model->id
                    ]);
                },
                'format' => 'raw',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'created_at',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'updated_at',
                'enableSorting' => false,
            ]
        ]
    ]); ?>

</div>
