<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap4\Nav;

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = Yii::t('app', 'Login');
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
    <i class="fas fa-fw fa-info-circle"></i> 欢迎回来。
</div>

<div class="card animate__animated animate__fadeIn animate__faster">
    <img src="<?= Yii::getAlias('@web') . '/images/login.jpg' ?>" class="card-img-top d-none d-md-block">
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => '']
        ]); ?>
        <?= $form->field($model, 'username', [
            'template' => '<div class="input-group">{input}</div>{error}',
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('username'),
            ],
        ])->label(false);
        ?>
        <?= $form->field($model, 'password', [
            'template' => '<div class="input-group">{input}</div>{error}',
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('password'),
            ],
        ])->passwordInput()->label(false);
        ?>

        <?php if ($model->scenario == 'withCaptcha') : ?>
            <?= $form->field($model, 'verifyCode', [
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('verifyCode'),
                ],
            ])->widget(\yii\captcha\Captcha::class, [
                'template' => '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sm fa-fw fa-check"></i></span></div>{input}</div>
            <div class="list-group text-center" style="margin-top: 1rem;"><div class="list-group-item">{image}<span class="text-secondary d-none d-sm-inline">点击图片换图</span></div></div>',
            ])->label(false);
            ?>
        <?php endif; ?>

        <span class="float-left"> <?= $form->field($model, 'rememberMe')->checkbox() ?></span>
        <span class="float-right">
            <?= Html::a('忘记密码', ['site/request-password-reset']) ?>
        </span>
        
        <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-block btn-primary btn-success', 'name' => 'login-button']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>