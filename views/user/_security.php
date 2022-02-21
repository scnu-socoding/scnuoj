<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alert alert-light"><i class="fas fa-fw fa-pen"></i> 修改密码</div>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'oldPassword', [
    'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">当前密码</span></div>{input}</div>",
    'options' => ['class' => '']])->passwordInput()->label(false) ?>
<p></p>
<?= $form->field($model, 'newPassword', [
    'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">新的密码</span></div>{input}</div>{error}",
    'options' => ['class' => '']])->passwordInput()->label(false) ?>
<p></p>
<?= $form->field($model, 'verifyPassword', [
    'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">确认密码</span></div>{input}</div>",
    'options' => ['class' => '']])->passwordInput()->label(false) ?>
<p></p>
<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
</div>