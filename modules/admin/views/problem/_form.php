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

    <?php if (Yii::$app->user->identity->isAdmin()) : ?>
        <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 非必要情况下，请不要更改本栏内容，维持当前状态即可。</div>
        <?= $form->field($model, 'id', [
            'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">题号</span></div>{input}</div>",
            'options' => ['class' => '']
        ])->textInput()->label(false) ?>
        <p></p>
    <?php endif ?>
    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 题目标题，可从题面中提取若干关键词，尽可能简短，对于非模板题避免直接出现考察的知识点。</div>
    <?= $form->field($model, 'title', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">标题</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput()->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 时限取标程时间 1.5-2 倍为宜。Java 和 Python 有 2s 额外时间，但仍需使用这些语言验题确保题解做法可以通过。</div>
    <?= $form->field($model, 'time_limit', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">时间</span></div>{input}<div class=\"input-group-append\"><span class=\"input-group-text\">秒</span></div></div>",
        'options' => ['class' => '']
    ])->textInput(['maxlength' => 128, 'autocomplete' => 'off'])->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 尽可能给足够大的空间，Java 和 Python 有 128MB 额外空间。</div>

    <?= $form->field($model, 'memory_limit', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">空间</span></div>{input}<div class=\"input-group-append\"><span class=\"input-group-text\">MB</span></div></div>",
        'options' => ['class' => '']
    ])->textInput(['maxlength' => 128, 'autocomplete' => 'off'])->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 题目可见性，可见即任何用户可见，隐藏即仅管理员可在后台可见。</div>

    <?php if (Yii::$app->user->identity->isAdmin()) : ?>
        <?= $form->field($model, 'status')->radioList([
            1 => Yii::t('app', 'Visible'),
            0 => Yii::t('app', 'Hidden'),
            // 2 => Yii::t('app', 'Private')
        ])->label(false) ?>
    <?php endif ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 题目描述，尽可能避免出现过多废话，避免将题目真正的要求放到输入输出（详见帮助文档）。</div>

    <?= $form->field($model, 'description')->widget('app\widgets\editormd\Editormd')->label(false); ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 输入格式，明确数据范围，尽可能做到无二义性，合理使用 LaTeX 公式，避免通过数据猜格式（详见帮助文档）。</div>

    <?= $form->field($model, 'input')->widget('app\widgets\editormd\Editormd')->label(false); ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 输出格式，尽可能做到无二义性，避免通过数据猜格式（详见帮助文档）。</div>

    <?= $form->field($model, 'output')->widget('app\widgets\editormd\Editormd')->label(false); ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 样例，请从样例 1 到样例 3 的顺序填写（详见帮助文档）。</div>

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

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 是否开启 Special Judge，开启后需要你还需要在此处提交您的答案检查器。</div>

    <?= $form->field($model, 'spj')->radioList([
        '1' => Yii::t('app', 'Yes'),
        '0' => Yii::t('app', 'No')
    ])->label(false) ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 提示与说明，可以提供样例的解释。</div>

    <?= $form->field($model, 'hint')->widget('app\widgets\editormd\Editormd')->label(false); ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 题目来源信息，填写这道题是为哪个比赛出的，或者这道题由哪位用户贡献。</div>

    <?= $form->field($model, 'source')->textarea(['maxlength' => true])->label(false) ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 题目标签，可填写本题知识点、年份和比赛信息，多个标签使用逗号隔开，标签信息将展示在前台。</div>

    <?= $form->field($model, 'tags')->textarea(['maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>