<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2018/1/30
 * Time: 17:08
 */

namespace app\wx\controller;


use think\Controller;

class Sucai extends Base
{
    public function shorttimeAdd(){
        $accesstoken=$this->accesstoken;
     //   halt($accesstoken);
        $type='image';
        $data=array("media"=>new \CURLFile('D:\Program\www\O2O\public\alipay.png'));
        $url='https://api.weixin.qq.com/cgi-bin/media/upload?access_token='.$accesstoken.'&type='.$type;
        return myCurl($url,1,$data);
    }

}