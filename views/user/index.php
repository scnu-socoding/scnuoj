<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table'],
        'rowOptions' => ['class' => ' animate__animated animate__fadeIn animate__faster'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
