<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Discuss */

$this->title = Yii::t('app', 'Update Discuss: ' . $model->title, [
    'nameAttribute' => '' . $model->title,
]);
?>
<div class="discuss-update">

<p class="lead"> 更新新闻《<?= Html::encode($model->title) ?>》内容与可见性。</p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
