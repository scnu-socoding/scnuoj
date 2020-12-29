<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap4\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SolutionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Status');
?>
<div class="solution-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'layout' => '{items}{pager}',
        'dataProvider' => $dataProvider,
        'options' => ['class' => 'table-responsive'],
        // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'tableOptions' => ['class' => 'table'],
        'columns' => [
            [
                'attribute' => 'id',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->id, ['/solution/detail', 'id' => $model->id], ['target' => '_blank', 'class' => 'text-dark']);
                },
                'format' => 'raw',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'min-width:100px;']
                
            ],
            [
                'attribute' => 'who',
                'value' => function ($model, $key, $index, $column) {
                    if (isset($model->user)) {
                        return Html::a($model->user->colorname, ['/user/view', 'id' => $model->created_by], ['class' => 'text-dark']);
                    }
                },
                'format' => 'raw',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'min-width:150px;']
            ],
            [
                'attribute' => 'problem_id',
                'value' => function ($model, $key, $index, $column) {
                    if (isset($model->problem)) {
                        return Html::a($model->problem_id . ' - ' . Html::encode($model->problem->title), ['/problem/view', 'id' => $model->problem_id], ['class' => 'text-dark']);
                    }
                },
                'format' => 'raw',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'min-width:200px;']
            ],
            [
                'attribute' => 'result',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->canViewErrorInfo()) {
                        return Html::a($model->getResult(),
                            ['/solution/result', 'id' => $model->id],
                            ['onclick' => 'return false', 'data-click' => "solution_info"]
                        );
                    } else {
                        return $model->getResult();
                    }
                },
                'format' => 'raw',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'min-width:100px;']
            ],
            [
                'attribute' => 'score',
                'visible' => Yii::$app->setting->get('oiMode'),
                'enableSorting' => false,
                'headerOptions' => ['style' => 'min-width:100px;']
            ],
            [
                'attribute' => 'time',
                'value' => function ($model, $key, $index, $column) {
                    return $model->time . ' MS';
                },
                'format' => 'raw',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'min-width:100px;']
            ],
            [
                'attribute' => 'memory',
                'value' => function ($model, $key, $index, $column) {
                    return $model->memory . ' KB';
                },
                'format' => 'raw',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'min-width:100px;']
            ],
            [
                'attribute' => 'language',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->canViewSource()) {
                        return Html::a($model->getLang(),
                            ['/solution/source', 'id' => $model->id],
                            ['onclick' => 'return false', 'data-click' => "solution_info", 'class' => 'text-dark']
                        );
                    } else {
                        return $model->getLang();
                    }
                },
                'format' => 'raw',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'min-width:100px;']
            ],
            [
                'attribute' => 'code_length',
                'format' => 'raw',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'min-width:100px;']
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model, $key, $index, $column) {
                    return Html::tag('span', Yii::$app->formatter->asRelativeTime($model->created_at), ['title' => $model->created_at]);
                },
                'format' => 'raw',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'min-width:100px;']
            ]
        ],
        'pager' => [
            'linkOptions' => ['class' => 'page-link'],
            'maxButtonCount' => 5,
        ]
    ]); ?>

<?php
$url = \yii\helpers\Url::toRoute(['/solution/verdict']);
$loadingImgUrl = Yii::getAlias('@web/images/loading.gif');
$js = <<<EOF
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

    
</div>
<?php Modal::begin([
    'options' => ['id' => 'solution-info']
]); ?>
    <div id="solution-content">
    </div>
<?php Modal::end(); ?>
