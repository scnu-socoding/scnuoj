<h5>结果</h5>

<div class="list-group">
    <div class="list-group-item">
        <b>等待测评</b> Pending<br>
        <small>
            你的答案在排队等待，请耐心等待。如果你的提交长时间未被评测，请联系管理员。
        </small>
    </div>
    <div class="list-group-item text-secondary">
        <b>等待重测</b> Pending Rejudge<br>
        <small>
            此结果已经被弃用，当管理员发起重测后，你的提交将被显示为等待评测。
        </small>
    </div>
    <div class="list-group-item">
        <b>正在编译</b> Compiling<br>
        <small>
            评测机正在编译你的程序。
        </small>
    </div>
    <div class="list-group-item">
        <b>正在测评</b> Running & Judging<br>
        <small>
            评测机正在运行你的程序，并根据事先准备的测试数据评测你的程序。
        </small>
    </div>
    <div class="list-group-item">
        <b>通过</b> Accepted<br>
        <small>
            恭喜你，你的程序通过了评测。
        </small>
    </div>
    <div class="list-group-item">
        <b>输出格式错误</b> Presentation Error<br>
        <small>
            答案基本正确，但是格式不对，请检查你的空格和换行是否符合要求。
        </small>
    </div>
    <div class="list-group-item">
        <b>解答错误</b> Wrong Answer<br>
        <small>
            答案不对，仅通过样例数据的测试并不一定就正确，一定还有你没想到的地方。
        </small>
    </div>
    <div class="list-group-item">
        <b>运行超时</b> Time Limit Exceeded<br>
        <small>
            运行超出时间限制，检查下是否有死循环，或者应该有更快的计算方法。
        </small>
    </div>
    <div class="list-group-item">
        <b>内存超限</b> Memory Limit Exceeded<br>
        <small>
            超出内存限制，数据可能需要压缩，检查内存是否有泄露。
        </small>
    </div>
    <div class="list-group-item">
        <b>输出超限</b> Output Limit Exceeded<br>
        <small>
            输出超过限制，你的输出比正确答案长了两倍或以上。
        </small>
    </div>
    <div class="list-group-item">
        <b>运行出错</b> Runtime Error<br>
        <small>
            运行时错误，可能是非法的内存访问，数组越界，指针漂移，调用禁用的系统函数。
        </small>
    </div>
    <div class="list-group-item">
        <b>编译错误</b> Compile Error<br>
        <small>
            编译错误，请访问评测详情页获得编译器的详细输出。
        </small>
    </div>
    <div class="list-group-item">
        <b>系统错误</b> System Error<br>
        <small>
            很遗憾，评测机出现了故障，请尽快联系管理员。
        </small>
    </div>
    <div class="list-group-item">
        <b>无评测数据</b> No Testdata<br>
        <small>
            管理员尚未上传此题的测试数据，请耐心等候管理员上传测试数据并重测你的提交。
        </small>
    </div>
</div>

<p></p>

<h5>编译参数</h5>

<div class="list-group">
    <div class="list-group-item">
        <b>C</b> (GCC 12.2.1)<br>
        <small>
            <code>gcc Main.c -o Main -fno-asm -O2 -Wall -lm --static -std=c11 -DONLINE_JUDGE</code>
        </small>
    </div>
    <div class="list-group-item">
        <b>C++</b> (GCC 12.2.1)<br>
        <small>
            <code>g++ -fno-asm -O2 -Wall -lm --static -std=c++14 -DONLINE_JUDGE -o Main Main.cc</code>
        </small>
    </div>
    <div class="list-group-item">
        <b>Java</b> (OpenJDK 17.0.9)<br>
        <small>
            <code>javac -J-Xms32m -J-Xmx256m Main.java</code>
        </small>
    </div>
    <div class="list-group-item">
        <b>Python</b> (3.11.6)<br>
        <small>
            编译参数不可用。
        </small>
    </div>
</div>
<p></p>
<h5>赛制</h5>

<div class="list-group">
    <div class="list-group-item">
        <b>ICPC</b><br>
        <small>
            无部分分，比赛期间提供判题结果反馈，排名按解题数量排序，解题数量相同按罚时排序。
        </small>
    </div>
    <?php if (!Yii::$app->setting->get('oiMode')) : ?>
        <div class="list-group-item">
            <b>IOI</b><br>
            <small>
                有部分分，比赛期间提供判题结果反馈，排名按每题最高得分总和排序。<br>
                OI 模式未开启，在 IOI 赛制的比赛提交代码将无法得到准确的分数。
            </small>
        </div>
        <div class="list-group-item">
            <b>OI</b><br>
            <small>
                有部分分，比赛期间不提供判题结果反馈，排名按每题最后一次提交得分总和排序。<br>
                OI 模式未开启，在 OI 赛制的比赛提交代码将无法得到准确的分数。
            </small>
        </div>
    <?php else : ?>
        <div class="list-group-item">
            <b>IOI</b><br>
            <small>
                有部分分，比赛期间提供判题结果反馈，排名按每题最高得分总和排序。
            </small>
        </div>
        <div class="list-group-item">
            <b>OI</b><br>
            <small>
                有部分分，比赛期间不提供判题结果反馈，排名按每题最后一次提交得分总和排序。
            </small>
        </div>
    <?php endif; ?>
</div>