<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;
use app\models\GroupUser;
use app\models\Contest;
use yii\bootstrap4\Nav;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $contestDataProvider yii\data\ActiveDataProvider */
/* @var $userDataProvider yii\data\ActiveDataProvider */
/* @var $newContest app\models\Contest */
/* @var $newGroupUser app\models\GroupUser */

$this->title = $model->name;

// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => Yii::$app->user->isGuest ? ['/group/index'] : ['/group/my-group']];
// $this->params['breadcrumbs'][] = $this->title;


$scoreboardFrozenTime = Yii::$app->setting->get('scoreboardFrozenTime') / 3600;
?>

<h3><?= Html::encode($this->title) ?></h3>

<?php
$menuItems = [
    [
        'label' => Yii::t('app', 'Information'),
        'url' => ['group/view', 'id' => $model->id],
    ],
    [
        'label' => Yii::t('app', 'Contest'),
        'url' => ['group/contest', 'id' => $model->id],
    ],
    [
        'label' => Yii::t('app', 'Member'),
        'url' => ['group/member', 'id' => $model->id],
    ]
];
echo Nav::widget([
    'items' => $menuItems,
    'options' => ['class' => 'nav nav-pills hidden-print'],
    'encodeLabels' => false
]) ?>
<p></p>
<?php if ($model->hasPermission()) : ?>
    <?php Modal::begin([
        'title' => Yii::t('app', 'Create'),
        'toggleButton' => [
            'label' => Yii::t('app', 'Create'),
            'tag' => 'a',
            'class' => 'btn btn-block btn-outline-primary'
        ],
        'size' => Modal::SIZE_LARGE
    ]); ?>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($newContest, 'title')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
    <?= $form->field($newContest, 'ext_link')->textInput() ?>
    <?= $form->field($newContest, 'invite_code')->textInput() ?>
    <?= $form->field($newContest, 'start_time')->widget('app\widgets\laydate\LayDate', [
        'clientOptions' => [
            'istoday' => true,
            'type' => 'datetime'
        ],
        'options' => ['autocomplete' => 'off']
    ]) ?>
    <?= $form->field($newContest, 'end_time')->widget('app\widgets\laydate\LayDate', [
        'clientOptions' => [
            'istoday' => true,
            'type' => 'datetime'
        ],
        'options' => ['autocomplete' => 'off']
    ]) ?>

    <?= $form->field($newContest, 'lock_board_time')->widget('app\widgets\laydate\LayDate', [
        'clientOptions' => [
            'istoday' => true,
            'type' => 'datetime'
        ]
    ])->hint("封榜仅对 ICPC 或作业有效。如果不需要封榜请留空，当前会在比赛结束{$scoreboardFrozenTime}小时后才会自动在前台页面解除封榜限制。
    如需提前结束封榜也可选择清空该表单项。
    ") ?>

    <?= $form->field($newContest, 'type')->radioList([
        // Contest::TYPE_RANK_SINGLE => Yii::t('app', 'Single Ranked'),
        Contest::TYPE_RANK_GROUP => Yii::t('app', 'ICPC'),
        Contest::TYPE_HOMEWORK => Yii::t('app', 'Homework'),
        Contest::TYPE_OI => Yii::t('app', 'OI'),
        Contest::TYPE_IOI => Yii::t('app', 'IOI'),
    ])->hint('不同类型的区别只在于榜单的排名方式。') ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary btn-block']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <?php Modal::end(); ?>
    <p></p>
<?php endif; ?>

<div class="contest-index">

    <?= GridView::widget([
        'layout' => '{items}{pager}',
        'dataProvider' => $contestDataProvider,
        // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'tableOptions' => ['class' => 'table'],
        'options' => ['class' => 'table-responsive'],
        'columns' => [
            [
                'attribute' => 'title',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->ext_link) {
                        if ($model->invite_code) {
                            return Html::a(Html::encode($model->title), ['/contest/view', 'id' => $key], ['class' => 'text-dark']) . '<span class="problem-list-tags"><span class="badge badge-secondary"><code class="text-white">' . $model->invite_code . '</code>' . '</span> <span class="badge badge-warning"> 站外 <i class="fas fa-sm fa-rocket"></i>' . '</span></span>';
                        }
                        return Html::a(Html::encode($model->title), ['/contest/view', 'id' => $key], ['class' => 'text-dark']) . '<span class="problem-list-tags badge badge-warning"> 站外 <i class="fas fa-sm fa-rocket"></i>' . '</span>';
                    }
                    return Html::a(Html::encode($model->title), ['/contest/view', 'id' => $key], ['class' => 'text-dark']) . '<span class="problem-list-tags">' . Html::a($model->getContestUserCount() . ' <i class="fas fa-sm fa-user"></i>', ['/contest/user', 'id' => $model->id], ['class' => 'badge badge-info']) . '</span>';
                },
                'format' => 'raw',
                'enableSorting' => false,
                'options' => ['style' => 'min-width:350px;'],
            ],
            [
                'attribute' => 'status',
                'value' => function ($model, $key, $index, $column) {
                    $link = Html::a(Yii::t('app', 'Register »'), ['/contest/register', 'id' => $model->id]);
                    if (!Yii::$app->user->isGuest && $model->isUserInContest()) {
                        $link = '<span class="well-done">' . Yii::t('app', 'Registration completed') . '</span>';
                    }
                    if (
                        $model->status == Contest::STATUS_VISIBLE &&
                        !$model->isContestEnd() &&
                        $model->scenario == Contest::SCENARIO_ONLINE
                    ) {
                        $column = $model->getRunStatus(true) . ' ' . $link;
                    } else {
                        $column = $model->getRunStatus(true);
                    }
                    $userCount = $model->getContestUserCount();
                    return $column;
                    // return $column . ' ' . Html::a(' <span class="glyphicon glyphicon-user"></span>x'. $userCount, ['/contest/user', 'id' => $model->id]);
                },
                'format' => 'raw',
                'options' => ['style' => 'width:150px;min-width:150px;'],
                'enableSorting' => false
            ],
            [
                'attribute' => 'start_time',
                'options' => ['style' => 'width:180px;min-width:180px;'],
                'enableSorting' => false
            ],
            [
                'attribute' => 'end_time',
                'value' => function ($model, $key, $index, $column) {
                    if (strtotime($model->end_time) >= 253370736000) {
                        $column = "一直开放";
                    } else {
                        $column = $model->end_time;
                    }
                    return $column;
                },
                'options' => ['style' => 'width:180px;min-width:180px;'],
                'enableSorting' => false
            ],
            [
                'attribute' => Yii::t('app', 'Update'),
                'value' => function ($model, $key, $index, $column) {
                    return Html::a('<i class="fas fa-sm fa-pen"></i>', ['/homework/update', 'id' => $key], ['class' => 'text-dark']);
                },
                'format' => 'raw',
                'visible' => $model->hasPermission()
            ],
        ],
        'pager' => [
            'linkOptions' => ['class' => 'page-link'],
            'maxButtonCount' => 5,
        ]
    ]); ?>

</div>

<?php
$js = <<<EOF
$('[data-click=user-manager]').click(function() {
    $.ajax({
        url: $(this).attr('href'),
        type:'post',
        error: function(){alert('error');},
        success:function(html){
        $('#solution-content').html(html);
        $('#solution-info').modal('show');
    }
    });
});
EOF;
$this->registerJs($js);
?>
<?php Modal::begin([
    'options' => ['id' => 'solution-info']
]); ?>
<div id="solution-content">
</div>
<?php Modal::end(); ?>