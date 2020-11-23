<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $settings array */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app', 'Setting');

?>

<div class="setting-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <hr>
    <?= Html::beginForm() ?>

    <div class="form-group">
        <?= Html::label(Yii::t('app', 'OJ名称'), 'ojName') ?>
        <?= Html::textInput('ojName', $settings['ojName'], ['class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', 'OI 模式'), 'oiMode') ?>
        <?= Html::radioList('oiMode', $settings['oiMode'], [
            1 => '是',
            0 => '否'
        ]) ?>
        <p class="hint-block">
            注意，如需启动 OI 模式，除了在此处选择是外，还需要在启动判题服务时加上 -o 参数。
        </p>
        <p class="hint-block">即需要在 jnoj/judge 目录下通过 <code>sudo ./dispatcher -o</code>来启动判题服务。</p>
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', '学校名称'), 'ojName') ?>
        <?= Html::textInput('schoolName', $settings['schoolName'], ['class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', '提交间隔时间'), 'submitTime') ?>
        <?= Html::textInput('submitTime', $settings['submitTime'], ['class' => 'form-control']) ?>
        <p class="hint-block">
            时间单位为秒，设为 0 时不限制提交，否则提交后必须间隔指定时间后才能再次提交，可避免用户短时间重复提交的情况。
        </p>
    </div>    

    <div class="form-group">
        <?= Html::label(Yii::t('app', '是否要共享代码'), 'isShareCode') ?>
        <?= Html::radioList('isShareCode', $settings['isShareCode'], [
            1 => '用户可以查看其他用户的代码',
            0 => '用户的代码只能由自己或者管理员查看'
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', '用户注册'), 'isUserReg') ?>
        <?= Html::radioList('isUserReg', $settings['isUserReg'], [
            1 => '开放',
            0 => '关闭'
        ]) ?>
    </div> 

    <div class="form-group">
        <?= Html::label(Yii::t('app', '用户昵称'), 'isChangeNickName') ?>
        <?= Html::radioList('isChangeNickName', $settings['isChangeNickName'], [
            2 => '只允许修改一次',
            1 => '允许修改',
            0 => '不允许修改'
        ]) ?>
    </div>    

    <div class="form-group">
        <?= Html::label(Yii::t('app', '开启讨论'), 'isDiscuss') ?>
        <?= Html::radioList('isDiscuss', $settings['isDiscuss'], [
            1 => '开启',
            0 => '关闭'
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', '创建小组'), 'isDefGroup') ?>
        <?= Html::radioList('isDefGroup', $settings['isDefGroup'], [
            1 => '开启',
            2 => '仅管理员',
            3 => '管理员与VIP用户',	            
            0 => '关闭'	            
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', '组长直接加成员'), 'isGroupJoin') ?>
        <?= Html::radioList('isGroupJoin', $settings['isGroupJoin'], [
            1 => '开启',
            0 => '关闭'
        ]) ?>
        <p class="hint-block">
                开启该功能后,组长可以直接将用户拉入到小组中,不需要用户确认。
        </p>         
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', '小组管理权限'), 'isGroupReset') ?>
        <?= Html::radioList('isGroupReset', $settings['isGroupReset'], [
            1 => '仅组长可重置密码与昵称',
            2 => '组长与管理员可重置密码与昵称',	            
            0 => '关闭密码与昵称重置功能'	            
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::label(Yii::t('app', '封榜时间'), 'scoreboardFrozenTime') ?>
        <?= Html::textInput('scoreboardFrozenTime', $settings['scoreboardFrozenTime'], ['class' => 'form-control']) ?>
        <p class="hint-block">单位：秒。这个时间是从比赛结束后开始计算，如值为
            <?= $settings['scoreboardFrozenTime'] ?> 时，表示比赛结束 <?= intval($settings['scoreboardFrozenTime'] / 3600) ?> 个小时后不再封榜。
        </p>
    </div>

    <hr>
    <div class="form-horizontal">
        <h4>配置 SMTP 发送邮箱</h4>
        <p class="hint-block">
            在用户忘记密码时，需要通过此处配置的邮箱来发送"重置密码"的邮箱给用户。
            若使用默认的 "no-reply@jnoj.org"，不能保证此默认邮箱长期可用，建议自行配置自己的邮箱。
        </p>

        <div class="form-group">
            <?= Html::label('邮箱验证码有效时间', 'passwordResetTokenExpire', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('passwordResetTokenExpire', $settings['passwordResetTokenExpire'], ['class' => 'form-control']) ?>
                <p class="hint-block">单位：秒。即 <?= intval($settings['passwordResetTokenExpire'] / 3600) ?> 小时后，用户邮箱确认链接失效。</p>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('是否要验证邮箱？', 'mustVerifyEmail', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::radioList('mustVerifyEmail', $settings['mustVerifyEmail'], [
                    1 => '新注册用户必须验证邮箱，且更改邮箱后必须验证邮箱',
                    0 => '否'
                ]) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Host', 'emailHost', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('emailHost', $settings['emailHost'], ['class' => 'form-control', 'placeholder' => 'smtp.exmail.qq.com']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Username', 'emailUsername', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('emailUsername', $settings['emailUsername'], ['class' => 'form-control', 'placeholder' => 'no-reply@jnoj.org']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Password', 'emailPassword', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('emailPassword', $settings['emailPassword'], ['class' => 'form-control', 'placeholder' => 'you_password']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Port', 'emailPort', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('emailPort', $settings['emailPort'], ['class' => 'form-control', 'placeholder' => '465']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::label('Encryption', 'emailEncryption', ['class' => 'col-sm-2 control-label']) ?>
            <div class="col-sm-10">
                <?= Html::textInput('emailEncryption', $settings['emailEncryption'], ['class' => 'form-control', 'placeholder' => 'ssl']) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm(); ?>

</div>
