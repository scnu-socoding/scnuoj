<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
use app\models\Contest;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $newAnnouncement app\models\ContestAnnouncement */
/* @var $announcements yii\data\ActiveDataProvider */

$this->title = $model->title;
// $this->params['breadcrumbs'][]][] = ['label' => Yii::t('app', 'Contests'), 'url' => ['index']];
// $this->params['breadcrumbs'][]][] = $this->title;

$problems = $model->problems;
?>
<div>

    <p class="lead">设置比赛 <?= Html::encode($model->title) ?>。</p>
    <div class="d-none d-lg-block">
        <div class="btn-block btn-group">
            <?= Html::a('选手', ['register', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('题册', ['print', 'id' => $model->id], ['class' => 'btn btn-outline-primary', 'target' => '_blank']) ?>
            <?= Html::a('题解', ['editorial', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('打印', ['/print', 'id' => $model->id], ['class' => 'btn btn-outline-info', 'target' => '_blank']) ?>
            <?= Html::a('答疑', ['clarify', 'id' => $model->id], ['class' => 'btn btn-outline-info', 'target' => '_blank']) ?>
            <?= Html::a('提交', ['status', 'id' => $model->id], ['class' => 'btn btn-outline-info', 'target' => '_blank']) ?>
            <?= Html::a('外榜', ['/contest/standing2', 'id' => $model->id], ['class' => 'btn btn-outline-info', 'target' => '_blank']) ?>
            <?= Html::a('终榜', ['rank', 'id' => $model->id], ['class' => 'btn btn-outline-success', 'target' => '_blank']) ?>
            <?= Html::a('积分', ['rated', 'id' => $model->id], ['class' => 'btn btn-outline-success']) ?>
            <?php Modal::begin([
                'title' => Yii::t('app', 'Scroll Scoreboard'),
                'toggleButton' => ['label' => Yii::t('app', 'Scroll Scoreboard'), 'class' => 'btn btn-outline-success'],
                'size' => Modal::SIZE_LARGE
            ]); ?>
            <?= Html::beginForm(['contest/scroll-scoreboard', 'id' => $model->id], 'get', ['target' => '_blank']) ?>
            <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 滚榜暂时只支持罚时 20 分钟的比赛，如罚时为其他值请先修改 web/js/scrollboard.js。</div>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">金牌</span></div>
                <?= Html::textInput('gold', round($model->getContestUserCount() * 0.1), ['class' => 'form-control']) ?>
            </div>
            <p></p>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">银牌</span></div>
                <?= Html::textInput('silver', round($model->getContestUserCount() * 0.2), ['class' => 'form-control']) ?>
            </div>
            <p></p>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">铜牌</span></div>
                <?= Html::textInput('bronze', round($model->getContestUserCount() * 0.3), ['class' => 'form-control']) ?>
            </div>
            <p></p>
            <?php if ($model->getRunStatus() == Contest::STATUS_ENDED) : ?>
                <div class="input-group">
                    <?= Html::submitButton(Yii::t('app', '打开滚榜页面'), ['class' => 'btn btn-success btn-block']) ?>
                </div>
            <?php else : ?>
                <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 比赛尚未结束，暂时不能滚榜。</div>
            <?php endif; ?>
            <?= Html::endForm(); ?>
            <?php Modal::end(); ?>

            <?= Html::a('删除', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?') . ' 该操作不可恢复，会删除所有与该场比赛有关的提交记录及其它信息',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>
    <div class="d-lg-none">
        <div class="btn-block btn-group">
            <?= Html::a('选手', ['register', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('题册', ['print', 'id' => $model->id], ['class' => 'btn btn-outline-primary', 'target' => '_blank']) ?>
            <?= Html::a('题解', ['editorial', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
        </div>
        <p></p>
        <div class="btn-block btn-group">
            <?= Html::a('打印', ['/print', 'id' => $model->id], ['class' => 'btn btn-outline-info', 'target' => '_blank']) ?>
            <?= Html::a('答疑', ['clarify', 'id' => $model->id], ['class' => 'btn btn-outline-info', 'target' => '_blank']) ?>
            <?= Html::a('提交', ['status', 'id' => $model->id], ['class' => 'btn btn-outline-info', 'target' => '_blank']) ?>
            <?= Html::a('外榜', ['/contest/standing2', 'id' => $model->id], ['class' => 'btn btn-outline-info', 'target' => '_blank']) ?>
        </div>
        <p></p>
        <div class="btn-block btn-group">
            <?= Html::a('终榜', ['rank', 'id' => $model->id], ['class' => 'btn btn-outline-success', 'target' => '_blank']) ?>
            <?= Html::a('积分', ['rated', 'id' => $model->id], ['class' => 'btn btn-outline-success']) ?>
            <?php Modal::begin([
                'title' => Yii::t('app', 'Scroll Scoreboard'),
                'toggleButton' => ['label' => Yii::t('app', 'Scroll Scoreboard'), 'class' => 'btn btn-outline-success'],
                'size' => Modal::SIZE_LARGE
            ]); ?>
            <?= Html::beginForm(['contest/scroll-scoreboard', 'id' => $model->id], 'get', ['target' => '_blank']) ?>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">金牌</span></div>
                <?= Html::textInput('gold', round($model->getContestUserCount() * 0.1), ['class' => 'form-control']) ?>
            </div>
            <p></p>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">银牌</span></div>
                <?= Html::textInput('silver', round($model->getContestUserCount() * 0.2), ['class' => 'form-control']) ?>
            </div>
            <p></p>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">铜牌</span></div>
                <?= Html::textInput('bronze', round($model->getContestUserCount() * 0.3), ['class' => 'form-control']) ?>
            </div>
            <p></p>
            <?php if ($model->getRunStatus() == Contest::STATUS_ENDED) : ?>
                <div class="input-group">
                    <?= Html::submitButton(Yii::t('app', '打开滚榜页面'), ['class' => 'btn btn-success btn-block']) ?>
                </div>
            <?php else : ?>
                <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 比赛尚未结束，暂时不能滚榜。</div>
            <?php endif; ?>
            <?= Html::endForm(); ?>
            <?php Modal::end(); ?>

            <?= Html::a('删除', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?') . ' 该操作不可恢复，会删除所有与该场比赛有关的提交记录及其它信息',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>
    <p></p>
    <p>
        <span class="lead"><?= Yii::t('app', 'Information') ?></span>
        <?= Html::a(Yii::t('app', 'Edit'), ['update', 'id' => $model->id]) ?>
    </p>
    <div class="table-responsive">
        <?= DetailView::widget([
            'model' => $model,
            'template' => '<tr><th class="bg-tablehead" style="width:120px;">{label}</th><td style="min-width:300px;">{value}</td></tr>',
            'options' => ['id' => 'grid', 'class' => 'table table-bordered'],
            'attributes' => [
                'id',
                'title',
                'start_time',
                'end_time',
                'lock_board_time',
                'description:html',
                'punish_time',
            ],
        ]) ?>
    </div>

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


    <div class="row">
        <div class="col">
            <span class="lead"><?= Yii::t('app', 'Problems') ?></span>

            <?php Modal::begin([
                'title' => Yii::t('app', '设置题目来源'),
                'toggleButton' => ['tag' => 'a', 'label' => '设置题目来源', 'class' => ''],
                'size' => Modal::SIZE_LARGE
            ]); ?>
            <?= Html::beginForm(['contest/set-problem-source', 'id' => $model->id]) ?>

            <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 设置题目来源有利于在首页题库中根据题目来源来搜索题目。此操作会修改题目的来源信息。</div>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">来源</span></div>
                <?= Html::textInput('source', $model->title, ['class' => 'form-control']) ?>
            </div>
            <p></p>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success btn-block']) ?>
            </div>
            <?= Html::endForm(); ?>
            <?php Modal::end(); ?>

            <?php Modal::begin([
                'title' => Yii::t('app', '设置题目前台可见性'),
                'toggleButton' => ['tag' => 'a', 'label' => '设置题目前台可见性', 'class' => ''],
                'size' => Modal::SIZE_LARGE
            ]); ?>
            <?= Html::beginForm(['contest/set-problem-status', 'id' => $model->id]) ?>
            <div class="form-group">
                <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 将本场比赛目前添加的所有题目在前台设为隐藏或可见。</div>
                <label class="radio-inline">
                    <input type="radio" name="status" value="<?= \app\models\Problem::STATUS_VISIBLE ?>">
                    <?= Yii::t('app', 'Visible') ?>
                </label>
                <label class="radio-inline">
                    <input type="radio" name="status" value="<?= \app\models\Problem::STATUS_HIDDEN ?>">
                    <?= Yii::t('app', 'Hidden') ?>
                </label>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success btn-block']) ?>
            </div>
            <?= Html::endForm(); ?>
            <?php Modal::end(); ?>
        </div>
    </div>
    <p></p>
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
                        <td><?= Html::a(chr(65 + $key), ['/admin/problem/view', 'id' => $p['problem_id']]) ?></td>
                        <td><?= Html::a($p['problem_id'], ['/admin/problem/view', 'id' => $p['problem_id']]) ?></td>
                        <td><?= Html::a(Html::encode($p['title']), ['/admin/problem/view', 'id' => $p['problem_id']]) ?></td>
                        <td>
                            <!-- <?php Modal::begin([
                                'title' => Yii::t('app', 'Modify') . ' ' . chr(65 + $key) . ' 题题目编号',
                                'size' => Modal::SIZE_LARGE,
                                'toggleButton' => ['tag' => 'a', 'label' => '<i class="fas fa-sm fa-pen"></i>', 'class' => 'text-dark'],
                            ]); ?>

                            <?= Html::beginForm(['contest/updateproblem', 'id' => $model->id]) ?>

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

                        <?= Html::beginForm(['contest/addproblem', 'id' => $model->id]) ?>

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
<?php Modal::begin([
    'title' => '<h3>' . Yii::t('app', 'Information') . '</h3>',
    'options' => ['id' => 'modal-info'],
    'size' => Modal::SIZE_LARGE
]); ?>
<div id="modal-content">
</div>
<?php Modal::end(); ?>
<?php
$js = "
$('[data-click=modal]').click(function() {
    $.ajax({
        url: $(this).attr('href'),
        type:'post',
        error: function(){alert('error');},
        success:function(html){
            $('#modal-content').html(html);
            $('#modal-info').modal('show');
        }
    });
});
";
$this->registerJs($js);
?>