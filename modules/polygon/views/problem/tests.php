<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\polygon\models\Problem;
use app\models\Solution;

/* @var $this yii\web\View */
/* @var $model app\modules\polygon\models\Problem */
/* @var $solutionStatus array */

$this->title = $model->title;
$this->params['model'] = $model;
$loadingImgUrl = Yii::getAlias('@web/images/loading.gif');

$files = $model->getDataFiles();
?>
<div class="alert alert-light">
    <i class="fas fa-fw fa-info-circle"></i> 输入文件以 <code>.in</code> 结尾，输出文件以 <code>.out</code> 或者
    <code>.ans</code> 结尾，文件名可以任意取。
</div>
<div class="alert alert-light">
    <i class="fas fa-fw fa-info-circle"></i> 输入文件跟输出文件的文件名必须一一对应。比如输入文件为
    <code>apple.in</code>，则输出文件需命名为 <code>apple.out</code> 或者 <code>apple.ans</code>。
</div>
<?= \app\widgets\webuploader\MultiImage::widget() ?>
<p></p>
<?php if (extension_loaded('zip')) : ?>
    <div class="btn-group btn-block">
        <?= Html::a('下载全部数据', ['download-data', 'id' => $model->id], ['class' => 'btn btn-outline-success']); ?>
        <?= Html::a('生成输出数据', ['/polygon/problem/run', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
    </div>
    <p></p>
<?php else : ?>
    <div class="alert alert-light">
        <i class="fas fa-fw fa-info-circle"></i> 服务器未启用 <code>php-zip</code> 扩展，如需下载测试数据，请安装 <code>php-zip</code> 扩展。
    </div>
<?php endif; ?>

<?php if (!empty($solutionStatus)) : ?>
    <?php if ($solutionStatus['result'] < 4) : ?>
        <div class="alert alert-light">
            <i class="fas fa-fw fa-info-circle"></i> 正在生成输出数据，请稍后回来查看生成结果。
        </div>
    <?php elseif ($solutionStatus['result'] == Solution::OJ_AC) : ?>
        <div class="alert alert-light">
            <i class="fas fa-fw fa-check-circle"></i> 最后一次生成时间为 <?= $solutionStatus['created_at'] ?>。<span class="float-right">用时
                <?= $solutionStatus['time'] ?> ms / 内存 <?= $solutionStatus['memory'] ?> KB</span>
        </div>
    <?php else : ?>
        <div class="alert alert-light">
            <i class="fas fa-fw fa-info-circle"></i> 输出数据生成失败，<?= Problem::getResultList($solutionStatus['result']) ?>。<span class="float-right">用时
                <?= $solutionStatus['time'] ?> ms / 内存 <?= $solutionStatus['memory'] ?> KB</span>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div class="row">
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>输入</th>
                        <th>大小 (bytes)</th>
                        <th>修改时间</th>
                        <th><a href="<?= Url::toRoute(['/polygon/problem/deletefile', 'id' => $model->id, 'name' => 'in']) ?>" onclick="return confirm('确定删除全部输入文件？');">
                                全部删除
                            </a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($files as $file) : ?>
                        <?php
                        if (!strpos($file['name'], '.in'))
                            continue;
                        ?>
                        <tr>
                            <td><?= $file['name'] ?></td>
                            <td><?= $file['size'] ?></td>
                            <td><?= date('Y-m-d H:i', $file['time']) ?></td>
                            <td>
                                <a href="<?= Url::toRoute(['/polygon/problem/viewfile', 'id' => $model->id, 'name' => $file['name']]) ?>" target="_blank" title="<?= Yii::t('app', 'View') ?>">
                                    <span class="fas fa-sm fa-eye text-dark"></span>
                                </a>
                                &nbsp;
                                <a href="<?= Url::toRoute(['/polygon/problem/deletefile', 'id' => $model->id, 'name' => $file['name']]) ?>" title="<?= Yii::t('app', 'Delete') ?>">
                                    <span class="fas fa-sm fa-trash text-dark"></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>输出</th>
                        <th>大小 (bytes)</th>
                        <th>修改时间</th>
                        <th><a href="<?= Url::toRoute(['/polygon/problem/deletefile', 'id' => $model->id, 'name' => 'out']) ?>" onclick="return confirm('确定删除全部输出文件？');">
                                全部删除
                            </a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($files as $file) : ?>
                        <?php
                        if (!strpos($file['name'], '.out') && !strpos($file['name'], '.ans'))
                            continue;
                        ?>
                        <tr>
                            <td><?= $file['name'] ?></td>
                            <td><?= $file['size'] ?></td>
                            <td><?= date('Y-m-d H:i', $file['time']) ?></td>
                            <td>
                                <a href="<?= Url::toRoute(['/polygon/problem/viewfile', 'id' => $model->id, 'name' => $file['name']]) ?>" target="_blank" title="<?= Yii::t('app', 'View') ?>">
                                    <span class="fas fa-sm fa-eye text-dark"></span>
                                </a>
                                &nbsp;
                                <a href="<?= Url::toRoute(['/polygon/problem/deletefile', 'id' => $model->id, 'name' => $file['name']]) ?>" title="<?= Yii::t('app', 'Delete') ?>">
                                    <span class="fas fa-sm fa-trash text-dark"></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>