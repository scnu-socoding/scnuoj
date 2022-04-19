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
?>

<!-- 启用封榜时显示的顶部横幅 -->

<?php if ($model->isScoreboardFrozen()) : ?>
    <div class="alert alert-light" style="text-align: left !important;"><i class="fas fa-fw fa-info-circle"></i>
        <?= (($model->isContestEnd())
            ? "比赛已经结束，封榜状态尚未解除，请等候管理员滚榜或解榜。"
            : "现已是封榜状态，榜单将不再实时更新，待赛后再揭晓。")
        ?>
    </div>
    <p></p>
<?php endif; ?>


<!-- 榜单 -->

<table class="table table-bordered standings-table">

    <tbody style="line-height: 1;">

        <!-- ########## 表头部分 ########## -->
        <tr class="bg-tablehead" style="line-height: 2;">

            <!-- 排名 -->
            <td style="width:2.5rem"><b>#</b></td>

            <!-- 学号 -->
            <td style="width:8rem"></td>

            <!-- 昵称 -->
            <td style="min-width:10rem;text-align:left"></td>

            <!-- 过题数和罚时 -->
            <td style="width:3.5rem"><b>=</b></td>

            <!-- 题号, 小于 27 题则使用大写英文字母，否则直接用数字编号 -->
            <?php foreach ($problems as $key => $p) : ?>
                <td style="width:3.5rem">
                    <b>
                        <?php
                        $cur_id = (sizeof($problems) > 26)
                            ? ('P' . str_pad($key + 1, 2, '0', STR_PAD_LEFT)) // 前导零补齐位数
                            : chr(65 + $key);
                        ?>

                        <?= Html::a($cur_id, ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'text-dark']) ?>
                    </b>
                </td>
            <?php endforeach; ?>
        </tr>

        <!-- ########## 榜单主体 ########## -->
        <?php for ($i = 0; $i < count($result); $i++) : ?>
            <?php $rank = $result[$i]; ?>


            <!-- 预处理 -->

            <!-- 如果关闭榜单（一些期末考试会需要到），榜单页只会显示自己的提交信息，其他人的会被隐藏。
            这时不告知用户排名，只打印 ? 号。 -->
            <!-- FIXME: 此部分不应该在视图层完成 -->

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

            <!-- 高亮用户自己所在的行 -->
            <?php if ((!Yii::$app->user->isGuest) && Yii::$app->user->id == $rank['user_id']) {
                $front_color = "bg-isyou";
            } else {
                $front_color = "";
            }
            ?>


            <tr class="animate__animated animate__fadeIn animate__faster <?= $front_color ?>">
                <!-- 排名 -->
                <td><?= $rank['finalrank'] ?></td>

                <!-- 学号 -->
                <td><?= Html::encode($rank['student_number']); ?></td>

                <!-- 昵称 -->
                <td style="text-align:left">
                    <?= Html::a(Html::encode($rank['nickname']), ['/user/view', 'id' => $rank['user_id']], ['class' => 'text-dark']) ?>
                </td>

                <!-- 总题数和总罚时 -->
                <td>
                    <span><b><?= $rank['solved'] ?></b></span>
                    <span class="text-secondary">
                        <?php if (strtotime($model->end_time) < Contest::TIME_INFINIFY) : ?>
                            <br><b><?= (intval($rank['time'] / 60) < 100000) ? intval($rank['time'] / 60) : "10W+" ?></b>
                        <?php endif; ?>
                    </span>
                </td>

                <!-- 每题的过题情况 -->
                <?php
                foreach ($problems as $key => $p) {
                    $css_class = '';
                    $num = '';
                    $time = '';
                    if (isset($rank['ac_time'][$p['problem_id']]) && $rank['ac_time'][$p['problem_id']] != -1) {
                        // 通过此题
                        $num = '+';
                        $css_class = 'text-success';
                        if ($first_blood[$p['problem_id']] == $rank['user_id'] && strtotime($model->end_time) < Contest::TIME_INFINIFY) {
                            // 一血
                            $css_class .= ' bg-firstblood';
                        }

                        // 每题 AC 前 WA 的次数，参考 Codeforces Edu 场的榜单显示
                        if ($rank['wa_count'][$p['problem_id']] != 0) {
                            $num .= $rank['wa_count'][$p['problem_id']];
                        }

                        // 罚时
                        if (intval($rank['ac_time'][$p['problem_id']]) < 100000) {
                            $time = '<br><span class="text-secondary">' . intval($rank['ac_time'][$p['problem_id']]) . '</span>';
                        } else {
                            $time = '<br><span class="text-secondary">' . '10W+' . '</span>';
                        }

                        // 永久开放的比赛不显示罚时
                        if (strtotime($model->end_time) >= Contest::TIME_INFINIFY) {
                            $time = '';
                        }

                        if ($rank['ac_time'][$p['problem_id']] == 0) {
                            // 补题
                            $time = '';
                            $css_class = 'text-primary';
                        }
                    } else if (isset($rank['wa_count'][$p['problem_id']])) {
                        // 交过题但是没有 AC
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
                        echo "<td class=\"{$css_class}\" style=\"cursor:pointer\" data-click='submission' data-href='{$url}'><b>{$num}{$time}</b></td>";
                    } else {
                        echo "<td class=\"{$css_class}\"><b>{$num}{$time}</b></td>";
                    }
                }
                ?>
            </tr>
        <?php endfor; ?>


        <!-- 表尾，显示各题提交数和通过数 -->
        <tr class="bg-tablehead" style="line-height: 1;">
            <td style="width:2.5rem"><b>#</b></td>
            <td style="width:8rem"></td>
            <td style="min-width:10rem;text-align:left"></td>
            <td style="width:3.5rem"><b>=</b></td>
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