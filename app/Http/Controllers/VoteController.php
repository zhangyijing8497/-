<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class VoteController extends Controller
{
    public function index()
    {
        // echo '<pre>';print_r($_GET);echo '</pre>';
        $code = $_GET['code'];

        // 获取access_token
        $data = $this->getAccessToken($code);
        // 获取用户信息
        $user_info = $this->getUserInfo($data['access_token'],$data['openid']);

        // 处理业务逻辑

        $openid = $user_info['openid'];
        $key = 's:vote:zhangsan';
        Redis::sadd($key,$openid);

        $members = Redis::Smembers($key); //获取所有投票者的openid
        $total = Redis::Scard($keys); //统计投票总人数
        echo "投票总人数: ".$total;
        echo '<hr>';
        echo '<pre>';print_r($members);echo '</pre>';
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
        $data = json_decode($json_data,true);
        if(isset($data['errcode'])){
            // 错误处理
            die('嘿!兄弟出错了 40001');  //40001标识获取用户信息失败
        }
        return $data;
    }
}
