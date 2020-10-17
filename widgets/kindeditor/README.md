KindEditor
===========
**修复了linux下的一些bug，由于Yii China 无法更新这些信息，抱歉。使用方法务必参考本文，YiiChina上的方法有拼写问题，因为无法修改，所以一定要看这个！！！***


中文的使用说明在页面下部
# install
Either run

`
$ php composer.phar require pjkui/kindeditor "*"
`

or add

`
"pjkui/kindeditor": "*"
`

to the `require` section of your `composer.json` file.

`'pjkui\\kindeditor\\'=>array($vendorDir . '/pjkui/kindeditor')`,
# Usage example

## add an actions() method in controller  

```php
public function actions()
{
    return [
        'Kupload' => [
            'class' => 'pjkui\kindeditor\KindEditorAction',
        ]
    ];
}
```

##used in view :  
```php

echo \pjkui\kindeditor\KindEditor::widget([]);
```

or ：

```php
echo $form->field($model,'colum')->widget('pjkui\kindeditor\KindEditor',[]);
```

or ：
```php
<?= $form->field($model, 'content')->widget('pjkui\kindeditor\KindEditor',
['clientOptions'=>['allowFileManager'=>'true',
'allowUpload'=>'true']]) 
?>
```
## configure 
 you can configure `clientOption` and `editorType` to change the kindeditor's preference, the detail configure see the official website[KindEditor website](http://kindeditor.net/doc.php)

###`editorType` configure
1. Work as text editor，default configure.
 
usage:
```php
 <?= $form->field($model, 'content')->widget('pjkui\kindeditor\KindEditor',
        ['clientOptions'=>['allowFileManager'=>'true',
                            'allowUpload'=>'true'
                            ]
        ]) ?>
```
 
2. `uploadButton`Kindediotr work as a upload file button ,can upload file/picture to the server automatic 
usage:
```php
<?= $form->field($model, 'article_pic')->widget('pjkui\kindeditor\KindEditor',
                    ['clientOptions'=>[
                                        'allowFileManager'=>'true',
                                        'allowUpload'=>'true'
                                        ],
                    'editorType'=>'uploadButton
                    ]) 
?>
```
3. `colorpicker`kindeditor work as color picker 
usage:
```php
<?= $form->field($model, 'content')->widget('pjkui\kindeditor\KindEditor',
                                                    'editorType'=>'colorpicker'])
        ?>
```
4. `file-manager`kindeditor work as file manager,can view and select the file which uploaded by it . 
usage:
```php
<?= $form->field($model, 'article_pic')->widget('pjkui\kindeditor\KindEditor',
                    ['clientOptions'=>[
                                'allowFileManager'=>'true',
                                'allowUpload'=>'true'
                                    ],
                        'editorType'=>'file-manager'
                        ]) 
        ?>
```
5. `image-dialog`kindeditor work as image upload dialog. 
usage:
```php
<?= $form->field($model, 'article_pic')->widget('pjkui\kindeditor\KindEditor',
                        ['clientOptions'=>['allowFileManager'=>'true',
                                            'allowUpload'=>'true'
                                            ],
                        'editorType'=>'image-dialog'
                        ]) 
?>
```
6. `file-dialog`kindeditor work as file upload dialog. 
usage:
```php
<?= $form->field($model, 'article_pic')->widget('pjkui\kindeditor\KindEditor',
                                ['clientOptions'=>['allowFileManager'=>'true',
                                                    'allowUpload'=>'true'],
                                'editorType'=>'file-dialog'
                                ])
    ?>
```

simple demo:  
```php
use \pjkui\kindeditor\KindEditor;
echo KindEditor::widget([
    'clientOptions' => [
        //editor size
        'height' => '500',
        //custom menu 
        'items' => [
        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink', '|', 'about'
        ]
]);
```

KindEditor中文手册
===========

# 如何安装
第一种方法：
如果装了composer,可以运行这个命令

