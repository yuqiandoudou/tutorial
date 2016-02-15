<?php
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Controller;
class ControllerBase extends Controller{
          public function beforeNotFoundAction(Event $event, Dispatcher $dispatcher) {
               $activeController = $dispatcher->getActiveController(); //加载控制器，实质是一个类
               $actions = call_user_func_array(array($activeController, 'actions'), array());//获取类中的actions方法
               if (isset($actions[$dispatcher->getActionName()])) {
                   $actionClass = $actions[$dispatcher->getActionName()] . "Action";
                   $actionFile = APP_DIR . "/actions/" . $actionClass .   ".php";
                   if (!file_exists($actionFile)) {
                       return true; // 没有找到对应的处理类，则返回让程序继续执行，由框架处理
                   }
                   require_once($actionFile);
                   $actionClass = explode("/", $actionClass);
                   $actionClass = array_pop($actionClass);
                   if (class_exists($actionClass)) {
                       (new $actionClass())->execute();
                       return false;
                   }
               }
          }
}
