<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ContestPrint */
/* @var $contest app\models\Contest */

$this->title = 'Create Print Source';
?>
<div class="print-source-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
