<?php

use yii\helpers\Html;
use app\models\Solution;

/* @var $this yii\web\View */
/* @var $model app\models\Solution */

$this->title = $model->id;

?>

<div class="table-responsive animate__animated animate__fadeIn animate__faster">
    <table class="table table-rank">
        <thead>
            <tr>
                <th style="min-width:90px"><?= Yii::t('app', 'Run ID') ?></th>
                <th style="min-width:150px"><?= Yii::t('app', 'Author') ?></th>
                <th style="min-width:200px"><?= Yii::t('app', 'Problem ID') ?></th>
                <th style="min-width:90px"><?= Yii::t('app', 'Verdict') ?></th>
                <?php if (Yii::$app->setting->get('oiMode')) : ?>
                    <th width="90px"><?= Yii::t('app', 'Score') ?></th>
                <?php endif; ?>
                <th style="min-width:90px"><?= Yii::t('app', 'Time') ?></th>
                <th style="min-width:90px"><?= Yii::t('app', 'Memory') ?></th>
                <th style="min-width:90px"><?= Yii::t('app', 'Lang') ?></th>
                <th style="min-width:90px"><?= Yii::t('app', 'Code Length') ?></th>
                <th style="min-width:90px"><?= Yii::t('app', 'Submit Time') ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $model->id ?></td>
                <td><?= Html::a(Html::encode($model->user->nickname ?? '临时用户'), ['/user/view', 'id' => $model->created_by], ['class' => 'text-dark']) ?>
                </td>
                <td><?= Html::a(Html::encode($model->problem_id . ' - ' . $model->problem->title), ['/problem/view', 'id' => $model->problem_id], ['class' => 'text-dark']) ?>
                </td>

                <td>
                    <?php if ($model->canViewResult()) {
                        echo $model->getResult();
                        // echo Solution::getResultList($model->result);
                    } else {
                        echo Solution::getResultList(Solution::OJ_WT0);
                    } ?>
                </td>
                <?php if (Yii::$app->setting->get('oiMode')) : ?>
                    <td>
                        <?php
                        if ($model->canViewResult()) {
                            echo $model->score;
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                <?php endif; ?>
                <td>
                    <?php
                    if ($model->canViewResult()) {
                        echo $model->time;
                    } else {
                        echo '-';
                    }
                    ?> MS
                </td>
                <td>
                    <?php
                    if ($model->canViewResult()) {
                        echo $model->memory;
                    } else {
                        echo '-';
                    }
                    ?> KB
                </td>
                <td><?= $model->getLang() ?></td>
                <td><?= $model->code_length ?></td>
                <td><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $flag = 0; ?>

<?php if ($model->canViewSource()) : ?>
    <div class="animate__animated animate__fadeIn animate__faster">
        <pre><code class="pre"><p style="font-size:1rem"><?= Html::encode($model->source) ?></p></code></pre>
    </div>
<?php endif; ?>

<?php if (!Yii::$app->setting->get('isContestMode') || (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin())) : ?>

    <?php if ($model->canViewResult() && (!Yii::$app->setting->get('isContestMode') || (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()))) : ?>
        <div class="alert alert-light animate__animated animate__fadeIn animate__faster">
            <i class="fas fa-fw fa-info-circle"></i>
            <?php if ($model->getTestCount()) : ?>
                本题共 <?= $model->getTestCount() ?> 个测试点，共通过了 <?= $model->getPassedTestCount() ?> 个测试点。
            <?php else : ?>
                暂时无法获取本题测试点详情。
                <?php $flag = 1; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($model->solutionInfo != null && $model->canViewErrorInfo()) : ?>
        <p></p>
        <?php if ($model->result != Solution::OJ_CE) : ?>
            <div id="run-info" class="list-group animate__animated animate__fadeIn animate__faster">
            </div>
        <?php else : ?>
            <div class="list-group animate__animated animate__fadeIn animate__faster">
                <div class="list-group-item">
                    <pre style="margin-bottom:0" id="run-info"></pre>
                </div>
            </div>
        <?php endif; ?>

        <!-- https://blog.csdn.net/sunbocong/article/details/81032758 -->

        <?php
        $json = $model->solutionInfo->run_info;
        $json = str_replace("&", "&#38;", $json);
        $json = str_replace("<", "&lt;", $json);
        $json = str_replace(">", "&gt;", $json);
        $json = str_replace(PHP_EOL, "<br>", $json);
        $json = str_replace("\\n", "<br>", $json);
        $json = str_replace("'", "&#39;", $json);
        $json = str_replace("\\r", "", $json);
        $json = str_replace("\\", "&#92;", $json);
        $oiMode = Yii::$app->setting->get('oiMode');
        $verdict = $model->result;
        $CE = Solution::OJ_CE;
        $js = <<<EOF

var oiMode = $oiMode;
var verdict = $verdict;
var CE = $CE;

var json = '$json';
if (verdict != CE) {
    json = JSON.parse(json);
    var subtasks = json.subtasks;
    var testId = 1;
    for (var i = 0; i < subtasks.length; i++) {
        var cases = subtasks[i].cases;
        var score = subtasks[i].score;
        var isSubtask = (subtasks.length != 1);
        if (isSubtask) {
            var verdict = cases[cases.length - 1].verdict;
            testId = 1;
            $("#run-info").append(subtaskHtml(i + 1, score, verdict));
            for (var j = 0; j < cases.length; j++) {
                var id = i + 1;
                $('#subtask-body-' + id).append(testHtml(id + '-' + testId, cases[j]));
                testId++;
            }
        } else {
            for (var j = 0; j < cases.length; j++) {
                $("#run-info").append(testHtml(testId, cases[j]));
                testId++;
            }
        }
    }
    json = "";
}
if (verdict == CE) {
    $("#run-info").append(json);
}
EOF;
        $this->registerJs($js);
        ?>
    <?php elseif ($model->solutionInfo != null && $model->canViewResult()) : ?>
        <p></p>
        <?php if ($model->result != Solution::OJ_CE) : ?>
            <div id="run-info" class="list-group">
            </div>
        <?php else : ?>
            <div class="list-group">
                <div class="list-group-item">
                    <pre id="run-info"></pre>
                </div>
            </div>
        <?php endif; ?>
        <?php
        $json = $model->solutionInfo->run_info;
        $json = str_replace("&", "&#38;", $json);
        $json = str_replace("<", "&lt;", $json);
        $json = str_replace(">", "&gt;", $json);
        $json = str_replace(PHP_EOL, "<br>", $json);
        $json = str_replace("\\n", "<br>", $json);
        $json = str_replace("'", "&#39;", $json);
        $json = str_replace("\\r", "", $json);
        $json = str_replace("\\", "&#92;", $json);
        $oiMode = Yii::$app->setting->get('oiMode');
        $verdict = $model->result;
        $CE = Solution::OJ_CE;
        $js = <<<EOF

var oiMode = $oiMode;
var verdict = $verdict;
var CE = $CE;

var json = '$json';
if (verdict != CE) {
    json = JSON.parse(json);
    var subtasks = json.subtasks;
    var testId = 1;
    for (var i = 0; i < subtasks.length; i++) {
        var cases = subtasks[i].cases;
        var score = subtasks[i].score;
        var isSubtask = (subtasks.length != 1);
        if (isSubtask) {
            var verdict = cases[cases.length - 1].verdict;
            $("#run-info").append(subtaskHtml(i + 1, score, verdict));
            testId = 1;
            for (var j = 0; j < cases.length; j++) {
                var id = i + 1;
                $('#subtask-body-' + id).append(testHtmlMinDetail(id + '-' + testId, cases[j]));
                testId++;
            }
        } else {
            for (var j = 0; j < cases.length; j++) {
                $("#run-info").append(testHtmlMinDetail(testId, cases[j]));
                testId++;
            }
        }
    }
    json = "";
}
if (verdict == CE) {
    $("#run-info").append(json);
}
EOF;
        $this->registerJs($js);
        ?>

    <?php elseif ($flag == 0) : ?>
        <div class="alert alert-light">
            <i class="fas fa-fw fa-info-circle"></i>
            暂时无法获取本题测试点详情。
        </div>
    <?php endif; ?>

<?php else : ?>

    <?php if ($model->result == Solution::OJ_CE) : ?>
        <div class="list-group animate__animated animate__fadeIn animate__faster">
            <div class="list-group-item">
                <pre id="run-info"><?= Html::encode($model->solutionInfo->run_info) ?></pre>
            </div>
        </div>
    <?php else : ?>
        <div class="alert alert-light animate__animated animate__fadeIn animate__faster">
            <i class="fas fa-fw fa-info-circle"></i>
            暂无评测详情可用。</b>
        </div>
    <?php endif; ?>

<?php endif; ?>