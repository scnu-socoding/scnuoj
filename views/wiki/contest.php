<div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 本页面已被隐藏，非管理员将无法查看此页面。
</div>

<h5>赛制调整</h5>

<p>个人赛制已经被移除，<b>请尽快将所有个人赛设置成其他赛制。</b></p>

<ol>
    <li>IOI 赛制不再计算 AC 题目数量，仅以每题最高分计算排名。</li>
    <li>OI 赛制不再计算每题最高分，仅以每题最后一次提交计算排名。</li>
    <li>新增永久题目集，支持类似 Codeforces 补题榜的排名计算方式。</li>
</ol>

<h5>关于线上赛与线下赛的区别</h5>
<p>两个类型已经被合并了，<b>请尽快将所有比赛设置成线上赛。</b></p>
<ol>
    <li>所有比赛均支持可批量创建比赛账号，即 <code>cxxxuserxxx</code>。</li>
    <li>所有比赛均可以设置哪些用户打星，打星用户不计积分也不参与排名，普通用户也可打星。</li>
    <li>所有比赛均可以设置是否开放答疑，是否开放打印。</li>
    <li>所有比赛均可通过设置邀请码限制注册。</li>
    <li>所有 ICPC 和作业比赛均可滚榜。</li>
</ol>
<p>请注意线上赛也可在机房集中进行。</p>

<h5>关于积分</h5>
<p>在参加比赛之后，参赛者将根据排名得到一定积分。积分榜单可在 <?= \yii\helpers\Html::a('排行榜页面', ['/rating'], ['target' => '_blank']) ?>
    查看。如果参加了比赛但没有通过任何题目，不会计算比赛积分。积分一定程度上反映了参赛者的程序设计能力，可供各位同学找准自己的定位。积分计算采用 Elo Ranking 算法，具体见
    <a href="https://en.wikipedia.org/wiki/Elo_rating_system" target="_blank">
        Wikipedia 相关词条</a>。
</p>