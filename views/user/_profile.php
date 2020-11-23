<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $profile app\models\UserProfile */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<?php if (Yii::$app->setting->get('isChangeNickName')==1): ?>
<?= $form->field($model, 'nickname')->textInput() ?>
<?php elseif (Yii::$app->setting->get('isChangeNickName')==2 && $model->username === $model->nickname ): ?>
<?= $form->field($model, 'nickname')->textInput() ?>
<p class="hint-block">
    昵称只能修改一次，请谨慎修改。<br>
</p>
<?php endif; ?>

<!-- <?= $form->field($profile, 'qq_number')->textInput() ?> -->

<!-- <?= $form->field($profile, 'student_number')->textInput() ?> -->

<?= $form->field($profile, 'gender')->radioList([Yii::t('app', 'Male'), Yii::t('app', 'Female')]) ?>

<?= $form->field($profile, 'major')->textInput() ?>

<div class="alert alert-info">新功能测试：自定义个人主页展示的内容...</div>

<?= $form->field($profile, 'personal_intro', [
            'template' => "{input}",
        ])->widget('app\widgets\editormd\Editormd'); ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>