<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Contest;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $form yii\widgets\ActiveForm */

$scoreboardFrozenTime = Yii::$app->setting->get('scoreboardFrozenTime') / 3600;
?>

<div class="contest-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 非必要情况下，请不要更改本栏内容，维持当前状态即可。</div>
    <?= $form->field($model, 'id', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">编号</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput()->label(false) ?>
    <p></p>
    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 比赛名称应该包含年份、序号、是否重现赛等信息。</div>
    <?= $form->field($model, 'title', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">标题</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput(['maxlength' => true])->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 按需填写。以 <code>https://</code> 开头。从比赛列表访问此比赛将重定向至此链接。填写此项将使本比赛的问题列表、答疑、榜单公告等功能失效。</div>
    <?= $form->field($model, 'ext_link', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">站外比赛链接</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput()->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 按需填写。若同时填写站外比赛一栏，邀请码将马上在前台（比赛列表）展示，适合指引用户参加 vjudge 私有比赛等场景；
        如果站外比赛一栏留空，邀请码将被用作普通的比赛密码使用，即不在前台展示，对于非小组比赛，用户需要填写与此相同的邀请码才可注册参赛，适合线下赛等场景（赛后无需邀请码即可看题交题）。</div>
    <?= $form->field($model, 'invite_code', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">邀请码</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput()->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 如需启用永久题目集，结束时间设置为 9999 年任意一天即可，直接按格式填写日期，选单是选不了这个日期的。</div>

    <?= $form->field($model, 'start_time', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">开始时间</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->widget('app\widgets\laydate\LayDate', [
        'clientOptions' => [
            'istoday' => true,
            'type' => 'datetime'
        ]
    ])->label(false) ?>
    <p></p>

    <?= $form->field($model, 'end_time', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">结束时间</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->widget('app\widgets\laydate\LayDate', [
        'clientOptions' => [
            'istoday' => true,
            'type' => 'datetime'
        ]
    ])->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 封榜仅对 ICPC 或作业有效，请不要在其它赛制启用，否则可能出现未知行为。如果不需要封榜请留空，当前会在比赛结束 <?= $scoreboardFrozenTime ?> 小时后才会自动在前台页面解除封榜限制。如需提前结束封榜也可选择清空该表单项。使用封榜功能，后台管理界面的比赛榜单仍然处于实时榜单。</div>

    <?= $form->field($model, 'lock_board_time', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">封榜时间</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->widget('app\widgets\laydate\LayDate', [
        'clientOptions' => [
            'istoday' => true,
            'type' => 'datetime'
        ]
    ])->label(false) ?>
    <p></p>


    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 设置比赛可见性。公开：任何用户均可参加比赛，若启用邀请码则正确填写邀请码的用户均可参赛。私有：任何时候比赛均只能由参赛用户访问，且比赛用户需要在后台手动添加。隐藏：前台无法看到比赛。</div>

    <?= $form->field($model, 'status')->radioList([
        Contest::STATUS_VISIBLE => Yii::t('app', 'Public'),
        Contest::STATUS_PRIVATE => Yii::t('app', 'Private'),
        Contest::STATUS_HIDDEN => Yii::t('app', 'Hidden')
    ])->label(false) ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 是否开启打印功能，适合线下赛场景使用。</div>

    <?= $form->field($model, 'enable_print')->radioList([
        '1' => '开启打印',
        '0' => '关闭打印',
    ])->label(false) ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 是否开启答疑功能，默认为是。注意用户发布的答疑默认隐藏，因此不能用于普通题目集讨论。</div>

    <?= $form->field($model, 'enable_clarify')->radioList([
        '1' => '开启答疑',
        '0' => '关闭答疑',
    ])->label(false) ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 不同类型的区别只在于榜单的排名方式。详见 <?= Html::a('比赛类型', ['/wiki/contest'], ['target' => '_blank']) ?>。如需使用 OI 或 IOI 比赛，请在后台设置页面启用 OI 模式，判题机启动时带上 <code>-o</code> 参数。</div>

    <?= $form->field($model, 'type')->radioList([
        Contest::TYPE_RANK_GROUP => Yii::t('app', 'ICPC'),
        Contest::TYPE_HOMEWORK => Yii::t('app', 'Homework'),
        Contest::TYPE_OI => Yii::t('app', 'OI'),
        Contest::TYPE_IOI => Yii::t('app', 'IOI'),
    ])->label(false) ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 比赛描述，此部分内容在比赛开始前就会公开展示。</div>

    <?= $form->field($model, 'description')->widget('app\widgets\editormd\Editormd')->label(false); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>