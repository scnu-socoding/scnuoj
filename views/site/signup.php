<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = Yii::t('app', 'Signup');
// $this->params['breadcrumbs'][] = $this->title;
?>



<div class="form-signin mt-5">
    <?php if (Yii::$app->setting->get('isUserReg')) : ?>
        <center>
            <h2><?= Html::encode($this->title) ?></h2>
        </center>
        <br>
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <p class="text-secondary">用户名和学号一经设置不可修改。</p>

        <?= $form->field($model, 'username', [
            'template' => '<div class="input-group">{input}</div>{error}',
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('username'),
            ],
        ])->label(false);
        ?>
        <?= $form->field($model, 'email', [
            'template' => '<div class="input-group">{input}</div>{error}',
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('email'),
            ],
        ])->label(false);
        ?>
        <?= $form->field($model, 'studentNumber', [
            'template' => '<div class="input-group">{input}</div>{error}',
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('studentNumber'),
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

        <?= $form->field($model, 'verifyCode', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('verifyCode'),
            ],
        ])->widget(\yii\captcha\Captcha::class, [
            'template' => '<div class="input-group">{input}</div>
            <div class="list-group text-center" style="margin-top: 1rem;"><div class="list-group-item">{image}<a href="signup"><span class="text-secondary d-none d-sm-inline">点击图片换图</span></a></div></div>',
        ])->label(false);
        ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn btn-success btn-block', 'name' => 'signup-button']) ?>
            <?= Html::a('已有帐号', ['site/login'], ['class' => 'btn btn-block text-secondary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    <?php else : ?>
        <h3> 当前未开放注册！</h3>
    <?php endif; ?>
</div>