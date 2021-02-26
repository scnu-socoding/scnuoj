<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap4\Nav;
use yii\helpers\Html;

$problem = $this->params['model'];
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<div class="polygon-header">
<p class="lead">设置题目《<?= Html::encode($problem->title) ?>》题面与数据信息。</p>
    <?= Nav::widget([
        'options' => ['class' => 'nav nav-pills'],
        'items' => [
            ['label' => Yii::t('app', 'Preview'), 'url' => ['/polygon/problem/view', 'id' => $problem->id]],
            ['label' => Yii::t('app', 'Edit'), 'url' => ['/polygon/problem/update', 'id' => $problem->id]],
            ['label' => Yii::t('app', 'Solution'), 'url' => ['/polygon/problem/solution', 'id' => $problem->id]],
            ['label' => Yii::t('app', '题解'), 'url' => ['/polygon/problem/answer', 'id' => $problem->id]],
            ['label' => Yii::t('app', 'Tests Data'), 'url' => ['/polygon/problem/tests', 'id' => $problem->id]],
            ['label' => Yii::t('app', 'Verify Data'), 'url' => ['/polygon/problem/verify', 'id' => $problem->id], 'visible' => !$problem->spj],
            ['label' => Yii::t('app', 'SPJ'), 'url' => ['/polygon/problem/spj', 'id' => $problem->id], 'visible' => isset($problem->spj) && $problem->spj],
            ['label' => Yii::t('app', 'Subtask'), 'url' => ['/polygon/problem/subtask', 'id' => $problem->id], 'visible' => Yii::$app->setting->get('oiMode')],
        ],
    ]) ?>
</div>
<p></p>
<?= $content ?>
<?php $this->endContent(); ?>