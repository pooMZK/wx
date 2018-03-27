<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/12/25
 * Time: 18:22
 */

namespace app\wx\controller;


use think\Controller;

class Test extends Controller
{
    public function index(){

       // return myCurl("https://www.baidu.com");
        $accesstoken=model('accesstoken')->getWxAccessToken();
        $url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$accesstoken;
        $data=[
            'expire_seconds'=>604800,
            'action_name'=>'QR_STR_SCENE',
            'action_info'=>[
                'scene'=>[
                    'scene_id'=>123
                ]
            ]
        ];
        $data=json_encode($data);
        $res=json_decode(myCurl($url,1,$data));
        $ticket=$res->ticket;
        $url='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($ticket);
        echo "<img src='".$url."'>";//直接输出


        $content = file_get_contents($url);//保存文件
        $name=date('Y-m-d');//保存文件
        file_put_contents('./wxercode/'.$name.'.jpg', $content);//保存文件

    }
}