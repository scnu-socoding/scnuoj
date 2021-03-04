<?php

use yii\helpers\Html;
use yii\helpers\Url;
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


        <table class="table table-bordered">

            <tbody style="line-height: 1;">
                <tr class="bg-tablehead" style="line-height: 2;">
                    <td style="width:2.5rem"><b>#</b></td>
                    <td style="width:8rem"></td>
                    <td style="min-width:10rem;text-align:left"></td>
                    <td style="width:3.5rem"><b>=</b></td>
                    <?php foreach ($problems as $key => $p) : ?>
                        <td>
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
                            <?= $rank['finalrank']; ?>
                        </td>
                        <td style="display:table-cell; vertical-align:middle">
                            <?= Html::encode($rank['student_number']); ?>

                        </td>
                        <td style="text-align:left;display:table-cell; vertical-align:middle">
                            <?= Html::a(Html::encode($rank['nickname']), ['/user/view', 'id' => $rank['user_id']], ['class' => 'text-dark']) ?>
                        </td>
                        <td style="display:table-cell; vertical-align:middle">
                            <span>
                                <b>
                                    <?php if ($model->type == Contest::TYPE_OI) : ?>
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
                            $first = ''; // 题目对应的排名表格第一行字的内容
                            $second = ''; // 第二行字的内容
                            if (isset($rank['solved_flag'][$p['problem_id']])) {
                                $css_class = 'text-success font-weight-bold '; // 全部正确
                            } else if ($model->type == Contest::TYPE_IOI) {
                                if (isset($rank['max_score'][$p['problem_id']]) && $rank['max_score'][$p['problem_id']] > 0) {
                                    $css_class = 'text-warning font-weight-bold '; // 部分正确
                                } else if (isset($rank['max_score'][$p['problem_id']]) && $rank['max_score'][$p['problem_id']] == 0) {
                                    $css_class = 'text-danger font-weight-bold '; // 尝试中
                                }
                            } else {
                                if (isset($rank['score'][$p['problem_id']]) && $rank['score'][$p['problem_id']] > 0) {
                                    $css_class = 'text-warning font-weight-bold '; // 部分正确
                                } else if (isset($rank['score'][$p['problem_id']]) && $rank['score'][$p['problem_id']] == 0) {
                                    $css_class = 'text-danger font-weight-bold '; // 尝试中
                                }
                            }

                            if (isset($rank['score'][$p['problem_id']])) {
                                $score = $rank['score'][$p['problem_id']];
                                $max_score = $rank['max_score'][$p['problem_id']];
                                if ($model->type == Contest::TYPE_OI) {
                                    $first = $score;
                                    $second = $max_score;
                                    // IOI 模式下没必要记录最后一次得分，显示解答时间与得分
                                } else {
                                    $first = $max_score;
                                    if (isset($rank['submit_time'][$p['problem_id']])) {
                                        $min = intval($rank['submit_time'][$p['problem_id']]);
                                        $second = sprintf("%02d:%02d", $min / 60, $min % 60);
                                    }
                                }
                            }

                            echo "<td style=\"display:table-cell; vertical-align:middle\"  class=\"{$css_class}\">{$first}</td>";
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
    </div>
</div>