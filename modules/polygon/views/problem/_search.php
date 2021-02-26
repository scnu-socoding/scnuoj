<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\polygon\models\ProblemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="problem-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => ''
        ],
    ]); ?>

    <div class="row">

        <div class="col-lg-4">
            <?= $form->field($model, 'title', [
                'template' => "{label}\n<div class=\"input-group\">{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => Yii::t('app', 'Title')])->label(false) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'username', [
                'template' => "{label}\n<div class=\"input-group\">{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => Yii::t('app', 'Who')])->label(false) ?>
        </div>
        <div class="col-lg-4" style="margin-bottom: 1rem;">
            <div class="btn-group btn-block">
                <?= Html::submitButton('<i class="fas fa-fw fa-search"></i> ' . Yii::t('app', 'Search'), ['class' => 'btn btn-info']) ?>
                <?= Html::resetButton('<i class="fas fa-fw fa-history"></i> ' . Yii::t('app', 'Reset'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>