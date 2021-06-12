<div class="list-group">
    <div class="list-group-item">
        参赛指引<br>
        <small>
            对于开放注册的比赛，你只需要注册一个帐号，进入比赛页面找到比赛，点击注册并按指引操作即可参赛。<br>
            对于小组内部赛等私密比赛，请联系比赛的举办者了解如何参赛。
        </small>
    </div>
    <?php if (Yii::$app->setting->get('schoolName') == "华南师范大学软件学院") : ?>
        <div class="list-group-item">
            积分<br>
            <small>
                所有香农先修班在本系统举办的限时比赛结束后，有效参赛用户的积分将会得到更新，积分可在个人页和排行页面查看。<br>
                积分使用 Elo 积分系统计算，不同比赛会被赋予不同的权重，积分升降幅度也不同，请注意目前这个系统仅供娱乐使用。
            </small>
        </div>
    <?php endif; ?>
    <?php if (!Yii::$app->setting->get('oiMode')) : ?>
        <div class="list-group-item">
            OI 模式<br>
            <small>
                OI 模式未开启，系统在遇到第一个无法通过的测试点时将立刻停止评测并该测试点的返回结果。<br>
                在当前状态下，在 IOI/OI 赛制的比赛提交代码将无法得到准确的分数。
            </small>
        </div>
    <?php else : ?>
        <div class="list-group-item">
            OI 模式<br>
            <small>
                OI 模式已开启，系统将对所有测试点进行评测，即使遇到非解答正确评测点也不停止评测。<br>
                在当前状态下，代码评测耗时会比较长，请耐心等待。
            </small>

        </div>
    <?php endif; ?>
    <div class="list-group-item">
        输入和输出<br>
        <small>
            你的程序应该从标准输入 <code>stdin</code> 获取输入，并将结果输出到标准输出 <code>stdout</code>。用户程序不允许直接读写文件, 如果这样做可能会判为运行错误。<br>
            SCNUOJ 评测机在 Linux 系统运行，<code>long long</code> 格式化读入和输出需要使用 <b><code>%lld</code></b> 而非 <code>%I64</code>。
        </small>
    </div>
    <div class="list-group-item">
        单点时限与空间限制<br>
        <small>
            考虑不同语言直接的差异，Java 和 Python 程序在题目所标时空限制的基础上有 2s 的额外运行时间和 64M 的额外空间。
        </small>
    </div>
    <div class="list-group-item">
        系统调用<br>
        <small>
            如果检查日志中提示 <code>A not allowed system call</code>，你可能使用了判题机禁止使用的系统调用。判题机采用的是白名单机制，允许的系统调用在 <a href="https://github.com/SCNU-SoCoding/scnuoj/blob/master/judge/src/okcalls64.h" target="_blank">这个文件</a> 有列举。<br>
            请确认你的代码中不包含 <code>system("pause");</code> 这样的语句，如果有则请删除后尝试重新提交。<br>
        </small>
    </div>
    <div class="list-group-item">
        C/C++<br>
        <small>
            <code>main</code> 函数必须返回 <code>0</code>，<code>void main</code> 的函数声明会报编译错误；当返回非 <code>0</code> 时会认为程序执行错误。<br>
            所有依赖的函数必须明确地在源文件中 <code>#include &lt;xxx&gt;</code>，不能通过工程设置而省略常用头文件。
        </small>
    </div>
    <div class="list-group-item">
        Java<br>
        <small>
            请不要使用 <code>package</code> 语句，并且确保自己的主类名称为 <code>Main</code>。<br>
            如果程序中引用了类库，在提交时必须将 <code>import</code> 语句与程序的其他部分同时提交，只允许使用 Java 自带的类库。
        </small>
    </div>
    <div class="list-group-item">
        Python<br>
        <small>
            评测系统仅提供 Python 3 的评判支持。Python 程序仅可以使用 Python 自带的库，使用其他的扩展库可能会报运行出错。<br>
            程序中应只包含计算模块，不要包含任何其他的模块，比如图形、系统接口调用、系统中断等。对于系统接口的调用都应通过标准库来进行。
        </small>
    </div>
</div>