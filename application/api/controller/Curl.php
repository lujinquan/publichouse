<?php

namespace app\api\controller;

use think\Db;
use think\Controller;

/**
 * @title https
 * @author Mr.Lu
 * @description
 */
class Curl extends Controller
{
	public function curl(){
        $url = input('url');
        if($url){
        	$res = $this->httpCurl($url);
        	halt($res);
        }else{
        	echo '请传递url参数，如?url=http://www.baidu.com';
        }
        $url = $http.'://www.baidu.com';
        
    }

        /**
     * [httpCurl HTTP请求]
     * @param  [type] $url      [description]
     * @param  string $type     [description]
     * @param  string $postData [description]
     * @return [type]           [description]
     */
    public function httpCurl($url, $type='get', $postData='')
    {
        //1.初始化
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//部分链接url要以https协议进行，设定以跳过证书验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($ch,CURLOPT_CAPATH ,dirname(__FILE__)."/");

        // curl_setopt($ch,CURLOPT_CAINFO ,"cacert.pem");
        // curl_setopt($ch, CURLOPT_CAINFO, "./cacert.pem");
        //2.设置curl参数
        curl_setopt($ch, CURLOPT_URL, $url); //要链接的url
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //将curl_exec()获取的信息以字符串返回，而不是直接输出。
        
        if($type == 'post'){
            curl_setopt($ch, CURLOPT_POST, true); //true时发送post请求；
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        //3.执行curl请求
        $res = curl_exec($ch); //将返回一个json格式的字符串
        halt(curl_errno($ch));
        //4.返回结果并关闭curl连接
        if(curl_errno($ch)){
            return curl_error($ch);
        }
        curl_close($ch);
        return $res;
    }
}