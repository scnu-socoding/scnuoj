<?php

use yii\helpers\Html;
use app\models\GroupUser;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $groupUser app\models\GroupUser */
?>

<p class="lead">用户 <?= Html::a(Html::encode($groupUser->user->nickname), ['/user/view', 'id' => $groupUser->user->id]) ?></p>
<div class="list-group">
    <div class="list-group-item">当前角色<span class="text-secondary float-right"><?= $groupUser->getRole() ?></span></div>
</div>
<?php if ($groupUser->role == GroupUser::ROLE_APPLICATION) : ?>
    <hr>
    <?= Html::a('同意加入', ['/group/user-update', 'id' => $groupUser->id, 'role' => 1], ['class' => 'btn btn-outline-success']); ?>
    <?= Html::a('拒绝加入', ['/group/user-update', 'id' => $groupUser->id, 'role' => 2], ['class' => 'btn btn-outline-danger']); ?>
<?php elseif ($groupUser->role == GroupUser::ROLE_REUSE_INVITATION) : ?>
    <hr>
    <?= Html::a('重新邀请', ['/group/user-update', 'id' => $groupUser->id, 'role' => 3], ['class' => 'btn btn-default']); ?>
<?php elseif ($groupUser->role == GroupUser::ROLE_MEMBER && ($model->getRole() == GroupUser::ROLE_LEADER || Yii::$app->user->identity->isAdmin())) : ?>
    <hr>
    <?= Html::a('设为管理员', ['/group/user-update', 'id' => $groupUser->id, 'role' => 4], ['class' => 'btn btn-outline-primary']); ?>
<?php elseif ($groupUser->role == GroupUser::ROLE_MANAGER && ($model->getRole() == GroupUser::ROLE_LEADER || Yii::$app->user->identity->isAdmin())) : ?>
    <hr>
    <?= Html::a('设为普通成员', ['/group/user-update', 'id' => $groupUser->id, 'role' => 5], ['class' => 'btn btn-outline-primary']); ?>
<?php endif; ?>

<?php if (($groupUser->role == GroupUser::ROLE_MEMBER && $model->getRole() == GroupUser::ROLE_LEADER && Yii::$app->setting->get('isGroupReset') != 0)
    || ($groupUser->role == GroupUser::ROLE_MEMBER && $model->getRole() == GroupUser::ROLE_MANAGER && Yii::$app->setting->get('isGroupReset') == 2)
) : ?>
    <?= Html::a('重置密码', ['/group/user-update', 'id' => $groupUser->id, 'role' => 6], ['class' => 'btn btn-default']); ?>
    <?= Html::a('重置昵称', ['/group/user-update', 'id' => $groupUser->id, 'role' => 7], ['class' => 'btn btn-default']); ?>
<?php endif; ?>