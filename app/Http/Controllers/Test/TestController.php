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

	/** */
	public function xmlTest()
	{
		$xml_str = '<xml>
		<ToUserName><![CDATA[gh_3f83c040e6b7]]></ToUserName>
		<FromUserName><![CDATA[obbcZwzFGIn4sRC_Ad1cdrh3BJdM]]></FromUserName>
		<CreateTime>1575888051</CreateTime>
		<MsgType><![CDATA[text]]></MsgType>
		<Content><![CDATA[.]]></Content>
		<MsgId>22561292412281981</MsgId>
		</xml>';

		$xml_obj = simplexml_load_string($xml_str);
		echo '<pre>';print_r($xml_obj);echo '</pre>';die;
		echo '<pre>';print_r($xml_obj);echo '</pre>';echo '<hr>';

		echo 'ToUserName: '.$xml_obj->ToUserName;echo '<br>';
		echo 'FromUserName: '.$xml_obj->FromUserName;echo '<br>';
	}

}
