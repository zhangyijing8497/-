<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class VoteController extends Controller
{
    /**
     * 只能测试用,线上禁用
     */
    public function delKey()
    {
        $key =$_GET['k'];
        echo 'delete key: ' .$key;echo '</br>';
        Redis::del($key);
    }

    public function index()
    {
        //echo '<pre>';print_r($_GET);echo '</pre>';
        $code = $_GET['code'];
        //获取access_token
        $data = $this->getAccessToken($code);
        //获取用户信息
        $user_info = $this->getUserInfo($data['access_token'],$data['openid']);
        
        // 保存用户信息
        $userinfo_key = 'h:u:'.$data['openid'];
        Redis::hMset($userinfo_key,$user_info);

        // 处理业务逻辑
        $openid = $user_info['openid'];
        $key = 'ss:vote:zhangsan';

        // 判断是否已经投过票
        if(Redis::zrank($key,$user_info['openid'])){
            echo "您已投过票了!";
        }else{
            Redis::Zadd($key,time(),$openid);
        }

        $total = Redis::zCard($key); //获取总数
        $members = Redis::ZRange($key,0,-1,true); //获取所有投票者的openid
        foreach($members as $k=>$v){
            $u_k = 'h:u:'.$k;
            $u = Redis::hgetAll($u_k);
            // $u = Redis::hMget($u_k,['openid','nickname','sex','headimgurl']);
            echo '<img src="'.$u['headimgurl'].'">';
        }
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

    public function hashTest()
    {
        $uid = 1000;
        $key = 'h:user_info:uid:'.$uid;

        $user_info = [
           'uid'       => $uid,
            'username' => '张三',
            'email'    => '2877503663@qq.com',
            'sex'      => 1,
            'age'      => 18
        ];

        Redis::hMset($key,$user_info);die;
        echo '<hr>';
        $u = Redis::hGetAll($key);
        echo '<pre>';print_r($u);echo '</pre>';
    }
}
