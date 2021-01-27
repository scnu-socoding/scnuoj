<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\UserSearch */

$this->title = Yii::t('app', 'Users');
?>
<div>

    <p class="lead">管理用户信息和权限。</p>

    <div class="btn-block btn-group">
        <?php Modal::begin([
            'title' => Yii::t('app', '批量创建用户'),
            'toggleButton' => ['label' => Yii::t('app', '创建'), 'class' => 'btn btn-outline-primary'],
            'size' => Modal::SIZE_LARGE
        ]); ?>
        <?php $form = ActiveForm::begin(['options' => ['target' => '_blank']]); ?>

    <div class="alert alert-light">1. 格式一: 每个用户一行，格式为 <code>username password</code>。<br>
        2. 格式二: 每个用户一行，格式为 <code>username nickname password</code>。<br>
        3. 用户名只能以数字、字母、下划线，且非纯数字，长度在 4 - 32 位之间。<br>
        4. 密码至少六位。</div>

        <?= $form->field($generatorForm, 'names')->textarea(['rows' => 10])  ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Generate'), ['class' => 'btn btn-success btn-block']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <?php Modal::end(); ?>

        <a id="general-user" class="btn btn-outline-success" href="javascript:void(0);">
            普通用户
        </a>
        <a id="vip-user" class="btn btn-outline-success" href="javascript:void(0);">
            助教
        </a>
        <a id="admin-user" class="btn btn-outline-success" href="javascript:void(0);">
            管理员
        </a>
    </div>
    <p></p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['id' => 'grid', 'class' => 'table-responsive'],
        'layout' => '{items}{pager}',
        'tableOptions' => ['class' => 'table table-bordered'],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'id',
            ],
            [
                'attribute' => 'id',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($key), ['user/view', 'id' => $key]);
                },
                'format' => 'raw',
                'enableSorting' => false,
            ],
            [
                'attribute' =>  'username',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->username), ['user/view', 'id' => $key]);
                },
                'format' => 'raw',
                'enableSorting' => false,
            ],
            [
                'attribute' =>  'nickname',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->nickname), ['user/view', 'id' => $key]);
                },
                'format' => 'raw',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'email',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'role',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->role == \app\models\User::ROLE_PLAYER) {
                        return '参赛用户';
                    } else if ($model->role == \app\models\User::ROLE_USER) {
                        return '普通用户';
                    } else if ($model->role == \app\models\User::ROLE_VIP) {
                        return '助教';
                    } else if ($model->role == \app\models\User::ROLE_ADMIN) {
                        return '管理员';
                    }
                    return '(未设置)';
                },
                'format' => 'raw',
                'enableSorting' => false,
            ],
            // 'status',
            // 'created_at',
            // 'updated_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'class' => 'text-dark'
                        ];
                        return Html::a('<i class="fas fa-sm fa-eye"></i>', $url, $options);
                    },
                    'update' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'class' => 'text-dark'
                        ];
                        return Html::a('<i class="fas fa-sm fa-pen"></i>', $url, $options);
                    },
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'class' => 'text-dark'
                        ];
                        return Html::a('<span class="fas fa-sm fa-trash"></span>', $url, $options);
                    }
                ]
            ]
        ],
    ]);
    $this->registerJs('
    $("#general-user").on("click", function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        $.post({
           url: "' . \yii\helpers\Url::to(['/admin/user/index', 'action' => \app\models\User::ROLE_USER]) . '", 
           dataType: \'json\',
           data: {keylist: keys}
        });
    });
    $("#vip-user").on("click", function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        $.post({
           url: "' . \yii\helpers\Url::to(['/admin/user/index', 'action' => \app\models\User::ROLE_VIP]) . '", 
           dataType: \'json\',
           data: {keylist: keys}
        });
    });
    $("#admin-user").on("click", function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        $.post({
           url: "' . \yii\helpers\Url::to(['/admin/user/index', 'action' => \app\models\User::ROLE_ADMIN]) . '", 
           dataType: \'json\',
           data: {keylist: keys}
        });
    });
    ');
    ?>
</div>