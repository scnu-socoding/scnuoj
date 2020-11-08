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
<?php if ($model->isScoreboardFrozen()): ?>
<p>现已是封榜状态，榜单将不再实时更新，待赛后再揭晓</p>
<?php endif; ?>
<table class="table table-rank">
    <thead>
        <tr>
            <th width="2.5rem">Rank</th>
            <th width="8rem">Number</th>
            <th style="text-align:left">Who</th>
            <th width="5rem" title="solved / penalty time" colspan="2">Score</th>
            <?php foreach($problems as $key => $p): ?>
            <th width="5rem">
                <?= Html::a(chr(65 + $key), ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'text-dark']) ?>

            </th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php for ($i = 0, $ranking = 1; $i < count($result); $i++): ?>
        <?php $rank = $result[$i]; ?>
        <tr>
            <td>
                <?php
                //线下赛，参加比赛但不参加排名的处理
                if ($model->scenario == \app\models\Contest::SCENARIO_OFFLINE && $rank['role'] != \app\models\User::ROLE_PLAYER) {
                    echo '*';
                }
                elseif ($rank['role'] == \app\models\User::ROLE_ADMIN) {
                    echo '*';
                } else {
                    echo $ranking;
                    $ranking++;
                }
                ?>
            </td>
            <td>
                <?= Html::encode($rank['student_number']); ?>
            </td>
            <td style="text-align:left">
                <?= Html::a(Html::encode($rank['nickname']), ['/user/view', 'id' => $rank['user_id']], ['class' => 'text-dark']) ?>

            </td>
            <td class="score-solved">
                <?= $rank['solved'] ?>
            </td>
            <td class="score-time">
                <?= min(intval($rank['time'] / 60), 99999) ?>
            </td>
            <?php
            foreach($problems as $key => $p) {
                $css_class = '';
                $num = 0;
                $time = '';
                $span = '';
                if (isset($rank['ac_time'][$p['problem_id']]) && $rank['ac_time'][$p['problem_id']] != -1) {
                    if ($first_blood[$p['problem_id']] == $rank['user_id']) {
                        $css_class = 'text-info';
                    } else {
                        $css_class = 'text-success';
                    }
                    $span = '+ ';
                    $num = $rank['wa_count'][$p['problem_id']];
                    if($num==0){
                        $num='';
                        $span='+';
                    }
                    $time = intval($rank['ac_time'][$p['problem_id']]);
                } 
                // else if (isset($rank['pending'][$p['problem_id']]) && $rank['pending'][$p['problem_id']]) {
                //     $num = $rank['wa_count'][$p['problem_id']] + $rank['pending'][$p['problem_id']];
                //     $css_class = 'text-secondary';
                //     $time = '';
                // } 
                else if (isset($rank['wa_count'][$p['problem_id']])) {
                    $css_class = 'text-danger';
                    $num =  $rank['wa_count'][$p['problem_id']];
                    $time = '';
                    $span = '- ';
                }
                // 封榜的显示
                if ($model->isScoreboardFrozen() && isset($rank['pending'][$p['problem_id']]) && $rank['pending'][$p['problem_id']]) {
                    $num = $rank['ce_count'][$p['problem_id']] + $rank['wa_count'][$p['problem_id']] . "+" .  $rank['pending'][$p['problem_id']];
                }
                if ((!Yii::$app->user->isGuest && $model->created_by == Yii::$app->user->id) || (!$model->isScoreboardFrozen() && $model->isContestEnd())) {
                    $url = Url::toRoute([
                        '/contest/submission',
                        'pid' => $p['problem_id'],
                        'cid' => $model->id,
                        'uid' => $rank['user_id']
                    ]);
                    echo "<th class=\"table-problem-cell\" style=\"cursor:pointer\" data-click='submission' data-href='{$url}'><span class=\"{$css_class}\">{$span}{$num}<br><small>{$time}</small></span></th>";
                } else {
                    echo "<th class=\"table-problem-cell\"><span class=\"{$css_class}\">{$time}<br><small>{$num} {$span}</small></span></th>";
                }
            }
            ?>
            </td>
        </tr>
        <?php endfor; ?>
    </tbody>
</table>
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