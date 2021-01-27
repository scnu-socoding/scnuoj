<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', '{username} - {nickname}', [
    'username' => $model->username,
    'nickname' => $model->nickname
]);
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">

    <p class="lead">更新用户 <?= Html::encode($model->nickname) ?> 账户信息。</p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>