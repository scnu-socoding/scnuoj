<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap4\Nav;
use yii\helpers\Html;

$model = $this->params['model'];
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<?php if (Yii::$app->user->identity->isAdmin()) : ?>
    <?= Nav::widget([
        'options' => ['class' => 'nav nav-pills'],
        'items' => [
            ['label' => Yii::t('app', 'Home'), 'url' => ['/admin/default/index']],
            ['label' => Yii::t('app', 'News'), 'url' => ['/admin/news/index']],
            ['label' => Yii::t('app', 'Problem'), 'url' => ['/admin/problem/index']],
            ['label' => Yii::t('app', 'User'), 'url' => ['/admin/user/index']],
            ['label' => Yii::t('app', 'Contest'), 'url' => ['/admin/contest/index']],
            ['label' => Yii::t('app', 'Rejudge'), 'url' => ['/admin/rejudge/index']],
            ['label' => Yii::t('app', 'Setting'), 'url' => ['/admin/setting/index']],
            ['label' => 'OJ ' . Yii::t('app', 'Update'), 'url' => ['/admin/update/index']]
        ],
    ]) ?>
    <p></p>
<?php endif; ?>
<div class="row">
    <div class="col">

        <div class="problem-header">
            <p class="lead"><?= Html::a("<i class=\"fas fa-fw fa-chevron-left\"></i>", ['index']) ?> 设置题目《<?= Html::encode($model->title) ?>》题面与数据信息。</p>
            <?= \yii\bootstrap4\Nav::widget([
                'options' => ['class' => 'nav nav-pills'],
                'items' => [
                    ['label' => Yii::t('app', 'Preview'), 'url' => ['/admin/problem/view', 'id' => $model->id]],
                    ['label' => Yii::t('app', 'Edit'), 'url' => ['/admin/problem/update', 'id' => $model->id]],
                    ['label' => '题解', 'url' => ['/admin/problem/solution', 'id' => $model->id]],
                    ['label' => Yii::t('app', 'Tests Data'), 'url' => ['/admin/problem/test-data', 'id' => $model->id]],
                    ['label' => Yii::t('app', 'Verify Data'), 'url' => ['/admin/problem/verify', 'id' => $model->id]],
                    ['label' => Yii::t('app', 'SPJ'), 'url' => ['/admin/problem/spj', 'id' => $model->id], 'visible' => $model->spj],
                    ['label' => Yii::t('app', 'Subtask'), 'url' => ['/admin/problem/subtask', 'id' => $model->id], 'visible' => Yii::$app->setting->get('oiMode')]
                ],
            ]) ?>
        </div>
        <p></p>
        <?= $content ?>
    </div>
</div>
<?php $this->endContent(); ?>
<script type="text/javascript">
    $(document).ready(function() {
        // 连接服务端
        var socket = io(document.location.protocol + '//' + document.domain + ':2120');
        var uid = <?= Yii::$app->user->isGuest ? session_id() : Yii::$app->user->id ?>;
        // 连接后登录
        socket.on('connect', function() {
            socket.emit('login', uid);
        });
        // 后端推送来消息时
        socket.on('msg', function(msg) {
            alert(msg);
        });
    })
</script>