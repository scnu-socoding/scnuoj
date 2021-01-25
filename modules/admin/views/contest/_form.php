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

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ext_link')->textInput()->hint("填写 URL。从比赛列表访问此比赛将重定向至此链接。
    站外链接请带上 https:// 开头。填写此项将使本比赛的问题列表、答疑、榜单公告等功能失效。") ?>

    <?= $form->field($model, 'invite_code')->textInput()->hint("若同时填写站外比赛一栏，邀请码将马上在前台（比赛列表）展示，适合指引用户参加 vjudge 私有比赛等场景；
    如果站外比赛一栏留空，邀请码将被用作普通的比赛密码使用，即不在前台展示，对于非小组比赛，用户需要填写与此相同的邀请码才可注册参赛，适合线下赛等场景（赛后无需邀请码即可看题交题）。") ?>

    <?= $form->field($model, 'start_time')->widget('app\widgets\laydate\LayDate', [
        'clientOptions' => [
            'istoday' => true,
            'type' => 'datetime'
        ]
    ]) ?>

    <?= $form->field($model, 'end_time')->widget('app\widgets\laydate\LayDate', [
        'clientOptions' => [
            'istoday' => true,
            'type' => 'datetime'
        ]
    ])->hint('如需启用永久题目集，结束时间设置为 9999 年任意一天即可，直接按格式填写日期，选单是选不了这个日期的') ?>

    <?= $form->field($model, 'lock_board_time')->widget('app\widgets\laydate\LayDate', [
        'clientOptions' => [
            'istoday' => true,
            'type' => 'datetime'
        ]
    ])->hint("封榜仅对 ICPC 或作业有效，请不要在其它赛制启用，否则可能出现未知行为。如果不需要封榜请留空，当前会在比赛结束{$scoreboardFrozenTime}小时后才会自动在前台页面解除封榜限制。
        如需提前结束封榜也可选择清空该表单项。使用封榜功能，后台管理界面的比赛榜单仍然处于实时榜单。") ?>

    <?= $form->field($model, 'status')->radioList([
        Contest::STATUS_VISIBLE => Yii::t('app', 'Public'),
        Contest::STATUS_PRIVATE => Yii::t('app', 'Private'),
        Contest::STATUS_HIDDEN => Yii::t('app', 'Hidden')
    ])->hint('公开：任何用户均可参加比赛（线下赛场景除外）。私有：任何时候比赛均只能由参赛用户访问，且比赛用户需要在后台手动添加。隐藏：前台无法看到比赛') ?>


    <?= $form->field($model, 'enable_print')->radioList([
        '0' => Yii::t('app', 'No'),
        '1' => Yii::t('app', 'Yes'),
    ])->hint('开启打印功能，适合线下赛场景使用。默认为否') ?>

<?= $form->field($model, 'enable_clarify')->radioList([
        '0' => Yii::t('app', 'No'),
        '1' => Yii::t('app', 'Yes'),
    ])->hint('开启答疑功能，默认为是。注意用户发布的答疑默认隐藏，因此不能用于普通题目集讨论。') ?>

    <?= $form->field($model, 'scenario')->radioList([
        $model::SCENARIO_ONLINE => Yii::t('app', 'Online'),
        // $model::SCENARIO_OFFLINE => Yii::t('app', 'Offline'),
    ])->hint('被淘汰的选项，请选择线上赛，后续版本将移除本选项') ?>

    <?= $form->field($model, 'type')->radioList([
        // Contest::TYPE_RANK_SINGLE => Yii::t('app', 'Single Ranked'),
        Contest::TYPE_RANK_GROUP => Yii::t('app', 'ICPC'),
        Contest::TYPE_HOMEWORK => Yii::t('app', 'Homework'),
        Contest::TYPE_OI => Yii::t('app', 'OI'),
        Contest::TYPE_IOI => Yii::t('app', 'IOI'),
    ])->hint('不同类型的区别只在于榜单的排名方式。详见：' . Html::a('比赛类型', ['/wiki/contest'], ['target' => '_blank']) .
     '如需使用 OI 或 IOI 比赛，请在后台设置页面启用 OI 模式，判题机启动时带上 -o 参数，否则遇到第一个非 AC 测试点就会结束评测。') ?>

    <?= $form->field($model, 'description')->widget('app\widgets\editormd\Editormd')->label(); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>