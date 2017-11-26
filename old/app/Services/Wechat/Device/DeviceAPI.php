<?php
/**
 * Created by PhpStorm.
 * User: jackie
 * Date: 4/24/16
 * Time: 3:56 PM
 */
namespace App\Services\Wechat\Device;

use EasyWeChat\Core\AbstractAPI;

class DeviceAPI extends AbstractAPI
{
    const API_AUTHORIZE_DEVICE  = "https://api.weixin.qq.com/device/authorize_device";
    const API_TRANSMSG          = "https://api.weixin.qq.com/device/transmsg";
    const API_CREATE_QRCODE     = "https://api.weixin.qq.com/device/create_qrcode";
    const API_GET_QRCODE        = "https://api.weixin.qq.com/device/getqrcode";
    const API_BIND              = "https://api.weixin.qq.com/device/bind";
    const API_UNBIND            = "https://api.weixin.qq.com/device/unbind";
    const API_COMPEL_BIND       = "https://api.weixin.qq.com/device/compel_bind";
    const API_COMPEL_UNBIND     = "https://api.weixin.qq.com/device/compel_unbind";
    const API_GET_STAT          = "https://api.weixin.qq.com/device/get_stat";
    const API_VERIFY_QRCODE     = "https://api.weixin.qq.com/device/verify_qrcode";
    const API_GET_OPENID        = "https://api.weixin.qq.com/device/get_openid";
    const API_GET_BIND_DEVICE   = "https://api.weixin.qq.com/device/get_bind_device";

    /**
     * 主动发送消息给设备 (http://iot.weixin.qq.com/wiki/document-2_3.html)
     *
     * @param $device_type  设备类型，目前为“公众账号原始ID”
     * @param $device_id    设备ID
     * @param $open_id      微信用户账号的openid
     * @param $content      消息内容，BASE64编码
     *
     * @return \EasyWeChat\Support\Collection
     */
    public function transmsg($device_type, $device_id, $open_id, $content)
    {
        $params = compact('device_type', 'device_id', 'open_id', 'content');
        return $this->parseJSON('json', [self::API_TRANSMSG, $params]);
    }
    /**
     * 获取设备二维码 (http://iot.weixin.qq.com/wiki/document-2_5.html)
     *
     * @param array $device_id_list 设备id的列表，json的array格式
     *
     * @return \EasyWeChat\Support\Collection
     */
    public function create_qrcode(array $device_id_list)
    {
        $device_num = count($device_id_list);
        $params = compact('device_num', 'device_id_list');
        return $this->parseJSON('json', [self::API_CREATE_QRCODE, $params]);
    }
    /**
     * 设备授权 (http://iot.weixin.qq.com/wiki/document-2_6.html)
     *
     * @param array $device_list      设备id的列表，json的array格式
     * @param int $product_id   设备的产品编号（由微信硬件平台分配）。
     * @param int $op_type      请求操作的类型，限定取值为：0：设备授权（缺省值为0） 1：设备更新（更新已授权设备的各属性值）
     *
     * @return \EasyWeChat\Support\Collection
     */
    public function authorize_device(array $device_list, $product_id=1, $op_type=0)
    {
        $device_num = count($device_list);
        $params = compact('device_num', 'device_list', 'op_type', 'product_id');
        return $this->parseJSON('json', [self::API_AUTHORIZE_DEVICE, $params]);
    }
    /**
     * 设备绑定 (http://iot.weixin.qq.com/wiki/document-2_12.html)
     *
     * @param $ticket       绑定操作合法性的凭证（由微信后台生成，第三方H5通过客户端jsapi获得）
     * @param $device_id    设备id
     * @param $openid       用户对应的openid
     *
     * @return \EasyWeChat\Support\Collection
     */
    public function bind($ticket, $device_id, $openid)
    {
        $params = compact('ticket', 'device_id', 'openid');
        return $this->parseJSON('json', [self::API_BIND, $params]);
    }
    /**
     * 设备解绑 (http://iot.weixin.qq.com/wiki/document-2_12.html)
     *
     * @param $ticket       绑定操作合法性的凭证（由微信后台生成，第三方H5通过客户端jsapi获得）
     * @param $device_id    设备id
     * @param $openid       用户对应的openid
     *
     * @return \EasyWeChat\Support\Collection
     */
    public function unbind($ticket, $device_id, $openid)
    {
        $params = compact('ticket', 'device_id', 'openid');
        return $this->parseJSON('json', [self::API_UNBIND, $params]);
    }
    /**
     * 强制绑定用户和设备 (http://iot.weixin.qq.com/wiki/document-2_12.html)
     *
     * @param $device_id    设备id
     * @param $openid       用户对应的openid
     *
     * @return \EasyWeChat\Support\Collection
     */
    public function compel_bind($device_id, $openid)
    {
        $params = compact('device_id', 'openid');
        return $this->parseJSON('json', [self::API_COMPEL_BIND, $params]);
    }
    /**
     * 强制解绑用户和设备 (http://iot.weixin.qq.com/wiki/document-2_12.html)
     *
     * @param $device_id    设备id
     * @param $openid       用户对应的openid
     *
     * @return \EasyWeChat\Support\Collection
     */
    public function compel_unbind($device_id, $openid)
    {
        $params = compact('device_id', 'openid');
        return $this->parseJSON('json', [self::API_COMPEL_UNBIND, $params]);
    }
    /**
     * 设备状态查询 (http://iot.weixin.qq.com/wiki/document-2_7.html)
     *
     * @param $device_id    设备id
     *
     * @return \EasyWeChat\Support\Collection
     */
    public function get_stat($device_id)
    {
        $params = compact('device_id');
        return $this->parseJSON('json', [self::API_GET_STAT, $params]);
    }
    /**
     * 验证二维码 (http://iot.weixin.qq.com/wiki/document-2_9.html)
     *
     * @param $ticket       设备二维码的ticket
     *
     * @return \EasyWeChat\Support\Collection
     */
    public function verify_qrcode($ticket)
    {
        $params = compact('ticket');
        return $this->parseJSON('json', [self::API_VERIFY_QRCODE, $params]);
    }
    /**
     * 获取设备绑定openID (http://iot.weixin.qq.com/wiki/document-2_4.html)
     *
     * @param $device_type  设备类型，目前为“公众账号原始ID”
     * @param $device_id    设备的deviceid
     *
     * @return \EasyWeChat\Support\Collection
     */
    public function get_openid($device_type, $device_id)
    {
        $params = compact('device_type', 'device_id');
        return $this->parseJSON('json', [self::API_GET_OPENID, $params]);
    }
    /**
     * 通过openid获取用户绑定的deviceid (http://iot.weixin.qq.com/wiki/document-2_13.html)
     *
     * @param $openid   要查询的用户的openid
     *
     * @return \EasyWeChat\Support\Collection
     */
    public function get_bind_device($openid)
    {
        $params = compact('openid');
        return $this->parseJSON('get', [self::API_GET_BIND_DEVICE, $params]);
    }
}