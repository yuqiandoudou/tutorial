<?php

use Phalcon\Loader;
use Phalcon\Tag;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;
//use toturail\Controller\ControllerBase as ConBase;
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
ini_set('display_errors','on');
try {

    //路径参数初始化
    define('BASE_DIR', dirname(__DIR__));
    //定义转发的实际模块的路径地址
    define('APP_DIR',BASE_DIR.'/app');
    // Register an autoloader
    $loader = new Loader();
    $loader->registerDirs(
        array(
            '../app/controllers/',
            '../app/models/'
        )
    )->register();

    // Create a DI
    $di = new FactoryDefault();

    // Set the database service
    $di['db'] = function() {
        return new DbAdapter(array(
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "tutorial"
        ));
    };
//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    $di->set('dispatcher', function () {

        // 创建一个事件管理
        $eventsManager = new EventsManager();
        $controller = new ControllerBase();
        // 为“dispatch”类型附上一个侦听者
        $eventsManager->attach("dispatch", 
            $controller
        );

        $dispatcher = new MvcDispatcher();

        // 将$eventsManager绑定到视图组件
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;

    }, true);
    //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    // Setting up the view component
    $di['view'] = function() {
        $view = new View();
        $view->setViewsDir('../app/views/');
        return $view;
    };

    // Setup a base URI so that all generated URIs include the "tutorial" folder
    $di['url'] = function() {
        $url = new Url();
        $url->setBaseUri('/tutorial/');
        return $url;
    };

    // Setup the tag helpers
    $di['tag'] = function() {
        return new Tag();
    };

    // Handle the request
    $application = new Application($di);

    echo $application->handle()->getContent();

} catch (Exception $e) {
     echo "Exception: ", $e->getMessage();
}
