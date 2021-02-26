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

<div class="card">
    <div class="card-header" style="padding: 0.5rem 1.25rem;">
        <small class="text-secondary">
            <!-- <i class="fas fa-fw fa-question"></i> -->

            <!-- <i class="fas fa-fw fa-user"></i> -->
            <?= Html::a(Html::encode($model->user->nickname ?? '临时用户'), ['/user/view', 'id' => $model->user->username]) ?>
            发表于
            <!-- <i class="fas fa-fw fa-clock"></i> -->
            <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
            ·
            关联问题
            <?= Html::a(
                Html::encode($model->problem->title),
                ['/problem/view', 'id' => $model->problem->id]
            )
            ?>

            <?php if (!Yii::$app->user->isGuest && (Yii::$app->user->id === $model->created_by || Yii::$app->user->identity->role == User::ROLE_ADMIN)) : ?>
                <span class="float-right">
                    <?= Html::a('<i class="fas fa-fw fa-pen fa-sm"></i>', ['/discuss/update', 'id' => $model->id], ['class' => 'text-secondary']) ?>
                    <?= Html::a('<i class="fas fa-fw fa-trash fa-sm"></i>', ['/discuss/delete', 'id' => $model->id], [
                        'data' => [
                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                        'class' => 'text-secondary',
                    ]) ?>
                <?php endif; ?>
                </span>
        </small>

    </div>
    <div class="card-body" style="padding-bottom: 0.25rem;">
        <?= Yii::$app->formatter->asMarkdown($model->content) ?>
    </div>
</div>
<p></p>
<?php $cnt = 2; ?>
<?php foreach ($replies as $reply) : ?>
    <div class="card">
        <div class="card-header" style="padding: 0.5rem 1.25rem;">
            <small class="text-secondary">
                <!-- <i class="fas fa-fw fa-comment"></i> -->
                <!-- <?= $cnt ?>楼 -->
                <!-- <?php $cnt = $cnt + 1; ?> -->
                <!-- <i class="fas fa-fw fa-user"></i> -->
                <?= Html::a(Html::encode($reply->user->nickname), ['/user/view', 'id' => $reply->user->id]) ?>
                <!-- <i class="fas fa-fw fa-clock"></i> -->
                发表于
                <?= Yii::$app->formatter->asRelativeTime($reply->created_at) ?>

                <?php if (!Yii::$app->user->isGuest && (Yii::$app->user->id === $reply->created_by || Yii::$app->user->identity->role == User::ROLE_ADMIN)) : ?>
                    <span class="float-right">
                        <?= Html::a('<i class="fas fa-fw fa-pen text-secondary fa-sm"></i>', ['/discuss/update', 'id' => $reply->id], ['class' => 'text-dark']) ?>
                        <?= Html::a('<i class="fas fa-fw fa-trash text-secondary fa-sm"></i>', ['/discuss/delete', 'id' => $reply->id], [
                            'data' => [
                                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                            'class' => 'text-dark'
                        ]) ?>
                    </span>
                <?php endif; ?>
            </small>
        </div>
        <div class="card-body" style="padding-bottom: 0.25rem;">
            <?= Yii::$app->formatter->asMarkdown($reply->content) ?>
        </div>

    </div>
    <p></p>
<?php endforeach; ?>
<?= \yii\widgets\LinkPager::widget([
    'pagination' => $pages,
    'maxButtonCount' => 5,
]); ?>
<p></p>
<div class=" well">

    <?php if (Yii::$app->user->isGuest) : ?>
    <?php else : ?>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($newDiscuss, 'content')->widget('app\widgets\editormd\Editormd')->label(false); ?>

        <div class="form-group">
            <?= Html::submitButton("<span class=\"fas fas-fw fa-comment\"></span> " . Yii::t('app', 'Reply'), ['class' => 'btn btn-block btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
</div>