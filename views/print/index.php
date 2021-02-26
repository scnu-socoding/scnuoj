<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $contest app\models\Contest */

$this->title = 'Print Sources';
// $this->params['breadcrumbs'][] = ['label' => Html::encode($contest->title), 'url' => ['/contest/view', 'id' => $contest->id]];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="print-source-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新建', ['create', 'id' => $contest->id], ['class' => 'btn btn-success']) ?> 在此处管理比赛的待打印代码，请注意查看某份代码后将自动标记代码为已处理。
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'tableOptions' => ['class' => 'table'],
        'columns' => [
            [
                'attribute' => 'id',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->id, ['/print/view', 'id' => $model->id], ['target' => '_blank']);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'who',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->user->username) . ' [' . Html::encode($model->user->nickname ?? '临时用户') . ']', ['/user/view', 'id' => $model->user->id]);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'status',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->status == \app\models\ContestPrint::STATUS_HAVE_READ) {
                        $text = '<p class="text-success"><strong>' . Yii::t('app', 'Already processed') . '</strong></p>';
                    } else {
                        $text = '<p class="text-danger"><strong>' . Yii::t('app', 'Not processed yet') . '</strong></p>';
                    }
                    return Html::a($text, ['/print/view', 'id' => $model->id]);
                },
                'format' => 'raw'
            ],
            'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'print',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'class' => 'text-dark'
                        ];
                        return Html::a('<i class="fas fa-sm fa-eye"></i>', $url, $options);
                    },
                    'update' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'class' => 'text-dark'
                        ];
                        return Html::a('<i class="fas fa-sm fa-pen"></i>', $url, $options);
                    },
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', '【注意】你正在删除选手提交打印的代码，查看过的代码会自动更新状态，因此【非必须情况，请不要删除】。删除前请确认你已经打印了此份代码。'),
                            'data-method' => 'post',
                            'class' => 'text-dark'
                        ];
                        return Html::a('<span class="fas fa-sm fa-trash"></span>', $url, $options);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
