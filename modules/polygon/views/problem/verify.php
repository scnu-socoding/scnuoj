<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Solution;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\polygon\models\Problem */
/* @var $solution \app\modules\polygon\models\PolygonStatus */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['model'] = $model;
$solution->language = Yii::$app->user->identity->language;
?>

<?= GridView::widget([
    'layout' => '{items}{pager}',
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table'],
    'options' => ['class' => 'table-responsive solution-index'],
    'columns' => [
        [
            'attribute' => 'id',
            'label' => '运行 ID',
            'value' => function ($solution, $key, $index, $column) use ($model) {
                return Html::a($solution->id, [
                    '/polygon/problem/solution-detail',
                    'id' => $model->id,
                    'sid' => $solution->id
                ], ['target' => '_blank']);
            },
            'format' => 'raw',
            'enableSorting' => false,
        ],
        [
            'attribute' => 'who',
            'label' => '作者',
            'value' => function ($model, $key, $index, $column) {
                return Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->created_by]);
            },
            'format' => 'raw'
        ],
        [
            'attribute' => 'result',
            'value' => function ($model, $key, $index, $column) {
                return $model->getResult();
            },
            'format' => 'raw',
            'enableSorting' => false,
        ],
        [
            'attribute' => 'language',
            'value' => function ($solution, $key, $index, $column) use ($model) {
                return $solution->getLang();
            },
            'format' => 'raw',
            'enableSorting' => false,
        ],
        [
            'attribute' => 'time',
            'value' => function ($model, $key, $index, $column) {
                return $model->time . ' MS';
            },
            'format' => 'raw',
            'enableSorting' => false,
        ],
        [
            'attribute' => 'memory',
            'value' => function ($model, $key, $index, $column) {
                return $model->memory . ' KB';
            },
            'format' => 'raw',
            'enableSorting' => false,
        ],
        [
            'attribute' => 'created_at',
            'value' => function ($model, $key, $index, $column) {
                return Html::tag('span', Yii::$app->formatter->asRelativeTime($model->created_at), ['title' => $model->created_at]);
            },
            'format' => 'raw',
            'enableSorting' => false,
        ]
    ],
    'pager' => [
        'linkOptions' => ['class' => 'page-link'],
    ]
]); ?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($solution, 'language', [
    'template' => "{input}",
])->dropDownList($solution::getLanguageList(), ['class' => 'form-control custom-select selectpicker']) ?>

<?= $form->field($solution, 'source', [
    'template' => "{input}",
])->widget('app\widgets\codemirror\CodeMirror'); ?>


<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success btn-block']) ?>
</div>
<?php ActiveForm::end(); ?>