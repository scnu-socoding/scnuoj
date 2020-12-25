<?php

use yii\helpers\Html;
use yii\grid\GridView;
use justinvoelker\tagging\TaggingWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProblemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $solvedProblem array */

$this->title = Yii::t('app', 'Problems');
?>
<div class="row">


    <div class="col-lg-9 col-md-8">
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
                    'options' => ['style' => 'min-width:100px;'],
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
                    // 'options' => ['width' => '100px'],
                    'enableSorting' => false,
                    'options' => ['style' => 'min-width:100px;'],
                ]
            ],
            'pager' => [
                'linkOptions' => ['class' => 'page-link text-dark'],
                'maxButtonCount' => 5,
            ]
        ]); ?>
        <p></p>
    </div>
    <div class="col-lg-3 col-md-4">
        <div class="card">
            <div class="card-body">
                <?= Html::beginForm('', 'post') ?>
                <div class="input-group">
                    <!-- <?= Html::label(Yii::t('app', 'Search'), 'q', ['class' => 'sr-only']) ?> -->
                    <?= Html::textInput('q', '', ['class' => 'form-control', 'placeholder' => '输入 ID 或标题或来源']) ?>
                    <span class="input-group-append">
                        <?= Html::submitButton('<i class="fas fa-fw fa-search"></i>', ['class' => 'btn btn-secondary']) ?>
                    </span>
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
                    'liOptions' => ['style' => 'list-style-type: none; display: inline-block; margin-bottom:0.35rem,padding-top: 0.2rem;padding-bottom: 0.2rem;'],
                    'linkOptions' => ['class' => 'btn btn-sm btn-secondary']
                ]) ?>
            </div>
        </div>
        <p>
            
        </p>
        <?php if ((Yii::$app->setting->get('isDiscuss')) && (!empty($discusses))): ?>
        <ol class="list-group">
            <li class="list-group-item text-center"><i class="fas fa-fw fa-comment"></i>最近讨论</li>

            <?php foreach ($discusses as $discuss): ?>
            <?= Html::a(Html::encode($discuss['title']) . '<br /><small>' . Html::encode($discuss['nickname']) . ' ' . Yii::$app->formatter->asRelativeTime($discuss['created_at']) . ' ' . Html::encode($discuss['ptitle']) . '</small>', ['/discuss/view', 'id' => $discuss['id']], ['class' => 'list-group-item list-group-item-action']) ?>
            <?php endforeach; ?>
        </ol>
        <?php endif; ?>
    </div>
</div>