```php
$ php composer.phar require pjkui/kindeditor "*"
```
第二种方法：
将
```php
"pjkui/kindeditor": "*"
```
加入到项目 `composer.json` 文件的`require` 部分。

第三种方法：
直接将程序文件放到系统的vendor下面,其实建议用compaser,这个是比较方便和规范的安装方法，如果是拷贝的话，有一个文件需要修改，以保证这个kindeditor类被加载。
这个文件是`/vendor/composer/autoload_psr4.php`.添加一行
```php
'pjkui\\kindeditor\\'=>array($vendorDir . '/pjkui/kindeditor'),
```
# 使用方法

##控制器:  
在控制器中加入这个方法：
```php
public function actions()
{
    return [
        'Kupload' => [
            'class' => 'pjkui\kindeditor\KindEditorAction',
        ]
    ];
}
```

##视图:  
先在视图中加入

```php

echo \pjkui\kindeditor\KindEditor::widget([]);
```

或者：

```php
echo $form->field($model,'colum')->widget('pjkui\kindeditor\KindEditor',[]);
```

或者：
```php
<?= $form->field($model, 'content')->widget('pjkui\kindeditor\KindEditor',
['clientOptions'=>['allowFileManager'=>'true',
'allowUpload'=>'true']]) 
?>
```
## 具体相关功能配置

编辑器相关配置，请在`view 中配置，参数为`clientOptions，比如定制菜单，编辑器大小等等，具体参数请查看[KindEditor官网文档](http://kindeditor.net/doc.php)。

### `editorType`配置
1. 配置为富文本编辑器，默认配置
 
 示例：
 
```php
<?= $form->field($model, 'content')->widget('pjkui\kindeditor\KindEditor',
        ['clientOptions'=>['allowFileManager'=>'true',
                            'allowUpload'=>'true'
                            ]
        ])
 ?>
```
 
2. 这时候配置kindeditor为上传文件按钮，可以自动上传文件到服务器
 示例：
 
```php
<?= $form->field($model, 'article_pic')->widget('pjkui\kindeditor\KindEditor',
                    ['clientOptions'=>[
                                        'allowFileManager'=>'true',
                                        'allowUpload'=>'true'
                                        ],
                    'editorType'=>'uploadButton
                    ]) 
?>
```
3. 配置kindeditor为取色器
 示例：

```php
<?= $form->field($model, 'content')->widget('pjkui\kindeditor\KindEditor',
                                                    'editorType'=>'colorpicker'])
        ?>
```
4. 配置kindeditor为文件管理器，可以查看和选着其上传的文件。
 示例：

```php
<?= $form->field($model, 'article_pic')->widget('pjkui\kindeditor\KindEditor',
                    ['clientOptions'=>[
                                'allowFileManager'=>'true',
                                'allowUpload'=>'true'
                                    ],
                        'editorType'=>'file-manager'
                        ]) 
        ?>
```
5. 配置kindeditor为图片上传对话框。
 示例：

```php
<?= $form->field($model, 'article_pic')->widget('pjkui\kindeditor\KindEditor',
                        ['clientOptions'=>['allowFileManager'=>'true',
                                            'allowUpload'=>'true'
                                            ],
                        'editorType'=>'image-dialog'
                        ]) 
?>
```

6.  配置kindeditor为文件上传对话框。
 示例：

```php
<?= $form->field($model, 'article_pic')->widget('pjkui\kindeditor\KindEditor',
                                ['clientOptions'=>['allowFileManager'=>'true',
                                                    'allowUpload'=>'true'],
                                'editorType'=>'file-dialog'
                                ])
    ?>
```


简单 示例:  
```php
use \pjkui\kindeditor\KindEditor;
echo KindEditor::widget([
    'clientOptions' => [
        //编辑区域大小
        'height' => '500',
        //定制菜单
        'items' => [
        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink', '|', 'about'
       ],
       'id'=>'thisID',//填写你想给textarea的id
]);
```
