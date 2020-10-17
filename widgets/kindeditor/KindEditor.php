<?php

/**
 * Description of KindEditor
 *
 * @author Qinn Pan <Pan JingKui, pjkui@qq.com>
 * @link http://www.pjkui.com
 * @QQ 714428042
 * @date 2015-3-4

 */

namespace app\widgets\kindeditor;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\InputWidget;

class KindEditor extends InputWidget {

    //配置选项，参阅KindEditor官网文档(定制菜单等)
    public $clientOptions = [];
    //定义编辑器的类型，
    //默认为textEditor;
    //uploadButton：自定义上传按钮
    //dialog:弹窗
    //colorpicker:取色器
    //file-manager浏览服务器
    //image-dialog 上传图片
    //multiImageDialog批量上传图片
    //fileDialog 文件上传
    public $editorType;
    //默认配置
    protected $_options;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init() {
        $this->id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->id;
        $this->_options = [
            'fileManagerJson' => Url::to(['Kupload', 'action' => 'fileManagerJson']),
            'uploadJson' => Url::to(['Kupload', 'action' => 'uploadJson']),
            'autoHeightMode'=> 'true',
            'wellFormatMode' => 'false',
            'width' => '100%',
            'height' => '100',
		'items' => [
	        'source', '|',  'fontname', 'fontsize', 'forecolor', 'hilitecolor','|', 'bold','italic', 'underline','lineheight','|', 'justifyleft', 'justifycenter', 'justifyright', 'justifyfull', '|','insertorderedlist', 'insertunorderedlist','|','undo', 'redo', '|',  'image', 'table',  'emoticons',   'link', 'unlink', '|','code',
	        ],
                //'allowFileManager' => 'true',
                //'langType' => (strtolower(Yii::$app->language) == 'en-us') ? 'en' : 'zh_cn',//kindeditor支持一下语言：en,zh_CN,zh_TW,ko,ar
        ];
        
        $this->clientOptions = ArrayHelper::merge($this->_options, $this->clientOptions);
        
        if($this->hasModel()){
            parent::init();
        }
    }

    public function run() {
        $this->registerClientScript();
        if ($this->hasModel()) {
            switch ($this->editorType) {
                case 'uploadButton':
                    return Html::activeInput('text', $this->model, $this->attribute, ['id' => $this->id, 'readonly' => "readonly"]) . '<input type="button" id="uploadButton" value="Upload" />';

                    break;
                case 'colorpicker':
                    return Html::activeInput('text', $this->model, $this->attribute, ['id' => $this->id]) . '<input type="button" id="colorpicker" value="打开取色器" />';

                    break;
                case 'file-manager':
                    return Html::activeInput('text', $this->model, $this->attribute, ['id' => $this->id]) . '<input type="button" id="filemanager" value="浏览服务器" />';

                    break;
                case 'image-dialog':
                    return Html::activeInput('text', $this->model, $this->attribute, ['id' => $this->id]) . '<input type="button" id="imageBtn" value="选择图片" />';

                    break;
                case 'file-dialog':
                    return Html::activeInput('text', $this->model, $this->attribute, ['id' => $this->id]) . '<input type="button" id="insertfile" value="选择文件" />';

                    break;

                default:
                    return Html::activeTextarea($this->model, $this->attribute, ['id' => $this->id]);
                    break;
            }
        } else {
            switch ($this->editorType) {
                case 'uploadButton':
                    return Html::input('text', $this->id, $this->value, ['id' => $this->id, 'readonly' => "readonly"]) . '<input type="button" id="uploadButton" value="Upload" />';
                    break;
                case 'colorpicker':
                    return Html::input('text', $this->id, $this->value, ['id' => $this->id]) . '<input type="button" id="colorpicker" value="打开取色器" />';
                    break;
                case 'file-manager':
                    return Html::input('text', $this->id, $this->value, ['id' => $this->id]) . '<input type="button" id="filemanager" value="浏览服务器" />';
                    break;
                case 'image-dialog':
                    return Html::input('text', $this->id, $this->value, ['id' => $this->id]) . '<input type="button" id="imageBtn" value="选择图片" />';
                    break;
                case 'file-dialog':
                    return Html::input('text', $this->id, $this->value, ['id' => $this->id]) . '<input type="button" id="insertfile" value="选择文件" />';
                    break;

                default:
                    return Html::textarea($this->id, $this->value, ['id' => $this->id]);
                    break;
            }
        }
    }

