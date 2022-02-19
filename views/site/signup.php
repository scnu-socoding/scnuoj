<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\SignupForm */

use yii\bootstrap4\Nav;

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = Yii::t('app', 'Signup');
// $this->params['breadcrumbs'][] = $this->title;
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
    <i class="fas fa-fw fa-info-circle"></i> 欢迎使用 SCNUOJ。
</div>

<div class="card animate__animated animate__fadeIn animate__faster">
    <!-- <img src="<?= Yii::getAlias('@web') . '/images/register.jpg' ?>" class="card-img-top d-none d-md-block"> -->
    <div class="card-body">
        <?php if (Yii::$app->setting->get('isUserReg')) : ?>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <small class="text-secondary">用户名将用于帐号登录，用户名一经设置不可修改。</small>
            <?= $form->field($model, 'username', [
                'template' => '<div class="input-group">{input}</div>{error}',
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('username'),
                ],
            ])->label(false);
            ?>

            <small class="text-secondary">邮箱将用于找回密码，请在注册后及时前往设置页验证邮箱。</small>
            <?= $form->field($model, 'email', [
                'template' => '<div class="input-group">{input}</div>{error}',
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('email'),
                ],
            ])->label(false);
            ?>

            <small class="text-secondary">请 SCNU 在校学生填写自己的真实学号，学号一经设置不可修改。</small>
            <?= $form->field($model, 'studentNumber', [
                'template' => '<div class="input-group">{input}</div>{error}',
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('studentNumber'),
                ],
            ])->label(false);
            ?>

            <small class="text-secondary">密码应当包含 6-16 个字符，同时包含数字、字母和特殊字符，请牢记你的密码。</small>

            <?= $form->field($model, 'password', [
                'template' => '<div class="input-group">{input}</div>{error}',
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('password'),
                ],
            ])->passwordInput()->label(false);
            ?>

            <small class="text-secondary">请填写下面图片中出现的字符以帮助我们确认你不是机器人。</small>

            <?= $form->field($model, 'verifyCode', [
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('verifyCode'),
                ],
            ])->widget(\yii\captcha\Captcha::class, [
                'template' => '<div class="input-group">{input}</div>
            <div class="list-group text-center" style="margin-top: 1rem;"><div class="list-group-item">{image}<a href="#" class="text-secondary" data-toggle="tooltip" title="点击图片以重置验证码"><span class="fas fa-fw fa-info-circle"></span></a></div></div>',
            ])->label(false);
            ?>

            <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn btn-success btn-block', 'name' => 'signup-button']) ?>
            <?php ActiveForm::end(); ?>
        <?php else : ?>
            <h3> 当前未开放注册！</h3>
        <?php endif; ?>
    </div>
</div>