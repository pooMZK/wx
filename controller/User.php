<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2018/1/8
 * Time: 13:15
 */

namespace app\wx\controller;



class User extends Base
{
    //用户管理接口

    /**
     * 创建标签
     * @return mixed
     */
    public function settag(){
    $url='https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.$this->accesstoken;
    $data=[
     'tag'=>[
         'name'=>'说得对',
        ]
     ];
    $data=json_encode($data,JSON_UNESCAPED_UNICODE);
     //   $data='{   "tag" : {     "name" : "广东"   } }';
    return myCurl($url,1,$data);
    }

    /**
     * 获取标签
     * @return mixed
     */
    public function gettag(){
        $url='https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$this->accesstoken;
        return myCurl($url);
    }


    /**
     * 获取用户基本信息，包含头像
     */
    public function information(){
        $id='o40vIvxT2WOI9SZScVpGeWOHu2QU';
        $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->accesstoken.'&openid='.$id.'&lang=zh_CN';
        $data=myCurl($url);
        $res=json_decode($data,true);
        halt($res);
    }


}