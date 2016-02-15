<?php
use Phalcon\Mvc\Controller;
class TestController extends Controller{
        public function actions(){
             return [
                 'student'=>'test/student',
                 ];      
        }
}

