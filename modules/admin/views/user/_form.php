<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 修改密码后，即可登录此账户进行进一步设置。</div>

    <?= $form->field($model, 'newPassword', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">密码</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput()->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 请不要修改参赛用户的权限，也不要将其他账户设置为参赛用户。</div>

    <?= $form->field($model, 'role')->radioList([
        $model::ROLE_PLAYER => '参赛用户',
        $model::ROLE_USER => '普通用户',
        $model::ROLE_VIP => '助教',
        $model::ROLE_ADMIN => '管理员'
    ])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>