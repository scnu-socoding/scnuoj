<?php

use app\models\Solution;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Nav;
use app\models\Contest;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $solution app\models\Solution */
/* @var $problem array */
/* @var $submissions array */

$this->title = Html::encode($model->title);
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contest'), 'url' => ['/contest/index']];
// $this->params['breadcrumbs'][] = $model->title;
$this->params['model'] = $model;
$submissionStatistics = $model->getSubmissionStatistics();

if (!Yii::$app->user->isGuest) {
    $solution->language = Yii::$app->user->identity->language;
}
$problems = $model->problems;
if (empty($problems)) {
    echo 'Please add problem';
    return;
}

$sample_input = unserialize($problem['sample_input']);
$sample_output = unserialize($problem['sample_output']);
$loadingImgUrl = Yii::getAlias('@web/images/loading.gif');

$loginUserProblemSolvingStatus = $model->getLoginUserProblemSolvingStatus();

?>


<h5>Problem <?= Html::encode(chr(65 + $problem['num']) . '. ' . $problem['title']) ?></h5>

<div class="row">
    <div class="col-lg-9">

        <?php if ($problem['description'] == '' && $problem['input'] == '' && $problem['output'] == '') : ?>
            <div class="alert text-dark border">比赛题目通过其它方式分发，敬请留意相关信息。</div>
        <?php else : ?>
            <?= Yii::$app->formatter->asMarkdown($problem['description']) ?>
            <p class="lead"><?= Yii::t('app', 'Input') ?></p>
            <?= Yii::$app->formatter->asMarkdown($problem['input']) ?>
            <p class="lead"><?= Yii::t('app', 'Output') ?></p>
            <?= Yii::$app->formatter->asMarkdown($problem['output']) ?>
            <?php if ($sample_input[0] != '' || $sample_output[0] != '') : ?>
                <p class="lead"><?= Yii::t('app', 'Examples') ?></p>
                <table class="table table-bordered" style="table-layout:fixed;">
                    <tbody>
                        <tr class="bg-tablehead" style="line-height: 1;">
                            <td>标准输入</td>
                        </tr>
                        <tr>
                            <td class="sample-test" style="cursor:pointer;" data-toggle="tooltip" title="点击复制">
                                <pre style="margin:0"><?= Html::encode($sample_input[0]) ?></pre>
                            </td>
                        </tr>
                        <tr class="bg-tablehead" style="line-height: 1;">
                            <td>标准输出</td>
                        </tr>
                        <tr>
                            <td class="sample-test" style="cursor:pointer;" data-toggle="tooltip" title="点击复制">
                                <pre style="margin:0"><?= Html::encode($sample_output[0]) ?></pre>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>
            <?php if ($sample_input[1] != '' || $sample_output[1] != '') : ?>
                <table class="table table-bordered" style="table-layout:fixed;">
                    <tbody>
                        <tr class="bg-tablehead" style="line-height: 1;">
                            <td>标准输入</td>
                        </tr>
                        <tr>
                            <td class="sample-test" style="cursor:pointer;" data-toggle="tooltip" title="点击复制">
                                <pre style="margin:0"><?= Html::encode($sample_input[1]) ?></pre>
                            </td>
                        </tr>
                        <tr class="bg-tablehead" style="line-height: 1;">
                            <td>标准输出</td>
                        </tr>
                        <tr>
                            <td class="sample-test" style="cursor:pointer;" data-toggle="tooltip" title="点击复制">
                                <pre style="margin:0"><?= Html::encode($sample_output[1]) ?></pre>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>
            <?php if ($sample_input[2] != '' || $sample_output[2] != '') : ?>
                <table class="table table-bordered" style="table-layout:fixed;">
                    <tbody>
                        <tr class="bg-tablehead" style="line-height: 1;">
                            <td>标准输入</td>
                        </tr>
                        <tr>
                            <td class="sample-test" style="cursor:pointer;" data-toggle="tooltip" title="点击复制">
                                <pre style="margin:0"><?= Html::encode($sample_input[2]) ?></pre>
                            </td>
                        </tr>
                        <tr class="bg-tablehead" style="line-height: 1;">
                            <td>标准输出</td>
                        </tr>
                        <tr>
                            <td class="sample-test" style="cursor:pointer;" data-toggle="tooltip" title="点击复制">
                                <pre style="margin:0"><?= Html::encode($sample_output[2]) ?></pre>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>


            <?php if (!empty($problem['hint'])) : ?>

                <p class="lead"><?= Yii::t('app', 'Hint') ?></p>
                <?= Yii::$app->formatter->asMarkdown($problem['hint']) ?>

            <?php endif; ?>
        <?php endif; ?>
        <p></p>
        <?php if ($model->isContestEnd() && time() < strtotime($model->end_time) + 5 * 60) : ?>
            <p></p>
            <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 比赛已结束。比赛结束五分钟后开放提交。</div>
        <?php else : ?>
            <?php if (Yii::$app->user->isGuest) : ?>
            <?php else : ?>
                <p></p>
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($solution, 'language', [
                    'template' => "{input}",
                ])->dropDownList($solution::getLanguageList(), ['class' => 'form-control custom-select selectpicker']) ?>

                <?= $form->field($solution, 'source', [
                    'template' => "{input}",
                ])->widget('app\widgets\codemirror\CodeMirror'); ?>

                <div class="form-group">
                    <?= Html::submitButton("<span class=\"fas fas-fw fa-paper-plane\"></span> " . Yii::t('app', 'Submit'), ['class' => 'btn btn-success btn-block', 'id' => 'submit_solution_btn']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            <?php endif; ?>
        <?php endif; ?>

    </div>
    <div class="col-lg-3">
        <div class="list-group list-group-flush">

            <div class="list-group-item">
                单点时限 <a href="#" class="text-dark" data-toggle="tooltip" title="Java / Python 有 2s 额外运行时间">
                    <span class="fas fa-fw fa-info-circle"></span>
                </a>
                <span class="float-right">
                    <?= Yii::t('app', '{t, plural, =1{# second} other{# seconds}}', ['t' => intval($problem['time_limit'])]); ?>
                </span>
            </div>

            <div class="list-group-item">
                内存限制 <a href="#" class="text-dark" data-toggle="tooltip" title="Java / Python 有 64M 额外空间">
                    <span class="fas fa-fw fa-info-circle"></span>
                </a>
                <span class="float-right">
                    <?= $problem['memory_limit'] ?> MB
                </span>
            </div>
            <?php if ($model->type == Contest::TYPE_OI && $model->getRunStatus() == Contest::STATUS_RUNNING) : ?>
            <?php else : ?>

                <div class="list-group-item">
                    提交
                    <span class="float-right">
                        <?= $submissionStatistics[$problem['id']]['submit'] ?>
                    </span>
                </div>
                <div class="list-group-item">
                    通过
                    <span class="float-right">
                        <?= $submissionStatistics[$problem['id']]['solved']  ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <p></p>

        <div>
            <?php foreach ($problems as $key => $p) : ?>
                <?php if ($model->type == Contest::TYPE_OI && $model->getRunStatus() == Contest::STATUS_RUNNING) : ?>
                    <?= Html::a('<code style="font-size: 0.8rem;">' . chr(65 + $key) . '</code>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'btn btn-secondary btn-sm', 'style' => 'margin-bottom:0.5rem']); ?>
                <?php else : ?>
                    <?php if (!isset($loginUserProblemSolvingStatus[$p['problem_id']])) : ?>
                        <?= Html::a('<code style="font-size: 0.8rem;">' . chr(65 + $key) . '</code>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'btn btn-secondary btn-sm', 'style' => 'margin-bottom:0.5rem;']); ?>
                    <?php elseif ($loginUserProblemSolvingStatus[$p['problem_id']] == \app\models\Solution::OJ_AC) : ?>
                        <?= Html::a('<code style="font-size: 0.8rem;">' . chr(65 + $key) . '</code>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'btn btn-success btn-sm', 'style' => 'margin-bottom:0.5rem']); ?>
                    <?php elseif ($loginUserProblemSolvingStatus[$p['problem_id']] < 4) : ?>
                        <?= Html::a('<code style="font-size: 0.8rem;">' . chr(65 + $key) . '</code>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'btn btn-secondary btn-sm', 'style' => 'margin-bottom:0.5rem;']); ?>
                    <?php else : ?>
                        <?= Html::a('<code style="font-size: 0.8rem;">' . chr(65 + $key) . '</code>', ['/contest/problem', 'id' => $model->id, 'pid' => $key], ['class' => 'btn btn-danger btn-sm', 'style' => 'margin-bottom:0.5rem;']); ?>
                    <?php endif; ?>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>
        <p></p>

        <?php if (!Yii::$app->user->isGuest && !empty($submissions)) : ?>

            <div class="list-group list-group-flush noscrollbar" style="max-height:17.5rem;overflow-y:auto;">
                <?php foreach ($submissions as $sub) : ?>
                    <?php
                    if ($sub['result'] <= Solution::OJ_WAITING_STATUS) {
                        $waitingHtmlDom = 'waiting="true"';
                        $loadingImg = "<img src=\"{$loadingImgUrl}\">";
                    } else {
                        $waitingHtmlDom = 'waiting="false"';
                        $loadingImg = "";
                    }
                    // OI 比赛过程中结果不可见
                    if ($model->type == \app\models\Contest::TYPE_OI && !$model->isContestEnd()) {
                        $waitingHtmlDom = 'waiting="false"';
                        $loadingImg = "";
                        $sub['result'] = 0;
                    }
                    $innerHtml =  'data-verdict="' . $sub['result'] . '" data-submissionid="' . $sub['id'] . '" ' . $waitingHtmlDom;
                    if ($sub['result'] == Solution::OJ_AC) {
                        $span = '<strong class="text-success"' . $innerHtml . '>' . Solution::getResultList($sub['result']) . '</strong><span class="float-right"> ' .  Yii::$app->formatter->asRelativeTime($sub['created_at']) . '</span>';
                    } else {
                        $span = '<strong class="text-danger" ' . $innerHtml . '>' . Solution::getResultList($sub['result']) . $loadingImg . '</strong><span class="float-right"> ' .  Yii::$app->formatter->asRelativeTime($sub['created_at']) . '</span>';
                    }
                    ?>
                    <?= Html::a(
                        $span,
                        ['/solution/source', 'id' => $sub['id']],
                        ['class' => 'list-group-item list-group-item-action', 'onclick' => 'return false', 'data-click' => "solution_info"]
                    ) ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <p></p>

</div>
<div class="row">
    <div class="col">


    </div>
</div>
<?php Modal::begin([
    'title' => '查看提交',
    'size' => Modal::SIZE_LARGE,
    'options' => ['id' => 'solution-info']
]); ?>
<div id="solution-content">
</div>
<?php Modal::end(); ?>

<?php
$url = \yii\helpers\Url::toRoute(['/solution/verdict']);
$js = <<<EOF

// 防止重复提交

var wait = 5;

var submit_btn = document.getElementById("submit_solution_btn");

function time() {
    if (wait == 0 && submit_btn) {
        submit_btn.removeAttribute("disabled");
        submit_btn.innerHTML = "<span class=\"fas fas-fw fa-paper-plane\"></span> 提交";
        wait = 5;
    } else if (submit_btn) {
        submit_btn.setAttribute("disabled", true);
        submit_btn.innerHTML = "若页面没有自动刷新, 请尝试重新提交";
        wait--;
        setTimeout(function () {
            time()
        },
            1000)
    }
}

if(submit_btn)
    submit_btn.parentNode.parentNode.onsubmit = function () { time(); }

$('[data-click=solution_info]').click(function() {
    $.ajax({
        url: $(this).attr('href'),
        type:'post',
        error: function(){alert('error');},
        success:function(html){
            $('#solution-content').html(html);
            $('#solution-info').modal('show');
        }
    });
});
function updateVerdictByKey(submission) {
    $.get({
        url: "{$url}?id=" + submission.attr('data-submissionid'),
        success: function(data) {
            var obj = JSON.parse(data);
            submission.attr("waiting", obj.waiting);
            submission.text(obj.result);
            if (obj.verdict === "4") {
                submission.attr("class", "text-success")
            }
            if (obj.waiting === "true") {
                submission.append('<img src="{$loadingImgUrl}" alt="loading">');
            }
        }
    });
}
var waitingCount = $("strong[waiting=true]").length;
if (waitingCount > 0) {
    console.log("There is waitingCount=" + waitingCount + ", starting submissionsEventCatcher...");
    var interval = null;
    var waitingQueue = [];
    $("strong[waiting=true]").each(function(){
        waitingQueue.push($(this));
    });
    waitingQueue.reverse();
    var testWaitingsDone = function () {
        updateVerdictByKey(waitingQueue[0]);
        var waitingCount = $("strong[waiting=true]").length;
        while (waitingCount < waitingQueue.length) {
            if (waitingCount < waitingQueue.length) {
                waitingQueue.shift();
            }
            if (waitingQueue.length === 0) {
                break;
            }
            updateVerdictByKey(waitingQueue[0]);
            waitingCount = $("strong[waiting=true]").length;
        }
        console.log("There is waitingCount=" + waitingCount + ", starting submissionsEventCatcher...");
        
        if (interval && waitingCount === 0) {
            console.log("Stopping submissionsEventCatcher.");
            clearInterval(interval);
            interval = null;
        }
    }
    interval = setInterval(testWaitingsDone, 1000);
}


$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
EOF;
$this->registerJs($js);
?>