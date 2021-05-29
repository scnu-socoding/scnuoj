<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Solution */

$this->title = $model->id;

if (!$model->canViewSource()) {
    return '暂无权限查看源码';
}
?>
<div class="solution-view">

    <?php if (!Yii::$app->setting->get('isContestMode') || (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin())) : ?>
        <div class="list-group">
            <?= Html::a(
                '运行 ID ' . $model->id . '<span class="float-right">提交于 ' . $model->created_at . '</span>',
                ['/solution/detail', 'id' => $model->id],
                ['class' => 'list-group-item list-group-item-action']
            ) ?>
        </div>
        <p></p>
        <pre><code class="pre"><p style="font-size:1rem"><?= Html::encode($model->source) ?></p></code></pre>
    <?php else : ?>
        <?php if ($model->result == 11) : ?>
            <div class="list-group animate__animated animate__fadeIn animate__faster">
                <div class="list-group-item">
                    <pre id="run-info"><?= Html::encode($model->solutionInfo->run_info) ?></pre>
                </div>
            </div>
        <?php else : ?>
            <div class="alert alert-light animate__animated animate__fadeIn animate__faster">
                <i class="fas fa-fw fa-info-circle"></i>
                本提交仍在排队等候评测或编译没有出现错误，暂无评测详情可用。</b>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            $('.pre p').each(function(i, block) { // use <pre><p>
                hljs.highlightBlock(block);
            });
        })
    })(jQuery);
</script>