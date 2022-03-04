<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\polygon\models\Problem */

$this->title = $model->title;
$this->params['model'] = $model;

$model->setSamples();
?>
<div class="alert alert-light">
    <i class="fas fa-fw fa-info-circle"></i> 如果题目需要配置子任务的，可以在下面填写子任务的配置，配置仅在主题库生效。
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