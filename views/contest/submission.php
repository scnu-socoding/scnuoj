<?php

use yii\helpers\Html;
use app\models\Solution;

/* @var $this yii\web\View */
/* @var $submissions array */
?>
<?php foreach ($submissions as $submission): ?>
    <p>
        <span class="glyphicon glyphicon-time"></span> <?= $submission['created_at'] ?>
        <?php
        $label = Solution::getResultList($submission['result']);
        if ($submission['result'] == Solution::OJ_AC) {
            echo "<span class=\"badge badge-success\">{$label}</span>";
        } else {
            echo "<span class=\"badge badge-danger\">{$label}</span>";
        }
        ?>
        →
        <?= Html::a($submission['id'], ['/solution/detail', 'id' => $submission['id']], ['target' => '_blank']) ?>
    </p>
<?php endforeach; ?>
