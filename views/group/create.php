<?php

use app\models\User;
use yii\helpers\Html;

use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = Yii::t('app', 'Create Group');

?>
<div class="group-create">
    <p class="lead">创建一个新的小组。</p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>