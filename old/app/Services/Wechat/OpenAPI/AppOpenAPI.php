<?php
/**
 * Created by PhpStorm.
 * User: jackie
 * Date: 4/25/16
 * Time: 11:46 PM
 */
namespace App\Services\Wechat\OpenAPI;

use EasyWeChat\Core\AbstractAPI;

class AppOpenAPI extends AbstractAPI
{
    const API_CTRL_DEVICE = "https://api.weixin.qq.com/hardware/mydevice/platform/ctrl_device";

    /**
     * 设备控制 (http://iot.weixin.qq.com/wiki/doc/hardwarecloud/openapi.pdf#12)
     *
     * @param $device_type
     * @param $device_id
     * @param $user
     * @param array $services
     * @param array|null $data
     * @return \EasyWeChat\Support\Collection
     */
    public function ctrl_device($device_type, $device_id, $user, $services=[], $data=null)
    {
        $params = compact('device_type', 'device_id', 'user', 'services');

        if(!is_null($data)){
            $params['data'] = $data;
        }
        
        return $this->parseJSON('json', [self::API_CTRL_DEVICE, $params]);
    }
}