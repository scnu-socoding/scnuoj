<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \app\models\ResetPasswordForm */

use yii\bootstrap4\Nav;

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = '重新发送邮箱验证链接';
?>

<?= Nav::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'Login'), 'url' => ['/site/login']
        ],
        [
            'label' => Yii::t('app', 'Register'), 'url' => ['/site/signup']
        ]
    ],
    'options' => ['class' => 'nav nav-pills']
]) ?>

<p></p>


<div class="alert alert-light">
    <i class="fas fa-fw fa-info-circle"></i> 请填写你的邮箱。
</div>

<div class="card animate__animated animate__fadeIn animate__faster">
    <img src="<?= Yii::getAlias('@web') . '/images/login.jpg' ?>" class="card-img-top d-none d-md-block">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'resend-verification-email-form']); ?>

        <?= $form->field($model, 'email', [
            'template' => '<div class="input-group">{input}</div>{error}',
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('email'),
            ],
        ])->label(false);
        ?>

        <?= Html::submitButton('发送', ['class' => 'btn btn-success btn-block']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>