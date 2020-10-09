<?php

use yii\helpers\Html;
use app\models\User;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\Problem */

$this->title = Yii::t('app', $model->title);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$this->params['model'] = $model;

if((Yii::$app->user->identity->isVip()) && isset($model->user) && (!$model->user->isVip())){
    throw new ForbiddenHttpException('You are not allowed to perform this action.');
}

?>

<div class="problem-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
