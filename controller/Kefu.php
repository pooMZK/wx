<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2018/1/12
 * Time: 12:32
 */

namespace app\wx\controller;


class Kefu extends Base
{
    //测试号不能用
    public function addkefu(){
        $url='https://api.weixin.qq.com/customservice/kfaccount/add?access_token='.$this->accesstoken;
        $data='{
     "kf_account" : "test1@gh_1df38865b5ce",
     "nickname" : "客服11112",
    
     }';
        return myCurl($url,1,$data);
    }

    public function getkefu(){
        $url='https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token='.$this->accesstoken;
        return myCurl($url);
    }
}