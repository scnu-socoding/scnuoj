<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */

$this->title = Html::encode($model->title);
?>
<div class="contest-update">

    <p class="lead">更新比赛 <?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?> 信息。</p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
