<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Modal;
use app\models\Contest;

/* @var $model app\models\Contest */
/* @var $rankResult array */

$problems = $model->problems;
$first_blood = $rankResult['first_blood'];
$result = $rankResult['rank_result'];
$submit_count = $rankResult['submit_count'];

if (Yii::$app->user->isGuest || !Yii::$app->user->identity->isAdmin()) {
    if ($model->isScoreboardFrozen() || ($model->type == Contest::TYPE_OI && !$model->isContestEnd())) {
        echo '<div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 待赛后再揭晓。</div><p></p>';
        return;
    }
}
?>
<table class="table table-bordered standings-table">

    <tbody style="line-height: 1;">
        <tr class="bg-tablehead" style="line-height: 2;">
            <td style="width:2.5rem"><b>#</b></td>
            <td style="width:8rem"></td>
            <td style="min-width:10rem;text-align:left"></td>
            <td style="width:3.5rem"><b>=</b></td>
            <?php foreach ($problems as $key => $p) : ?>
                <td>
                    <b>

                        <?php
                        $cur_id = (sizeof($problems) > 26)
                            ? ('P' . str_pad($key + 1, 2, '0', STR_PAD_LEFT))
                            : chr(65 + $key);
                        ?>

                        <?= Html::a($cur_id, ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'text-dark']) ?>
                    </b>
                </td>
            <?php endforeach; ?>
        </tr>

        <?php for ($i = 0; $i < count($result); $i++) : ?>

            <?php $rank = $result[$i]; ?>
            <?php if (
                (!$model->enable_board)
                && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin()))
            ) {
                if (Yii::$app->user->id != $rank['user_id']) {
                    continue;
                } else {
                    $rank['finalrank'] = "?";
                }
            }
            ?>
            <?php if ((!Yii::$app->user->isGuest) && Yii::$app->user->id == $rank['user_id']) {
                $front_color = "bg-isyou";
            } else {
                $front_color = "";
            }
            ?>
            <tr class="animate__animated animate__fadeIn animate__faster <?= $front_color ?>">
                <td><?= $rank['finalrank'] ?></td>
                <td><?= Html::encode($rank['student_number']); ?></td>
                <td style="text-align:left;">
                    <?= Html::a(Html::encode($rank['nickname']), ['/user/view', 'id' => $rank['user_id']], ['class' => 'text-dark']) ?>
                </td>
                <td>
                    <span>
                        <b>
                            <?php if ($model->type == Contest::TYPE_OI && $showStandingBeforeEnd == 1) : ?>
                                <?= $rank['total_score'] ?>
                            <?php else : ?>
                                <?= $rank['correction_score'] ?>
                            <?php endif ?>
                        </b>
                    </span>
                </td>

                <?php
                foreach ($problems as $key => $p) {
                    $score = '';
                    $max_score = '';
                    $css_class = ''; // CSS 颜色
                    $first = ''; // 题目对应的排名表格的内容
                    if (isset($rank['solved_flag'][$p['problem_id']])) {
                        $css_class = 'text-success'; // 全部正确
                    } else if ($model->type == Contest::TYPE_IOI && isset($rank['max_score'][$p['problem_id']])) {
                        $css_class = ($rank['max_score'][$p['problem_id']] > 0) ? 'text-warning' : 'text-danger';
                    } else if (isset($rank['score'][$p['problem_id']])) {
                        $css_class = ($rank['score'][$p['problem_id']] > 0) ? 'text-warning' : 'text-danger';
                    }
                    if (isset($rank['score'][$p['problem_id']])) {
                        $first = ($model->type == Contest::TYPE_OI && $showStandingBeforeEnd == 1) ?
                            $rank['score'][$p['problem_id']] : $rank['max_score'][$p['problem_id']];
                    }
                    if ((!Yii::$app->user->isGuest && $model->created_by == Yii::$app->user->id) || $model->isContestEnd()) {
                        $url = Url::toRoute([
                            '/contest/submission',
                            'pid' => $p['problem_id'],
                            'cid' => $model->id,
                            'uid' => $rank['user_id']
                        ]);
                        echo "<td class=\"{$css_class}\" style=\"cursor:pointer\" data-click='submission' data-href='{$url}'><b>{$first}</b></td>";
                    } else {
                        echo "<td class=\"{$css_class}\"><b>{$first}</b></td>";
                    }
                }
                ?>
            </tr>
        <?php endfor; ?>
        <tr class="bg-tablehead" style="line-height: 1;">
            <td style="width:2.5rem;"><b>#</b></td>
            <td style="width:8rem"></td>
            <td style="min-width:10rem;text-align:left"></td>
            <td style="width:3.5rem;"><b>=</b></td>
            <?php foreach ($problems as $key => $p) : ?>
                <td style="width:3.5rem">
                    <span class="text-success">
                        <b><?= $submit_count[$p['problem_id']]['solved'] ?? 0 ?></b>
                    </span>
                    <br>
                    <span class="text-secondary">
                        <b><?= $submit_count[$p['problem_id']]['submit'] ?? 0 ?></b>
                    </span>
                </td>
            <?php endforeach; ?>
        </tr>

    </tbody>
</table>
<p></p>
<?= \yii\widgets\LinkPager::widget([
    'pagination' => $pages,
    'linkOptions' => ['class' => 'page-link'],
    'maxButtonCount' => 5,
]); ?>
<?php
$js = "
$(function () {
    $('[data-toggle=\"tooltip\"]').tooltip()
})
$('[data-click=submission]').click(function() {
    $.ajax({
        url: $(this).attr('data-href'),
        type:'post',
        error: function(){alert('error');},
        success:function(html){
            $('#submission-content').html(html);
            $('#submission-info').modal('show');
        }
    });
});
";
$this->registerJs($js);
?>
<?php Modal::begin([
    'options' => ['id' => 'submission-info']
]); ?>
<div id="submission-content">
</div>
<?php Modal::end(); ?>