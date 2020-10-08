<h3>Special Judge</h3>
<p>　　Special Judge 是指判题系统将使用一个特定的程序来判断提交的程序的输出是不是正确的，而不是单纯地看提交的程序的输出是否和标准输出一模一样。一般使用 Special Judge 都是因为题目的答案不唯一，更具体一点说的话一般是两种情况：</p>

<ol>
<li>题目最终要求输出一个解决方案，而且这个解决方案可能不唯一。</li>
<li>题目最终要求输出一个浮点数，而且会告诉只要答案和标准答案相差不超过某个较小的数就可以，比如 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;">0.01</span>。这种情况保留三位小数、四位小数等等都是可以的，而且多保留几位小数也没什么坏处。</li>
</ol>

<p>　　Special Judge 程序编译参数为 <code>g++ -fno-asm -std=c++14 -O2</code>，即已经开启 C++ 14 以及 O2 优化。在 OJ 运行的时候会给定三个参数，分别是输入文件、用户输出和标程输出，即 <code>./spj in.txt out.txt ans.txt</code>。程序的返回值决定着判断结果，返回零表示通过，返回非零值表示答案错误。你需要确保 SPJ 程序可以正确运行，也未调用与判题无关的系统函数，当 SPJ 在 OJ 中编译出错或运行出错时，OJ 不会给出反馈。SPJ 输出到 <code>stderr</code> 的内容将会被记录到用户错误数据点中。</p>

<br />

<h3>Testlib</h3>

<p>　　本判题系统支持 Codeforces 管理员 MikeMirzayanov 维护的 <a href="https://github.com/MikeMirzayanov/testlib" target="_blank">Testlib</a> 库，面对各种各样奇怪的输出文件，出题人都会感到十分头疼。使用常规的 IO 来读取数据，鲁棒性很难得到保证。Testlib 通过一套完善的 API 来读取数据，从而确保能在任何奇怪数据的考验下，都能给出正确的结果。该库已被成功用于数百场 Codeforces Rounds 和 ICPC/CCPC 等知名比赛中。我们要求 SPJ 题目必须使用 Testlib 库读入用户数据，以避免 Judgment Failed。</p>

    <p>　　在使用到 Testlib 库的程序中，有 3 个重要的结构体，<code>inf</code> 指数据输入文件（本例子中没有使用到），<code>ouf</code> 指选手输出文件，<code>ans</code> 指标程答案。我们直接从这 3 个结构体读入数据，不需要用到标准输入输出。如果读到的数据类型与范围和下面的期望不一致，则 SPJ 会直接返回答案错误。</p>

    <p>　　下面是 Testlib 的一些常见用法，供参考：</p>

<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>用法</th>
            <th>解释</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th><code>void registerTestlibCmd(argc, argv)</code></th>
            <th>初始化检查器，必须在最前面调用一次</th>
        </tr>
        <tr>
            <th><code>char readChar()</code></th>
            <th>读入一个字符，指针后移一位</th>
        </tr>
        <tr>
            <th><code>char readChar(char c)</code></th>
            <th>和上面一样，但是只能读到一个字母 c</th>
        </tr>
        <tr>
            <th><code>char readSpace()</code></th>
            <th>同 <code>readChar(' ')</code></th>
        </tr>
        <tr>
            <th><code>string readToken()</code></th>
            <th>读入 string，遇到空格换行或 eof 为止</th>
        </tr>
        <tr>
            <th><code>string readString(), string readLine()</code></th>
            <th>读入 string，到换行或者 eof 为止</th>
        </tr>
        <tr>
            <th><code>long long readLong()</code></th>
            <th>读入一个 long long / int64</th>
        </tr>
        <tr>
            <th><code>long long readLong(long long L, long long R)</code></th>
            <th>同上，但是限定范围 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;">[L,R]</span></th>
        </tr>
        <tr>
            <th><code>int readInt()</code></th>
            <th>读入一个 int</th>
        </tr>
        <tr>
            <th><code>int readInt(int L, int R)</code></th>
            <th>同上，但是限定范围 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;">[L,R]</span></th>
        </tr>
        <tr>
            <th><code>double readReal()</code></th>
            <th>读入一个实数</th>
        </tr>
        <tr>
            <th><code>double readReal(double L, double R)</code></th>
            <th>同上，但是限定范围 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;">[L,R]</span></th>
        </tr>
        
        
        <tr>
            <th><code>quitf(\_ok, "Correct: answer is %d", ans)</code></th>
            <th>答案正确，给出 AC</th>
        </tr>
        <tr>
            <th><code>quitf(\_wa, "Wrong answer: expected %f, found %f", jans, pans)</code></th>
            <th>答案错误，给出 WA</th>
        </tr>
        </tbody>
    </table>
</div>

<h3>示例</h3>

<p>　　当标准输出和选手输出的差小于 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;">0.01</span>，那么可以 AC，否则 WA：</p>
<div class="pre"><p>#include "testlib.h"
int main(int argc, char *argv[])
{
    registerTestlibCmd(argc, argv);
    double pans = ouf.readDouble();
    double jans = ans.readDouble();
    if (fabs(pans - jans) < 0.01)
        quitf(_ok, "The answer is correct.");
    else
        quitf(_wa, "The answer is wrong: expected = %f, found = %f", jans, pans);
}
</p></div>

<p>　　如果无法得知选手答案的输出规模（即行数不定），可以参考下面的例子：</p>
<div class="pre"><p>#include "testlib.h"
int main(int argc, char *argv[])
{
    registerTestlibCmd(argc, argv);
    while (!ans.eof())
    {
        double pans = ouf.readDouble();
        double jans = ans.readDouble();
        if (fabs(pans - jans) >= 0.01)
            quitf(_wa, "The answer is wrong: expected = %f, found = %f", jans, pans);
    }
    quitf(_ok, "The answer is correct.");
}
</p></div>
