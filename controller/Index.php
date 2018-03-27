<?php
/**
 * Created by PhpStorm.
 * User: my
 * Date: 2017/12/22
 * Time: 15:11
 */

namespace app\wx\controller;


use think\Controller;


class Index extends Controller{

    public function index(){

        $data=input('param.');

      //  test
//        $mark='get数据为：';
//        foreach ($data as $key=>$value){
//           $mark.=$key.':'.$value."\r\n";
//        }
//        $this->testlog($mark);//请求参数记录

        $this->checkform();//信息来源验证，保证是微信服务器来源

        if (array_key_exists("echostr",$data)){//第一次链接走这
               die($data['echostr']);
        }else{

            $this->response();

        }

    }

    private function checkform(){		// 获得由微信公众平台请求的验证数据
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $token='poower';
        // 将时间戳，随机字符串，token按照字母顺序排序并连接
        $tmp_arr = array($token, $timestamp, $nonce);
        sort($tmp_arr, SORT_STRING);// 字典顺序
        $tmp_str = implode($tmp_arr);//连接
        $tmp_str = sha1($tmp_str);// sha1签名

        if ($signature == $tmp_str) {
            return true;
        } else {
            die('Where are you from?');
        }

    }



    private function response(){
        /*
         * <xml>  <ToUserName>< ![CDATA[toUser] ]></ToUserName>  <FromUserName>< ![CDATA[fromUser] ]></FromUserName>  <CreateTime>1348831860</CreateTime>  <MsgType>< ![CDATA[text] ]></MsgType>  <Content>< ![CDATA[this is a test] ]></Content>  <MsgId>1234567890123456</MsgId>  </xml>
         */
        $data=$GLOBALS['HTTP_RAW_POST_DATA'];
        $this->testlog($data);

        if (empty($data)) {
            $this->testlog('xml字符串为空');
        }

        libxml_disable_entity_loader(true);//禁止xml实体解析，防止xml注入
        $xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);//从字符串获取simpleXML对象

        $to=$xml->FromUserName;
        $from=$xml->ToUserName;

        switch ($xml->MsgType){
            case 'text'://文本消息处理
                $content=$xml->Content;
                $this->textfollow($to,$from,$content);

            break;
            case 'event';//事件处理
                $event=$xml->Event;
                $this->eventfollow($to,$from,$event,$xml);
                break;
        }


    }

    private function textfollow($to,$from,$content){
        switch ($content){
            case 1;//关键字回复
                $reversion="一帆风顺";
                $this->respondtext($to,$from,$reversion);
               break;
            case 2;
                $reversion="二龙戏珠";
                $this->respondtext($to,$from,$reversion);
                break;
            case 3;
                $reversion="<a href='http://www.fcczzu.cn'>网站</a>";
                $this->respondtext($to,$from,$reversion);
                break;
            case 4;

                $this->respondtuwen($to,$from);
                break;
            default;
                $reversion="What are you 想弄啥嘞";
                $this->respondtext($to,$from,$reversion);
                break;
        }


    }
    private function eventfollow($to,$from,$event,$xml){
        if($event=="subscribe"){//关注事件处理
            $reversion="大漠孤烟直，\n长河落日圆";
            $this->respondtext($to,$from,$reversion);
        }elseif ($event=="unsubscribe"){//取消关注事件处理

        }elseif ($event=="TEMPLATESENDJOBFINISH"){//模板消息发送事件

        }elseif ($event=='LOCATION'){
            $data='经度：'.$xml->Longitude.'\n
                维度'.$xml->Latitude;
            $this->testlog($data);
        }

    }




   private function respondtext($to,$from,$reversion){//回复文本

       $temp="<xml>
                       <ToUserName><![CDATA[%s]]></ToUserName>
                       <FromUserName><![CDATA[%s]]></FromUserName>
                       <CreateTime>%s</CreateTime>
                       <MsgType><![CDATA[%s]]></MsgType>
                       <Content><![CDATA[%s]]></Content>
                       </xml>";
       $e=sprintf($temp,$to,$from,time(),'text',$reversion);
    //   $this->testlog($e);
       echo $e;

   }


   private function respondtuwen($to,$from){
       $arr=[
           0=>[
               'title'=>'百度',
               'description'=>'蓦然回首，那人却在灯火阑珊处',
               'picUrl'=>'http://img.zcool.cn/community/01fba55549a6ac0000019ae935b28c.jpg@1280w_1l_2o_100sh.jpg',
               'url'=>'http://www.baidu.com'
           ],
           1=>[
               'title'=>'优酷',
               'description'=>'优一酷',
               'picUrl'=>'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1514638626970&di=789b8330819d819c4411db0952183553&imgtype=0&src=http%3A%2F%2Fimg.zcool.cn%2Fcommunity%2F01f68b58cc2725a801219c77c16ccb.png%40900w_1l_2o_100sh.jpg',
               'url'=>'http://www.youku.com/'
           ],

       ];
      // $count=count($array);
       //count(array_filter($array)):返回数组中非空元素个数


       $template = "<xml>
						<ToUserName><![CDATA[".$to."]]></ToUserName>
						<FromUserName><![CDATA[".$from."]]></FromUserName>
						<CreateTime>".time()."</CreateTime>
						<MsgType><![CDATA[news]]></MsgType>
						<ArticleCount>".count($arr)."</ArticleCount>
						<Articles>";
       foreach($arr as $k=>$v){
           $template .="<item>
							<Title><![CDATA[".$v['title']."]]></Title> 
							<Description><![CDATA[".$v['description']."]]></Description>
							<PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>
							<Url><![CDATA[".$v['url']."]]></Url>
							</item>";
       }

       $template .="</Articles>
						</xml> ";
       echo $template;


   }

    private function music($to,$from,$title,$description,$url,$hurl){
       $temp="<xml>
                <ToUserName>< ![CDATA[$to] ]></ToUserName>
                <FromUserName>< ![CDATA[$from] ]></FromUserName>
                <CreateTime>time()</CreateTime>
                <MsgType>< ![CDATA[music] ]></MsgType>
                <Music>
                  <Title>< ![CDATA[$title] ]></Title>
                  <Description>< ![CDATA[$description] ]></Description>
                  <MusicUrl>< ![CDATA[$url] ]></MusicUrl>
                  <HQMusicUrl>< ![CDATA[$hurl] ]></HQMusicUrl>
                  <ThumbMediaId>< ![CDATA[media_id] ]></ThumbMediaId>
                </Music>
              </xml>";
    }
    private function testlog($data){


        file_put_contents("../mytestlog.txt", date('Y-m-d H:i:s',time())."\r\n".$data."\r\n".'-----------------------------------------'."\r\n", FILE_APPEND);
    }



    public function getQrCode(){

    }




}