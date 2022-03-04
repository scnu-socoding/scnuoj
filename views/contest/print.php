<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $newContestPrint app\models\ContestPrint */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['model'] = $model;

?>
<div>

    <div class="alert alert-light">
    <i class="fas fa-fw fa-info-circle"></i> 如需打印代码以供队友查看，可以在此提交代码内容，工作人员打印好后会送至队伍前。
    </div>

    <?= GridView::widget([
        'layout' => '{items}{pager}',
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-bordered'],
        'columns' => [
            [
                'attribute' => 'id',
                'label' => '#',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->id, ['/print/view', 'id' => $model->id], ['target' => '_blank', 'class' => 'text-dark']);
                },
                'format' => 'raw',
                'enableSorting' => false,
                'options' => ['style' => 'width:4rem;min-width:4rem'],
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model, $key, $index, $column) {
                    return Yii::$app->formatter->asRelativeTime($model->created_at);
                },
                'enableSorting' => false,
                'options' => ['style' => 'width:7rem;min-width:7rem'],
            ],
            [
                'attribute' => 'status',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->status == \app\models\ContestPrint::STATUS_HAVE_READ) {
                        $text = '<span class="text-success"><strong>管理员已处理</strong></span>';
                    } else {
                        $text = '<span class="text-danger"><strong>请耐心等候管理员处理</strong></span>';
                    }
                    return $text;
                },
                'format' => 'raw',
                'enableSorting' => false
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'print',
                'template' => '{view} {update} {delete}',
                'options' => ['style' => 'width:5rem;min-width:5rem'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'class' => 'text-dark',
                            'target' => '_blank'
                        ];
                        return Html::a('<center><i class="fas fa-sm fa-eye"></i> 查看</center>', $url, $options);
                    },
                ]
            ],
        ],
    ]); ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($newContestPrint, 'source', [
                    'template' => "{input}",
                ])->widget('app\widgets\codemirror\CodeMirror'); ?>

    <div class="form-group">
        <?= Html::submitButton("<span class=\"fas fas-fw fa-paper-plane\"></span> " . Yii::t('app', 'Submit'), ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>