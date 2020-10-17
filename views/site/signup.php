<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\SignupForm */
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = Yii::t('app', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Yii::$app->session->setFlash('info', '用户名和学号一经设置<b>不可修改</b>，请使用真实学号注册（注册成功后可以设置昵称）。'); ?>

<div class="form-signin">
    <?php if (Yii::$app->setting->get('isUserReg')): ?>    
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

    <?= $form->field($model, 'username', [
            'template' => '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sm fa-fw fa-user"></i></span></div>{input}</div>{error}',
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('username'),
            ],
        ])->label(false);
    ?>
    <?= $form->field($model, 'email', [
            'template' => '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sm fa-fw fa-mail-bulk"></i></span></div>{input}</div>{error}',
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('email'),
            ],
        ])->label(false);
    ?>
    <?= $form->field($model, 'studentNumber', [
            'template' => '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sm fa-fw fa-info"></i></span></div>{input}</div>{error}',
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('studentNumber'),
            ],
        ])->label(false);
    ?>
    <?= $form->field($model, 'password', [
           'template' => '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sm fa-fw fa-lock"></i></span></div>{input}</div>{error}',
           'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('password'),
            ],
        ])->passwordInput()->label(false);
    ?>

    <?= $form->field($model, 'verifyCode', [
           'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('verifyCode'),
            ],
        ])->widget(\yii\captcha\Captcha::className(),[
            'template' => '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sm fa-fw fa-check"></i></span></div>{input}</div>
            <div class="list-group text-center" style="margin-top: 1rem;"><div class="list-group-item">{image}<span class="text-secondary d-none d-sm-inline">点击图片换图</span></div></div>',
        ])->label(false);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn btn-success btn-block', 'name' => 'signup-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <?php else: ?>
       <h3> 当前未开放注册！</h3>
    <?php endif; ?>    
</div>

