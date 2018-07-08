<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/20
 * Time: 19:59
 */

namespace app\core\components;

use yii\console\Application as ConsoleApplication;
use yii\helpers\Url;
use yii\web\Application as WebApplication;
use yii\web\GroupUrlRule;

abstract class AbstractModule extends \yii\base\Module
{
    public $disableDebugModule = false;

    public static function getUrlPrefix()
    {
        return static::getModuleId();
    }

    public static function getRoutePrefix()
    {
        return static::getModuleId();
    }

    abstract public static function getUserComponent();

    public static function getRouteRules()
    {
        return [
            '' => 'site/index',
            '<controller>' => '<controller>/index',
            '<controller>/<action>' => '<controller>/<action>',
        ];
    }

    public static function getUrlRules()
    {
        return [
            'class' => GroupUrlRule::class,
            'prefix' => static::getUrlPrefix(),
            'routePrefix' => static::getRoutePrefix(),
            'rules' => static::getRouteRules(),
        ];
    }

    public static function toRoute($route, $scheme = false)
    {
        if (is_array($route)) {
            $route[0] = '/' . static::getUrlPrefix() . '/' . $route[0];
        } else {
            $route = '/' . static::getUrlPrefix() . '/' . $route;
        }

        return Url::toRoute($route, $scheme);
    }

    abstract public static function getModuleId();

    public function init()
    {
        parent::init();

        $this->layout = 'main';

        if (\Yii::$app instanceof WebApplication) {
            \Yii::$app->getErrorHandler()->errorAction = static::getRoutePrefix() . '/site/error';
        }

        if (\Yii::$app instanceof ConsoleApplication) {
            $namespace = (new \ReflectionClass(get_called_class()))->getNamespaceName();
            $this->controllerNamespace = $namespace . '\\commands';
        }

        if ($this->disableDebugModule) {
            /* @var $debug \yii\debug\Module|null */
            $debug = \Yii::$app->getModule('debug');

            if ($debug) {
                $debug->allowedIPs = [];
            }
        }
    }
}
