<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Nav;
use app\models\Contest;
use app\models\Homework;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Homework */

$this->title = Html::encode($model->title);
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => Yii::$app->user->isGuest ? ['/group/index'] : ['/group/my-group']];
// $this->params['breadcrumbs'][] = ['label' => Html::encode($model->group->name), 'url' => ['/group/view', 'id' => $model->group->id]];
// $this->params['breadcrumbs'][] = ['label' => Html::encode($model->title), 'url' => ['/contest/view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = Yii::t('app', 'Setting');
$this->params['model'] = $model;
$problems = $model->problems;
$scoreboardFrozenTime = Yii::$app->setting->get('scoreboardFrozenTime') / 3600;
?>

<div>

    <p class="lead">更新比赛 <?= Html::a(Html::encode($model->title), ['/contest/view', 'id' => $model->id]) ?> 信息。</p>

    <?= Html::a('删除该比赛', ['/homework/delete', 'id' => $model->id], [
        'class' => 'btn btn-outline-danger btn-block',
        'data-confirm' => '此操作不可恢复，你确定要删除吗？',
        'data-method' => 'post',
    ]) ?>

    <?php $form = ActiveForm::begin(); ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 比赛名称应该包含年份、序号、是否重现赛等信息。</div>
    <?= $form->field($model, 'title', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">标题</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput(['maxlength' => true])->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 按需填写。以 <code>https://</code> 开头。从比赛列表访问此比赛将重定向至此链接。填写此项将使本比赛的问题列表、答疑、榜单公告等功能失效。</div>
    <?= $form->field($model, 'ext_link', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">站外比赛链接</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput()->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 按需填写。若同时填写站外比赛一栏，邀请码将马上在前台（比赛列表）展示，适合指引用户参加 vjudge 私有比赛等场景；
        如果站外比赛一栏留空，邀请码将被用作普通的比赛密码使用，即不在前台展示，对于非小组比赛，用户需要填写与此相同的邀请码才可注册参赛，适合线下赛等场景（赛后无需邀请码即可看题交题）。</div>
    <?= $form->field($model, 'invite_code', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">邀请码</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->textInput()->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 如需启用永久题目集，结束时间设置为 9999 年任意一天即可，直接按格式填写日期，选单是选不了这个日期的。</div>

    <?= $form->field($model, 'start_time', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">开始时间</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->widget('app\widgets\laydate\LayDate', [
        'clientOptions' => [
            'istoday' => true,
            'type' => 'datetime'
        ]
    ])->label(false) ?>
    <p></p>

    <?= $form->field($model, 'end_time', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">结束时间</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->widget('app\widgets\laydate\LayDate', [
        'clientOptions' => [
            'istoday' => true,
            'type' => 'datetime'
        ]
    ])->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 封榜仅对 ICPC 或作业有效，请不要在其它赛制启用，否则可能出现未知行为。如果不需要封榜请留空，当前会在比赛结束 <?= $scoreboardFrozenTime ?> 小时后才会自动在前台页面解除封榜限制。如需提前结束封榜也可选择清空该表单项。使用封榜功能，后台管理界面的比赛榜单仍然处于实时榜单。</div>

    <?= $form->field($model, 'lock_board_time', [
        'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">封榜时间</span></div>{input}</div>",
        'options' => ['class' => '']
    ])->widget('app\widgets\laydate\LayDate', [
        'clientOptions' => [
            'istoday' => true,
            'type' => 'datetime'
        ]
    ])->label(false) ?>
    <p></p>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 比赛描述，此部分内容在比赛开始前就会公开展示。</div>

    <?= $form->field($model, 'description')->widget('app\widgets\editormd\Editormd')->label(false); ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 题解内容在比赛结束后，才会出现在前台的比赛页面中供用户查看。</div>

    <?= $form->field($model, 'editorial')->widget('app\widgets\editormd\Editormd')->label(false); ?>

    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 不同类型的区别只在于榜单的排名方式。详见 <?= Html::a('比赛类型', ['/wiki/contest'], ['target' => '_blank']) ?>。如需使用 OI 或 IOI 比赛，请在后台设置页面启用 OI 模式，判题机启动时带上 <code>-o</code> 参数。</div>

    <?= $form->field($model, 'type')->radioList([
        Contest::TYPE_RANK_GROUP => Yii::t('app', 'ICPC'),
        Contest::TYPE_HOMEWORK => Yii::t('app', 'Homework'),
        Contest::TYPE_OI => Yii::t('app', 'OI'),
        Contest::TYPE_IOI => Yii::t('app', 'IOI'),
    ])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <p>
        <span class="lead"><?= Yii::t('app', 'Announcements') ?></span>
        <?php Modal::begin([
            'title' => Yii::t('app', 'Make an announcement'),
            'toggleButton' => ['tag' => 'a', 'label' => Yii::t('app', 'Create'), 'class' => ''],
            'size' => Modal::SIZE_LARGE
        ]); ?>
        <?php $form = ActiveForm::begin(); ?>
    <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 公告内容一经发布不可撤回不可编辑，请慎重填写。必要时还可使用可编辑的 <?= Html::a('全局公告', ['/admin/setting']) ?>。</div>
    <?= $form->field($newAnnouncement, 'content')->textarea(['rows' => 6])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success btn-block']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <?php Modal::end(); ?>
    </p>

    <div>
        <?= GridView::widget([
            'dataProvider' => $announcements,
            'layout' => '{items}{pager}',
            'options' => ['class' => 'table-responsive'],
            'tableOptions' => ['class' => 'table table-bordered'],
            'columns' => [
                [
                    'attribute' => 'content',
                    'enableSorting' => false,
                    'headerOptions' => ['style' => 'min-width:300px;']
                ],
                [
                    'attribute' => 'created_at',
                    'enableSorting' => false,
                    'value' => function ($model, $key, $index, $column) {
                        return Html::tag('span', Yii::$app->formatter->asRelativeTime($model->created_at), ['title' => $model->created_at]);
                    },
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'min-width:90px;']
                ]
            ],
        ]) ?>
    </div>
    <p class="lead"><?= Yii::t('app', 'Problems') ?></p>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="70px">#</th>
                    <th width="120px">Problem ID</th>
                    <th><?= Yii::t('app', 'Problem Name') ?></th>
                    <th width="80px"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($problems as $key => $p) : ?>
                    <tr>
                        <td><?= Html::a(chr(65 + $key), ['view', 'id' => $model->id, 'action' => 'problem', 'problem_id' => $key]) ?></td>
                        <td><?= Html::a($p['problem_id'], '') ?></td>
                        <td><?= Html::a(Html::encode($p['title']), ['view', 'id' => $model->id, 'action' => 'problem', 'problem_id' => $key]) ?></td>
                        <td>
                            <!-- <?php Modal::begin([
                                        'title' => Yii::t('app', 'Modify') . ' ' . chr(65 + $key) . ' 题题目编号',
                                        'size' => Modal::SIZE_LARGE,
                                        'toggleButton' => ['tag' => 'a', 'label' => '<i class="fas fa-sm fa-pen"></i>', 'class' => 'text-dark'],
                                    ]); ?>

                            <?= Html::beginForm(['/homework/updateproblem', 'id' => $model->id]) ?>

                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">原题目编号</span></div>
                                <?= Html::textInput('problem_id', $p['problem_id'], ['class' => 'form-control', 'readonly' => 1]) ?>
                            </div>
                            <p></p>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">新题目编号</span></div>
                                <?= Html::textInput('new_problem_id', $p['problem_id'], ['class' => 'form-control']) ?>
                            </div>
                            <p></p>

                            <div class="form-group">
                                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success btn-block']) ?>
                            </div>
                            <?= Html::endForm(); ?> -->

                            <?php Modal::end(); ?>
                            <?= Html::a('<i class="fas fa-sm fa-trash"></i>', [
                                'deleteproblem',
                                'id' => $model->id,
                                'pid' => $p['problem_id']
                            ], [
                                'class' => 'text-dark',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <?php Modal::begin([
                            'title' => Yii::t('app', 'Add a problem'),
                            'size' => Modal::SIZE_LARGE,
                            'toggleButton' => ['tag' => 'a', 'label' => Yii::t('app', 'Add a problem'), 'class' => 'text-success'],
                        ]); ?>

                        <?= Html::beginForm(['/homework/addproblem', 'id' => $model->id]) ?>

                        <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 如果有几个题目，可以用空格或逗号键分开；如果有连续多个题目，可以用 1001-1005 这样的格式。</div>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">题目编号</span></div>
                            <?= Html::textInput('problem_id', '', ['class' => 'form-control']) ?>
                        </div>
                        <p></p>
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success btn-block']) ?>
                        </div>
                        <?= Html::endForm(); ?>

                        <?php Modal::end(); ?>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

</div>