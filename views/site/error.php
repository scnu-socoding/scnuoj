<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>


<div class="alert alert-danger">
    <i class="fas fa-fw fa-info-circle"></i> <?= nl2br(Html::encode($message)) ?>
</div>

<div class="card animate__animated animate__fadeIn animate__faster">
    <img src="<?= Yii::getAlias('@web') . '/images/error-header.png' ?>" class="card-img-top d-none d-md-block">
    <div class="card-body">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        页面没有如您所期望地加载，在大多数情况下可能是因为访问权限受限或者页面不存在。<br>
        如果您认为这是站点本身的问题，欢迎您联系 <a target="_blank" href="https://github.com/scnu-socoding/scnuoj">SCNU Online Judge 开发组</a>。
        <p></p>
        <a class="btn-block btn btn-primary" href="<?=Yii::$app->homeUrl?>"> <i class="fas fa-fw fa-home"></i> 返回首页</a>
    </div>
</div>