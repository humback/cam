<?php
/**
 * Created by PhpStorm.
 * User: jackie
 * Date: 4/22/16
 * Time: 4:35 PM
 */

return [
    /**
     * Debug ģʽ��bool ֵ��true/false
     *
     * ��ֵΪ false ʱ�����е���־�������¼
     */
    'debug'  => env('APP_DEBUG', true),

    /**
     * �˺Ż�����Ϣ�����΢�Ź���ƽ̨/����ƽ̨��ȡ
     */
    'org_id'  => 'gh_0c8c62eb016b',                             // ΢�Ź��ں�ԭʼid gh_0c8c62eb016b
    'app_id'  => 'wxc71ef836ecf81bc4',                          // AppID wxc71ef836ecf81bc4
    'secret'  => 'c292d0edfcc5bd27e5ff5fa378d83cdd',            // AppSecret c292d0edfcc5bd27e5ff5fa378d83cdd
    'token'   => 'aithinker_smartlife',                      	// Token  aithinker_smartlife
    'aes_key' => 'PilHjpLYyv4830CHhqq2F87yR6qzSsxP3gfWezq56Eh', // EncodingAESKey PilHjpLYyv4830CHhqq2F87yR6qzSsxP3gfWezq56Eh

    /**
     * ��־����
     *
     * level: ��־����, ��ѡΪ��
     *         debug/info/notice/warning/error/critical/alert/emergency
     * file����־�ļ�λ��(����·��!!!)��Ҫ���дȨ��
     */
    'log' => [
        'level' => 'debug',
        'file'  => '/tmp/easywechat.log',
    ],

    /**
     * OAuth ����
     *
     * scopes������ƽ̨��snsapi_userinfo / snsapi_base��������ƽ̨��snsapi_login
     * callback��OAuth��Ȩ��ɺ�Ļص�ҳ��ַ
     */
    'oauth' => [
        'scopes'   => ['snsapi_userinfo'],
        'callback' => '/wechat/callback',
    ],

    /**
     * ΢��֧��
     */
    'payment' => [
        'merchant_id'        => 'your-mch-id',
        'key'                => 'key-for-signature',
        'cert_path'          => 'path/to/your/cert.pem', // XXX: ����·����������
        'key_path'           => 'path/to/your/key',      // XXX: ����·����������
        // 'device_info'     => '013467007045764',
        // 'sub_app_id'      => '',
        // 'sub_merchant_id' => '',
        // ...
    ],

    /**
     * �豸����
     */
    'device' => [
        'guard' => [
            'token' => 'aithinkerwxcloud',
            'aes_key' => 'lZN3nVfMQLnOMLIYjrbrir9zIGpGXGeZpME0XyWPee5',//lZN3nVfMQLnOMLIYjrbrir9zIGpGXGeZpME0XyWPee5
            'product_id' => 8728
        ]
    ]
];