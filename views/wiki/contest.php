<h3>比赛榜单计分方式</h3>

<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th style="min-width: 80px">Contest</th>
            <th>比赛榜单计分方式</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>单人</th>
            <th>
                每题得分 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;">x = 250  + max(0, 500 - 2 \cdot time - 50 \cdot cnt_{rejected}) + 50 \cdot isFirstBlood</span>，排名方式按解题数从多到少排序，解题数相同则按得分总和从高到低排序。
            </th>
        </tr>
        <tr>
            <th>ICPC</th>
            <th>每道试题用时为从竞赛开始到试题解答被判定为正确所耗时间，其间每一次提交运行结果被判错误的话将被加罚 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;">20</span> 分钟时间。赛时未能解答的试题不记时。排名方式由解题数从多到少排序，解题数相同则按各题用时之和从少到多排序。</th>
        </tr>
        <tr>
            <th>作业</th>
            <th>按正确解答的题目数量由多到少排序，不计罚时。比赛过程中用户可以查看出错信息。</th>
        </tr>
        <tr>
            <th>OI</th>
            <th>对所有数据点进行测试，根据题目数据配置文件来按数据点算分。比赛结束前选手无法得知自己的过题情况。测评总分为每道题最后一次提交的得分之和；订正总分为每道题所有提交最高得分之和。</th>
        </tr>
        <tr>
            <th>IOI</th>
            <th>对所有数据点进行测试，根据题目数据配置文件来按数据点算分。测评总分为每道题最后一次提交的得分之和；订正总分为每道题所有提交最高得分之和。</th>
        </tr>
        </tbody>
    </table>
</div>

    <h3>关于线上赛与线下赛的区别</h3>
    <p>　　线下赛是为了举办现场赛而设立的一个场景。线上赛与线下赛的区别在于：</p>
    <ol>
        <li>线下赛在比赛页面会有代码打印链接，用于给参赛选手提供代码打印服务的功能；线上赛无此功能。</li>
        <li>线下赛的参赛帐号只能在后台管理界面批量添加；线上赛在比赛结束前任何时刻都可以注册比赛。</li>
        <li>线下赛场景中批量生成的帐号会被禁止修改个人信息。</li>
        <li>线下赛所添加的参赛帐号中，非批量生成的帐号为打星参赛模式；线上赛无此功能。</li>
        <li>线下赛可以滚榜；线上赛无此功能。</li>
    </ol> 
    <p>　　请注意线上赛也可在机房集中进行，除了 ACM 校赛等组队赛之外，通常创建线上赛。</p>

    <br />
    <h3>关于积分</h3>
    <p>　　在参加比赛之后，参赛者将根据排名得到一定积分。积分榜单可在 <?= \yii\helpers\Html::a('排行榜页面', ['/rating'], ['target' => '_blank']) ?> 查看。如果参加了比赛但没有通过任何题目，不会计算比赛积分。积分一定程度上反映了参赛者的程序设计能力，可供各位同学找准自己的定位。
    </p>

    <br />
    <h3>积分计算方式</h3>
    <p>　　采用 Elo Ranking 算法，具体见 
        <a href="https://en.wikipedia.org/wiki/Elo_rating_system" target="_blank">
            Wikipedia 相关词条</a>。
    </p>

