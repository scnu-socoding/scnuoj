<?php

use yii\helpers\Html;
use app\models\Solution;

/* @var $this yii\web\View */
/* @var $model app\models\Solution */

$this->title = $model->id;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Status'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;

?>

<div class="table-responsive">
    <table class="table table-rank">
        <thead>
            <tr>
                <th style="min-width:100px"><?= Yii::t('app', 'Run ID') ?></th>
                <th style="min-width:150px"><?= Yii::t('app', 'Author') ?></th>
                <th style="min-width:200px"><?= Yii::t('app', 'Problem ID') ?></th>
                <th style="min-width:100px"><?= Yii::t('app', 'Verdict') ?></th>
                <?php if (Yii::$app->setting->get('oiMode')) : ?>
                    <th width="100px"><?= Yii::t('app', 'Score') ?></th>
                <?php endif; ?>
                <th style="min-width:100px"><?= Yii::t('app', 'Time') ?></th>
                <th style="min-width:100px"><?= Yii::t('app', 'Memory') ?></th>
                <th style="min-width:100px"><?= Yii::t('app', 'Lang') ?></th>
                <th style="min-width:100px"><?= Yii::t('app', 'Code Length') ?></th>
                <th style="min-width:100px"><?= Yii::t('app', 'Submit Time') ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $model->id ?></td>
                <td><?= Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->created_by], ['class' => 'text-dark']) ?>
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

<?php if ($model->canViewSource()) : ?>
    <pre><code class="pre"><p style="font-size:1rem"><?= Html::encode($model->source) ?></p></code></pre>
<?php endif; ?>

<?php if ($model->canViewResult()) : ?>
    <div class="alert alert-light">
        <i class="fas fa-fw fa-info-circle"></i>
        <?php if ($model->getPassedTestCount()) : ?>
            本题共 <?= $model->getTestCount() ?> 个测试点，共通过了 <?= $model->getPassedTestCount() ?> 个测试点。</h3>
        <?php else : ?>
            暂时无法获取本题测试点信息。
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if ($model->solutionInfo != null && $model->canViewErrorInfo()) : ?>
    <p></p>
    <?php if ($model->result != Solution::OJ_CE) : ?>
        <div id="run-info" class="list-group">
        </div>
    <?php else : ?>
        <div class="list-group">
            <div class="list-group-item"><pre id="run-info"></pre></div>
        </div>
    <?php endif; ?>
    </div>
    <?php
    $json = $model->solutionInfo->run_info;
    $json = str_replace(PHP_EOL, "<br>", $json);
    $json = str_replace("\\n", "<br>", $json);
    $json = str_replace("'", "\'", $json);
    $json = str_replace("\\r", "", $json);
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
            for (var j = 0; j < cases.length; j++) {
                var id = i + 1;
                $('#subtask-body-' + id).append(testHtml(testId, cases[j]));
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
<?php elseif ($model->canViewResult()) : ?>
    <p></p>
    <?php if ($model->result != Solution::OJ_CE) : ?>
        <div id="run-info" class="list-group">
        </div>
    <?php else : ?>
        <div class="list-group">
            <div class="list-group-item"><pre id="run-info"></pre></div>
        </div>
    <?php endif; ?>
    <?php
    $json = $model->solutionInfo->run_info;
    $json = str_replace(PHP_EOL, "<br>", $json);
    $json = str_replace("\\n", "<br>", $json);
    $json = str_replace("'", "\'", $json);
    $json = str_replace("\\r", "", $json);
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
            for (var j = 0; j < cases.length; j++) {
                var id = i + 1;
                $('#subtask-body-' + id).append(testHtmlMinDetail(testId, cases[j]));
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

<?php endif; ?>