<?php
/**
 * Created by PhpStorm.
 * User: jackie
 * Date: 4/25/16
 * Time: 11:46 PM
 */
namespace App\Services\Wechat\OpenAPI;

use EasyWeChat\Core\AccessToken;

class OpenAPI
{
    /**
     * @var AppOpenAPI $app
     */
    public $app;

    /**
     * @var DeviceOpenAPI $device
     */
    public $device;

    public function __construct(AccessToken $accessToken)
    {
        $this->app = new AppOpenAPI($accessToken);
        $this->device = new DeviceOpenAPI($accessToken);
    }
}