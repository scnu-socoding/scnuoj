<?php

/* @var $this yii\web\View */
/* @var $settings array */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app', 'Update');
?>
<p class="lead">感谢使用 SCNUOJ <?= date("Y.m.d", filemtime(Yii::getAlias('@app/CHANGELOG.md'))) ?>。</p>

<a class="btn btn-outline-primary btn-block" href="https://github.com/SCNU-SoCoding/scnuoj/blob/master/docs/upgrade.md">了解如何更新</a>

<p></p>


<div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 更新日志从 <a href="https://gitee.com/bobby285271/scnuoj/raw/master/CHANGELOG.md">gitee.com</a> 抓取，感谢 Gitee 的代码仓库托管服务。</div>

<div class="card">
    <div class="card-body">
        <?= Yii::$app->formatter->asMarkdown($changelog, true) ?>
    </div>
</div>