<div class="list-group">
    <div class="list-group-item">
        参赛指引<br>
        <small>
            对于开放注册的比赛，你只需要注册一个帐号，进入比赛页面找到比赛，点击注册并按指引操作即可参赛。<br>
            对于小组内部赛等私密比赛，请联系比赛的举办者了解如何参赛。
        </small>
    </div>
    <?php if (!Yii::$app->setting->get('oiMode')) : ?>
        <div class="list-group-item text-secondary">
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
        主函数返回值<br>
        <small>
            对于 C/C++ 程序，<code>main</code> 函数必须返回 <b><code>int</code></b>，<code>void main</code> 的函数声明会报编译错误。我们也建议你尽快丢弃谭浩强的教材和 Visual C++ 6.0。
        </small>
    </div>
    <div class="list-group-item">
        系统调用<br>
        <small>
            如果检查日志中需要你申请代码复核，你可能使用了判题机禁止使用的系统调用。判题机采用的是白名单机制，允许的系统调用在 <a href="https://github.com/SCNU-SoCoding/scnuoj/blob/master/judge/src/okcalls64.h">这个文件</a> 有列举。<br>
            如果你希望我们复核你的代码并调整白名单设置，请先确认你的代码中不包含 <code>system("pause");</code> 这样的语句，如果有则请先删除后尝试重新提交。<br>
            如果你正在参加一场公开赛，如 AK 杯程序设计精神、蓝桥杯热身赛、天梯赛选拔赛等比赛，请通过比赛答疑系统联系 SCNUOJ 开发组，我们将尽快处理。<br>
            在非公开赛比赛场合，请通过 <a href="/discuss/view?id=1" target="_blank">运行出错反馈专帖</a> 联系 SCNUOJ 开发组。
        </small>
    </div>
</div>