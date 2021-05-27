<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \app\models\Discuss */

$this->title = Html::encode($model->title);
// $this->params['breadcrumbs'][] = $this->title;
?>
<h3><?= Html::encode($this->title) ?></h3>
<div class="text-secondary">
    <i class="fas fa-fw fa-clock"></i> 发表于 <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
</div>
<hr>
<div class="animate__animated animate__fadeIn animate__faster">
    <?= Yii::$app->formatter->asMarkdown($model->content) ?>
</div>