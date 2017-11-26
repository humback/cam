<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;

class MenuController extends Controller
{
    public $app;

    /**
     * MenuController constructor
     */
    public function  __construct()
    {
        $config = config('wechat');
        $this->app = new Application($config);
    }

    /**
     * @param \EasyWeChat\Menu\Menu $menu
     * @return mixed
     */ 
    private function menu(&$menu)
    {
        $buttons = [
            [
                "name"       => "添加设备",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "扫描二维码",
                        "url"  => "http://wechat.ai-thinker.com/common/devices/add"
                    ],
                    [
                        "type" => "view",
                        "name" => "WiFi配置",
                        "url"  => "http://wechat.ai-thinker.com/common/wifi/config"
                    ]                    
                ]
            ], 
            [
                "type" => "view",
                "name" => "我的设备",
                "url"  => "https://hw.weixin.qq.com/devicectrl/panel/device-list.html?appid=wxc71ef836ecf81bc4"
            ]
        ];
        return $menu->add($buttons);
    }

    public function postIndex(){
		
		echo '123';
        //return $this->menu($this->app->menu);
    }
	
	public function getMenu(){
		
		//echo '123';
        return $this->menu($this->app->menu);
    }
}
