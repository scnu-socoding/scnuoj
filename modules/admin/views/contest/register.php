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
<p class="lead">管理比赛 <?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) ?> 参赛用户。</p>

<div class="btn-group btn-block">

    <?= Html::a('打星', ['contest/star', 'id' => $model->id], ['class' => 'btn btn-outline-primary', 'target' => '_blank']) ?>

    <?php Modal::begin([
        'title' => Yii::t('app', 'Add participating user'),
        'toggleButton' => ['label' => '添加', 'class' => 'btn btn-outline-primary'],
        'size' => Modal::SIZE_LARGE
    ]); ?>
    <?= Html::beginForm(['contest/register', 'id' => $model->id]) ?>
    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 请把要参赛用户的用户名复制到此处，一个名字占据一行，请自行删除多余的空行。</div>
    <div class="form-group">
        <?= Html::textarea('user', '', ['class' => 'form-control', 'rows' => 10]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success btn-block']) ?>
    </div>
    <?= Html::endForm(); ?>
    <?php Modal::end(); ?>

    <?php Modal::begin([
        'title' => Yii::t('app', 'Generate user for the contest'),
        'toggleButton' => ['label' => '生成', 'class' => 'btn btn-outline-success'],
        'size' => Modal::SIZE_LARGE
    ]); ?>
    <div class="alert alert-danger"><i class="fas fa-fw fa-info-circle"></i> 重复使用此功能会删除已生成的帐号，请勿在分发账号后进行此操作。</div>
    <?php $form = ActiveForm::begin(); ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 前缀不应更改，不同比赛的前缀都不一样，是为了可以一直保留比赛榜单。</div>

    <?= $form->field($generatorForm, 'prefix', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">前缀</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput([
        'maxlength' => true, 'value' => 'c' . $model->id . 'user', 'disabled' => true
    ])->label(false) ?>
    <p></p>

    <?= $form->field($generatorForm, 'team_number', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">数量</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput(['maxlength' => true, 'value' => '50'])->label(false) ?>
    <p></p>
    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 请把所有队伍名称复制到此处，一个名字占据一行，请自行删除多余的空行。</div>

    <?= $form->field($generatorForm, 'names')->textarea(['rows' => 10])->label(false)  ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Generate'), ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Modal::end(); ?>
    <?= Html::a('导出', ['contest/printuser', 'id' => $model->id], ['class' => 'btn btn-outline-success', 'target' => '_blank']) ?>
</div>
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
                return Html::a(Html::encode($model->user->username), ['/user/view', 'id' => $model->user->id]);
            },
            'format' => 'raw'
        ],
        [
            'attribute' => Yii::t('app', 'Nickname'),
            'value' => function ($model, $key, $index, $column) {
                return Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->user->id]);
            },
            'format' => 'raw'
        ],
        [
            'attribute' => 'user_password',
            'value' => function ($contestUser, $key, $index, $column) use ($model) {
                // if ($model->scenario == Contest::SCENARIO_OFFLINE) {
                if ($contestUser->user_password) {
                    return Html::encode($contestUser->user_password);
                } else {
                    return "N/A";
                }
            },
            'format' => 'raw',
            'enableSorting' => false,
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $key) use ($contest_id) {
                    $options = [
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'Delete'),
                        'data-confirm' => '删除该项，也会删除该用户在此比赛中的提交记录，确定删除？',
                        'data-method' => 'post',
                    ];
                    return Html::a('<span class="fas fas-fw fa-trash text-dark"></span>', Url::toRoute(['contest/register', 'id' => $contest_id, 'uid' => $model->user->id]), $options);
                },
            ]
        ],
    ],
]); ?>