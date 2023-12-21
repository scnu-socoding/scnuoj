<?php

use app\models\User;

/* @var $users \app\models\User */
/* @var $top3users \app\models\User */
/* @var $pages \yii\data\Pagination */
/* @var $currentPage integer */
/* @var $defaultPageSize integer */

use yii\bootstrap4\Nav;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Rating');
?>

<style>
    .btn-custom {
        font-size: 0.8rem; /* 调整字体大小 */
        padding: .335rem .65rem; /* 调整内边距以适应新的字体大小 */
    }
</style>
<div class="row">
    <div class="col">
        <?php if (isset($lastUpdated)): ?>
            <p style="display: inline-block; margin-right: 10px;">榜单更新时间： <?= Yii::$app->formatter->asDatetime($lastUpdated) ?></p>
        <?php endif; ?>
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()): ?>
            <?= Html::a('刷新榜单', ['rating/clear-cache'], ['class' => 'btn btn-warning btn-custom', 'style' => 'display: inline-block; vertical-align: middle;']) ?>
        <?php endif; ?>
    </div>
</div>


<div class="row">
    <div class="col">
        <div class="rating-index">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr class="bg-tablehead">
                            <td><b>#</b></td>
                            <td></td>
                            <td></td>
                            <td><b>=</b></td>
                        </tr>
                        <?php foreach ($users as $k => $user) : ?>
                            <?php $num = $k + ($currentPage-1) * $defaultPageSize + 1; ?>
                            <tr  class="animate__animated animate__fadeIn animate__faster">
                                <td><?= $num ?></td>
                                <td>
                                    <?= $user['student_number'] ?>
                                </td>
                                <td>
                                    <?= Html::a(Html::encode($user['nickname']), ['/user/view', 'id' => $user['id']], ['class' => 'text-dark']) ?>
                                </td>
                                <td>
                                    <?= $user['solved'] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?= \yii\widgets\LinkPager::widget(
                [
                    'pagination' => $pages,
                    'linkOptions' => ['class' => 'page-link'],
                    'maxButtonCount' => 5,
                ]
            ) ?>
        </div>
        <p></p>
    </div>
</div>
