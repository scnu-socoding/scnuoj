<?php

use yii\helpers\Html;
use yii\grid\GridView;
use justinvoelker\tagging\TaggingWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProblemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $solvedProblem array */

$this->title = Yii::t('app', 'Problems');

$js = <<<EOT
$(".toggle-show-contest-standing input[name='showTags']").change(function () {
    $(".toggle-show-contest-standing").submit();
});
EOT;
$this->registerJs($js);
?>



<?= Html::beginForm('/problem/index', 'get') ?>

<div class="row">
    <div class="input-group">
        <div class="col-lg-6" style="margin-bottom: 1rem;">
            <?= Html::textInput('q', $q, ['class' => 'form-control', 'placeholder' => '题号 / 标题 / 来源']) ?>
        </div>

        <div class="col-lg-6" style="margin-bottom: 1rem;">
            <div class="btn-group btn-block search-submit">
                <?= Html::submitButton('<i class="fas fa-fw fa-search"></i> 搜索', ['class' => 'btn btn-primary']) ?>
                <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#myModal"><i class="fas fa-fw fa-tags"></i> 标签</button>
                <?= Html::a('<i class="fas fa-fw fa-globe"></i>&nbsp;出题', ['/polygon'], ['class' => 'btn btn-outline-primary'])
                ?>
            </div>
        </div>
    </div>
</div>
<?= Html::endForm() ?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:800px!important">
        <div class="modal-content">
            <div class="modal-header">
                标签
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            </div>
            <div class="modal-body">

                <?= Html::beginForm('', 'post') ?>
                <div class="input-group">
                    <?= Html::textInput('q', '', ['class' => 'form-control', 'placeholder' => '题号 / 标题 / 来源']) ?>
                    <span class="input-group-append">
                        <?= Html::submitButton('<i class="fas fa-fw fa-search"></i>', ['class' => 'btn btn-primary']) ?>

                    </span>
                </div>

                <p></p>
                <?= Html::endForm() ?>
                <?= TaggingWidget::widget([
                    'items' => $tags,
                    'url' => ['/problem/index'],
                    'format' => 'ul',
                    'urlParam' => 'tag',
                    'listOptions' => ['style' => 'padding-left:0;'],
                    'liOptions' => ['style' => 'list-style-type: none; display: inline-block; margin-bottom:0.35rem,padding-top: 0.2rem;padding-bottom: 0.2rem;'],
                    'linkOptions' => ['class' => 'badge badge-warning']
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php
$title_str = Html::beginForm(['/problem/index', 'page' => $page, 'tag' => $tag], 'get', ['class' => 'toggle-show-contest-standing pull-left']);
$title_str .= '标题 <span class="float-right">';
$title_str .= Html::checkbox('showTags', $showTags, ['style' => 'vertical-align:middle;']);
$title_str .= ' 显示标签</span>';
$title_str .= Html::endForm();
$title_str .= '';

?>

<div class="row">
    <div class="col">

        <?= GridView::widget([
            'layout' => '{items}{pager}',
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table'],
            'options' => ['class' => 'table-responsive problem-index-list'],
            'rowOptions' => ['class' => ' animate__animated animate__fadeIn animate__faster'],
            'columns' => [
                [
                    'attribute' => 'id',
                    'value' => function ($model, $key, $index, $column) use ($solvedProblem) {
                        $solve = '';
                        if (isset($solvedProblem[$model->id])) {
                            return $solve . Html::a($model->id, ['/problem/view', 'id' => $key], ['class' => 'badge badge-success']);
                        }
                        return $solve . Html::a($model->id, ['/problem/view', 'id' => $key], ['class' => 'badge badge-secondary']);
                    },
                    'format' => 'raw',
                    'options' => ['style' => 'width:100px;min-width:100px;'],
                    // 'options' => ['width' => '100px'],
                    'enableSorting' => false
                ],
                [
                    'attribute' => 'title',
                    'header' => $title_str,
                    'value' => function ($model, $key, $index, $column) use ($showTags) {
                        $res = Html::a(Html::encode($model->title), ['/problem/view', 'id' => $key], ['class' => 'text-dark']);
                        $tags = !empty($model->tags) ? explode(',', $model->tags) : [];
                        $tagsCount = count($tags);
                        if ($showTags && $tagsCount > 0) {
                            $res .= '<span class="problem-list-tags">';
                            foreach ((array)$tags as $tag) {
                                $res .= Html::a(Html::encode($tag), [
                                    '/problem/index', 'tag' => $tag
                                ], ['class' => 'badge badge-warning']);
                                $res .= ' ';
                            }
                            $res .= '</span>';
                        }
                        return $res;
                    },
                    'format' => 'raw',
                    'enableSorting' => false,
                    'options' => ['style' => 'min-width:300px;'],
                ],
                [
                    'attribute' => 'solved',
                    'value' => function ($model, $key, $index, $column) use ($solvedProblem) {
                        return Html::a($model->accepted, [
                            '/solution/index',
                            'SolutionSearch[problem_id]' => $model->id,
                            'SolutionSearch[result]' => 4
                        ], ['class' => 'text-dark']);
                    },
                    'format' => 'raw',
                    'options' => ['style' => 'width:80px;min-width:80px;'],
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'submit',
                    'value' => function ($model, $key, $index, $column) use ($solvedProblem) {
                        return Html::a($model->submit, [
                            '/solution/index',
                            'SolutionSearch[problem_id]' => $model->id
                        ], ['class' => 'text-dark']);
                    },
                    'format' => 'raw',
                    'options' => ['style' => 'width:80px;min-width:80px;'],
                    'enableSorting' => false,
                ]
            ],
            'pager' => [
                'linkOptions' => ['class' => 'page-link'],
                'maxButtonCount' => 5,
            ]
        ]); ?>
        <p></p>
    </div>
</div>