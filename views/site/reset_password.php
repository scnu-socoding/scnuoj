<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \app\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
$this->title = '重置密码';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-signin">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 请设置新密码。</div>
    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

    <?= $form->field($model, 'password', [
           'template' => '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sm fa-fw fa-lock"></i></span></div>{input}</div>{error}',
           'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('password'),
            ],
        ])->passwordInput()->label(false);
    ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
</div>