<?php
namespace app\components;

use Yii;
use yii\web\Controller;

/**
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class BaseController extends Controller
{

    public function init()
    {
        parent::init();
        $this->setLanguage();
    }

    /**
     * Set the language displayed on the current site
     */
    public function setLanguage()
    {
        Yii::$app->language = 'zh-CN';
    }
}