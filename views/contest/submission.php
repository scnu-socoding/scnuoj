<?php

use yii\helpers\Html;
use app\models\Solution;

/* @var $this yii\web\View */
/* @var $submissions array */
?>
<p class="lead" style="text-align: left;">查看提交历史</p>
<?php if (empty($submissions)) : ?>
    <div class="list-group">
        <div class="list-group-item" style="text-align: left;">
            没有找到数据。
        </div>
    </div>
<?php else : ?>
    <div class="list-group">
        <?php foreach ($submissions as $submission) : ?>

            <?php
            if ($submission['result'] == Solution::OJ_AC)
                $label_color = "text-success";
            else if ($submission['result'] == Solution::OJ_WA)
                $label_color = "text-danger";
            else
                $label_color = "text-warning";
            ?>

            <?= Html::a(
                '<span class="' . $label_color . '">' . Solution::getResultList($submission['result']) . '</span>' .
                    '<span class="float-right text-secondary">' . $submission['created_at'] . '</span>',
                [
                    '/solution/detail', 'id' => $submission['id']
                ],
                [
                    'class' => 'list-group-item list-group-item-action',
                    'style' => 'text-align: left;',
                    'target' => '_blank'
                ]
            ) ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>