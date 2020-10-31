<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
use app\models\Solution;

/* @var $this yii\web\View */
/* @var $model app\models\Problem */
/* @var $solution app\models\Solution */
/* @var $submissions array */

$this->title = $model->id . ' - ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Problems'), 'url' => ['problem/index']];
$this->params['breadcrumbs'][] = $this->title;

if (!Yii::$app->user->isGuest) {
    $solution->language = Yii::$app->user->identity->language;
}

$model->setSamples();

$loadingImgUrl = Yii::getAlias('@web/images/loading.gif');
$previousProblemID = $model->getPreviousProblemID();
$nextProblemID = $model->getNextProblemID();
?>


<div class="card bg-secondary text-white">
    <div class="card-body">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
</div>
<p></p>

<div class="row">
    
    <?php if ($this->beginCache('problem-' . $model->id)): ?>
    
    <div class="col-md-9 problem-view">
        
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= Yii::t('app', 'Description') ?></h3>
                <?= Yii::$app->formatter->asMarkdown($model->description) ?>
            </div>
        </div>
        <p></p>

        <div class="card">

            <div class="card-body">
                <h3 class="card-title"><?= Yii::t('app', 'Input') ?></h3>
                <!-- <div class="content-wrapper"> -->
                    <?= Yii::$app->formatter->asMarkdown($model->input) ?>
                <!-- </div> -->
            </div>
        </div>
        <p></p>

        <div class="card">

            <div class="card-body">
                <h3 class="card-title"><?= Yii::t('app', 'Output') ?></h3>
                <!-- <div class="content-wrapper"> -->
                    <?= Yii::$app->formatter->asMarkdown($model->output) ?>
                <!-- </div> -->
            </div>
        </div>
        
        <p></p>
        <div class="card">

            <div class="card-body">
                <h3 class="card-title"><?= Yii::t('app', 'Examples') ?></h3>
                <div class="sample-test">
                    <div class="input">
                        <h5><?= Yii::t('app', 'Input') ?> 1 </h5>
                        <pre class="list-group-item"><?= Html::encode($model->sample_input) ?></pre>
                    </div>
                    <div class="output">
                        <h5><?= Yii::t('app', 'Output') ?> 1 </h5>
                        <pre class="list-group-item"><?= Html::encode($model->sample_output) ?></pre>
                    </div>

                    <?php if ($model->sample_input_2 != '' || $model->sample_output_2 != ''):?>
                        <div class="input">
                            <h5><?= Yii::t('app', 'Input') ?> 2 </h5>
                            <pre class="list-group-item"><?= Html::encode($model->sample_input_2) ?></pre>
                        </div>
                        <div class="output">
                            <h5><?= Yii::t('app', 'Output') ?> 2 </h5>
                            <pre class="list-group-item"><?= Html::encode($model->sample_output_2) ?></pre>
                        </div>
                    <?php endif; ?>

                    <?php if ($model->sample_input_3 != '' || $model->sample_output_3 != ''):?>
                        <div class="input">
                            <h5><?= Yii::t('app', 'Input') ?> 3 </h5>
                            <pre class="list-group-item"><?= Html::encode($model->sample_input_3) ?></pre>
                        </div>
                        <div class="output">
                            <h5><?= Yii::t('app', 'Output') ?> 3 </h5>
                            <pre class="list-group-item"><?= Html::encode($model->sample_output_3) ?></pre>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>


        <?php if (!empty($model->hint)): ?>
            <p></p>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><?= Yii::t('app', 'Hint') ?></h3>
                    <!-- <div class="content-wrapper"> -->
                    <?= Yii::$app->formatter->asMarkdown($model->hint) ?>
                    <!-- </div> -->
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($model->source)): ?>
            <p></p>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><?= Yii::t('app', 'Source') ?></h3>
                    <!-- <div class="content-wrapper"> -->
                        <?= Yii::$app->formatter->asMarkdown($model->source) ?>
                    <!-- </div> -->
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php $this->endCache(); ?>
    <?php endif; ?>
    <div class="col-md-3 problem-info">
        <div class="panel panel-default">
            <!-- Table -->
            <table class="table">
                <tbody>
                <tr>
                    <td><?= Yii::t('app', 'Time Limit') ?></td>
                    <td>
                        <?= Yii::t('app', '{t, plural, =1{# second} other{# seconds}}', ['t' => intval($model->time_limit)]); ?>
                    </td>
                </tr>
                <tr>
                    <td><?= Yii::t('app', 'Memory Limit') ?></td>
                    <td><?= $model->memory_limit ?> MB</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="btn-group btn-block">
        <?php Modal::begin([
            'title' => '<h3>'.Yii::t('app','Submit') . '：' . Html::encode($model->id . '. ' . $model->title) . '</h3>',
            'size' => Modal::SIZE_LARGE,
            'toggleButton' => [
                'label' => '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Submit'),
                'class' => 'btn btn-secondary'
            ]
        ]); ?>
            <?php if (Yii::$app->user->isGuest): ?>
                <?= app\widgets\login\Login::widget(); ?>
            <?php else: ?>
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($solution, 'language')->dropDownList($solution::getLanguageList()) ?>

                <?= $form->field($solution, 'source')->widget('app\widgets\codemirror\CodeMirror'); ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-outline-secondary', 'id' => 'submit_solution_btn']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            <?php endif; ?>
        <?php Modal::end(); ?>

        <?= Html::a('<span class="glyphicon glyphicon-comment"></span> ' . Yii::t('app', 'Discuss'),
            ['/problem/discuss', 'id' => $model->id],
            ['class' => 'btn btn-outline-secondary'])
        ?>
        <?php if (!empty($model->solution)): ?>
        <?= Html::a('<span class="glyphicon glyphicon-info-sign"></span> ' . Yii::t('app', '题解'),
            ['/problem/solution', 'id' => $model->id],
            ['class' => 'btn btn-outline-secondary'])
        ?>
        <?php endif; ?>
        <?= Html::a('<span class="glyphicon glyphicon-signal"></span> ' . Yii::t('app', 'Stats'),
            ['/problem/statistics', 'id' => $model->id],
            ['class' => 'btn btn-outline-secondary']
        )?>
        </div>
        <hr />

        <div class="btn-group btn-block">
        <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> 上一题',
            $previousProblemID ? ['/problem/view', 'id' => $previousProblemID, 'view' => 'classic'] : 'javascript:void(0);',
            ['class' => 'btn btn-outline-secondary', 'disabled' => !$previousProblemID]
            // ['class' => 'btn btn-default', 'style' => 'width: 40%', 'disabled' => !$previousProblemID]
        )?>

        <?= Html::a('下一题 <span class="glyphicon glyphicon-arrow-right"></span>',
            $nextProblemID ? ['/problem/view', 'id' => $nextProblemID, 'view' => 'classic'] : 'javascript:void(0);',
            ['class' => 'btn btn-outline-secondary', 'disabled' => !$previousProblemID]
            // ['class' => 'btn btn-default', 'style' => 'width: 50%', 'disabled' => !$nextProblemID]
        )?>
        </div>

        <?php if (!Yii::$app->user->isGuest && !empty($submissions)): ?>
            <!-- <div class="panel panel-default" style="margin-top: 40px"> -->
            <p></p>
            <!-- Table -->
            <table class="table">
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
                                    ['onclick' => 'return false', 'data-click' => "solution_info", 'data-pjax' => 0]
                                );
                            } else {
                                $span = '<strong class="text-danger" ' . $innerHtml . '>' . Solution::getResultList($sub['result']) . $loadingImg . '</strong>';
                                echo Html::a($span,
                                    ['/solution/result', 'id' => $sub['id']],
                                    ['onclick' => 'return false', 'data-click' => "solution_info", 'data-pjax' => 0]
                                );
                            }
                            ?>
                        </td>
                        <td>
                            <?= Html::a('»',
                                ['/solution/source', 'id' => $sub['id']],
                                ['title' => '查看源码', 'class' => 'text-dark', 'onclick' => 'return false', 'data-click' => "solution_info", 'data-pjax' => 0]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <!-- </div> -->
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
        submit_btn.innerHTML = "提交";
        wait = 5;
    } else {
        submit_btn.setAttribute("disabled", true);
        submit_btn.innerHTML = "请等待";
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
    interval = setInterval(testWaitingsDone, 200);
}
EOF;
$this->registerJs($js);
?>
