<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;
use app\models\Contest;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $generatorForm app\modules\admin\models\GenerateUserForm */

$this->title = $model->title;
$contest_id = $model->id;
?>
<p class="lead">管理比赛 <?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?> 打星用户。</p>

<?php Modal::begin([
    'title' => '添加打星用户',
    'toggleButton' => ['label' => Yii::t('app', '添加打星用户'), 'class' => 'btn btn-outline-primary btn-block'],
    'size' => Modal::SIZE_LARGE
]);?>
<?= Html::beginForm(['contest/star', 'id' => $model->id]) ?>
<div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 在这里填写用户名，必须是已经注册本比赛的用户。一个名字占据一行，请自行删除多余的空行。</div>
    <div class="form-group">
        <?= Html::textarea('user', '',['class' => 'form-control', 'rows' => 10]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success btn-block']) ?>
    </div>
    <?= Html::endForm(); ?>
<?php Modal::end(); ?>

<p></p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => '{items}{pager}',
    'options' => ['class' => 'table-responsive'],
    'tableOptions' => ['class' => 'table table-bordered'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => Yii::t('app', 'Username'),
            'value' => function ($model, $key, $index, $column) {
                return Html::a($model->user->username, ['/user/view', 'id' => $model->user->id]);
            },
            'format' => 'raw'
        ],
        [
            'attribute' => Yii::t('app', 'Nickname'),
            'value' => function ($model, $key, $index, $column) {
                return Html::a($model->user->nickname, ['/user/view', 'id' => $model->user->id]);
            },
            'format' => 'raw'
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $key) use ($contest_id) {
                    $options = [
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'Delete'),
                        'data-confirm' => '取消打星？',
                        'data-method' => 'post',
                    ];
                    return Html::a('<span class="fas fas-fw fa-trash text-dark"></span>', Url::toRoute(['contest/star', 'id' => $contest_id, 'uid' => $model->user->id]), $options);
                },
            ]
        ],
    ],
]); ?>
