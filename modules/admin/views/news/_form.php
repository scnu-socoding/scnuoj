<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Discuss */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="discuss-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">标题</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput()->label(false) ?>
    <p></p>

    <?= $form->field($model, 'content', [
        'template' => "{input}",
    ])->widget('app\widgets\editormd\Editormd'); ?>

    <?= $form->field($model, 'status')->radioList([
        1 => '设为可见',
        0 => '设为隐藏'
    ])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>