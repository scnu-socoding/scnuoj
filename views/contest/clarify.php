<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $newClarify app\models\Discuss */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $discuss app\models\Discuss */

$this->title = $model->title;
$this->params['model'] = $model;

if ($discuss != null) {
    return $this->render('_clarify_view', [
        'clarify' => $discuss,
        'newClarify' => $newClarify
    ]);
}
?>
<div style="margin-top: 20px">
    <?php
    if ($dataProvider->count > 0) {
        echo GridView::widget([
            'layout' => '{items}{pager}',
            // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'table-responsive'],
            'columns' => [
                [
                    'attribute' => 'created_at',
                    'options' => ['width' => '150px'],
                    'format' => 'datetime',
                    'enableSorting' => false
                ],
                [
                    'attribute' => Yii::t('app', 'Announcement'),
                    'value' => function ($model, $key, $index, $column) {
                        return Yii::$app->formatter->asMarkdown($model->content);
                    },
                    'format' => 'html',
                    'enableSorting' => false
                ],
            ],
        ]);
        echo '<hr>';
    }
    ?>
    <div class="well">
        如果你认为题目存在歧义，可以在这里提出。
    </div>

    <?= GridView::widget([
        'dataProvider' => $clarifies,
        // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'tableOptions' => ['class' => 'table'],
        'columns' => [
            [
                'attribute' => 'Who',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->user->colorname, ['/user/view', 'id' => $model->user->id]);
                },
                'format' => 'raw',
                'enableSorting' => false
            ],
            [
                'attribute' => 'title',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->title), [
                        '/contest/clarify',
                        'id' => $model->entity_id,
                        'cid' => $model->id
                    ], ['data-pjax' => 0]);
                },
                'format' => 'raw',
                'enableSorting' => false
            ],
            [
                'attribute' => 'created_at',
                'enableSorting' => false
            ],
            [
                'attribute' => 'updated_at',
                'enableSorting' => false
            ]
        ]
    ]); ?>

    <div class="well">
        <?php if ($model->getRunStatus() == \app\models\Contest::STATUS_RUNNING): ?>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($newClarify, 'title', [
            'template' => "{label}\n<div class=\"input-group\"><span class=\"input-group-addon\">" . Yii::t('app', 'Title') . "</span>{input}</div>{error}",
        ])->textInput(['maxlength' => 128, 'autocomplete'=>'off'])->label(false) ?>

        <?= $form->field($newClarify, 'content')->widget('app\widgets\editormd\Editormd'); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?php else: ?>
        <p><?= Yii::t('app', 'The contest has ended.') ?></p>
        <?php endif; ?>
    </div>
</div>
