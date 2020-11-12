<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model app\models\Discuss */
/* @var $newDiscuss app\models\Discuss */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['problem/index']];
$this->params['breadcrumbs'][] = ['label' => Html::encode($model->problem->id . ' - ' . $model->problem->title), 'url' => ['problem/view', 'id' => $model->problem->id]];
$this->params['breadcrumbs'][] = ['label' => Html::encode(Yii::t('app', 'Discuss')), 'url' => ['problem/discuss', 'id' => $model->problem->id]];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="row">
    <div class="col">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <h3><?= Html::encode($this->title) ?></h3>
            </div>
        </div>
        <p></p>
        <div class="card">
            <div class="card-body">
                <?= Yii::$app->formatter->asMarkdown($model->content) ?>
            </div>
            <div class="card-footer">

                <?= Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->user->username], ['class' => 'text-dark']) ?>
                /
                <span class="text-dark"><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></span>
                <?php if (!Yii::$app->user->isGuest && (Yii::$app->user->id === $model->created_by || Yii::$app->user->identity->role == User::ROLE_ADMIN)): ?>
                <span class="float-right">
                    <?= Html::a('<i class="fas fa-fw fa-pen"></i>', ['/discuss/update', 'id' => $model->id], ['class' => 'text-dark']) ?>
                    <?= Html::a('<i class="fas fa-fw fa-trash"></i>', ['/discuss/delete', 'id' => $model->id], [
                        'data' => [
                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                        'class' => 'text-dark',
                    ]) ?>
                    <?php endif; ?>
                </span>
            </div>
        </div>
        <p></p>
        <div class="card">
            <div class="card-body">
                <h3 style="margin-bottom:0"><?= Yii::t('app', 'Comments') ?></h3>
            </div>
        </div>
        <p></p>
        <?php foreach ($replies as $reply): ?>
        <div class="card">
            <div class="card-body">
                <?= Yii::$app->formatter->asMarkdown($reply->content) ?>
            </div>
            <div class="card-footer">
                <?= Html::a(Html::encode($reply->user->nickname), ['/user/view', 'id' => $reply->user->id], ['class' => 'text-dark']) ?>
                /
                <?= Yii::$app->formatter->asRelativeTime($reply->created_at) ?>

                <?php if (!Yii::$app->user->isGuest && (Yii::$app->user->id === $reply->created_by || Yii::$app->user->identity->role == User::ROLE_ADMIN)): ?>
                <span class="float-right">
                    <?= Html::a('<i class="fas fa-fw fa-pen"></i>', ['/discuss/update', 'id' => $reply->id], ['class' => 'text-dark']) ?>
                    <?= Html::a('<i class="fas fa-fw fa-trash"></i>', ['/discuss/delete', 'id' => $reply->id], [
                        'data' => [
                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                        'class' => 'text-dark'
                    ]) ?>
                </span>
                <?php endif; ?>
            </div>
        </div>
        <p></p>
        <?php endforeach; ?>
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
        ]); ?>
        <div class="well">

            <?php if (Yii::$app->user->isGuest): ?>
            <?= app\widgets\login\Login::widget(); ?>
            <?php else: ?>
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($newDiscuss, 'content')->widget('app\widgets\editormd\Editormd')->label(false); ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Reply'), ['class' => 'btn btn-block btn-outline-secondary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <?php endif; ?>


        </div>
    </div>
</div>