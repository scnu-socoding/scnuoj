<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $form yii\widgets\ActiveForm */
/* @var $data array */

$this->title = Html::encode($model->title);
$this->params['model'] = $model;
?>
<div class="animate__animated animate__fadeIn animate__faster">
    <?php
        if ($model->editorial != NULL) {
            echo Yii::$app->formatter->asMarkdown($model->editorial);
        } else {
            echo '<div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 出题人去火星旅游了，这里什么也没有。</div>';
        }
        ?>
</div>