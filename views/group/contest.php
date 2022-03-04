<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;
use app\models\Contest;
use yii\bootstrap4\Nav;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $contestDataProvider yii\data\ActiveDataProvider */
/* @var $userDataProvider yii\data\ActiveDataProvider */
/* @var $newContest app\models\Contest */
/* @var $newGroupUser app\models\GroupUser */

$this->title = $model->name;


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
    <?= $form->field($newContest, 'ext_link')->textInput()->hint("填写 URL。从比赛列表访问此比赛将重定向至此链接。
    站外链接请带上 https:// 开头。填写此项将使本比赛的问题列表、答疑、榜单公告等功能失效。") ?>
    <?= $form->field($newContest, 'invite_code')->textInput()->hint("需同时填写站外比赛一栏，届时邀请码将马上在前台（比赛列表）展示，适合指引用户参加 vjudge 私有比赛等场景；
    如果站外比赛一栏留空，邀请码将不会发挥作用。") ?>
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
    ])->hint("封榜仅对 ICPC 或作业有效，请不要在其它赛制启用，否则可能出现未知行为。如果不需要封榜请留空，当前会在比赛结束{$scoreboardFrozenTime}小时后才会自动在前台页面解除封榜限制。
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
        'rowOptions' => ['class' => ' animate__animated animate__fadeIn animate__faster'],
        'options' => ['class' => 'table-responsive'],
        'columns' => [
            [
                'attribute' => 'title',
                'value' => function ($model, $key, $index, $column) {
                    
                    $base_title = Html::a(Html::encode($model->title), ['/contest/view', 'id' => $key], ['class' => 'text-dark']);

                    if ($model->ext_link) {
                        if ($model->invite_code) {
                            return $base_title . '<span class="problem-list-tags"><span class="badge badge-secondary"><code class="text-white">' . $model->invite_code . '</code>' . '<i class="fas fa-sm fa-lock" style="margin-left:4px"></i></span> <span class="badge badge-warning"> 重定向 <i class="fas fa-sm fa-rocket"></i>' . '</span></span>';
                        }
                        return $base_title . '<span class="problem-list-tags badge badge-warning"> 重定向 <i class="fas fa-sm fa-rocket"></i>' . '</span>';
                    }

                    $stat = "";

                    if (!Yii::$app->user->isGuest && $model->isUserInContest()) {
                        $stat = '<span class="badge badge-success">参赛 <i class="fas fa-sm fa-check"></i></span> ';
                    }

                    $people_cnt = Html::a($model->getContestUserCount() . ' <i class="fas fa-sm fa-user"></i>', ['/contest/user', 'id' => $model->id], ['class' => 'badge badge-info']);

                    return $base_title . '<span class="problem-list-tags">' . $stat . $people_cnt . '</span>';
                },
                'format' => 'raw',
                'enableSorting' => false,
                'options' => ['style' => 'min-width:400px;'],
            ],
            [
                'attribute' => 'status',
                'value' => function ($model, $key, $index, $column) {
                    return $model->getRunStatus(true);
                },
                'format' => 'raw',
                'options' => ['style' => 'width:100px;min-width:100px;'],
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
                    if (strtotime($model->end_time) >= Contest::TIME_INFINIFY) {
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