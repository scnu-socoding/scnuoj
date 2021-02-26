<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $profile app\models\UserProfile */
/* @var $form yii\bootstrap4\ActiveForm */


$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/verify-email']);

$emailTemplate = '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text">邮箱</span></div>{input}</div>';

?>

<div class="alert alert-light"><i class="fas fa-fw fa-pen"></i> 基本信息</div>

<!-- <div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">账户</span></div><input type="text"
        class="form-control" disabled="disabled" value="<?= $model->username ?>">
</div>
<p></p> -->



<?php $form = ActiveForm::begin(); ?>

<div class="card bg-light">
    <div class="card-body">
    <div class="alert alert-warning"><i class="fas fa-fw fa-info-circle"></i> SCNUOJ 开发组祝大家新春快乐！账户名仅可在春节期间更改，且新的账户名也不能与他人相同。</div>
    <?= $form->field($model, 'username', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">账户</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput()->label(false) ?>
    
    </div>
</div>
<p></p>

<div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">学号</span></div><input type="text"
        class="form-control" disabled="disabled" value="<?= $profile->student_number ?>">
</div>
<p></p>

<?php if (Yii::$app->setting->get('isChangeNickName') == 1) : ?>
    <?= $form->field($model, 'nickname', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">昵称</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput()->label(false) ?>
    <p></p>
<?php elseif (Yii::$app->setting->get('isChangeNickName') == 2 && $model->username == $model->nickname) : ?>
    <?= $form->field($model, 'nickname', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">昵称</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput()->label(false) ?>
    <div class="alert alert-light">
        昵称只能修改一次，请谨慎修改。<br>
    </div>
    <p></p>
<?php endif; ?>

<?= $form->field($profile, 'major', [
    'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">班级</span></div>{input}</div>",
    'options' => ['class' => '']
])->textInput()->label(false) ?>
<p></p>

<?= $form->field($model, 'email', ['options' => ['class' => ''], 'template' => $emailTemplate])->textInput()->label(false) ?>
<p></p>



<div class="alert alert-light"><i class="fas fa-fw fa-pen"></i> 个人主页自定义</div>

<?= $form->field($profile, 'personal_intro', [
    'template' => "{input}",
])->widget('app\widgets\editormd\Editormd'); ?>

<div class="form-group btn-block btn-group">
    <?php if (!$model->isVerifyEmail()) : ?>
        <a class="btn btn-primary" href="<?= $verifyLink ?>">验证邮箱</a>
    <?php endif; ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>