<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \app\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
$this->title = '重置密码';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-signin">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 请填写您的电子邮件信息以获取重置密码的链接。</div>

    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

    <?= $form->field($model, 'email', [
            'template' => '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sm fa-fw fa-mail-bulk"></i></span></div>{input}</div>{error}',
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('email'),
            ],
        ])->label(false);
    ?>

    <div class="form-group">
        <?= Html::submitButton('发送', ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
</div>