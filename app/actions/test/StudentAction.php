<?php 
//use Phalcon\Mvc\View\Simple;
class StudentAction {
    protected $declareService;
    protected $declareRender;
    protected $req;
    protected $res;
    protected function declarations() {
         $this->declareService = 'test/Student';
         $this->declareRender = 'json';
    }
    public function execute() {
        try {
            $this->declarations();
            //获取可能有的传值
            $get = is_array($_GET) ? $_GET : array();
            $post = is_array($_POST) ? $_POST : array();
            $request = is_array($_REQUEST) ? $_REQUEST : array();
            $this->req = array(
                'params' => array_merge($get, $post, $request),
                'cookies' => $_COOKIE,
                'files' => $_FILES,
            );
            $this->runService();
        } catch (Exception $e){
        
        
        }
     //   这里可以加你的渲染模板
        //$this->view();
    }
    private function runService() {
        if ($this->declareService) {
            $serviceClass = APP_DIR . "/servlet/" . $this->declareService . "Service";
            $serviceFile = $serviceClass . ".php";
            require_once($serviceFile);
            $serviceClass = explode("/", $serviceClass);
            $serviceClass = array_pop($serviceClass);
            $service = new $serviceClass();
            $service->run();
            //$this-req里面是前端传过来的数据可以直接处理
            }     
    }
   }
?>
