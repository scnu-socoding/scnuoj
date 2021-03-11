<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Problem */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="problem-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 题目标题。</div>
    <?= $form->field($model, 'title', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">标题</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput()->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 单个测试点时间限制：Java 和 Python 有 2s 额外时间。</div>
    <?= $form->field($model, 'time_limit', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">时间</span></div>{input}<div class=\"input-group-append\"><span class=\"input-group-text\">秒</span></div></div>",
        'options' => ['class' => '']
    ])->textInput(['maxlength' => 128, 'autocomplete' => 'off'])->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 空间限制：Java 和 Python 有 128MB 额外空间。</div>

    <?= $form->field($model, 'memory_limit', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">空间</span></div>{input}<div class=\"input-group-append\"><span class=\"input-group-text\">MB</span></div></div>",
        'options' => ['class' => '']
    ])->textInput(['maxlength' => 128, 'autocomplete' => 'off'])->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 题目描述。</div>

    <?= $form->field($model, 'description')->widget('app\widgets\editormd\Editormd')->label(false); ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 输入格式。</div>

    <?= $form->field($model, 'input')->widget('app\widgets\editormd\Editormd')->label(false); ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 输出格式。</div>

    <?= $form->field($model, 'output')->widget('app\widgets\editormd\Editormd')->label(false); ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 样例：请从样例 1 到样例 3 的顺序填写。</div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'sample_input')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'sample_output')->textarea(['rows' => 6]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'sample_input_2')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'sample_output_2')->textarea(['rows' => 6]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'sample_input_3')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'sample_output_3')->textarea(['rows' => 6]) ?>
        </div>
    </div>


    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 是否开启 Special Judge：开启后需要你还需要在此处提交您的答案检查器。</div>

    <?= $form->field($model, 'spj')->radioList([
        '1' => Yii::t('app', 'Yes'),
        '0' => Yii::t('app', 'No')
    ])->label(false) ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 提示与说明。</div>

    <?= $form->field($model, 'hint')->widget('app\widgets\editormd\Editormd')->label(false); ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 题目标签：多个标签使用逗号隔开，标签信息将展示在前台。</div>

    <?= $form->field($model, 'tags')->textarea(['maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>