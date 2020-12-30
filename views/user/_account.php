<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/verify-email']);

if ($model->isVerifyEmail()) {
    $emailTemplate = '{label}<div class="input-group">{input}<div class="input-group-addon">已验证</div></div>{hint}{error}';
} else {
    $emailTemplate = '{label}<div class="input-group">{input}<div class="input-group-addon">
        未验证 <a href="' . $verifyLink . '">发送验证链接</a>
        </div></div>{hint}{error}';
}
?>

<div class="card">
    <div class="card-body">

        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group">
            <label for="user-username">用户名</label>
            <input type="text" class="form-control" disabled="disabled" value="<?=$model->username?>">
        </div>

        <?= $form->field($model, 'email', [
            'template' => $emailTemplate
        ])->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>