<?php

use yii\helpers\Html;
use yii\bootstrap4\Nav;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $profile app\models\UserProfile */
/* @var $action string */

$this->title = $model->nickname;
// $this->params['breadcrumbs'][] = Yii::t('app', 'Setting');
?>
<div>
    <div>
        <?= $this->render('_profile', [
            'model' => $model,
            'profile' => $profile
        ]) ?>
    </div>
    <p></p>
    <div>
        <?= $this->render('_account', [
            'model' => $model,
            'profile' => $profile
        ]) ?>
    </div>
    <p></p>
    <div>
        <?= $this->render('_security', [
            'model' => $model,
            'profile' => $profile
        ]) ?>
    </div>
</div>
