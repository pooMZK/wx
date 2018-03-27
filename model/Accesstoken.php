<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2018/1/3
 * Time: 9:18
 */

namespace app\wx\model;


use think\Model;

class Accesstoken extends Model
{
    public function getWxAccessToken(){

        $create_time=$this->max('create_time');//取出最大值id，也可是创建时间

        $checktime=time()-$create_time;

        if($checktime>7000){//检查是否过期，如过期重新调取并存入accesstoken，微信服务器规定是7200s
            $this->saveWxAccessToken();
            $create_time=$this->max('create_time');
        }
        //halt($arr);

        $res=$this->where('create_time',$create_time)->value('access_token');
        return $res;

    }



    public function saveWxAccessToken(){//把accesstoken调取并存入数据库
        //1、请求url地址https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
        $appid=config('wx.appid');
        $appsecret=config('wx.appsecret');
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        $res=myCurl($url);
        $arr=json_decode($res,true);
       // halt($arr);
        //    $accesstoken=$arr['access_token'];
        $this->save($arr);

    }

    public function getWxServerIp(){//获取微信ip地址，暂没用  但设计了这个字段，字段名：wxserverip
        $accesstoken=$this->getWxAccessToken();
        $url='https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token='.$accesstoken;
        $res=myCurl($url);
        $arr=json_decode($res,true);
       // print_r($arr);

    }

}