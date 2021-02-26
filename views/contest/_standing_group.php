<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Modal;

/* @var $model app\models\Contest */
/* @var $rankResult array */

$problems = $model->problems;
$first_blood = $rankResult['first_blood'];
$result = $rankResult['rank_result'];
$submit_count = $rankResult['submit_count'];
?>
<?php if ($model->isScoreboardFrozen()) : ?>
    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 现已是封榜状态，榜单将不再实时更新，待赛后再揭晓。</div>
    <p></p>
<?php endif; ?>
<table class="table table-bordered">

    <tbody style="line-height: 1;">
        <tr class="bg-tablehead" style="line-height: 2;">
            <td style="width:2.5rem"><b>#</b></td>
            <td style="width:8rem"></td>
            <td style="min-width:10rem;text-align:left"></td>
            <td style="width:3.5rem"><b>=</b></td>
            <?php foreach ($problems as $key => $p) : ?>
                <td style="width:3.5rem">
                    <b>
                        <?= Html::a(chr(65 + $key), ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'text-dark']) ?>
                    </b>
                </td>
            <?php endforeach; ?>
        </tr>
        <?php for ($i = 0, $ranking = 1, $last_ranking = 1; $i < count($result); $i++) : ?>
            <?php $rank = $result[$i]; ?>
            <tr>
                <td style="display:table-cell; vertical-align:middle">
                    <?php
                    echo $rank['finalrank'];
                    ?>
                </td>
                <td style="display:table-cell; vertical-align:middle">
                    <?= Html::encode($rank['student_number']); ?>
                </td>
                <td style="text-align:left;display:table-cell; vertical-align:middle">
                    <?= Html::a(Html::encode($rank['nickname']), ['/user/view', 'id' => $rank['user_id']], ['class' => 'text-dark']) ?>
                </td>
                <td style="display:table-cell; vertical-align:middle">
                    <span><b><?= $rank['solved'] ?></b></span>
                    <span class="text-secondary">
                        <?php if (strtotime($model->end_time) >= 253370736000) : ?>
                        <?php else : ?>
                            <?php if (intval($rank['time'] / 60) < 100000) : ?>
                                <br><b><?= intval($rank['time'] / 60) ?></b>
                            <?php else : ?>
                                <br><b>10W+</b>
                            <?php endif; ?>
                        <?php endif; ?>
                    </span>
                </td>

                <?php
                foreach ($problems as $key => $p) {
                    $css_class = '';
                    $num = '';
                    $time = '';
                    if (isset($rank['ac_time'][$p['problem_id']]) && $rank['ac_time'][$p['problem_id']] != -1) {
                        if ($first_blood[$p['problem_id']] == $rank['user_id'] && strtotime($model->end_time) < 253370736000) {
                            $css_class = 'text-success bg-firstblood';
                        } else {
                            $css_class = 'text-success';
                        }
                        if ($rank['wa_count'][$p['problem_id']] == 0) {
                            $num = '+';
                        } else {
                            $num = '+' . $rank['wa_count'][$p['problem_id']];
                        }
                        if (intval($rank['ac_time'][$p['problem_id']]) < 100000) {
                            $time = '<br><span class="text-secondary">' . intval($rank['ac_time'][$p['problem_id']]) . '</span>';
                        } else {
                            $time = '<br><span class="text-secondary">' . '10W+' . '</span>';
                        }
                        if (strtotime($model->end_time) >= 253370736000) {
                            $time = '';
                        }

                        if ($rank['ac_time'][$p['problem_id']] == 0) {
                            // 补题
                            $time = '';
                            $css_class = 'text-primary';
                        }
                    } else if (isset($rank['wa_count'][$p['problem_id']])) {
                        $css_class = 'text-danger';
                        if ($rank['wa_count'][$p['problem_id']] != 0) {
                            $num = '-' . $rank['wa_count'][$p['problem_id']];
                        }
                        $time = '';
                    }
                    // 封榜的显示
                    if ($model->isScoreboardFrozen() && isset($rank['pending'][$p['problem_id']]) && $rank['pending'][$p['problem_id']]) {
                        $num = "<span class=\"text-primary\">?<span>";
                    }
                    if ((!Yii::$app->user->isGuest && $model->created_by == Yii::$app->user->id) || (!$model->isScoreboardFrozen() && $model->isContestEnd())) {
                        $url = Url::toRoute([
                            '/contest/submission',
                            'pid' => $p['problem_id'],
                            'cid' => $model->id,
                            'uid' => $rank['user_id']
                        ]);
                        echo "<td class=\"{$css_class}\" style=\"display:table-cell; vertical-align:middle; cursor:pointer\" data-click='submission' data-href='{$url}'><b>{$num}{$time}</b></td>";
                    } else {
                        echo "<td style=\"display:table-cell; vertical-align:middle\"  class=\"{$css_class}\"><b>{$num}{$time}</b></td>";
                    }
                }
                ?>
            </tr>
        <?php endfor; ?>
        <tr class="bg-tablehead" style="line-height: 1;">
            <td style="width:2.5rem;display:table-cell; vertical-align:middle"><b>#</b></td>
            <td style="width:8rem"></td>
            <td style="min-width:10rem;text-align:left"></td>
            <td style="width:3.5rem;display:table-cell; vertical-align:middle"><b>=</b></td>
            <?php foreach ($problems as $key => $p) : ?>
                <td style="width:3.5rem">
                    <span class="text-success">
                        <b>
                            <?php
                            if (isset($submit_count[$p['problem_id']]['solved']))
                                echo $submit_count[$p['problem_id']]['solved'];
                            else
                                echo 0;
                            ?>
                        </b>
                    </span>
                    <br>
                    <span class="text-secondary">
                        <b>
                            <?php
                            if (isset($submit_count[$p['problem_id']]['submit']))
                                echo $submit_count[$p['problem_id']]['submit'];
                            else
                                echo 0;
                            ?>
                        </b>
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