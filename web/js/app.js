var OJ_VERDICT = new Array(
  "Pending",
  "Pending Rejudge",
  "Compiling",
  "Running & Judging",
  "Accepted",
  "Presentation Error",
  "Wrong Answer",
  "Time Limit Exceeded",
  "Memory Limit Exceeded",
  "Output Limit Exceeded",
  "Runtime Error",
  "Compile Error",
  "System Error",
  "No Test Data"
);
// bootstrap 3 CSS class
var OJ_VERDICT_COLOR = new Array(
  "text-muted",
  "text-muted",
  "text-muted",
  "text-muted",
  "text-success", // AC
  "text-warning", // PE
  "text-danger",  // WA
  "text-warning", // TLE
  "text-warning", // MLE
  "text-warning", // OLE
  "text-warning", // RE
  "text-warning", // CE
  "text-danger",  // SE
  "text-danger"
);

function HTMLEncode(html) {
  var temp = document.createElement("div");
  (temp.textContent != null) ? (temp.textContent = html) : (temp.innerText = html);
  var output = temp.innerHTML;
  temp = null;
  return output;
}

function testHtml(id, caseJsonObject) {
  return '<div class="list-group-item test-for-popup"> \
        <div role="tab" id="heading' + id + '"> \
                <a class="collapsed text-dark" role="button" data-toggle="collapse" \
                   href="#test-' + id + '" aria-expanded="false" aria-controls="test-' + id + '"> \
                    <div class="' + OJ_VERDICT_COLOR[caseJsonObject.verdict] + '">\
                    测试点 <span class="test" style="width: 50px">' + id + '</span> / \
                    <span class="verdict">' + OJ_VERDICT[caseJsonObject.verdict] + '</span> \
                    <span class="float-right text-secondary d-none d-md-inline">用时 <span class="time">' + caseJsonObject.time + '</span> ms / \
                    内存 <span class="memory">' + caseJsonObject.memory + '</span> KB \
                    </span></div> \
                </a> \
        </div> \
        <div id="test-' + id + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' + id + '"> \
            <div class="panel-body"><hr>' + (caseJsonObject.verdict != 4 ? ('\
                <div class="sample-test">\
                    <div class="input">\
                        <h6>标准输入</h6>\
                        <pre class="list-group-item">' + HTMLEncode(caseJsonObject.input) + '</pre>\
                    </div>\
                    <div class="output">\
                        <h6>标准输出</h6>\
                        <pre class="list-group-item">' + HTMLEncode(caseJsonObject.user_output) + '</pre>\
                    </div>\
                    <div class="output">\
                        <h6>答案</h6>\
                        <pre class="list-group-item">' + HTMLEncode(caseJsonObject.output) + '</pre>\
                    </div>' + (caseJsonObject.checker_log == "" ? "" : '<div class="output"><h6>检查日志</h6><pre class="list-group-item">' + HTMLEncode(caseJsonObject.checker_log) + '</pre></div>')
      + '<div class="output">') : '<div class="alert alert-light">你已经通过本测试点，测试点数据已经被隐藏。</div>') + '\
                        <h6>系统信息</h6>\
                        <pre class="list-group-item">exit code: ' + caseJsonObject.exit_code + ', checker exit code: ' + caseJsonObject.checker_exit_code + '</pre>\
                    </div>\
                </div>\
            </div>\
        </div>\
    </div>';
}

function testHtmlMinDetail(id, caseJsonObject) {
  return '<div class="list-group-item test-for-popup"> \
        <div role="tab" id="heading' + id + '"> \
                <span class="collapsed text-dark"> \
                    <div class="' + OJ_VERDICT_COLOR[caseJsonObject.verdict] + '">\
                    测试点 <span class="test" style="width: 50px">' + id + '</span> / \
                    <span class="verdict">' + OJ_VERDICT[caseJsonObject.verdict] + '</span> \
                    <span class="float-right text-secondary d-none d-md-inline">评测信息暂不可用</span></div> \
                </span> \
        </div> \
    </div>';
}

function subtaskHtml(id, score, verdict) {
  var scoregot = score;
  var csscolor = 'panel-success';
  if (verdict != 4) {
    scoregot = 0;
    csscolor = 'panel-warning';
  }
  return (id == 1 ? '' : '<p></p>') + '<div class="alert alert-light"><i class="fas fa-fw fa-tasks"></i> 子任务 ' + id + '<span class="float-right text-secondary">得分 ' + scoregot + ' / 总分 ' + score +
    '</span></div><div id = "subtask-body-' + id + '" class="panel-body" > \
    </div> ';
}
$(document).ready(function () {

  function renderKatex() {
    $(".katex.math.inline").each(function () {
      var parent = $(this).parent()[0];
      if (parent.localName !== "code") {
        var texTxt = $(this).text();
        var el = $(this).get(0);
        try {
          katex.render(texTxt, el);
        } catch (err) {
          $(this).html("<span class=\'err\'>" + err);
        }
      } else {
        $(this).parent().text($(this).parent().text());
      }
    });
    $(".katex.math.multi-line").each(function () {
      var texTxt = $(this).text();
      var el = $(this).get(0);
      try {
        katex.render(texTxt, el, { displayMode: true })
      } catch (err) {
        $(this).html("<span class=\'err\'>" + err)
      }
    });
    $('.pre p').each(function (i, block) {  // use <pre><p>
      hljs.highlightBlock(block);
    });
  }
  renderKatex();

  function addCopyBtn() {
    $(".sample-test h5").each(function () {
      var preId = ("id" + Math.random()).replace('.', '0');
      var cpyId = ("id" + Math.random()).replace('.', '0');

      $(this).parent().find("pre").attr("id", preId);
      var copy = $("<div title='Copy' data-clipboard-target='#" + preId + "' id='" + cpyId + "' class='btn btn-sm btn-outline-secondary' >复制</div>");
      $(this).append(copy);

      var clipboard = new ClipboardJS('#' + cpyId, {
        text: function (trigger) {
          return document.querySelector('#' + preId).innerText;
        }
      });
      clipboard.on('success', function (e) {
        $('#' + cpyId).text("已复制");
        setTimeout(function () {
          $('#' + cpyId).text('复制');
        }, 500);
        e.clearSelection();
      });
      clipboard.on('error', function (e) {
        $('#' + cpyId).text("复制失败");
        setTimeout(function () {
          $('#' + cpyId).text('复制');
        }, 500);
      });
    });
  }

  addCopyBtn();

  $(document).on('pjax:complete', function () {
    renderKatex();
    addCopyBtn();
  });





  //do something
})
