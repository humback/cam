<?php

/**
 * @var \Illuminate\Routing\Router $router
 */

 
$router->get('/', function () {
    return view('welcome');
});
/**
$router->post('/Modules/A6C/Photo/{imagename}', function () {
    return view('welcome_post');
});

$router->get('/Modules/A6C/{imagename}', function () {
    return view('welcome_get');
});
*/
$router->post('/Modules/A6C/Photo/{imagename}','ModuleA6CController@postPhoto');
//$router->get('/Modules/A6C/Camera/{imagename}','ModuleA6CController@getPhoto');
//$router->get('/Modules/A6C/{imagename}','ModuleA6CController@getPhoto');
$router->get('/Modules/A6C/Photo/{imagename}','ModuleA6CController@postPhoto');
$router->group([
    'middleware'=> ['wechat'],
    'prefix'    => '/wechat'
], function($router){
    $router->any('/', 'WechatController@index');
    $router->any('/device/{name}', 'WechatController@device');
    $router->get('/callback', 'WechatController@callback');

   // $router->controller('/menu','MenuController');
    $router->get('/menu','MenuController@getMenu');
    $router->get('/product/G01/panel', 'ProductController@getG01Panel');  //
	$router->post('/product/G01/panel', 'ProductController@postG01Panel');  //
	$router->get('/product/wxcamera/panel', 'ProductController@getWXCameraPanel');  //
	$router->post('/product/wxcamera/panel', 'ProductController@postWXCameraPanel');  //
    
    $router->controller('test', 'TestController');
});
