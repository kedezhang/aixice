<?php
class MaleController extends BaseController {
   public function actionindex(){
       $showList=array(
           'num'=>rand(100,1000)
       );
       //测试
       $this->render('index',$showList);
   }
}