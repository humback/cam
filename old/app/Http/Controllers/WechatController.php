<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;

class WechatController extends Controller
{
    protected $config, $app;
    public function __construct()
    {
        $this->config = config('wechat');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $app = new Application($this->config);

        return $this->startApplication($app);
    }

    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function device($name)
    {
        $config = $this->config['device'][$name];
        if(is_null($config)){
            throw new ModelNotFoundException();
        };
        $options = array_merge($this->config, $config);
        $app = new Application($options);
        
        return $this->startApplication($app);
    }

    public function callback(Request $request)
    {
        $app = new Application($this->config);
        // 获取 OAuth 授权结果用户信息
        $user = $app->oauth->user();
        session(['wechat_user' => $user]);

        $targetUrl = session('target_url', $request->input('target', '/'));
		echo 'location:'. $targetUrl;
        header('location:'. $targetUrl);		
    }

    /**
     * @param \EasyWeChat\Foundation\Application $app
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function startApplication(&$app)
    {
        $this->app = $app;
        return $this->serve($app->server);
    }

    /**
     * @param \EasyWeChat\Server\Guard  $server
     * @return mixed
     */
    private function serve(&$server)
    {
        $server->setMessageHandler(function($message) {
            $type = $message->MsgType?:'other';
            $method = 'handle' . ucfirst(strtolower($type));
            if(method_exists($this, $method)){
                return $this->$method($message);
            }
        });
        return $server->serve();
    }

    private function handleEvent($message)
    {
        $event = $message->Event?:'other';
        $method = 'handleEvent' . ucfirst(strtolower($event));
        if(method_exists($this, $method)){
            return $this->$method($message);
        }
        return '事件消息';
    }

    private function handleText($message)
    {
        return '文本消息';
    }

    private function handleImage($message)
    {
        return '图片消息';
    }

    private function handleVoice($message)
    {
        return '语音消息';
    }

    private function handleVideo($message)
    {
        return '视频消息';
    }

    private function handleLocation($message)
    {
        return '位置消息';
    }

    private function handleLink($message)
    {
        return '链接消息';
    }

    private function handleOther($message)
    {
        return '其他消息';
    }

    /*
     * Begin handle event message
     */

    private function handleEventSubscribe($message)
    {
        return '您好，欢迎关注安信可科技！';
    }

    private function handleEventUnsubscribe($message)
    {
        // 用户取消关注
        return '';
    }

    private function handleEventLocation($message)
    {
        // 用户端上报地理位置
        return '您的纬度:'.$message->Latitude().'您的经度:'.$message->Longitude();
    }

    private function handleEventClick($message)
    {
        // 用户点击菜单
        if($message->EventKey=='openId') {
            // 获取OpenId
            $userInfo = $this->app->user->get($message->FromUserName);

            return 'OpenID:'.$userInfo->openid."\n".
                   '昵称:'.$userInfo->nickname."\n".
                   '性别:'.$userInfo->sex."\n".
                   '语言:'.$userInfo->language."\n".
                   '城市:'.$userInfo->city."\n".
                   '省:'.$userInfo->province."\n".
                   '国家:'.$userInfo->country."\n";
        }
    }
}
