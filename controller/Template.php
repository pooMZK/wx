<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2018/1/7
 * Time: 18:13
 */

namespace app\wx\controller;


use think\Controller;

class Template extends Controller
{
    /**
     * 设置行业信息
     * @return mixed
     *
     */

    public function setindustry(){
        $accesstoken=model('accesstoken')->getWxAccessToken();
        $url='https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token='.$accesstoken;
        $data=[
            "industry_id1"=>39,
            "industry_id2"=>31,
        ];
        $data=json_encode($data);
       return myCurl($url,1,$data);
    }

    /**
     * 获取行业信息
     * @return mixed
     *
     */
    public function getindustry(){
        $accesstoken=model('accesstoken')->getWxAccessToken();
        $url='https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token='.$accesstoken;
        return myCurl($url);
    }

    /***
     * 获取模板id
     * @return string
     */
    public function gettemplateid(){
        $accesstoken=model('accesstoken')->getWxAccessToken();
        $data=[
            "template_id_short"=>"TM00015"
        ];
        $data=json_encode($data);
        $url='https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token='.$accesstoken;
        $res=myCurl($url,1,$data);
        $res=json_decode($res);
      //  halt($res);
        if($res){
            return $res->template_id;
        }else{
            return false;
        }
    }

    /**
     * 获取模板列表：包含列表id，内容能字段
     */
    public function gettemplatelist(){
        $accesstoken=model('accesstoken')->getWxAccessToken();
        $url='https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token='.$accesstoken;
        $res=myCurl($url);
        $res=json_decode($res,true);
        var_dump($res);
    }

    /***
     * 删除模板
     * @return mixed
     */
    public function deletetemplate(){
        $accesstoken=model('accesstoken')->getWxAccessToken();
        $url='https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token='.$accesstoken;
        $data=[
            'template_id'=>''//方法写好在这放着，不测试了
        ];
        $data=json_encode($data);
        return myCurl($url,1,$data);

    }

    /***
     * 发送模板消息
     * @return mixed
     */
    public function posttemplate(){
        $accesstoken=model('accesstoken')->getWxAccessToken();
        $url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$accesstoken;
        $data=[
            "touser"=>"o40vIvxT2WOI9SZScVpGeWOHu2QU",
            "template_id"=>"CmyRcj7xCQq4bgmm65kA0goBw4_XVCdAPoHGXWZ4PjA",
            "url"=>"http://weixin.qq.com/download",
            //跳小程序所需数据，不需跳小程序可不用传该数据
//            "miniprogram"=>[
//                "appid"=>"",
//                "pagepath"=>"index?foo=bar"
//            ],
            "data"=>[
                "first"=>[
                    "value"=>"恭喜你购买成功！",
                    "color"=>"#173177"
                ],
                "orderMoneySum"=>[
                    "value"=>"30",
                    "color"=>"red"
                ],
                 "orderProductName"=> [
                       "value"=>"一瓶来自潘帕斯大草原的空气",
                       "color"=>"#173177"
                   ],

                   "Remark"=>[
                       "value"=>"欢迎再次购买",
                       "color"=>"#173177"
                   ]
            ]
        ];
        $data=json_encode($data);
        return myCurl($url,1,$data);
    }
}