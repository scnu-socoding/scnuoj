<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $data array */

?>

<p class="lead">查看答疑帖《<?= Html::encode($clarify->title) ?>》。</p>

<?php Modal::begin([
    'title' => Yii::t('app', '设置帖子可见性'),
    'toggleButton' => ['label' => '设置帖子可见性', 'class' => 'btn btn-outline-primary btn-block'],
    'size' => Modal::SIZE_LARGE
]); ?>

<?php $form = ActiveForm::begin(); ?>
<div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 如果询问同一问题的人数过多，可以公开答疑帖，注意帖子公开后将允许其他人回复。</div>
<?= $form->field($clarify, 'status')->radioList([
    1 => Yii::t('app', '对所有人可见'),
    2 => Yii::t('app', '仅对提问人可见')
])->label(false) ?>
<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
<?php ActiveForm::end(); ?>

<?php Modal::end(); ?>
<p></p>
<div class="card">
    <div class="card-header" style="padding: 0.5rem 1.25rem;">
        <small class="text-secondary">
            <!-- <i class="fas fa-fw fa-user"></i> -->
            <?= Html::a(Html::encode($clarify->user->nickname), ['/user/view', 'id' => $clarify->user->id]) ?>
            发表于
            <!-- <i class="fas fa-fw fa-clock"></i> -->
            <?= Yii::$app->formatter->asRelativeTime($clarify->created_at) ?>
        </small>
    </div>
    <div class="card-body" style="padding-bottom: 0.25rem;">
        <?= Yii::$app->formatter->asMarkdown($clarify->content) ?>
    </div>
</div>
<p></p>
<?php foreach ($clarify->reply as $reply) : ?>
    <div class="card">
        <div class="card-header" style="padding: 0.5rem 1.25rem;">
            <small class="text-secondary">
                <!-- <i class="fas fa-fw fa-user"></i> -->
                <?= Html::a(Html::encode($reply->user->nickname), ['/user/view', 'id' => $reply->user->id]) ?>
                <!-- <i class="fas fa-fw fa-clock"></i> -->
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
<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($new_clarify, 'content')->widget('app\widgets\editormd\Editormd')->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Reply'), ['class' => 'btn btn-success btn-block']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>