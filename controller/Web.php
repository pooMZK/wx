<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2018/1/11
 * Time: 12:30
 */

namespace app\wx\controller;


class Web extends Base
{

    public function getCode(){
        $appid=config('wx.appid');
        $redirect_uri=urlencode('www.fcczzu.cn');
    }
}