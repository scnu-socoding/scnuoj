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

<?= Nav::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'Rank by Rating'),
            'url' => ['rating/index'],
        ],
        [
            'label' => Yii::t('app', 'Rank by Solved Problems'),
            'url' => ['rating/problem'],
        ]
    ],
    'options' => ['class' => 'nav-pills']
]) ?>
<p></p>

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
                            <?php $num = $k + $currentPage * $defaultPageSize + 1; ?>
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