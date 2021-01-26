<?php

use yii\helpers\Html;
use app\models\Solution;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Problem */
/* @var $spjContent string */

$this->title = $model->title;
// // $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
// // // $this->params['breadcrumbs'][]][] = $this->title;
$this->params['model'] = $model;

?>
<div class="solutions-view">
    <div class="alert alert-light">
        <i class="fas fa-fw fa-info-circle"></i> 如果题目需要配置子任务的，可以在下面填写子任务的配置，具体可参考 <?= Html::a('帮助文档', ['/wiki/oi']) ?>。
    </div>

    <?= Html::beginForm() ?>

    <div class="form-group">
        <?= Html::label(Yii::t('app', 'Subtask'), 'subtaskContent', ['class' => 'sr-only']) ?>

        <?= \app\widgets\codemirror\CodeMirror::widget(['name' => 'subtaskContent', 'value' => $subtaskContent]);  ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success btn-block']) ?>
    </div>
    <?= Html::endForm(); ?>
</div>