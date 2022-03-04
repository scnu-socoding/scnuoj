<?php

/* @var $this yii\web\View */
/* @var $model app\models\Discuss */

$this->title = Yii::t('app', 'Release news');

$model->status = $model::STATUS_PUBLIC;
?>
<div class="discuss-create">

<p class="lead">创建并发布一则新闻。</p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
