<?php

use yii\helpers\Html;
?>
<div class="card">
    <div class="card-body" style="padding: 1rem;">
        <h5 style="margin-bottom: 0.25rem;">
            <?= Html::a(Html::encode($model['name']), ['/group/view', 'id' => $model['id']]) ?>
        </h5>
        <?php if ($model['description']) : ?>
            <small>
                <?= Html::encode($model['description']) ?>
            </small>
        <?php endif; ?>
    </div>
</div>