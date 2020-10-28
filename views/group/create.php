<?php

use yii\helpers\Html;

use app\models\User;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

if (Yii::$app->user->identity->role !== User::ROLE_ADMIN && Yii::$app->user->identity->role !== User::ROLE_VIP) {
    throw new ForbiddenHttpException('You are not allowed to perform this action.');
}

$this->title = Yii::t('app', 'Create Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
