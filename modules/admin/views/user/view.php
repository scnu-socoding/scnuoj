<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->id;
?>
<div class="user-view">

    <p class="lead">查看用户 <?= Html::encode($model->nickname) ?> 账户信息。</p>

    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary btn-block']) ?>
    <p></p>

    <div class="table-responsive">
        <?= DetailView::widget([
            'model' => $model,
            'options' => ['id' => 'grid', 'class' => 'table table-bordered'],
            'template' => '<tr><th class="bg-tablehead" style="width:120px;">{label}</th><td style="min-width:300px;">{value}</td></tr>',
            'attributes' => [
                'id',
                'username',
                'nickname',
                'email',
                [
                    'attribute' => 'role',
                    'value' => function ($model, $widget) {
                        if ($model->role == \app\models\User::ROLE_PLAYER) {
                            return '参赛用户';
                        } else if ($model->role == \app\models\User::ROLE_USER) {
                            return '普通用户';
                        } else if ($model->role == \app\models\User::ROLE_VIP) {
                            return '助教';
                        } else if ($model->role == \app\models\User::ROLE_ADMIN) {
                            return '管理员';
                        }
                        return '(未设置)';
                    },
                    'format' => 'raw',
                ],
                'rating',
                'created_at',
                'updated_at',
            ],
        ]) ?>

    </div>
</div>