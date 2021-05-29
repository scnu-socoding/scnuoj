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
    <div class="list-group">
        <?= Html::a(
            '运行 ID ' . $model->id . '<span class="float-right">提交于 ' . $model->created_at . '</span>',
            ['/solution/detail', 'id' => $model->id],
            ['class' => 'list-group-item list-group-item-action']
        ) ?>
    </div>
    <p></p>
    <?php if (!Yii::$app->setting->get('isContestMode') || (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin())) : ?>

        <pre><code class="pre"><p style="font-size:1rem"><?= Html::encode($model->source) ?></p></code></pre>
    <?php else : ?>
        <div class="alert alert-light animate__animated animate__fadeIn animate__faster">
            <i class="fas fa-fw fa-info-circle"></i>
            你没有权限查看提交详情，<b>对于编译错误的提交可以点击上方按钮查看编译信息。</b>
        </div>
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