<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $settings array */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Setting');

?>

<div class="setting-form">
    <p class="lead">修改评测系统全局设定。</p>

    <?= Html::beginForm() ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 全局公告将展示在每个页面的上方。</div>

    <div class="input-group">
        <div class="input-group-prepend"><span class="input-group-text">全局公告</span></div>
        <?= Html::textInput('notice', $settings['notice'], ['class' => 'form-control']) ?>
    </div>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 如需启动 OI 模式，除了在此处选择是外，还需要在启动判题服务时加上 <code>-o</code> 参数。</div>

    <?= Html::radioList('oiMode', $settings['oiMode'], [
        1 => '启用 OI 模式',
        0 => '关闭 OI 模式'
    ]) ?>

    <p></p>

    <?= Html::radioList('isContestMode', $settings['isContestMode'], [
        1 => '启用比赛模式',
        0 => '关闭比赛模式'
    ]) ?>

    <p></p>

    <div class="input-group">
        <div class="input-group-prepend"><span class="input-group-text">单场比赛</span></div>
        <?= Html::textInput('examContestId', $settings['examContestId'], ['class' => 'form-control']) ?>
    </div>
    <p></p>

    <div class="card bg-light">
        <div class="card-body">
            <div class="alert alert-warning"><i class="fas fa-fw fa-info-circle"></i> 下列选项的可用性未知，SCNUOJ 尚未提供这些选项的支持，如果您在使用这些选项时遇到问题，请反馈给 SCNUOJ 开发者。</div>

            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">系统名称</span></div>
                <?= Html::textInput('ojName', $settings['ojName'], ['class' => 'form-control']) ?>
            </div>
            <p></p>

            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">学校名称</span></div>
                <?= Html::textInput('schoolName', $settings['schoolName'], ['class' => 'form-control']) ?>
            </div>
            <p></p>

            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">解榜时间</span></div>
                <?= Html::textInput('scoreboardFrozenTime', $settings['scoreboardFrozenTime'], ['class' => 'form-control']) ?>
            </div>
            <p></p>

            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">提交间隔时间</span></div>
                <?= Html::textInput('submitTime', $settings['submitTime'], ['class' => 'form-control']) ?>
            </div>
            <p></p>

            <?= Html::radioList('isShareCode', $settings['isShareCode'], [
                1 => '用户可以查看其他用户的代码',
                0 => '用户的代码只能由自己或者管理员查看'
            ]) ?>

            <?= Html::radioList('isUserReg', $settings['isUserReg'], [
                1 => '开放用户注册',
                0 => '关闭用户注册'
            ]) ?>

            <?= Html::radioList('isChangeNickName', $settings['isChangeNickName'], [
                2 => '允许用户修改一次昵称',
                1 => '允许用户修改昵称',
                0 => '不允许用户修改昵称'
            ]) ?>

            <?= Html::radioList('isDiscuss', $settings['isDiscuss'], [
                1 => '开启讨论',
                0 => '关闭讨论'
            ]) ?>

            <?= Html::radioList('isDefGroup', $settings['isDefGroup'], [
                1 => '开放小组创建',
                2 => '仅管理员可以创建小组',
                3 => '仅管理员和助教可以创建小组',
                0 => '关闭小组创建'
            ]) ?>

            <?= Html::radioList('isGroupJoin', $settings['isGroupJoin'], [
                1 => '允许组长直接组员',
                0 => '禁止组长直接组员'
            ]) ?>

            <?= Html::radioList('isGroupReset', $settings['isGroupReset'], [
                1 => '仅组长可重置密码与昵称',
                2 => '组长与管理员可重置密码与昵称',
                0 => '关闭密码与昵称重置功能'
            ]) ?>

            <?= Html::radioList('mustVerifyEmail', $settings['mustVerifyEmail'], [
                1 => '用户必须验证邮箱',
                0 => '用户无需验证邮箱'
            ]) ?>
        </div>
    </div>
    <p></p>
    <p class="lead">配置发信服务</p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 在用户忘记密码时，需要通过此处配置的邮箱来发送重置密码的邮箱给用户。</div>

    <div class="input-group">
        <div class="input-group-prepend"><span class="input-group-text">邮箱验证码有效时间</span></div>
        <?= Html::textInput('passwordResetTokenExpire', $settings['passwordResetTokenExpire'], ['class' => 'form-control']) ?>
        <div class="input-group-append"><span class="input-group-text">秒</span></div>
    </div>
    <p></p>

    <div class="input-group">
        <div class="input-group-prepend"><span class="input-group-text">SMTP 服务器</span></div>
        <?= Html::textInput('emailHost', $settings['emailHost'], ['class' => 'form-control', 'placeholder' => 'smtp.exmail.qq.com']) ?>
    </div>
    <p></p>

    <div class="input-group">
        <div class="input-group-prepend"><span class="input-group-text">账号</span></div>
        <?= Html::textInput('emailUsername', $settings['emailUsername'], ['class' => 'form-control', 'placeholder' => 'no-reply@jnoj.org']) ?>
    </div>
    <p></p>


    <div class="input-group">
        <div class="input-group-prepend"><span class="input-group-text">密码</span></div>
        <?= Html::textInput('emailPassword', $settings['emailPassword'], ['class' => 'form-control', 'placeholder' => 'you_password']) ?>
    </div>
    <p></p>

    <div class="input-group">
        <div class="input-group-prepend"><span class="input-group-text">端口</span></div>
        <?= Html::textInput('emailPort', $settings['emailPort'], ['class' => 'form-control', 'placeholder' => '465']) ?>
    </div>
    <p></p>

    <div class="input-group">
        <div class="input-group-prepend"><span class="input-group-text">加密</span></div>
        <?= Html::textInput('emailEncryption', $settings['emailEncryption'], ['class' => 'form-control', 'placeholder' => 'ssl']) ?>
    </div>
    <p></p>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
    </div>
    <?= Html::endForm(); ?>
</div>