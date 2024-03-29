<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $clarify app\models\Discuss */
/* @var $newClarify app\models\Discuss */

$this->title = $model->title;
$this->params['model'] = $model;

?>
<div class="row">
    <div class="col">
        <h5><?= Html::encode($clarify->title) ?></h5>
        <div class="card animate__animated animate__fadeIn animate__faster">
            <div class="card-header" style="padding: 0.5rem 1.25rem;">
                <small class="text-secondary">
                    <?= Html::a(Html::encode($clarify->user->nickname), ['/user/view', 'id' => $clarify->user->id]) ?>
                    发表于
                    <?= Yii::$app->formatter->asRelativeTime($clarify->created_at) ?>
                </small>
            </div>
            <div class="card-body" style="padding-bottom: 0.25rem;">
                <?= Yii::$app->formatter->asMarkdown($clarify->content) ?>
            </div>
        </div>
        <p></p>
        <?php foreach ($clarify->reply as $reply) : ?>
            <div class="card animate__animated animate__fadeIn animate__faster">
                <div class="card-header" style="padding: 0.5rem 1.25rem;">
                    <small class="text-secondary">
                        <?= Html::a(Html::encode($reply->user->nickname), ['/user/view', 'id' => $reply->user->id]) ?>
                        发表于
                        <?= Yii::$app->formatter->asRelativeTime($reply->created_at) ?>
                    </small>
                </div>
                <div class="card-body" style="padding-bottom: 0.25rem;">
                    <?= Yii::$app->formatter->asMarkdown($reply->content) ?>
                </div>
            </div>
            <p></p>
        <?php endforeach; ?>
        <div class="well animate__animated animate__fadeIn animate__faster">
            <?php if ($model->getRunStatus() == \app\models\Contest::STATUS_RUNNING) : ?>
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($newClarify, 'content', [
                    'template' => "{input}",
                ])->widget('app\widgets\editormd\Editormd'); ?>

                <div class="form-group">
                    <?= Html::submitButton('<i class="fas fa-fw fa-comment"></i> ' . Yii::t('app', 'Reply'), ['class' => 'btn btn-block btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            <?php else : ?>
                <div class="alert alert-warning"><?= Yii::t('app', 'The contest has ended.') ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>