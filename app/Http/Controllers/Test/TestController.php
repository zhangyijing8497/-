<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;

class TestController extends Controller
{
	public function hello()
	{
		echo '111';
		echo '222';
		echo '333';
		echo '444';
	}


	public function redis1()
	{
		$key = 'weixin';
		$val = 'hello';
		Redis::set($key,$val);

		echo time();echo '<hr>';
		echo date('Y-m-d h:i:s');
	}

	public function  redis2()
	{
		$key='weixin';
		echo Redis::get($key);
	}

	public function baidu()
	{
		$url = 'https://www.sina.com.cn/';
		$client = new Client();
		$response = $client->request('GET',$url);
		echo $response->getBody();
	}

	public function index(Request $request)
    {
        $echostr=$request->input('echostr');
        echo $echostr;
    }
}
