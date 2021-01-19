<?php

use yii\helpers\Html;
use yii\grid\GridView;
use justinvoelker\tagging\TaggingWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProblemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $solvedProblem array */

$this->title = Yii::t('app', 'Discuss');

$js = <<<EOT
$(".toggle-show-contest-standing input[name='showTags']").change(function () {
    $(".toggle-show-contest-standing").submit();
});
EOT;
$this->registerJs($js);
?>


<div class="row">
    <div class="col">
    <div class="alert alert-light">
        <i class="fas fa-fw fa-info-circle"></i> 仅展示最近三十则讨论消息，在问题页可以查看该问题下的所有讨论。
    </div>
        <ol class="list-group">
            <?php foreach ($discusses as $discuss) : ?>
                <?= Html::a(Html::encode($discuss['title']) . '<br /><small>' . Html::encode($discuss['nickname']) . ' 发表于 ' . Yii::$app->formatter->asRelativeTime($discuss['created_at']) . ' · 关联问题 ' . Html::encode($discuss['ptitle']) . '</small>', ['/discuss/view', 'id' => $discuss['id']], ['class' => 'list-group-item list-group-item-action']) ?>
            <?php endforeach; ?>
        </ol>
    </div>
</div>