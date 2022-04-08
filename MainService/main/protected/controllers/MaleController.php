<?php
class MaleController extends CController{
   public function actionindex(){
       $showList=array(
           'num'=>rand(100,1000)
       );
       $this->render('index',$showList);
   }
}