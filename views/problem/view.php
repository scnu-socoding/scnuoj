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
        <?= Html::a( Yii::t('app', 'Problem'),
            ['/p/' . $model->id],
            ['class' => 'nav-link active'])
        ?>
    </li>
    <?php if (Yii::$app->setting->get('isDiscuss')): ?>
    <li class="nav-item">
        <?= Html::a( Yii::t('app', 'Discuss'),
            ['/problem/discuss', 'id' => $model->id],
            ['class' => 'nav-link'])
        ?>
    </li>
    <?php endif; ?>
    <?php if (!empty($model->solution)): ?>
    <li class="nav-item">
        <?= Html::a(Yii::t('app', 'Editorial'),
            ['/problem/solution', 'id' => $model->id],
            ['class' => 'nav-link'])
        ?>
    </li>
    <?php endif; ?>
</ul>
<p></p>

<div class="row">

    <div class="col-lg-8">

        <p><b>单点时限:</b>
            <?= Yii::t('app', '{t, plural, =1{# second} other{# seconds}}', ['t' => intval($model->time_limit)]); ?><br>
            <b>内存限制:</b> <?= $model->memory_limit ?>
            MB
        </p>
        <?= Yii::$app->formatter->asMarkdown($model->description) ?>
        <h5><?= Yii::t('app', 'Input') ?></h5>
        <?= Yii::$app->formatter->asMarkdown($model->input) ?>
        <h5><?= Yii::t('app', 'Output') ?></h5>
        <?= Yii::$app->formatter->asMarkdown($model->output) ?>
        <h5><?= Yii::t('app', 'Examples') ?></h5>
        <div class="sample-test">
            <table class="table table-bordered" style="table-layout:fixed;">
                <tbody>
                    <tr class="bg-tablehead" style="line-height: 1;">
                        <td width="50%">标准输入</td>
                        <td width="50%">标准输出</td>
                    </tr>
                    <tr>
                        <td>
                            <pre style="margin:0"><?= Html::encode($model->sample_input) ?></pre>
                        </td>
                        <td>
                            <pre style="margin:0"><?= Html::encode($model->sample_output) ?></pre>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php if ($model->sample_input_2 != '' || $model->sample_output_2 != ''):?>
            <table class="table table-bordered" style="table-layout:fixed;">
                <tbody>
                    <tr class="bg-tablehead" style="line-height: 1;">
                        <td width="50%">标准输入</td>
                        <td width="50%">标准输出</td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <pre style="margin:0"><?= Html::encode($model->sample_input_2) ?></pre>
                        </td>
                        <td width="50%">
                            <pre style="margin:0"><?= Html::encode($model->sample_output_2) ?></pre>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php endif; ?>
            <?php if ($model->sample_input_3 != '' || $model->sample_output_3 != ''):?>
            <table class="table table-bordered" style="table-layout:fixed;">
                <tbody>
                    <tr class="bg-tablehead" style="line-height: 1;">
                        <td width="50%">标准输入</td>
                        <td width="50%">标准输出</td>
                    </tr>
                    <tr>
                        <td>
                            <pre style="margin:0"><?= Html::encode($model->sample_input_3) ?></pre>
                        </td>
                        <td>
                            <pre style="margin:0"><?= Html::encode($model->sample_output_3) ?></pre>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php endif; ?>
        </div>


        <?php if (!empty($model->hint)): ?>
        <h5><?= Yii::t('app', 'Hint') ?></h5>
        <?= Yii::$app->formatter->asMarkdown($model->hint) ?>
        <?php endif; ?>
        <p></p>
        <?php if (Yii::$app->user->isGuest): ?>
        <?php else: ?>
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


    <div class="col-lg-4 problem-info">
        <div class="border rounded" style="padding: 1rem 1rem 0rem 1rem">

            <?php if (!empty($model->source)): ?>
            <small>
                来源 <span class="text-info font-weight-bold"><?= $model->source ?></span>.
            </small>
            <?php else: ?>
            <small>
                来源 <span class="text-info font-weight-bold">不详</span>.
            </small>
            <?php endif; ?>

            <div><small>创建于
                    <span
                        class="text-info font-weight-bold"><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></span>，最后更新于
                    <span
                        class=" text-info font-weight-bold"><?= Yii::$app->formatter->asRelativeTime($model->updated_at) ?></span>.</small>
            </div>
            <div><small>共
                    <span class="text-info font-weight-bold"><?= $model->submit ?></span> 提交，其中
                    <span class="text-info font-weight-bold"><?= $model->accepted ?></span> 通过.</small>
            </div>
            <p></p>

            <?php if (!Yii::$app->user->isGuest && !empty($submissions)): ?>
            <table class="table" style="line-height: 1;">
                <tbody>
                    <?php foreach ($submissions as $sub): ?>
                    <tr>
                        <td title="<?= $sub['created_at'] ?>">
                            <?= Yii::$app->formatter->asRelativeTime($sub['created_at']) ?>
                        </td>
                        <td>
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
                                $span = '<strong class="text-success"' . $innerHtml . '>' . Solution::getResultList($sub['result']) . '</strong>';
                                echo Html::a($span,
                                    ['/solution/source', 'id' => $sub['id']],
                                    ['onclick' => 'return false', 'data-click' => "solution_info"]
                                );
                            } else {
                                $span = '<strong class="text-danger" ' . $innerHtml . '>' . Solution::getResultList($sub['result']) . $loadingImg . '</strong>';
                                echo Html::a($span,
                                    ['/solution/result', 'id' => $sub['id']],
                                    ['onclick' => 'return false', 'data-click' => "solution_info"]
                                );
                            }
                            ?>
                        </td>
                        <td>
                            <?= Html::a('<i class="fas fa-sm fa-edit"></i>',
                                ['/solution/source', 'id' => $sub['id']],
                                ['title' => '查看源码', 'class' => 'text-dark', 'onclick' => 'return false', 'data-click' => "solution_info"]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <p></p>
        <div class="list-group" style="max-height:30rem;overflow-y: auto;">
            <?php if($previousProblemID):?>
            <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> 上一题',
                $previousProblemID ? ['/problem/view', 'id' => $previousProblemID] : 'javascript:void(0);',
                ['class' => 'list-group-item list-group-item-action']
            )?>
            <?php else:?>
            <div class="list-group-item text-secondary">已经是第一题了</div>
            <?php endif; ?>

            <?php if($nextProblemID):?>
            <?= Html::a('下一题 <span class="glyphicon glyphicon-arrow-right"></span>',
                $nextProblemID ? ['/problem/view', 'id' => $nextProblemID] : 'javascript:void(0);',
                ['class' => 'list-group-item list-group-item-action']
            )?>
            <?php else:?>
            <div class="list-group-item text-secondary">已经是最后一题了</div>
            <?php endif; ?>

        </div>
    </div>
    <?php Modal::begin([
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
    if (wait == 0) {
        submit_btn.removeAttribute("disabled");
        submit_btn.innerHTML = "<span class=\"fas fas-fw fa-paper-plane\"></span> 提交";
        wait = 5;
    } else {
        submit_btn.setAttribute("disabled", true);
        submit_btn.innerHTML = "若页面没有自动刷新, 请尝试重新提交";
        wait--;
        setTimeout(function () {
            time()
        },
            1000)
    }
}

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