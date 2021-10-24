<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $contests array */
/* @var $contestCnt integer */

$this->title = $model->nickname;
$solutionStats = $model->getSolutionStats();
$recentSubmission = $model->getRecentSubmission();
?>

<h3><?= Html::encode($model->nickname) ?></h3>
<p></p>
<?php if ($model->role != \app\models\User::ROLE_PLAYER) : ?>
    <?php if (Yii::$app->setting->get('isContestMode') && (Yii::$app->user->isGuest || (!Yii::$app->user->identity->isAdmin())) && Yii::$app->setting->get('examContestId')) : ?>
        <div class="card animate__animated animate__fadeIn animate__faster">
            <div class="card-body">
                <i class="text-secondary">个人信息已被暂时隐藏，请等候比赛结束。</i>
            </div>
        </div>
        <p></p>
        <div class="list-group animate__animated animate__fadeIn animate__faster">
            <div class="list-group-item">
                <?= Yii::t('app', 'Username') ?><span class="float-right text-secondary"><?= Html::encode($model->username) ?></span>
            </div>
            <div class="list-group-item">
                <?= Yii::t('app', 'Student Number') ?><span class="float-right text-secondary"><?= $model->profile->student_number ?></span>
            </div>
        </div>
    <?php else : ?>

        <div class="row animate__animated animate__fadeIn animate__faster">
            <div class="col-lg-4">
                <div class="list-group">
                    <div class="list-group-item">
                        <?= Yii::t('app', 'Username') ?><span class="float-right text-secondary"><?= Html::encode($model->username) ?></span>
                    </div>
                    <div class="list-group-item">
                        <?= Yii::t('app', 'Major') ?><span class="float-right text-secondary"><?= Html::encode($model->profile->major) ?></span>
                    </div>
                    <div class="list-group-item">
                        <?= Yii::t('app', 'Student Number') ?><span class="float-right text-secondary"><?= $model->profile->student_number ?></span>
                    </div>
                </div>
                <p></p>
                <div class="list-group">
                    <div class="list-group-item">
                        提交总数<span class="float-right text-secondary"> <?= $solutionStats['all_count'] ?></span>
                    </div>
                    <div class="list-group-item">
                        通过<span class="float-right text-secondary"> <?= $solutionStats['ac_count'] ?></span>
                    </div>
                    <div class="list-group-item">
                        通过率
                        <span class="float-right text-secondary">
                            <?= $solutionStats['all_count'] == 0 ? 0 : number_format($solutionStats['ac_count'] / $solutionStats['all_count'] * 100, 2) ?>%
                        </span>
                    </div>
                    <div class="list-group-item">
                        错误解答<span class="float-right text-secondary"> <?= $solutionStats['wa_count'] ?></span>
                    </div>
                    <div class="list-group-item">
                        时间超限<span class="float-right text-secondary"> <?= $solutionStats['tle_count'] ?></span>
                    </div>
                    <div class="list-group-item">
                        编译错误<span class="float-right text-secondary"> <?= $solutionStats['ce_count'] ?></span>
                    </div>
                </div>
                <p></p>
            </div>
            <div class="col-lg-8">

                <div class="card">
                    <!-- <div class="card-header">个人档案</div> -->

                    <?php if ($model->profile->personal_intro != '') : ?>
                        <div class="card-body" style="padding-bottom: 0.25rem;">
                            <?= Yii::$app->formatter->asMarkdown($model->profile->personal_intro) ?>
                        </div>
                    <?php else : ?>
                        <div class="card-body text-secondary">
                            用户还没有填写个人介绍信息哦。
                        </div>
                    <?php endif; ?>
                </div>

                <p></p>

                <div class="card">
                    <div class="card-header">已解答 <small class="text-secondary"><?= count($solutionStats['solved_problem']) ?>
                            Problem<?php if (count($solutionStats['solved_problem']) != 1) echo "s"; ?></small></div>
                    <div class="card-body">
                        <?php if (count($solutionStats['solved_problem']) != 0) : ?>
                            <?php foreach ($solutionStats['solved_problem'] as $p) : ?>
                                <?= Html::a('<code>' . $p . '</code>', ['/problem/view', 'id' => $p], ['class' => 'btn-sm bg-light text-dark', 'style' => "margin-bottom:0.5rem"]) ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            没有找到数据。
                        <?php endif; ?>
                    </div>
                </div>
                <p></p>


                <div class="card">
                    <div class="card-header">未解答 <small class="text-secondary"><?= count($solutionStats['unsolved_problem']) ?>
                            Problem<?php if (count($solutionStats['unsolved_problem']) != 1) echo "s"; ?></small></div>
                    <div class="card-body">
                        <?php if (count($solutionStats['unsolved_problem']) != 0) : ?>
                            <?php foreach ($solutionStats['unsolved_problem'] as $p) : ?>
                                <?= Html::a('<code>' . $p . '</code>', ['/problem/view', 'id' => $p], ['class' => 'btn-sm bg-light text-dark', 'style' => "margin-bottom:0.5rem"]) ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            没有找到数据。
                        <?php endif; ?>
                    </div>
                </div>
                <p></p>
            </div>

        </div>
    <?php endif; ?>

<?php else : ?>
    <div class="card animate__animated animate__fadeIn animate__faster">
        <div class="card-body">
            <i class="text-secondary">线下赛参赛用户。</i>
        </div>
    </div>
<?php endif; ?>