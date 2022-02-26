<?php

/* @var $this yii\web\View */
/* @var $model app\models\Problem */

$this->title = Yii::t('app', $model->title);
$this->params['model'] = $model;

?>

<div class="problem-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
