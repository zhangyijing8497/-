<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Model\UserModel;

class LoginController extends Controller
{
    public function addUser()
    {
        /*密码进行加密*/
        $pass='123456abc';
        $email='zhangsan@qq.com';
        $user_name=Str::random(8);
        
        /*使用密码函数进行加密*/
        $password=password_hash($pass,PASSWORD_BCRYPT);
        
        $data=[
            'user_name'=> $user_name,
            'password' => $password,
            'email' => $email,
        ];
       $uid = UserModel::insertGetId($data);
       var_dump($uid);
    } 
}
