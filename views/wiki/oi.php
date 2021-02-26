<div class="alert alert-light"><i class="fas fa-fw fa-info-circle"></i> 本页面已被隐藏，非管理员将无法查看此页面。
</div>

<h5>启用 OI 模式</h5>
<p>按照下面的步骤启用 OI 模式：</p>
<ol>
  <li>在网站后台设置页面选择启用 OI 模式。</li>
  <li>在启动判题机时，加上 <code>-o</code> 选项。</li>
</ol>

<p>如果你是初次启动判题机服务，只需在 <code>judge</code> 目录下运行 <code>sudo ./dispatcher -o</code>。
  如果已经有正在运行中的判题机服务，则先需要运行 <code>sudo pkill -9 dispatcher</code> 结束判题机，
  再运行 <code>sudo ./dispatcher -o</code> 启动判题机。</p>

<h5>子任务配置要求</h5>
<p>子任务配置文件举例如下：</p>
<div class="pre"><p>data[0-10] 10
data[11-13] 10
[14-20] 55
s[21] 5
test[] 20</p></div>
<p></p>
<p>在这个配置文件中，已经包含了可以配置的各种情况。其中，每行表示一个子任务，方括号前为文件名的字符串前缀（可以没有，如示例中的任务三），方括号中间为测试点的序号（该序号为非负整数）的区间，方括号后为空格，即：</p>
<ul>
  <li>任务一：输入文件为 <code>data0.in, data1.in, ..., data10.in</code>，分数 10 分。</li>
  <li>任务二：输入文件为 <code>data11.in, data12.in, data13.in</code>，分数 10 分。</li>
  <li>任务三：输入文件为 <code>14.in, 15.in, ..., 20.in</code>，分数 55 分。</li>
  <li>任务四：输入文件为 <code>s21.in</code>，分数 5 分。</li>
  <li>任务五：输入文件为 <code>test.in</code>，分数为 20 分。</li>
</ul>
<p>测试点上传时的输入文件的后缀要求为 <code>in</code>，输出文件的后缀要求为 <code>out</code>，在子任务的配置中，不需要配置后缀名。</p>
<p>每个子任务的描述均要有一对方括号出现 <code>[</code> <code>]</code>，方括号内填数字区间或一个数字或留空。如果方括号内无数字（如上述的任务五），则表示需要测评的测试点文件名为方括号前的字符串。</p>
<p>当判题机发现配置文件时，只会判断配置文件中所出现的数据点，如果配置文件中描述的数据点比真实的数据点要多，判题结果会判为 <code>No Test Data</code>。</p>