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

        <ol class="list-group">
            <?php foreach ($discusses as $discuss) : ?>
                <?= Html::a(Html::encode($discuss['title']) . '<br /><small>' . Html::encode($discuss['nickname']) . ' ' . Yii::$app->formatter->asRelativeTime($discuss['created_at']) . ' ' . Html::encode($discuss['ptitle']) . '</small>', ['/discuss/view', 'id' => $discuss['id']], ['class' => 'list-group-item list-group-item-action']) ?>
            <?php endforeach; ?>
        </ol>
    </div>
</div>