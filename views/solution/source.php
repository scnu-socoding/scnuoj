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
    <pre><code class="pre"><p style="font-size:1rem"><?= Html::encode($model->source) ?></p></code></pre>
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