<?php

/* @var $this yii\web\View */
/* @var $settings array */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app', 'Update');
?>
<p class="lead">感谢使用 SCNUOJ <?= file_get_contents(Yii::getAlias('@app/VERSION')) ?>。</p>

<a class="btn btn-outline-primary btn-block" href="https://github.com/SCNU-SoCoding/scnuoj/blob/master/docs/upgrade.md">了解如何更新</a>

<p></p>


<div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 更新日志从本地获取。</div>

<div class="card">
    <div class="card-body">
        <?= Yii::$app->formatter->asMarkdown($changelog, true) ?>
    </div>
</div>