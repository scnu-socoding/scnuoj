<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Problem */
/* @var $spjContent string */

$this->title = $model->title;
$this->params['model'] = $model;

?>
<div class="solutions-view">

    <div class="alert alert-light">
        <i class="fas fa-fw fa-info-circle"></i> 请在下面填写特判程序，具体可上网搜索 Testlib 并阅读 <?= Html::a('帮助文档', ['/wiki/spj']) ?>。
    </div>

    <div class="alert alert-light">
        <i class="fas fa-fw fa-info-circle"></i> 目前仅支持使用 C/C++ 编写特判程序。
    </div>

    <?= Html::beginForm() ?>

    <div class="form-group">
        <?= \app\widgets\codemirror\CodeMirror::widget(['name' => 'spjContent', 'value' => $spjContent]);  ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success btn-block']) ?>
    </div>
    <?= Html::endForm(); ?>
</div>