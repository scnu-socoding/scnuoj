<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;
use app\models\GroupUser;
use app\models\Contest;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $contestDataProvider yii\data\ActiveDataProvider */
/* @var $userDataProvider yii\data\ActiveDataProvider */
/* @var $newContest app\models\Contest */
/* @var $newGroupUser app\models\GroupUser */

$this->title = $model->name;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => Yii::$app->user->isGuest ? ['/group/index'] : ['/group/my-group']];
$this->params['breadcrumbs'][] = $this->title;


$scoreboardFrozenTime = Yii::$app->setting->get('scoreboardFrozenTime') / 3600;
?>

<div class="card bg-secondary text-white">
    <div class="card-body">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
</div>
<p></p>

<div class="group-view">
    <div class="row">

        <div class="col-md-8 col-lg-9">
            <div class="card">
                <div class="card-body">
                    <h3 style="display: inline">
                        <?= Yii::t('app', 'Homework'); ?>
                    </h3>
                    <?php if ($model->hasPermission()): ?>
                    <?php Modal::begin([
                    'title' => '<h3>' . Yii::t('app', 'Create') . '</h3>',
                    'toggleButton' => [
                        'label' => Yii::t('app', 'Create'),
                        'tag' => 'a',
                        'class' => 'btn btn-sm btn-outline-secondary float-right'
                    ]
                ]); ?>

                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($newContest, 'title')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
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
                    ])->hint("如果不需要封榜请留空，当前会在比赛结束{$scoreboardFrozenTime}小时后才会自动在前台页面解除封榜限制。
                        如需提前结束封榜也可选择清空该表单项。
                    ") ?>

                    <?= $form->field($newContest, 'type')->radioList([
                        Contest::TYPE_RANK_SINGLE => Yii::t('app', 'Single Ranked'),
                        Contest::TYPE_RANK_GROUP => Yii::t('app', 'ICPC'),
                        Contest::TYPE_HOMEWORK => Yii::t('app', 'Homework'),
                        Contest::TYPE_OI => Yii::t('app', 'OI'),
                        Contest::TYPE_IOI => Yii::t('app', 'IOI'),
                    ])->hint('不同类型的区别只在于榜单的排名方式。详见：' . Html::a('比赛类型', ['/wiki/contest'], ['target' => '_blank'])) ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <?php Modal::end(); ?>
                    <?php endif; ?>
                </div>
            </div>
            <p></p>

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
                            return Html::a(Html::encode($model->title), ['/contest/view', 'id' => $key], ['class' => 'text-dark']) . '<span class="problem-list-tags">' . Html::a($model->getContestUserCount() . ' <i class="fas fa-sm fa-user"></i>', ['/contest/user', 'id' => $model->id], ['class' => 'btn-sm btn-secondary']) . '</span>';
                        },
                        'format' => 'raw',
                        'enableSorting' => false,
                        'options' => ['style' => 'min-width:300px'],
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function ($model, $key, $index, $column) {
                            $link = Html::a(Yii::t('app', 'Register »'), ['/contest/register', 'id' => $model->id]);
                            if (!Yii::$app->user->isGuest && $model->isUserInContest()) {
                                $link = '<span class="well-done">' . Yii::t('app', 'Registration completed') . '</span>';
                            }
                            if ($model->status == Contest::STATUS_VISIBLE &&
                                !$model->isContestEnd() &&
                                $model->scenario == Contest::SCENARIO_ONLINE) {
                                $column = $model->getRunStatus(true) . ' ' . $link;
                            } else {
                                $column = $model->getRunStatus(true);
                            }
                            $userCount = $model->getContestUserCount();
                            return $column;
                            // return $column . ' ' . Html::a(' <span class="glyphicon glyphicon-user"></span>x'. $userCount, ['/contest/user', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'options' => ['style' => 'min-width:100px'],
                        'enableSorting' => false
                    ],
                    [
                        'attribute' => 'start_time',
                        'options' => ['style' => 'min-width:180px'],
                        'enableSorting' => false
                    ],
                    [
                        'attribute' => 'end_time',
                        'options' => ['style' => 'min-width:180px'],
                        'enableSorting' => false
                    ],
                ],
                'pager' => [
                    'linkOptions' => ['class' => 'page-link text-dark'],
                    'maxButtonCount' => 5,
                ]
            ]); ?>

            <p></p>
            <div class="card">
                <div class="card-body">
                    <h3 style="display: inline">
                        <?= Yii::t('app', 'Member'); ?>
                    </h3>
                    <?php if ($model->hasPermission()): ?>
                    <?php Modal::begin([
                        'title' => '<h3>' . Yii::t('app', 'Invite Member') . '</h3>',
                        'toggleButton' => [
                            'label' => Yii::t('app', 'Invite Member'),
                            'tag' => 'a',
                            'class' => 'btn btn-sm btn-outline-secondary float-right'
                        ]
                    ]); ?>
                    <?php $form = ActiveForm::begin(); ?>
                    <p class="hint-block">1. 一个用户占据一行，每行格式为<code>username</code>。</p>
                      <p class="hint-block">2. 必须是已经注册过的用户。</p>
                      <?= $form->field($newGroupUser, 'username')->textarea(['rows' => 10]) ?>
                      <?php if (Yii::$app->setting->get('isGroupJoin')): ?>    
                        <?= $form->field($newGroupUser, 'role')->radioList(['2'=>'邀请中','4'=>'普通成员'],['value'=>[4]]) ?>
                      <?php else: ?>
                        <?= $form->field($newGroupUser, 'role')->radioList(['2'=>'邀请中'],['value'=>[2]]) ?>
                      <?php endif; ?>  
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <?php Modal::end(); ?>
                    <?php endif; ?>
                </div>
            </div>
            <p></p>
            <?= GridView::widget([
                'layout' => '{items}{pager}',
                'dataProvider' => $userDataProvider,
                // 'tableOptions' => ['class' => 'table table-striped table-bordered'],
                 'tableOptions' => ['class' => 'table'],
                'options' => ['class' => 'table-responsive'],
                'columns' => [
                    [
                        'attribute' => 'role',
                        'value' => function ($model, $key, $index, $column) {
                            return $model->getRole(true);
                        },
                        'format' => 'raw',
                        'options' => ['style' => 'min-width:100px'],
                        'enableSorting' => false
                    ],
                    [
                        'attribute' => Yii::t('app', 'Nickname'),
                        'value' => function ($model, $key, $index, $column) {
                            return Html::a(Html::encode($model->user->nickname), ['/user/view', 'id' => $model->user->id], ['class' => 'text-dark']);
                        },
                        'format' => 'raw',
                        'options' => ['style' => 'min-width:200px'],
                        'enableSorting' => false
                    ],
                    [
                        'attribute' => 'created_at',
                        'value' => function ($model, $key, $index, $column) {
                            return Yii::$app->formatter->asRelativeTime($model->created_at);
                        },
                        'options' => ['style' => 'min-width:100px'],
                        'enableSorting' => false
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{user-update} {user-delete}',
                        'buttons' => [
                            'user-update' => function ($url, $model, $key) {
                                $options = [
                                    'title' => Yii::t('yii', 'Update'),
                                    'aria-label' => Yii::t('yii', 'Update'),
                                    'onclick' => 'return false',
                                    'data-click' => "user-manager",
                                    'class' => 'text-dark'
                                ];
                                return Html::a('<i class="fas fa-sm fa-pen"></i>', $url, $options);
                            },
                            'user-delete' => function ($url, $model, $key) {
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
                        'visible' => $model->hasPermission(),
                        'options' => ['width' => '90px']
                    ]
                ],
                'pager' => [
                    'linkOptions' => ['class' => 'page-link text-dark'],
                    'maxButtonCount' => 5,
                ]
            ]); ?>

        </div>
        <div class="col-md-4 col-lg-3">
            <?php if (!Yii::$app->user->isGuest && ($model->role == GroupUser::ROLE_LEADER || Yii::$app->user->identity->isAdmin())): ?>
            <?= Html::a(Yii::t('app', 'Setting'), ['/group/update', 'id' => $model->id], ['class' => 'btn btn-outline-secondary btn-block']) ?>
            <p></p>
            <?php endif; ?>
            <div class="list-group">
                <div class="list-group-item">
                    <?= $model->description ?>
                </div>
            </div>

            <p></p>

            <div class="list-group">
                <div class="list-group-item"><?= Yii::t('app', 'Join Policy') ?><span
                        class="float-right text-secondary"><?= $model->getJoinPolicy() ?></span></div>
                <div class="list-group-item"><?= Yii::t('app', 'Status') ?><span
                        class="float-right text-secondary"><?= $model->getStatus() ?></span></div>
            </div>
        </div>
    </div>
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