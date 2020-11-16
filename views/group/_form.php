<?php

use app\models\Group;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name' ,[
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">". Yii::t('app', 'Names') ."</span></div>{input}</div>",
      ])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description' ,[
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">". Yii::t('app', 'Description') ."</span></div>{input}</div>",
      ])->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'join_policy')->radioList([
        Group::JOIN_POLICY_INVITE => Yii::t('app', 'Invite Only'),
        Group::JOIN_POLICY_APPLICATION => Yii::t('app', 'Application & Approve'),
        Group::JOIN_POLICY_FREE => Yii::t('app', 'Free')
    ])?>

    <?= $form->field($model, 'status')->radioList([
        Group::STATUS_VISIBLE => Yii::t('app', 'Visible'),
        Group::STATUS_HIDDEN => Yii::t('app', 'Hidden')
    ])->hint('可见：用户可在探索页面发现。') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
