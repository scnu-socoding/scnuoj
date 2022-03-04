<?php

use app\models\Contest;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $form yii\widgets\ActiveForm */
/* @var $showStandingBeforeEnd bool */
/* @var $rankResult array */

$this->title = $model->title;
$this->params['model'] = $model;

$js =<<<EOT
$(".toggle-show-contest-standing input[name='showStandingBeforeEnd']").change(function () {
    $(".toggle-show-contest-standing").submit();
});
EOT;
$this->registerJs($js);
?>
<div class="text-center center-block">
    <?php if ($model->type != Contest::TYPE_OI || $model->isContestEnd()): ?>
    <div class="legend-strip">
        <?php if ($model->isContestEnd()): ?>
        <?= Html::beginForm(
                ['/contest/standing', 'id' => $model->id],
                'get',
                ['class' => 'toggle-show-contest-standing pull-left', 'style' => 'margin-top: 6px;']
            ); ?>
        <div class="checkbox float-right">
            <label>
                <?php if ($showStandingBeforeEnd): ?>
                <?= Html::hiddenInput('showStandingBeforeEnd', 0) ?>
                <?php endif; ?>
                <?= Html::checkbox('showStandingBeforeEnd', $showStandingBeforeEnd) ?>
                显示比赛期间榜单
            </label>
        </div>
        <?= Html::endForm(); ?>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="clearfix"></div>
    <div class="table-responsive">
        <?php
            if ($model->type == $model::TYPE_RANK_SINGLE) {
                echo $this->render('_standing_single', [
                    'model' => $model,
                    'pages' => $pages,
                    'showStandingBeforeEnd' => $showStandingBeforeEnd,
                    'rankResult' => $rankResult
                ]);
            } else if ($model->type == $model::TYPE_OI || $model->type == $model::TYPE_IOI) {
                echo $this->render('_standing_oi', [
                    'model' => $model,
                    'pages' => $pages,
                    'showStandingBeforeEnd' => $showStandingBeforeEnd,
                    'rankResult' => $rankResult
                ]);
            } else {
                echo $this->render('_standing_group', [
                    'model' => $model,
                    'pages' => $pages,
                    'showStandingBeforeEnd' => $showStandingBeforeEnd,
                    'rankResult' => $rankResult
                ]);
            }
        ?>
    </div>
</div>