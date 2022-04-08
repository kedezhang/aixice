<?php
error_reporting(E_ALL^E_NOTICE ^E_DEPRECATED);
$yii= './../../ConfigService/framework/yii.php';//新路径
$config=dirname(__FILE__).'/protected/config/main.php';
require_once($yii);
Yii::createWebApplication($config)->run();