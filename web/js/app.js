var OJ_VERDICT = new Array(
  "等待测评",
  "等待重测",
  "正在编译",
  "正在测评",
  "通过",
  "输出格式错误",
  "解答错误",
  "运行超时",
  "内存超限",
  "输出超限",
  "运行出错",
  "编译错误",
  "系统错误",
  "无评测数据"
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
function testHtml(id, caseJsonObject) {
  if (caseJsonObject.checker_log.substring(0, 57) == "Runtime Error: [ERROR] A not allowed system call, call ID") {
    return '<div class="list-group-item test-for-popup"> \
          <div role="tab" id="heading' + id + '"> \
                  <a class="collapsed text-dark" role="button" data-toggle="collapse" \
                    href="#test-' + id + '" aria-expanded="false" aria-controls="test-' + id + '"> \
                      <div class="' + OJ_VERDICT_COLOR[caseJsonObject.verdict] + '">\
                      <span class="text-danger fas fa-fw fa-circle"></span> 测试点 <span class="test" style="width: 50px">' + id + '</span> / \
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
                          <pre class="list-group-item">' + caseJsonObject.input + '</pre>\
                      </div>\
                      <div class="output">\
                          <h6>标准输出</h6>\
                          <pre class="list-group-item">' + caseJsonObject.user_output + '</pre>\
                      </div>\
                      <div class="output">\
                          <h6>答案</h6>\
                          <pre class="list-group-item">' + caseJsonObject.output + '</pre>\
                      </div>' + (caseJsonObject.checker_log == "" ? "" : '<div class="output"><h6>检查日志</h6><pre class="list-group-item">' + caseJsonObject.checker_log + '</pre></div>')
        + '<div class="output">') : '<div class="alert alert-light">你已经通过本测试点，测试点数据已经被隐藏。</div>') + '\
                          <h6>系统信息</h6>\
                          <pre class="list-group-item">exit code: ' + caseJsonObject.exit_code + ', checker exit code: ' + caseJsonObject.checker_exit_code + '</pre>\
                      </div>\
                  </div>\
              </div>\
          </div>\
      </div>';
  } else {
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
                          <pre class="list-group-item">' + caseJsonObject.input + '</pre>\
                      </div>\
                      <div class="output">\
                          <h6>标准输出</h6>\
                          <pre class="list-group-item">' + caseJsonObject.user_output + '</pre>\
                      </div>\
                      <div class="output">\
                          <h6>答案</h6>\
                          <pre class="list-group-item">' + caseJsonObject.output + '</pre>\
                      </div>' + (caseJsonObject.checker_log == "" ? "" : '<div class="output"><h6>检查日志</h6><pre class="list-group-item">' + caseJsonObject.checker_log + '</pre></div>')
        + '<div class="output">') : '<div class="alert alert-light">你已经通过本测试点，测试点数据已经被隐藏。</div>') + '\
                          <h6>系统信息</h6>\
                          <pre class="list-group-item">exit code: ' + caseJsonObject.exit_code + ', checker exit code: ' + caseJsonObject.checker_exit_code + '</pre>\
                      </div>\
                  </div>\
              </div>\
          </div>\
      </div>';
  }
}

function testHtmlMinDetail(id, caseJsonObject) {
  if (caseJsonObject.checker_log.substring(0, 57) == "Runtime Error: [ERROR] A not allowed system call, call ID") {
    return '<div class="list-group-item test-for-popup"> \
    <div role="tab" id="heading' + id + '"> \
            <span class="collapsed text-dark"> \
                <div class="' + OJ_VERDICT_COLOR[caseJsonObject.verdict] + '">\
                <span class="text-danger fas fa-fw fa-circle"></span> 测试点 <span class="test" style="width: 50px">' + id + '</span> / \
                <span class="verdict">' + OJ_VERDICT[caseJsonObject.verdict] + '</span> \
                <span class="float-right text-danger d-none d-md-inline">非法的系统调用</span></div> \
            </span> \
    </div> \
  </div>';
  } else {
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
    $(".sample-test").each(function () {
      var preId = ("id" + Math.random()).replace('.', '0');
      var cpyId = ("id" + Math.random()).replace('.', '0');

      $(this).find(".sample-input-btn").attr("id", cpyId);
      $(this).find(".sample-input-text").attr("id", preId);

      var clipboard = new ClipboardJS('#' + cpyId, {
        text: function (trigger) {
          return document.querySelector('#' + preId).innerText;
        }
      });
    });

    $(".sample-test").each(function () {
      var preId = ("id" + Math.random()).replace('.', '0');
      var cpyId = ("id" + Math.random()).replace('.', '0');

      $(this).find(".sample-output-btn").attr("id", cpyId);
      $(this).find(".sample-output-text").attr("id", preId);

      var clipboard = new ClipboardJS('#' + cpyId, {
        text: function (trigger) {
          return document.querySelector('#' + preId).innerText;
        }
      });
    });
  }

  addCopyBtn();

  $(document).on('pjax:complete', function () {
    renderKatex();
    addCopyBtn();
  });


  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });


  //do something
})
