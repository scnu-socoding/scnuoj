<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $clarify app\models\Discuss */
/* @var $newClarify app\models\Discuss */

$this->title = $model->title;
$this->params['model'] = $model;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contest'), 'url' => ['/contest/index']];
// $this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <h3><?= Html::encode($clarify->title) ?></h3>
            </div>
        </div>
        <p></p>
        <div class="card">
            <div class="card-body">
                <?= Yii::$app->formatter->asMarkdown($clarify->content) ?>
            </div>
            <div class="card-footer">
                <?= Html::a(Html::encode($clarify->user->nickname), ['/user/view', 'id' => $clarify->user->id], ['class' => 'text-dark']) ?>
                /
                <?= Yii::$app->formatter->asRelativeTime($clarify->created_at) ?>
            </div>
        </div>
        <p></p>
        <?php foreach ($clarify->reply as $reply): ?>
        <div class="card">
            <div class="card-body">
                <?= Yii::$app->formatter->asMarkdown($reply->content) ?>
            </div>
            <div class="card-footer">
                <?= Html::a(Html::encode($reply->user->nickname), ['/user/view', 'id' => $reply->user->id], ['class' => 'text-dark']) ?>
                /
                <?= Yii::$app->formatter->asRelativeTime($reply->created_at) ?>
            </div>
        </div>
        <p></p>
        <?php endforeach; ?>
        <div class="well">
            <?php if ($model->getRunStatus() == \app\models\Contest::STATUS_RUNNING): ?>
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($newClarify, 'content')->widget('app\widgets\editormd\Editormd'); ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Reply'), ['class' => 'btn btn-block btn-outline-secondary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <?php else: ?>
            <div class="alert alert-warning"><?= Yii::t('app', 'The contest has ended.') ?></div>
            <?php endif; ?>
        </div>
    </div>