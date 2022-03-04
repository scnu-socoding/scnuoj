<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
use app\models\Contest;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */

$this->title = $model->title;
?>
<div class="contest-view">

    <p class="lead">比赛 <?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?> 题解编辑。</p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 题解内容在比赛结束后，才会出现在前台的比赛页面中供用户查看。</div>
    

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'editorial')->widget('app\widgets\editormd\Editormd')->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>