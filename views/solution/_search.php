<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SolutionSearch */
/* @var $form yii\widgets\ActiveForm */
?>



    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => '',
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-lg" style="margin-bottom: 3px">
        <?= $form->field($model, 'problem_id', [
            'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\"><i class=\"fas fa-fw fa-bars\"></i></span></div>{input}</div>",
            'options' => ['class' => ''],
        ])->textInput(['maxlength' => 128, 'autocomplete'=>'off', 'placeholder' => Yii::t('app', 'Problem ID')])->label(false) ?>

        </div>

        <div class="col-lg" style="margin-bottom: 3px">
            <?= $form->field($model, 'username', [
                'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\"><i class=\"fas fa-fw fa-user\"></i></span></div>{input}</div>",
                'options' => ['class' => ''],
            ])->textInput(['maxlength' => 128, 'autocomplete'=>'off', 'placeholder' => Yii::t('app', 'Who')])->label(false) ?>

        </div> 
        <div class="col-lg" style="margin-bottom: 3px">
            <?= $form->field($model, 'result', [
                'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\"><i class=\"fas fa-fw fa-check\"></i></span></div>{input}</div>",
                'options' => ['class' => ''],
            ])->dropDownList($model::getResultList(), ['class' => 'form-control custom-select'])->label(false) ?>
        </div>
        <div class="col-lg" style="margin-bottom: 3px">
            <?= $form->field($model, 'language', [
                'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\"><i class=\"fas fa-fw fa-globe\"></i></span></div>{input}</div>",
                'options' => ['class' => ''],
            ])->dropDownList($model::getLanguageList(), ['class' => 'form-control custom-select'])->label(false) ?>
        </div> 
        <div class="col-lg" style="margin-bottom: 3px">
            <div class="btn-group btn-block">
                <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-secondary']) ?>
                <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
    </div>
    <p></p>

    <?php ActiveForm::end(); ?>


