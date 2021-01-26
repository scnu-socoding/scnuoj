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
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contests'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
?>
<h3><?= Html::encode($model->title) . ' - 打星用户设置'?></h3>

<?php Modal::begin([
    'title' => '<h2>设置打星</h2>',
    'toggleButton' => ['label' => Yii::t('app', '添加打星用户'), 'class' => 'btn btn-success'],
]);?>
<?= Html::beginForm(['contest/star', 'id' => $model->id]) ?>
    <?php if ($model->scenario == Contest::SCENARIO_OFFLINE): ?>
        <p class="text-muted">当前比赛为线下赛，在此添加的账号在榜单排名上会被打星，不参与榜单排名</p>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::label(Yii::t('app', 'User'), 'user') ?>
        <?= Html::textarea('user', '',['class' => 'form-control', 'rows' => 10]) ?>
        <p class="hint-block">请把要打星用户的用户名复制到此处，必须是已经注册本比赛的用户，否则设置无效，一个名字占据一行，请自行删除多余的空行。</p>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm(); ?>
<?php Modal::end(); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
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
                    return Html::a('<span class="fas fas-fw fa-trash"></span>', Url::toRoute(['contest/star', 'id' => $contest_id, 'uid' => $model->user->id]), $options);
                },
            ]
        ],
    ],
]); ?>
