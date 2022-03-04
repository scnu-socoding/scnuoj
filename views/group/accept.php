<?php

use yii\grid\GridView;
use yii\helpers\Html;
use app\models\Group;
use app\models\GroupUser;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $userDataProvider yii\data\ActiveDataProvider */
$this->title = Html::encode($model->name);

?>
<h3><?= Html::encode($model->name) ?></h3>
<p><?= Html::encode($model->description) ?></p>
<?php if (!Yii::$app->user->isGuest && $model->getRole() == GroupUser::ROLE_INVITING): ?>
<div class="alert alert-light"><i class="fas fa-fw fa-question-circle"></i> 是否接受邀请加入此小组？</div>
<div class="btn-block btn-group">
    <?= Html::a('同意', ['/group/accept', 'id' => $model->id, 'accept' => 1], ['class' => 'btn btn-success']) ?>
    <?= Html::a('拒绝', ['/group/accept', 'id' => $model->id, 'accept' => 0], ['class' => 'btn btn-danger']) ?>
</div>
<?php elseif (!Yii::$app->user->isGuest && $model->join_policy == Group::JOIN_POLICY_APPLICATION): ?>
<?= Html::a('申请加入', ['/group/accept', 'id' => $model->id, 'accept' => 3], ['class' => 'btn btn-success btn-block']) ?>
<?php elseif (!Yii::$app->user->isGuest && $model->join_policy == Group::JOIN_POLICY_FREE): ?>
<?= Html::a('加入小组', ['/group/accept', 'id' => $model->id, 'accept' => 2], ['class' => 'btn btn-success btn-block']) ?>
<?php endif; ?>

<p></p>

<h5>小组成员列表</h5>
<?= GridView::widget([
    'layout' => '{items}{pager}',
    'dataProvider' => $userDataProvider,
    'tableOptions' => ['class' => 'table'],
    'options' => ['class' => 'table-responsive'],
    'columns' => [
        [
            'attribute' => 'role',
            'value' => function ($model, $key, $index, $column) {
                return $model->getRole(true);
            },
            'format' => 'raw',
            'options' => ['style' => 'width:100px;min-width:100px'],
            'enableSorting' => false
        ],
        [
            'attribute' => Yii::t('app', 'Nickname'),
            'value' => function ($model, $key, $index, $column) {
                return Html::a(Html::encode($model->user->nickname ?? '临时用户'), ['/user/view', 'id' => $model->user->id], ['class' => 'text-dark']);
            },
            'format' => 'raw',
            'options' => ['style' => 'min-width:200px'],
        ],
        [
            'attribute' => 'created_at',
            'value' => function ($model, $key, $index, $column) {
                return Yii::$app->formatter->asRelativeTime($model->created_at);
            },
            'options' => ['style' => 'min-width:100px;width:100px'],
            'enableSorting' => false
        ]
    ],
    'pager' => [
        'linkOptions' => ['class' => 'page-link'],
        'maxButtonCount' => 5,
    ]
]); ?>