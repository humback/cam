<?php
/**
 * Created by PhpStorm.
 * User: jackie
 * Date: 4/24/16
 * Time: 10:35 PM
 */

namespace App\Services\Wechat\Device;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class DeviceServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['device'] = function($pimple) {
            return new DeviceAPI($pimple['access_token']);
        };
    }

}