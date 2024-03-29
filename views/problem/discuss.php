<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */
/* @var $model app\models\Problem */
/* @var $discusses app\models\Discuss */
/* @var $newDiscuss app\models\Discuss */
/* @var $pages yii\data\Pagination */

$this->title = Yii::t('app', 'Discuss');

?>
<h3><?= Html::encode($model->id . '. ' . $model->title) ?> </h3>

<ul class="nav nav-pills">
    <li class="nav-item">
        <?= Html::a(
            Yii::t('app', 'Problem'),
            ['/problem/view', 'id' => $model->id],
            ['class' => 'nav-link']
        )
        ?>
    </li>
    <?php if (Yii::$app->setting->get('isDiscuss')) : ?>
        <li class="nav-item">
            <?= Html::a(
                Yii::t('app', 'Discuss'),
                ['/problem/discuss', 'id' => $model->id],
                ['class' => 'nav-link active']
            )
            ?>
        </li>
    <?php endif; ?>
    <?php if (!empty($model->solution)) : ?>
        <li class="nav-item">
            <?= Html::a(
                Yii::t('app', 'Editorial'),
                ['/problem/solution', 'id' => $model->id],
                ['class' => 'nav-link']
            )
            ?>
        </li>
    <?php endif; ?>
</ul>
<p></p>


<?php if (!empty($discusses)) : ?>
    <div class="list-group animate__animated animate__fadeIn animate__faster">
        <?php foreach ($discusses as $discuss) : ?>
            <?= Html::a(Html::encode($discuss->title) . '<br><small>' . Html::encode($discuss->user->nickname) . ' 发表于 ' . Yii::$app->formatter->asRelativeTime($discuss->created_at) . ' · 关联问题 ' . Html::encode($model->title) . '</small>', ['/discuss/view', 'id' => $discuss->id], ['class' => 'text-dark list-group-item list-group-item-action']) ?>
        <?php endforeach; ?>
    </div>
    <p></p>
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $pages,
        'linkOptions' => ['class' => 'page-link'],
        'maxButtonCount' => 5,
    ]); ?>
    <p></p>
<?php endif; ?>

<?php if (Yii::$app->user->isGuest) : ?>
    <div class="animate__animated animate__fadeIn animate__faster">
        <div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 登录以创建新的讨论。</div>
    </div>
<?php else : ?>
    <div class="discuss-form animate__animated animate__fadeIn animate__faster">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($newDiscuss, 'title', [
            'template' => "<div class=\"input-group\"><div class=\"input-group-prepend\"><span class=\"input-group-text\">" . Yii::t('app', 'Title') . "</span></div>{input}</div>",
        ])->textInput(['maxlength' => 128, 'autocomplete' => 'off'])
        ?>

        <?= $form->field($newDiscuss, 'content', [
            'template' => "{input}",
        ])->widget('app\widgets\editormd\Editormd'); ?>

        <div class="form-group">
            <?= Html::submitButton("<span class=\"fas fas-fw fa-comment\"></span> " . Yii::t('app', 'Create'), ['class' => 'btn btn-block btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
<?php endif; ?>