<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
use app\models\Solution;

/* @var $this yii\web\View */
/* @var $model app\models\Problem */
/* @var $solution app\models\Solution */
/* @var $submissions array */

$this->title = $model->id . '. ' . $model->title;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['problem/index']];
// $this->params['breadcrumbs'][] = $this->title;

if (!Yii::$app->user->isGuest) {
    $solution->language = Yii::$app->user->identity->language;
}

$model->setSamples();

$loadingImgUrl = Yii::getAlias('@web/images/loading.gif');
$previousProblemID = $model->getPreviousProblemID();
$nextProblemID = $model->getNextProblemID();
?>

<h3><?= Html::encode($this->title) ?> </h3>

<ul class="nav nav-pills">
    <li class="nav-item">
        <?= Html::a(
            Yii::t('app', 'Problem'),
            ['/problem/view', 'id' => $model->id],
            ['class' => 'nav-link active']
        )
        ?>
    </li>
    <?php if (Yii::$app->setting->get('isDiscuss')) : ?>
        <li class="nav-item">
            <?= Html::a(
                Yii::t('app', 'Discuss'),
                ['/problem/discuss', 'id' => $model->id],
                ['class' => 'nav-link']
            )
            ?>
        </li>
    <?php endif; ?>
    <?php if (!empty($model->solution)) : ?>
        <li class="nav-item">
            <?= Html::a(
                Yii::t('app', 'Editorial'),
                ['/problem/solution', 'id' => $model->id],
                ['class' => 'nav-link']
            )
            ?>
        </li>
    <?php endif; ?>
</ul>
<p></p>

