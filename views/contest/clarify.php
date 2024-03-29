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
<div class="animate__animated animate__fadeIn animate__faster">
    <?php
    if ($dataProvider->count > 0) {
        echo GridView::widget([
            'layout' => '{items}{pager}',
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'table-responsive'],
            'columns' => [
                [
                    'attribute' => Yii::t('app', 'Announcement'),
                    'value' => function ($model, $key, $index, $column) {
                        return Html::encode($model->content);
                    },
                    'format' => 'html',
                    'enableSorting' => false
                ],
            ],
            'pager' => [
                'linkOptions' => ['class' => 'page-link'],
                'maxButtonCount' => 5,
            ]
        ]);
    }
    ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 如果你认为题目表述不清，可以在这里提问。</div>

    <?php if (!empty($clarifies)) : ?>
        <div class="list-group">
            <?php foreach ($clarifies as $clarify) : ?>
                <?= Html::a(Html::encode($clarify->title) . '<br><small>' . Html::encode($clarify->user->nickname) . ' 发表于 ' . Yii::$app->formatter->asRelativeTime($clarify->updated_at) . '</small>', ['/contest/clarify', 'id' => $clarify->entity_id, 'cid' => $clarify->id], ['class' => 'list-group-item text-dark list-group-item-action']) ?>
            <?php endforeach; ?>
        </div>
        <p></p>
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
            'linkOptions' => ['class' => 'page-link'],
            'maxButtonCount' => 5,
        ]); ?>
        <p></p>
    <?php endif; ?>

    <div class="well">
        <?php if ($model->getRunStatus() == \app\models\Contest::STATUS_RUNNING && $model->enable_clarify == 1) : ?>
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($newClarify, 'title', [
                'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">" . Yii::t('app', 'Title') . "</span></div>{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete' => 'off'])->label(false) ?>

            <?= $form->field($newClarify, 'content', [
                'template' => "{input}",
            ])->widget('app\widgets\editormd\Editormd'); ?>

            <div class="form-group">
                <?= Html::submitButton('<i class="fas fa-fw fa-comment"></i> ' . Yii::t('app', 'Create'), ['class' => 'btn btn-success btn-block']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        <?php elseif ($model->enable_clarify == 1) : ?>
            <div class="alert alert-warning"><?= Yii::t('app', 'The contest has ended.') ?></div>
        <?php else : ?>
            <div class="alert alert-warning"><?= Yii::t('app', '本场比赛不提供答疑服务。') ?></div>
        <?php endif; ?>
    </div>
</div>