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
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contest'), 'url' => ['/contest/index']];
$this->params['breadcrumbs'][] = $this->title;

if ($discuss != null) {
    return $this->render('_clarify_view', [
        'clarify' => $discuss,
        'newClarify' => $newClarify
    ]);
}
?>
<div>
    <?php
    if ($dataProvider->count > 0) {
        echo GridView::widget([
            'layout' => '{items}{pager}',
            // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'table-responsive'],
            'columns' => [
                // [
                //     'attribute' => 'created_at',
                //     'options' => ['width' => '150px'],
                //     'format' => 'datetime',
                //     'enableSorting' => false
                // ],
                [
                    'attribute' => Yii::t('app', 'Announcement'),
                    'value' => function ($model, $key, $index, $column) {
                        return $model->content;
                    },
                    'format' => 'html',
                    'enableSorting' => false
                ],
            ],
            'pager' => [
                'linkOptions' => ['class' => 'page-link text-dark'],
            ]
        ]);
    }
    ?>
    <div class="alert alert-info">如果你认为题目表述不清，可以在这里提问。</div>

    <?php if (!empty($clarifies)): ?>
        <div class="list-group">
        <?php foreach ($clarifies as $clarify): ?>
            <?= Html::a(Html::encode($clarify->title) . '<span class="float-right">' . Html::encode($clarify->user->nickname) . ' / '. Yii::$app->formatter->asRelativeTime($clarify->updated_at) . '</span>', ['/contest/clarify', 'id' => $clarify->entity_id, 'cid' => $clarify->id], ['class' => 'list-group-item text-dark list-group-item-action']) ?>
        <?php endforeach; ?>
        </div>
        <p></p>
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
            'linkOptions' => ['class' => 'page-link text-dark'],
            //'widgetId' => '#content',
        ]); ?>
        <p></p>
    <?php endif; ?>

    

    <div class="well">
        <?php if ($model->getRunStatus() == \app\models\Contest::STATUS_RUNNING): ?>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($newClarify, 'title', [
            'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">". Yii::t('app', 'Title') ."</span></div>{input}</div>",
        ])->textInput(['maxlength' => 128, 'autocomplete'=>'off'])->label(false) ?>

        <?= $form->field($newClarify, 'content', [
            'template' => "{input}",
        ])->widget('app\widgets\editormd\Editormd'); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-outline-secondary btn-block']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?php else: ?>
        <div class="alert alert-warning"><?= Yii::t('app', 'The contest has ended.') ?></div>
        <?php endif; ?>
    </div>
</div>
