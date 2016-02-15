<?php

class IndexAction extends Lib\BaseAction {
         public function declarations() {
               $this->declareService = 'Index/index';
               $this->declareRender  = 'json';
         }
}
