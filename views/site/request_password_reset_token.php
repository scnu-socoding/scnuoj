<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \app\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = '重置密码';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-signin mt-5">
    <center>
        <h2><?= Html::encode($this->title) ?></h2>
    </center>
    <br>

    <p class="text-secondary">填写电子邮件信息以获取重置密码的链接。</p>

    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

    <?= $form->field($model, 'email', [
        'template' => '<div class="input-group">{input}</div>{error}',
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