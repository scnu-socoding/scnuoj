<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProblemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Problems');
?>
<div class="problem-index">
    <p class="lead">创建、导入和管理题目数据。</p>
    <div class=" d-none d-md-block">
        <div class="btn-group btn-block">
            <?= Html::a('创建', ['create'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Polygon', ['create-from-polygon'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('HUSTOJ', ['import'], ['class' => 'btn btn-outline-primary']) ?>
            <?php if (Yii::$app->user->identity->isAdmin()) : ?>
                <a id="available" class="btn btn-outline-success" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="更改勾选项状态：任何用户均能在前台看见题目">
                    公开
                </a>
                <a id="reserved" class="btn btn-outline-success" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="更改勾选项状态：题目只能在后台查看">
                    隐藏
                </a>
                <a id="private" class="btn btn-outline-success" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="更改勾选项状态：前台题目列表会出现题目标题，但只有VIP用户才能查看题目信息">
                    私有
                </a>
                <a id="delete" class="btn btn-outline-danger" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="更改勾选项状态：不可恢复">
                    删除
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="d-md-none">
        <div class="btn-group btn-block">
            <?= Html::a('创建', ['create'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Polygon', ['create-from-polygon'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('HUSTOJ', ['import'], ['class' => 'btn btn-outline-primary']) ?>
        </div>
        <p></p>
        <div class="btn-group btn-block">
            <?php if (Yii::$app->user->identity->isAdmin()) : ?>
                <a id="available" class="btn btn-outline-success" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="更改勾选项状态：任何用户均能在前台看见题目">
                    可见
                </a>
                <a id="reserved" class="btn btn-outline-success" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="更改勾选项状态：题目只能在后台查看">
                    隐藏
                </a>
                <a id="private" class="btn btn-outline-success" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="更改勾选项状态：前台题目列表会出现题目标题，但只有VIP用户才能查看题目信息">
                    私有
                </a>
                <a id="delete" class="btn btn-outline-danger" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="更改勾选项状态：不可恢复">
                    删除
                </a>
            <?php endif; ?>
        </div>
    </div>
    <p></p>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}{pager}',
        'options' => ['class' => 'table-responsive'],
        'tableOptions' => ['class' => 'table table-bordered'],
        'options' => ['id' => 'grid'],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'id',
                'visible' => Yii::$app->user->identity->isAdmin()
            ],
            [
                'attribute' => 'id',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->id, ['problem/view', 'id' => $key]);
                },
                'format' => 'raw',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'title',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->title), ['problem/view', 'id' => $key]);
                },
                'format' => 'raw',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'status',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->status == \app\models\Problem::STATUS_VISIBLE) {
                        return Yii::t('app', 'Visible');
                    } else if ($model->status == \app\models\Problem::STATUS_HIDDEN) {
                        return Yii::t('app', 'Hidden');
                    } else {
                        return Yii::t('app', 'Private');
                    }
                },
                'format' => 'raw',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'created_by',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->user) {
                        return Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->user->id]);
                    }
                    return '';
                },
                'format' => 'raw',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'polygon_id',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->polygon_problem_id, ['/polygon/problem/view', 'id' => $model->polygon_problem_id]);
                },
                'format' => 'raw',
                'enableSorting' => false,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
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
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'class' => 'text-dark'
                        ];
                        return Html::a('<span class="fas fa-sm fa-trash"></span>', $url, $options);
                    }
                ],
                'visible' => Yii::$app->user->identity->isAdmin()
            ]
        ],
    ]);
    $this->registerJs('
    $(function () {
      $(\'[data-toggle="tooltip"]\').tooltip()
    })
    $("#available").on("click", function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        $.post({
           url: "' . \yii\helpers\Url::to(['/admin/problem/index', 'action' => \app\models\Problem::STATUS_VISIBLE]) . '", 
           dataType: \'json\',
           data: {keylist: keys}
        });
    });
    $("#reserved").on("click", function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        $.post({
           url: "' . \yii\helpers\Url::to(['/admin/problem/index', 'action' => \app\models\Problem::STATUS_HIDDEN]) . '", 
           dataType: \'json\',
           data: {keylist: keys}
        });
    });
    $("#private").on("click", function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        $.post({
           url: "' . \yii\helpers\Url::to(['/admin/problem/index', 'action' => \app\models\Problem::STATUS_PRIVATE]) . '", 
           dataType: \'json\',
           data: {keylist: keys}
        });
    });
    $("#delete").on("click", function () {
        if (confirm("确定要删除？此操作不可恢复！")) {
            var keys = $("#grid").yiiGridView("getSelectedRows");
            $.post({
               url: "' . \yii\helpers\Url::to(['/admin/problem/index', 'action' => 'delete']) . '", 
               dataType: \'json\',
               data: {keylist: keys}
            });
        }
    });
    ');
    ?>
</div>