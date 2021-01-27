<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */

$this->title = Html::encode($model->title);
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contests'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="contest-update">

    <p class="lead">更新比赛 <?= Html::encode($this->title) ?> 信息。</p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
