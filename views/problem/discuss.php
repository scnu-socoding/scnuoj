<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */
/* @var $model app\models\Problem */
/* @var $discusses app\models\Discuss */
/* @var $newDiscuss app\models\Discuss */
/* @var $pages yii\data\Pagination */

$this->title = Yii::t('app', 'Discuss');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['problem/index']];
$this->params['breadcrumbs'][] = ['label' => Html::encode($model->id . ' - ' . $model->title), 'url' => ['problem/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Discuss');

?>
<div class="card bg-secondary text-white">
    <div class="card-body">
        <h3><?= Yii::t('app', 'Discuss') ?></h3>
    </div>
</div>
<br />

<?php if (!empty($discusses)): ?>
<div class="list-group">
    <?php foreach ($discusses as $discuss): ?>
    <?= Html::a(Html::encode($discuss->title) . '<span class="float-right">' .Html::encode($discuss->user->nickname) . ' / ' . Yii::$app->formatter->asRelativeTime($discuss->updated_at) . '</span>', ['/discuss/view', 'id' => $discuss->id], ['class' => 'text-dark list-group-item list-group-item-action']) ?>
    <?php endforeach; ?>
</div>
<p></p>
<?= \yii\widgets\LinkPager::widget([
        'pagination' => $pages,
        'linkOptions' => ['class' => 'page-link text-dark'],
        'maxButtonCount' => 5,
    ]); ?>
<p></p>
<?php endif;?>

<?php if (Yii::$app->user->isGuest): ?>

<?php else: ?>
<div class="discuss-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($newDiscuss, 'title', [
            'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">". Yii::t('app', 'Title') ."</span></div>{input}</div>",
        ])->textInput(['maxlength' => 128, 'autocomplete'=>'off'])
        ?>

    <?= $form->field($newDiscuss, 'content', [
            'template' => "{input}",
        ])->widget('app\widgets\editormd\Editormd'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-outline-secondary btn-block']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php endif; ?>