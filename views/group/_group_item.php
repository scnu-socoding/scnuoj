<?php

use yii\helpers\Html;
?>
<?php if ($model['id'] != 1): ?>
<div class="card" style="border-color:#4582ec;">
    <div class="card-body">
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
<?php else:?>
    <div class="card" style="border-color:goldenrod;">
    <div class="card-body">
        <h5 style="margin-bottom: 0.25rem;">
            <?= Html::a(Html::encode($model['name']), ['/group/view', 'id' => $model['id']], ['style' => 'color:goldenrod;']) ?>
        </h5>
        <?php if ($model['description']) : ?>
            <small>
                <?= Html::encode($model['description']) ?>
            </small>
        <?php endif; ?>
    </div>
</div>
<?php endif;?>