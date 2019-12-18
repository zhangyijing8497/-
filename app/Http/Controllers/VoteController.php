<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index()
    {
        echo '<pre>';print_r($_GET);echo '</pre>';
        $code = $_GET['code'];

        // 获取access_token
        $data = $this->getAccessToken($code);
        // 获取用户信息
        $user_info = $this->getUserInfo($data['access_token'],$data['openid']);
    }

    /**
     * 根据code 获取access_token
     */
    protected function getAccessToken($code)
    {
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET').'&code='.$code.'&grant_type=authorization_code';
        $json_data = file_get_contents($url);
        return json_decode($json_data,true);
    }

    /**
     * 获取用户基本信息
     */
    protected function getUserInfo($access_token,$openid)
    {
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        $json_data = file_get_contents($url);
        $user_info = json_decode($json_data,true);
        echo '<pre>';print_r($user_info);echo '</pre>';
    }
}
