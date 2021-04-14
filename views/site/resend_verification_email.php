<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \app\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = '重新发送邮箱验证链接';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-signin mt-5">
    <center>
        <h2><?= Html::encode($this->title) ?></h2>
    </center>
    <br>

    <p class="text-secondary">请填写你的邮箱。</p>


    <?php $form = ActiveForm::begin(['id' => 'resend-verification-email-form']); ?>

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