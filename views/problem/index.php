<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use justinvoelker\tagging\TaggingWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProblemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $solvedProblem array */

$this->title = Yii::t('app', 'Problems');
?>
<div class="row">
    

    <div class="col-md-9">
        <?= GridView::widget([
            'layout' => '{items}{pager}',
            'dataProvider' => $dataProvider,
            // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
            'tableOptions' => ['class' => 'table'],
            'options' => ['class' => 'table-responsive problem-index-list'],
            'columns' => [
                [
                    'attribute' => 'id',
                    'value' => function ($model, $key, $index, $column) use ($solvedProblem) {
                        $solve = '';
                        if (isset($solvedProblem[$model->id])) {
                            return $solve . Html::a($model->id, ['/problem/view', 'id' => $key], ['class' => 'btn-sm btn-success']);
                        }
                        return $solve . Html::a($model->id, ['/problem/view', 'id' => $key], ['class' => 'btn-sm btn-secondary']);
                    },
                    'format' => 'raw',
                    // 'options' => ['width' => '100px'],
                    'enableSorting' => false
                ],
                [
                    'attribute' => 'title',
                    'value' => function ($model, $key, $index, $column) {
                        $res = Html::a(Html::encode($model->title), ['/problem/view', 'id' => $key], ['class' => 'text-dark']);
                        $tags = !empty($model->tags) ? explode(',', $model->tags) : [];
                        $tagsCount = count($tags);
                        if ($tagsCount > 0) {
                            $res .= '<span class="problem-list-tags">';
                            foreach((array)$tags as $tag) {
                                $res .= Html::a(Html::encode($tag), [
                                    '/problem/index', 'tag' => $tag
                                ], ['class' => 'btn-sm btn-secondary']);
                                $res .= ' ';
                            }
                            $res .= '</span>';
                        }
                        return $res;
                    },
                    'format' => 'raw',
                    'enableSorting' => false
                ],
                [
                    'attribute' => 'solved',
                    'value' => function ($model, $key, $index, $column) use ($solvedProblem) {
                        return Html::a($model->accepted, [
                            '/solution/index',
                            'SolutionSearch[problem_id]' => $model->id,
                            'SolutionSearch[result]' => 4
                        ], ['class' => 'text-dark'], ['data-pjax' => 0]);
                    },
                    'format' => 'raw',
                    // 'options' => ['width' => '100px'],
                    'enableSorting' => false
                ]
            ],
            'pager' => [
                'linkOptions' => ['class' => 'page-link text-dark'],
            ]
        ]); ?>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <?= Html::beginForm('', 'post', ['class' => 'form-inline']) ?>
                <div class="input-group">
                    <?= Html::label(Yii::t('app', 'Search'), 'q', ['class' => 'sr-only']) ?>
                    <?= Html::textInput('q', '', ['class' => 'form-control', 'placeholder' => '输入 ID 或标题或来源']) ?>
                    <!-- <span class="input-group-btn">
                    <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn btn-default']) ?>
                    </span> -->
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
        <br />
        <div class="card">
            <div class="card-header"><?= Yii::t('app', 'Tags') ?></div>
            <div class="card-body">
                 <?= TaggingWidget::widget([
                    'items' => $tags,
                    'url' => ['/problem/index'],
                    'format' => 'ul',
                    'urlParam' => 'tag',
                    'listOptions' => ['style' => 'padding-left:0;'],
                    'liOptions' => ['style' => 'list-style-type: none; display: inline-block;'],
                    'linkOptions' => ['class' => 'btn-sm btn-secondary']
                ]) ?> 
            </div>
        </div>
    </div>
</div>
