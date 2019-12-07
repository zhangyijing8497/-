<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WxController extends Controller
{
    public function wechat()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $echostr = $_GET["echostr"];
        
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if( $tmpStr == $signature ){
            echo $echostr;
        }else{
            die "not ok";
        }
    }
}
