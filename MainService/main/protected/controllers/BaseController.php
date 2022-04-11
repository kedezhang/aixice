<?php

class BaseController extends CController
{
    private $weChat;
    public function __construct()
    {
       $this->weChat=new WeChat();
    }
    public function getWeiXinUserInfo(){
        if(empty($_GET['code']) || !isset($_GET['code'])){
            // 通过授权获取code
            $url = get_page_url();
            $authorize_url = $this->weChat->getAuthorizeUrl($url);
            header("Location:{$authorize_url}"); // 重定向浏览器
            exit();
        }else{
            // 获取微信用户信息
            $code = $_GET['code'];
            $weiwei_token = $this->weChat->getToken(); // 获取微信token
            $user_info = $this->weChat->getUserInfo($code, $weiwei_token);
            return $user_info;
        }
    }
}