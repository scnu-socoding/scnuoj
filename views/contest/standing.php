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
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contest'), 'url' => ['/contest/index']];
$this->params['breadcrumbs'][] = $this->title;

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
                    'showStandingBeforeEnd' => $showStandingBeforeEnd,
                    'rankResult' => $rankResult
                ]);
            } else if ($model->type == $model::TYPE_OI || $model->type == $model::TYPE_IOI) {
                echo $this->render('_standing_oi', [
                    'model' => $model,
                    'showStandingBeforeEnd' => $showStandingBeforeEnd,
                    'rankResult' => $rankResult
                ]);
            } else {
                echo $this->render('_standing_group', [
                    'model' => $model,
                    'showStandingBeforeEnd' => $showStandingBeforeEnd,
                    'rankResult' => $rankResult
                ]);
            }
        ?>
    </div>
    <!-- <?php if ($model->type == Contest::TYPE_IOI): ?>
    <p class="float-left">注：表格第一个数字为所通过样例的得分。第二个数字为最好一次解答时距离比赛开始提交的时间。若无第二个数字，则表明是比赛结束后的提交。</p>
    <?php elseif ($model->type == Contest::TYPE_OI): ?>
    <p>注：表格第一个数字为最后一次提交时所通过样例的得分。第二个数字为所有提交中通过样例最大的得分。</p>
    <?php else: ?>
    <p>注：表格第一个数字为距离比赛开始第一次通过时提交的时间（单位：分钟），若为 0，则表示比赛结束后的提交。</p>
    <?php endif; ?> -->
</div>
