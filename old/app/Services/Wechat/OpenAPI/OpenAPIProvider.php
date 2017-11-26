<?php
/**
 * Created by PhpStorm.
 * User: jackie
 * Date: 4/24/16
 * Time: 10:35 PM
 */

namespace App\Services\Wechat\OpenAPI;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class OpenAPIProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['openAPI'] = function($pimple) {
            return new OpenAPI($pimple['access_token']);
        };
    }

}