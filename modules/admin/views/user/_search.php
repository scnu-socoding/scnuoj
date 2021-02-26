<?php

use app\models\User;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="d-none d-lg-block">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => ''
        ],
    ]); ?>

    <div class="row">
        <div class="col-lg-2">
            <?= $form->field($model, 'id', [
                'template' => "{label}\n<div class=\"input-group\">{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => 'ID'])->label(false) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'username', [
                'template' => "{label}\n<div class=\"input-group\">{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => '用户名'])->label(false) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'nickname', [
                'template' => "{label}\n<div class=\"input-group\">{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => '昵称'])->label(false) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'email', [
                'template' => "{label}\n<div class=\"input-group\">{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => '邮箱'])->label(false) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'student_number', [
                'template' => "{label}\n<div class=\"input-group\">{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => '学号'])->label(false) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'role', [
                'template' => "{label}\n<div class=\"input-group\">{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => '昵称'])->dropDownList([
                '' => '所有用户',
                User::ROLE_PLAYER => '参赛用户',
                User::ROLE_USER => '普通用户',
                User::ROLE_VIP => '助教',
                User::ROLE_ADMIN => '管理员',

            ])->label(false) ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group btn-group btn-block">
                <?= Html::submitButton('<i class="fas fa-fw fa-search"></i> ' . Yii::t('app', 'Search'), ['class' => 'btn btn-info']) ?>
                <?= Html::resetButton('<i class="fas fa-fw fa-history"></i> ' . Yii::t('app', 'Reset'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>


</div>

<div class="d-lg-none">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => ''
        ],
    ]); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'id', [
                'template' => "{label}\n<div class=\"input-group\">{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => 'ID'])->label(false) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'username', [
                'template' => "{label}\n<div class=\"input-group\">{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => '用户名'])->label(false) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'nickname', [
                'template' => "{label}\n<div class=\"input-group\">{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => '昵称'])->label(false) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'email', [
                'template' => "{label}\n<div class=\"input-group\">{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => '邮箱'])->label(false) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'student_number', [
                'template' => "{label}\n<div class=\"input-group\">{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => '学号'])->label(false) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'role', [
                'template' => "{label}\n<div class=\"input-group\">{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete' => 'off', 'placeholder' => '昵称'])->dropDownList([
                '' => '所有用户',
                User::ROLE_PLAYER => '参赛用户',
                User::ROLE_USER => '普通用户',
                User::ROLE_VIP => '助教',
                User::ROLE_ADMIN => '管理员',

            ])->label(false) ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group btn-group btn-block">
                <?= Html::submitButton('<i class="fas fa-fw fa-search"></i> ' . Yii::t('app', 'Search'), ['class' => 'btn btn-info']) ?>
                <?= Html::resetButton('<i class="fas fa-fw fa-history"></i> ' . Yii::t('app', 'Reset'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>


</div>