    /**
     * 注册客户端脚本
     */
    protected function registerClientScript() {
        //UEditorAsset::register($this->view);
        KindEditorAsset::register($this->view);
        $clientOptions = Json::encode($this->clientOptions);

        $fileManagerJson = Url::to(['Kupload', 'action' => 'fileManagerJson']);
        $uploadJson = Url::to(['Kupload', 'action' => 'uploadJson']);
        switch ($this->editorType) {
            case 'uploadButton':
                $url = Url::to(['Kupload', 'action' => 'uploadJson', 'dir' => 'file']);

                $script = <<<EOT
                             KindEditor.ready(function(K) {
				var uploadbutton = K.uploadbutton({
					button : K('#uploadButton')[0],
					fieldName : 'imgFile',
                                        url : '{$url}',
					afterUpload : function(data) {
						if (data.error === 0) {
							var url = K.formatUrl(data.url, 'absolute');
							K('#{$this->id}').val(url);
						} else {
							alert(data.message);
						}
					},
					afterError : function(str) {
						alert('自定义错误信息: ' + str);
					}
				});
				uploadbutton.fileBox.change(function(e) {
					uploadbutton.submit();
				});
			});
EOT;

                break;
            case 'colorpicker':
                $script = <<<EOT
                            KindEditor.ready(function(K) {
				var colorpicker;
				K('#colorpicker').bind('click', function(e) {
					e.stopPropagation();
					if (colorpicker) {
						colorpicker.remove();
						colorpicker = null;
						return;
					}
					var colorpickerPos = K('#colorpicker').pos();
					colorpicker = K.colorpicker({
						x : colorpickerPos.x,
						y : colorpickerPos.y + K('#colorpicker').height(),
						z : 19811214,
						selectedColor : 'default',
						noColor : '无颜色',
						click : function(color) {
							K('#{$this->id}').val(color);
							colorpicker.remove();
							colorpicker = null;
						}
					});
				});
				K(document).click(function() {
					if (colorpicker) {
						colorpicker.remove();
						colorpicker = null;
					}
				});
			});
EOT;

                break;
            case 'file-manager':
                $script = <<<EOT
                           KindEditor.ready(function(K) {
				var editor = K.editor({
                                      
					fileManagerJson : '{$fileManagerJson}'
				});
				K('#filemanager').click(function() {
					editor.loadPlugin('filemanager', function() {
						editor.plugin.filemanagerDialog({
							viewType : 'VIEW',
							dirName : 'image',
							clickFn : function(url, title) {
								K('#{$this->id}').val(url);
								editor.hideDialog();
							}
						});
					});
				});
			});
EOT;

                break;
            case 'image-dialog':
                $script = <<<EOT
                          KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager : true,
                                        "uploadJson":"{$uploadJson}",
                                         "fileManagerJson":"{$fileManagerJson}",
                                        
				});
				K('#imageBtn').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							imageUrl : K('#{$this->id}').val(),
							clickFn : function(url, title, width, height, border, align) {
								K('#{$this->id}').val(url);
								editor.hideDialog();
							}
						});
					});
				});
			});
EOT;

                break;
            case 'file-dialog':
                $script = <<<EOT
                          KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager : true,
                                        "uploadJson":"{$uploadJson}",
                                         "fileManagerJson":"{$fileManagerJson}",
                                        
				});
				K('#insertfile').click(function() {
					editor.loadPlugin('insertfile', function() {
						editor.plugin.fileDialog({
							fileUrl : K('#{$this->id}').val(),
							clickFn : function(url, title) {
								K('#{$this->id}').val(url);
								editor.hideDialog();
							}
						});
					});
				});
			});
EOT;

                break;
            default:
                $script = "KindEditor.ready(function(K) {
	K.create('#" . $this->id . "', " . $clientOptions . ");
});";
                break;
        }

        $this->view->registerJs($script, View::POS_END);
    }

}

?>
