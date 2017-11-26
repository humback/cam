<?php
/**
 * Created by PhpStorm.
 * User: jackie
 * Date: 4/22/16
 * Time: 4:35 PM
 */

return [
    /**
     * Debug 模式，bool 值：true/false
     *
     * 当值为 false 时，所有的日志都不会记录
     */
    'debug'  => env('APP_DEBUG', true),

    /**
     * 账号基本信息，请从微信公众平台/开放平台获取
     */
    'org_id'  => 'gh_0c8c62eb016b',                             // 微信公众号原始id gh_0c8c62eb016b
    'app_id'  => 'wxc71ef836ecf81bc4',                          // AppID wxc71ef836ecf81bc4
    'secret'  => 'c292d0edfcc5bd27e5ff5fa378d83cdd',            // AppSecret c292d0edfcc5bd27e5ff5fa378d83cdd
    'token'   => 'aithinker_smartlife',                      	// Token  aithinker_smartlife
    'aes_key' => 'PilHjpLYyv4830CHhqq2F87yR6qzSsxP3gfWezq56Eh', // EncodingAESKey PilHjpLYyv4830CHhqq2F87yR6qzSsxP3gfWezq56Eh

    /**
     * 日志配置
     *
     * level: 日志级别, 可选为：
     *         debug/info/notice/warning/error/critical/alert/emergency
     * file：日志文件位置(绝对路径!!!)，要求可写权限
     */
    'log' => [
        'level' => 'debug',
        'file'  => '/tmp/easywechat.log',
    ],

    /**
     * OAuth 配置
     *
     * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
     * callback：OAuth授权完成后的回调页地址
     */
    'oauth' => [
        'scopes'   => ['snsapi_userinfo'],
        'callback' => '/wechat/callback',
    ],

    /**
     * 微信支付
     */
    'payment' => [
        'merchant_id'        => 'your-mch-id',
        'key'                => 'key-for-signature',
        'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
        'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！
        // 'device_info'     => '013467007045764',
        // 'sub_app_id'      => '',
        // 'sub_merchant_id' => '',
        // ...
    ],

    /**
     * 设备功能
     */
    'device' => [
        'guard' => [
            'token' => 'aithinkerwxcloud',
            'aes_key' => 'lZN3nVfMQLnOMLIYjrbrir9zIGpGXGeZpME0XyWPee5',//lZN3nVfMQLnOMLIYjrbrir9zIGpGXGeZpME0XyWPee5
            'product_id' => 8728
        ]
    ]
];