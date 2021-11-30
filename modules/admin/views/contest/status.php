<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $searchModel app\models\SolutionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $data array */

$this->title = $model->title;
$this->params['model'] = $model;
$problems = $model->problems;
$problems_size = sizeof($problems);

$nav = [];
$nav[''] = 'All';

foreach ($problems as $key => $p) {
    $nav[$p['problem_id']] = ($problems_size > 26)
        ? ('P' . str_pad($key + 1, 2, '0', STR_PAD_LEFT))
        : chr(65 + $key);

    $nav[$p['problem_id']] .=  '. ' . $p['title'];
}
?>
<div class="container">
    <?= Html::beginForm(
        ['/admin/contest/status', 'id' => $model->id],
        'get',
        ['class' => 'toggle-auto-refresh']
    ); ?>
    <span class="float-right">
        <label>
            <?= Html::checkbox('autoRefresh', $autoRefresh) ?>
            自动刷新当前页面
        </label>
    </span>
    <?= Html::endForm(); ?>
    <p class="lead">
        查看比赛 <?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?> 提交信息。
    </p>
    <div class="btn-group btn-block">
        <?php Modal::begin([
            'title' => '更改前台可见性',
            'size' => Modal::SIZE_LARGE,
            'toggleButton' => ['label' => '前台可见性', 'class' => 'btn btn-outline-primary'],
        ]); ?>
        <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 公开提交将同步提交数据到公共题库状态页，允许任何用户查看代码及出错数据等信息。</div>
        <div class="alert alert-danger"><i class="fas fa-fw fa-info-circle"></i> 比赛期间设置公开提交将导致不可预知的后果，请在比赛结束后再根据需要开放。</div>
        <div class="btn-block btn-group">
            <?= Html::a('设为公开', ['/admin/contest/status', 'id' => $model->id, 'active' => 1], ['class' => 'btn btn-info']) ?>
            <?= Html::a('设为隐藏', ['/admin/contest/status', 'id' => $model->id, 'active' => 2], ['class' => 'btn btn-primary']) ?>
        </div>
        <?php Modal::end(); ?>

        <?= Html::a(
            '导出提交',
            ['/admin/contest/download-solution', 'id' => $model->id],
            ['class' => 'btn btn-outline-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => '下载比赛期间正确解答的代码，可用于查重']
        ); ?>
    </div>

    <p></p>

    <div class="solution-index">
        <?= $this->render('_status_search', ['model' => $searchModel, 'nav' => $nav, 'contest_id' => $model->id]); ?>

        <?= GridView::widget([
            'layout' => '{items}{pager}',
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'table-responsive'],
            'tableOptions' => ['class' => 'table'],
            'columns' => [
                [
                    'attribute' => 'id',
                    'value' => function ($model, $key, $index, $column) {
                        return Html::a($model->id, ['/solution/detail', 'id' => $model->id], ['target' => '_blank', 'class' => 'text-dark']);
                    },
                    'format' => 'raw',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'min-width:90px;']
                ],
                [
                    'attribute' => 'who',
                    'value' => function ($model, $key, $index, $column) {
                        return Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->created_by], ['class' => 'text-dark']);
                    },
                    'format' => 'raw',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'min-width:150px;']
                ],
                [
                    'label' => Yii::t('app', 'Problem'),
                    'value' => function ($model, $key, $index, $column) use ($problems_size) {
                        $res = $model->getProblemInContest();
                        if (!isset($model->problem)) {
                            return null;
                        }
                        if (!isset($res->num)) {
                            return $model->problem->title;
                        } else {
                            $cur_id = ($problems_size > 26)
                                ? ('P' . str_pad($res->num + 1, 2, '0', STR_PAD_LEFT))
                                : chr(65 + $res->num);
                        }
                        return Html::a(
                            $cur_id . ' - ' . $model->problem->title,
                            ['/contest/problem', 'id' => $res->contest_id, 'pid' => $res->num],
                            ['class' => 'text-dark']
                        );
                    },
                    'format' => 'raw',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'min-width:200px;']
                ],
                [
                    'attribute' => 'result',
                    'value' => function ($model, $key, $index, $column) {
                        return $model->getResult();
                    },
                    'format' => 'raw',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'min-width:90px;']
                ],
                [
                    'attribute' => 'score',
                    'visible' => Yii::$app->setting->get('oiMode'),
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'min-width:90px;']
                ],
                [
                    'attribute' => 'time',
                    'value' => function ($model, $key, $index, $column) {
                        return $model->time . ' MS';
                    },
                    'format' => 'raw',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'min-width:90px;']
                ],
                [
                    'attribute' => 'memory',
                    'value' => function ($model, $key, $index, $column) {
                        return $model->memory . ' KB';
                    },
                    'format' => 'raw',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'min-width:90px;']
                ],
                [
                    'attribute' => 'language',
                    'value' => function ($model, $key, $index, $column) {
                        return Html::a(
                            $model->getLang(),
                            ['/solution/source', 'id' => $model->id],
                            ['onclick' => 'return false', 'data-click' => "solution_info", 'class' => 'text-dark']
                        );
                    },
                    'format' => 'raw',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'min-width:90px;']
                ],
                [
                    'attribute' => 'code_length',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'min-width:90px;']
                ],
                [
                    'attribute' => 'created_at',
                    'value' => function ($model, $key, $index, $column) {
                        return Html::tag('span', Yii::$app->formatter->asRelativeTime($model->created_at), ['title' => $model->created_at]);
                    },
                    'format' => 'raw',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'min-width:90px;']
                ]
            ],
            'pager' => [
                'linkOptions' => ['class' => 'page-link'],
            ]
        ]); ?>
    </div>
    <?php
    $url = \yii\helpers\Url::toRoute(['/solution/verdict']);
    $loadingImgUrl = Yii::getAlias('@web/images/loading.gif');
    $js = <<<EOF
$('[data-toggle="tooltip"]').tooltip();
$(".toggle-auto-refresh input[name='autoRefresh']").change(function () {
    $(".toggle-auto-refresh").submit();
});
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
    var testWaitingsDone = function () {
        var waitingCount = $("strong[waiting=true]").length;
        console.log("There is waitingCount=" + waitingCount + ", starting submissionsEventCatcher...");
        $("strong[waiting=true]").each(function(){
            updateVerdictByKey($(this));
        });
        if (interval && waitingCount === 0) {
            console.log("Stopping submissionsEventCatcher.");
            clearInterval(interval);
            interval = null;
        }
    }
    interval = setInterval(testWaitingsDone, 1000);
}
EOF;

    // 自动刷新
    if ($autoRefresh) {
        $js .= 'setTimeout(function(){ location.reload() }, 2000);'; //指定2秒刷新一次
    }
    $this->registerJs($js);
    ?>

</div>


<?php Modal::begin([
    'title' => '<h3>' . Yii::t('app', 'Information') . '</h3>',
    'options' => ['id' => 'solution-info']
]); ?>
<div id="solution-content">
</div>
<?php Modal::end(); ?>