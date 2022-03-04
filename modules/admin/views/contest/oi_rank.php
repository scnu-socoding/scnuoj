<?php

use yii\helpers\Html;
use app\models\Contest;

/* @var $model app\models\Contest */

$this->title = $model->title;
$problems = $model->problems;
$rank_result = $model->getOIRankData(false);
$first_blood = $rank_result['first_blood'];
$result = $rank_result['rank_result'];
$submit_count = $rank_result['submit_count'];

$this->registerAssetBundle('yii\bootstrap4\BootstrapPluginAsset');
?>

<p class="lead">查看比赛 <?= Html::encode($model->title) ?> 终榜。</p>
<div class="text-center center-block">
    <div class="table-responsive">


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
                                    ? (str_pad($key + 1, 2, '0', STR_PAD_LEFT))
                                    : chr(65 + $key);
                                ?>
                                <?= Html::a($cur_id, ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'text-dark']) ?>
                            </b>
                        </td>
                    <?php endforeach; ?>
                </tr>

                <?php for ($i = 0; $i < count($result); $i++) : ?>
                    <?php $rank = $result[$i]; ?>
                    <tr>
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
                                        <br>
                                        <span class="text-secondary"><?= intval($rank['total_time']) ?></span>
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
                            if (isset($rank['score'][$p['problem_id']])) {
                                $first = ($model->type == Contest::TYPE_OI && $showStandingBeforeEnd == 1) ?
                                    $rank['score'][$p['problem_id']] : $rank['max_score'][$p['problem_id']];
                            }
                            if (isset($rank['solved_flag'][$p['problem_id']])) {
                                $css_class = 'text-success'; // 全部正确
                                $first .= '<br><span class="text-secondary">' . intval($rank['submit_time'][$p['problem_id']]) . '</span>';
                            } else if ($model->type == Contest::TYPE_IOI && isset($rank['max_score'][$p['problem_id']])) {
                                $css_class = ($rank['max_score'][$p['problem_id']] > 0) ? 'text-warning' : 'text-danger';
                                if ($rank['max_score'][$p['problem_id']] > 0)
                                    $first .= '<br><span class="text-secondary">' . intval($rank['submit_time'][$p['problem_id']]) . '</span>';
                            } else if (isset($rank['score'][$p['problem_id']])) {
                                $css_class = ($rank['score'][$p['problem_id']] > 0) ? 'text-warning' : 'text-danger';
                            }
                            echo "<td class=\"{$css_class}\"><b>{$first}</b></td>";
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
    </div>
</div>