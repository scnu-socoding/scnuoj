<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model app\models\Discuss */
/* @var $newDiscuss app\models\Discuss */

$this->title = Html::encode($model->title);
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['problem/index']];
// $this->params['breadcrumbs'][] = ['label' => Html::encode($model->problem->id . ' - ' . $model->problem->title), 'url' => ['problem/view', 'id' => $model->problem->id]];
// $this->params['breadcrumbs'][] = ['label' => Html::encode(Yii::t('app', 'Discuss')), 'url' => ['problem/discuss', 'id' => $model->problem->id]];
// $this->params['breadcrumbs'][] = $this->title;


?>

<h3><?= Html::encode($model->title) ?></h3>

<p><span class="text-secondary">
        <i class="fas fa-fw fa-question"></i>
        <?= Html::a( Html::encode($model->problem->title),
            ['/p/' . $model->problem->id], ['class' => 'text-secondary'])
        ?>
        <i class="fas fa-fw fa-user"></i>
        <?= Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->user->username], ['class' => 'text-secondary']) ?>
        <i class="fas fa-fw fa-clock"></i>
        <?= Yii::$app->formatter->asDate($model->created_at) ?>

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
    </span>
</p>
<hr>
<?= Yii::$app->formatter->asMarkdown($model->content) ?>
<hr>
<?php $cnt = 2; ?>
<?php foreach ($replies as $reply): ?>
<p><small class="text-secondary">
        <i class="fas fa-fw fa-comment"></i>
        <?= $cnt ?>楼
        <?php $cnt = $cnt + 1; ?>
        <i class="fas fa-fw fa-user"></i>
        <?= Html::a(Html::encode($reply->user->nickname), ['/user/view', 'id' => $reply->user->id], ['class' => 'text-secondary']) ?>
        <i class="fas fa-fw fa-clock"></i>
        <?= Yii::$app->formatter->asDate($reply->created_at) ?>

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
    </small></p>
<?= Yii::$app->formatter->asMarkdown($reply->content) ?>
<hr>
<?php endforeach; ?>
<?= \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
            'maxButtonCount' => 5,
        ]); ?>
<p></p>
<div class="well">

    <?php if (Yii::$app->user->isGuest): ?>
    <?php else: ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($newDiscuss, 'content')->widget('app\widgets\editormd\Editormd')->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton("<span class=\"fas fas-fw fa-comment\"></span> " . Yii::t('app', 'Reply'), ['class' => 'btn btn-block btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <?php endif; ?>
</div>
</div>
</div>