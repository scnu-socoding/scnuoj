<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Discuss */
/* @var $form yii\widgets\ActiveForm */

?>

<h3>编辑帖子</h3>

<div class="contest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($model->entity == \app\models\Discuss::ENTITY_PROBLEM && $model->parent_id == 0): ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'content')->widget('app\widgets\editormd\Editormd')->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton("<span class=\"fas fas-fw fa-check\"></span> " . Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
