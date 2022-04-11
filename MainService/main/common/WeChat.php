<?php
// 字符编码
header("Content-Type:text/html; charset=utf-8");

// 微信接口类
class WeChat
{
    private static $appid;
    private static $appsecret;

    function __construct()
    {
        self::$appid = '';      // 开发者ID(AppID)
        self::$appsecret = '';  // 开发者密码(AppSecret)
    }

    // 微信授权地址
    public static function getAuthorizeUrl($url)
    {
        $url_link = urlencode($url);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . self::$appid . "&redirect_uri={$url_link}&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
    }

    // 获取TOKEN
    public static function getToken()
    {
        $urla = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . self::$appid . "&secret=" . self::$appsecret;
        $outputa = self::curlGet($urla);
        $result = json_decode($outputa, true);
        return $result['access_token'];
    }

    /**
     * getUserInfo 获取用户信息
     * @param string $code 微信授权code
     * @param string $weiwei_token Token
     * @return array
     */
    public static function getUserInfo($code, $weiwei_token)
    {
        $access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . self::$appid . "&secret=" . self::$appsecret . "&code={$code}&grant_type=authorization_code";
        $access_token_json = self::curlGet($access_token_url);
        $access_token_array = json_decode($access_token_json, true);
        $openid = $access_token_array['openid'];
        $new_access_token = $weiwei_token;

        //全局access token获得用户基本信息
        $userinfo_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$new_access_token}&openid={$openid}";
        $userinfo_json = self::curlGet($userinfo_url);
        $userinfo_array = json_decode($userinfo_json, true);
        return $userinfo_array;
    }

    /**
     * 发送get请求
     * @param string $url 链接
     * @return bool|mixed
     */
    private static function curlGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        if (curl_errno($curl)) {
            return 'ERROR ' . curl_error($curl);
        }
        curl_close($curl);
        return $output;
    }

    /**
     * 发送post请求
     * @param string $url 链接
     * @param string $data 数据
     * @return bool|mixed
     */
    private static function curlPost($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}

/**
 * get_page_url 获取完整URL
 * @return url
 */
function get_page_url($type = 0)
{
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == 'on') {
        $pageURL .= 's';
    }
    $pageURL .= '://';
    if ($type == 0) {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"];
    }
    return $pageURL;
}