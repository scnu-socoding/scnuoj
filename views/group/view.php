<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;
use app\models\GroupUser;
use app\models\Contest;
use yii\bootstrap4\Nav;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $contestDataProvider yii\data\ActiveDataProvider */
/* @var $userDataProvider yii\data\ActiveDataProvider */
/* @var $newContest app\models\Contest */
/* @var $newGroupUser app\models\GroupUser */

$this->title = $model->name;

$scoreboardFrozenTime = Yii::$app->setting->get('scoreboardFrozenTime') / 3600;
?>


<h3><?= Html::encode($this->title) ?></h3>

<?php
$menuItems = [
    [
        'label' => Yii::t('app', 'Information'),
        'url' => ['group/view', 'id' => $model->id],
    ],
    [
        'label' => Yii::t('app', 'Contest'),
        'url' => ['group/contest', 'id' => $model->id],
    ],
    [
        'label' => Yii::t('app', 'Member'),
        'url' => ['group/member', 'id' => $model->id],
    ]
];
echo Nav::widget([
    'items' => $menuItems,
    'options' => ['class' => 'nav nav-pills hidden-print'],
    'encodeLabels' => false
]) ?>
<p></p>




<div class="row animate__animated animate__fadeIn animate__faster">



    <div class="col-lg-8">
        <?php if ($model->description != '') : ?>
            <div class="alert alert-light">
                <i class="fas fa-fw fa-info-circle"></i>
                <?= $model->description ?>
            </div>
            <p></p>
        <?php endif; ?>
        <div class="card">
            <?php if ($model->kanban != '') : ?>
                <div class="card-body" style="padding-bottom: 0.25rem;">
                    <?= Yii::$app->formatter->asMarkdown($model->kanban) ?>
                </div>
            <?php else : ?>
                <div class="card-body text-secondary">
                    暂时没有新的消息哦。
                </div>
            <?php endif; ?>

        </div>
        <p></p>
    </div>
    <div class="col-lg-4">
        <div class="list-group">
            <div class="list-group-item"><?= Yii::t('app', 'Join Policy') ?><span class="float-right text-secondary"><?= $model->getJoinPolicy() ?></span></div>
            <div class="list-group-item"><?= Yii::t('app', 'Status') ?><span class="float-right text-secondary"><?= $model->getStatus() ?></span></div>
        </div>
        <?php if (!Yii::$app->user->isGuest && ($model->role == GroupUser::ROLE_LEADER || Yii::$app->user->identity->isAdmin())) : ?>
            <p></p>
            <?= Html::a(Yii::t('app', 'Setting'), ['/group/update', 'id' => $model->id], ['class' => 'btn btn-outline-primary btn-block']) ?>

        <?php endif; ?>
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