<div class="row">

    <div class="col-lg-9">
        <?= Yii::$app->formatter->asMarkdown($model->description) ?>
        <p class="lead"><?= Yii::t('app', 'Input') ?></p>
        <?= Yii::$app->formatter->asMarkdown($model->input) ?>
        <p class="lead"><?= Yii::t('app', 'Output') ?></p>
        <?= Yii::$app->formatter->asMarkdown($model->output) ?>
        <?php if ($model->sample_input != '' || $model->sample_output != '') : ?>
            <p class="lead"><?= Yii::t('app', 'Examples') ?></p>
            <table class="table table-bordered" style="table-layout:fixed;">
                <tbody>
                    <tr class="bg-tablehead" style="line-height: 1;">
                        <td>标准输入</td>
                    </tr>
                    <tr>
                        <td class="sample-test" style="cursor:pointer;" data-toggle="tooltip" title="点击复制">
                            <pre style="margin:0"><?= Html::encode($model->sample_input) ?></pre>
                        </td>
                    </tr>
                    <tr class="bg-tablehead" style="line-height: 1;">
                        <td>标准输出</td>
                    </tr>
                    <tr>
                        <td class="sample-test" style="cursor:pointer;" data-toggle="tooltip" title="点击复制">
                            <pre style="margin:0"><?= Html::encode($model->sample_output) ?></pre>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
        <?php if ($model->sample_input_2 != '' || $model->sample_output_2 != '') : ?>
            <table class="table table-bordered" style="table-layout:fixed;">
                <tbody>
                    <tr class="bg-tablehead" style="line-height: 1;">
                        <td>标准输入</td>
                    </tr>
                    <tr>
                        <td class="sample-test" style="cursor:pointer;" data-toggle="tooltip" title="点击复制">
                            <pre style="margin:0"><?= Html::encode($model->sample_input_2) ?></pre>
                        </td>
                    </tr>
                    <tr class="bg-tablehead" style="line-height: 1;">
                        <td>标准输出</td>
                    </tr>
                    <tr>
                        <td class="sample-test" style="cursor:pointer;" data-toggle="tooltip" title="点击复制">
                            <pre style="margin:0"><?= Html::encode($model->sample_output_2) ?></pre>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
        <?php if ($model->sample_input_3 != '' || $model->sample_output_3 != '') : ?>
            <table class="table table-bordered" style="table-layout:fixed;">
                <tbody>
                    <tr class="bg-tablehead" style="line-height: 1;">
                        <td>标准输入</td>
                    </tr>
                    <tr>
                        <td class="sample-test" style="cursor:pointer;" data-toggle="tooltip" title="点击复制">
                            <pre style="margin:0"><?= Html::encode($model->sample_input_3) ?></pre>
                        </td>
                    </tr>
                    <tr class="bg-tablehead" style="line-height: 1;">
                        <td>标准输出</td>
                    </tr>
                    <tr>
                        <td class="sample-test" style="cursor:pointer;" data-toggle="tooltip" title="点击复制">
                            <pre style="margin:0"><?= Html::encode($model->sample_output_3) ?></pre>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>


        <?php if (!empty($model->hint)) : ?>
            <p class="lead"><?= Yii::t('app', 'Hint') ?></p>
            <?= Yii::$app->formatter->asMarkdown($model->hint) ?>
            <p></p>
        <?php endif; ?>

        <?php if (!empty($model->source)) : ?>
            <p class="lead"><?= Yii::t('app', 'Source') ?></p>
            <p><?= $model->source ?></p>
            <p></p>
        <?php endif; ?>
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
    </div>


    <div class="col-lg-3">
        <div class="list-group list-group-flush">

            <div class="list-group-item">
                单点时限 <a href="#" class="text-dark" data-toggle="tooltip" title="Java / Python 有 2s 额外运行时间">
                    <span class="fas fa-fw fa-info-circle"></span>
                </a>
                <span class="float-right">
                    <?= Yii::t('app', '{t, plural, =1{# second} other{# seconds}}', ['t' => intval($model->time_limit)]); ?>
                </span>
            </div>

            <div class="list-group-item">
                内存限制 <a href="#" class="text-dark" data-toggle="tooltip" title="Java / Python 有 64M 额外空间">
                    <span class="fas fa-fw fa-info-circle"></span>
                </a>
                <span class="float-right">
                    <?= $model->memory_limit ?> MB
                </span>
            </div>
            <div class="list-group-item">
                提交
                <span class="float-right">
                    <?= $model->submit ?>
                </span>
            </div>
            <div class="list-group-item">
                通过
                <span class="float-right">
                    <?= $model->accepted ?>
                </span>
            </div>
        </div>

        <p></p>
        <div class="list-group list-group-flush">
            <?php if ($previousProblemID) : ?>
                <?= Html::a(
                    '上一题 ' . '<span class="float-right">' .  $previousProblemID . '</span>',
                    $previousProblemID ? ['/problem/view', 'id' => $previousProblemID] : 'javascript:void(0);',
                    ['class' => 'list-group-item list-group-item-action']
                ) ?>
            <?php else : ?>
                <div class="list-group-item text-secondary"><span class="fas fa-fw fa-check"></span> 已经是第一题了</div>
            <?php endif; ?>

            <?php if ($nextProblemID) : ?>
                <?= Html::a(
                    '下一题 ' . '<span class="float-right">' . $nextProblemID . '</span>',
                    $nextProblemID ? ['/problem/view', 'id' => $nextProblemID] : 'javascript:void(0);',
                    ['class' => 'list-group-item list-group-item-action']
                ) ?>
            <?php else : ?>
                <div class="list-group-item text-secondary"><span class="fas fa-fw fa-check"></span> 已经是最后一题了</div>
            <?php endif; ?>
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
                    $innerHtml =  'data-verdict="' . $sub['result'] . '" data-submissionid="' . $sub['id'] . '" ' . $waitingHtmlDom;
                    if ($sub['result'] == Solution::OJ_AC) {
                        $span = '<strong class="text-success"' . $innerHtml . '>' . Solution::getResultList($sub['result']) . '</strong> <span class="float-right">
                        ' . Yii::$app->formatter->asRelativeTime($sub['created_at']) . '</span>';
                    } else {
                        $span = '<strong class="text-danger" ' . $innerHtml . '>' . Solution::getResultList($sub['result']) . $loadingImg . '</strong> <span class="float-right">
                        ' . Yii::$app->formatter->asRelativeTime($sub['created_at']) . '</span>';
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

EOF;
    $this->registerJs($js);
    ?>