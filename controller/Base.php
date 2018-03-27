<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2018/1/8
 * Time: 13:21
 */

namespace app\wx\controller;


use think\Controller;

class Base extends Controller
{
    public $accesstoken;
    public function _initialize(){
        $accesstoken=model('Accesstoken')->getWxAccessToken();
        $this->accesstoken=$accesstoken;
    }
}