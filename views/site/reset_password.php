<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \app\models\ResetPasswordForm */

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
    <p class="text-secondary">请设置新密码。</p>
    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

    <?= $form->field($model, 'password', [
        'template' => '<div class="input-group">{input}</div>{error}',
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