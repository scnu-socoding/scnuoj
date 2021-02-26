<?php
use yii\helpers\Html;
use yii\bootstrap4\Modal;
?>

<div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 本页面已被隐藏，非管理员将无法查看此页面。
</div>

<h5>Polygon System</h5>

<p>为了方便课程助教和部分有需要的同学和老师，我们开放了造题系统 <?= Html::a(Yii::t('app', 'Polygon System'), ['/polygon']) ?>。所有注册用户都可以在该平台上面创建题目，非管理员用户只能查看自己创建的题目，管理员可以查看所有用户的题目，并将题目加入公共题库或比赛中。</p>

<p>在 Polygon System，要完成一道题目的创建，你需要提供题目的题目标题、题目描述、输入描述、输出描述、样例输入（可提供多组）、对应的样例输出、题目的提示信息（可选）、测试数据的输入文件和解决该问题的源程序。测试数据的输出文件由该平台根据你提供的源程序生成。</p>

<p></p>
<h5>题面规范</h5>
<ol>
    <li>题面必须清晰好懂，没有语法错误。</li>
    <li>题目背景中不要写数据范围，全部都要写在输入格式里。</li>
    <li>对于数字的输入，必须写明是实数（或浮点数）还是整数。</li>
    <li>必须写明所提到的所有变量的范围，数据范围描述应当使用 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;">\leq</span>，而不是 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;"><</span>。</li>
    <li>如果提到一个字符串，必须写明哪些字符可以出现在这个字符串内。</li>
    <li>题目中描述数组下标应当从 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;">1</span> 开始。</li>
    <li>题目出现的所有变量名必须 Katex 语法来包含，数据范围的描述也用 Katex 来写。</li>
    <li>描述数据范围是，数字达一万以上应当采用科学计数法，如 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;">2 \cdot 10^5</span>。不应采用 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;">2e5</span> 这样的格式。</li>
    <li>如果是中文题面的题目，建议遵循《<a href="https://sparanoid.com/note/chinese-copywriting-guidelines/" target="_blank">中文文案排版指北</a>》排版，不混用中英文标点，中英文间加空格。</li>
</ol>

<p></p>

<h5>测试数据文件要求</h5>
<ol>
<li>输入文件的后缀为 <code>in</code>，例如 <code>1.in</code>。</li>
<li>就算题目无输入要求，为了正确生成输出文件，也应包含至少一个输入文件（文件内容可以是数个空格）。</li>
<li>一个输入文件（以及对应的输出文件）称为一个测试点，测试点可以有多个。程序运行时间的计算结果为所有测试点中，单个测试点所需时间的最大值。</li>
<li>一般情况下建议一个测试点只包含一组样例，方便学生查看出错点。但是如果你希望将题目用于正式比赛中且希望对读入进行考察，或是超过一百个测试点下仍不足以达到测试要求，仍建议使用多组样例输入，此时应适当描述测试点的样例数据分布情况。</li>
<li>必须包括各种各样的数据，而且应该有各种各样的达到最小数据范围的数据和达到最大数据范围的数据。也就是说如果题目中给定的数据范围是 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;">1 \leq n \leq 2 \cdot 10^5</span>，那么既应该有 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;">n = 1</span> 的数据，也应该有 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;">n = 2 \cdot 10^5</span> 的数据。</li>
<li>测试数据不应完全依赖于程序随机生成，最好人为考虑各种不同的情况，针对各种情况出数据，确保暴力和假算法无法通过。</li>
</ol>


<h5>Special Judge</h5>
<p>Special Judge 是指判题系统将使用一个特定的程序来判断提交的程序的输出是不是正确的，而不是单纯地看提交的程序的输出是否和标准输出一模一样。一般使用 Special Judge 都是因为题目的答案不唯一，更具体一点说的话一般是两种情况：</p>

<ol>
<li>题目最终要求输出一个解决方案，而且这个解决方案可能不唯一。</li>
<li>题目最终要求输出一个浮点数，而且会告诉只要答案和标准答案相差不超过某个较小的数就可以，比如 <span class="katex math inline" style="font: normal 1em KaTeX_Main, Times New Roman, serif !important;">0.01</span>。这种情况保留三位小数、四位小数等等都是可以的，而且多保留几位小数也没什么坏处。</li>
</ol>

<p>Special Judge 写法详见 <?= Html::a('Special Judge', ['/wiki/spj']) ?> 页面。</p>


<h5>如何快速生成输入文件</h5>
<p>以下只是一种示范，数据请勿完全依赖随机生成，应根据题目要求考虑不同情况设定数据，同时应包含题面各个范围的数据情况。</p>


<div class="pre"><p>#include &lt;bits/stdc++.h&gt;
int main()
{
    // 生成 30 组数据
    for (int test = 1; test <= 30; test++)
    {
        char name[100];
        sprintf(name, "%d.in", test); // 注意文件名称必须以 in 作为后缀
        FILE *fp = fopen(name, "w");
        int a = rand() % 100 + 1;     // 随机生成在一个在 [1, 100] 范围内的数
        int b = rand() % 100 + 1;     // 随机生成在一个在 [1, 100] 范围内的数
        fprintf(fp, "%d %d\n", a, b); // 输出到文件中
        fclose(fp);
    }
    return 0;
}
</p></div>

