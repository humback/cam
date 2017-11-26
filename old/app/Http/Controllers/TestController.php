<?php
/**
 * Created by PhpStorm.
 * User: jackie
 * Date: 4/29/16
 * Time: 12:11 AM
 */

namespace App\Http\Controllers;

use App\Services\Wechat\OpenAPI\OpenAPIProvider;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * @var Request $request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function postTest()
    {
        $request = $this->request;
        $this->validate($request, [
            'device_type'   => 'required',
            'device_id'     => 'required',
            'openid'        => 'required',
            'type'          => 'required',
            'content'       => 'required'
        ]);

        $inputs = $request->only(['type', 'openid', 'device_id', 'device_type', 'content']);
        if(!in_array($inputs['type'], ['mobile', 'status'])){
            return response("bad params", 422);
        }

//        $user = $this->wechat->oauth->user();
//
//        if ($inputs['openid'] != $user->id){
//            return response("access denied", 403);
//        }

        /**
         * @var \App\Services\Wechat\OpenAPI\OpenAPI $openAPI
         */
        $app = $this->request->wechat;
        $app->register(new OpenAPIProvider());
        $openAPI = $app->openAPI;
        if($inputs['type'] == 'status'){
            $services = [
                'operation_status' => ['status' => intval($inputs['content'])]
            ];
        } else {
            $services = [
                'aialert' => ['tel' => $inputs['content']]
            ];
        }
        return $openAPI->app->ctrl_device($inputs['device_type'], $inputs['device_id'], $inputs['openid'], $services);
    }

    public function getTest()
    {
        return view('device.test', [
            'device_type' => 'gh_0c8c62eb016b',
            'device_id'   => 'gh_4248324a4d02_683b32a3289555a2',
            'openid'      => 'obQhpvwvn62INCwah1EJRbcLAhOg',
            'target_url'  => $this->request->getRequestUri()
        ]);
    }
}