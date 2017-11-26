<?php

namespace App\Http\Controllers;

use App\Services\Wechat\OpenAPI\OpenAPIProvider;
use Illuminate\Http\Request;
use App\Http\Requests;



function get_last_imageid($deviceId,$userId)
{    
	$dstpath=realpath(base_path('/')).'\Public\Modules\A6C';	
	$filepath=$dstpath.'\\a6c_'.$deviceId.'_'.$userId.'.txt';	
	$resId="00000";
	
	//echo $filepath;
	if(file_exists($filepath))
		$imgId=file_get_contents($filepath);
	else 
		return $resId;
	 
	 if(strlen($imgId)==0)
	 {  
	    return $resId;
	 }
	  
	 return $imgId;
}

function set_last_imageid($deviceId,$userId,$imageId)
{
	$dstpath=realpath(base_path('/')).'\Public\Modules\A6C';	
	$filepath=$dstpath.'\\a6c_'.$deviceId.'_'.$userId.'.txt';	
	
	//echo $filepath;
	
    $file=fopen($filepath,'a+'); 	
     if($file==false)
	 {
		 return 0;
	 }
	 
	 ftruncate($file,0); 
	 
	 fputs($file,$imageId); 
	 
	 fclose($file);
	 
	 return 1;
}

function imageName2Imageid($imageName)
{
	$id=strrchr($imageName,'_');
	
	return  substr($id,1);
}

class ProductController extends Controller
{

    /**
     * @var Request $request
     */
    protected $request;

    /**
     * @var \EasyWeChat\Foundation\Application $wechat
     */
    protected $wechat;

    /**
     * DeviceController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->wechat = $request->wechat;

        $target = ['target_url'=> $request->getRequestUri()];
        session($target);
        view()->share($target);
    }

    /**
     * @return mixed
     */
    public function getG01Panel()
    {
        $request = $this->request;
        $device_id = $request->input('device_id');		
        
        if(!$user = session('wechat_user', false)){
            $callback = $request->root() . config('wechat.oauth.callback');
            $redirect = $callback . '?target=' . urlencode(session('target_url'));
            return $this->wechat->oauth->redirect($redirect);
        }
        
        $device_type = config('wechat.org_id');
        return view('device.safe-guard', compact('user', 'device_id', 'device_type'));
    }
	
	 /**
     * @return \EasyWeChat\Support\Collection
     */
    public function postG01Panel()
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

        $app = $this->wechat;
        $user = session('wechat_user');
        if ($inputs['openid'] != $user->id){
            return response("access denied", 403);
        }

        $app->register(new OpenAPIProvider());
        /**
         * @var \App\Services\Wechat\OpenAPI\OpenAPI $openAPI
         */
        $openAPI = $app->openAPI;
        $services = [
            'operation_status' => ['status' => intval('0')],
        ];
        if($inputs['type'] == 'status'){
            $cfg_state = (int) ($inputs['content'] == 'true');
            $daodata = '{"cfg":'.$cfg_state.'}';
        } else {
            $daodata = '{"tel":"' .$inputs['content'].'"}';
        }
        
        return $openAPI->app->ctrl_device($inputs['device_type'], $inputs['device_id'], $user->id, $services, $daodata);
    }
	
	public function getWXCameraPanel()
    {
        $request = $this->request;
        $device_id = $request->input('device_id');		
		
		//echo "123 WXCamera";
       // echo $device_id;
		
        if(!$user = session('wechat_user', false)){
            $callback = $request->root().config('wechat.oauth.callback');
            $redirect = $callback.'?target='.urlencode(session('target_url'));			
            return $this->wechat->oauth->redirect($redirect);
        }
       // echo '<br>';
	   // echo 'openid='.$user->openid;	
		
        $device_type = config('wechat.org_id'); 
        		
		//$device_id='gh_0c8c62eb016b_d9654130d1120f3c';
        $image_id=get_last_imageid($device_id,$user->id);
       // echo $image_id;       
		 
	   return view('device.wxcamera', compact('user', 'device_id', 'device_type','image_id'));
    }   
	
	public function postWXCameraPanel()
    {
		$dstpath=realpath(base_path('/')).'\Public\Modules\A6C';	
        
		$request = $this->request;		
		
		if($request->has(['query','image_name']))
        {       
            $inputs = $request->only(['image_name']);
			
			$image_name = $inputs['image_name'];
			$image_local_path=$dstpath.'\\a6c_'.$image_name.'.jpg';	
			
			//echo $image_local_path;
			
			if(file_exists($image_local_path))
			{
				echo '{"query":1}';					
			}
			else
				echo '{"query":2}';	
			
			return ;
        }			
				
		
        $this->validate($request, [
            'device_type'   => 'required',
            'device_id'     => 'required',
            'openid'        => 'required',
            'image_name'          => 'required',
            'image_size'       => 'required'
        ]);
		
		//echo '123';
		//return;

        $inputs = $request->only(['openid', 'device_id', 'device_type', 'image_name','image_size']);
        
        $app = $this->wechat;
        $user = session('wechat_user');
        if ($inputs['openid'] != $user->id){
            return response("access denied", 403);
        }

        $app->register(new OpenAPIProvider());
        /**
         * @var \App\Services\Wechat\OpenAPI\OpenAPI $openAPI
         */
        $openAPI = $app->openAPI;
        $services = [
            'operation_status' => ['status' => intval('1')],
        ];
		
        $image_size = $inputs['image_size'];  
		$image_name = $inputs['image_name'];		
        
		$data='{"image_size":'.$image_size.',"image_name":"'.$image_name.'"}';
		
		
		//echo $data;
		
		//delete image file	
		
		$lastImageName=$inputs['device_id'].'_'.$user->id.'_'.get_last_imageid($inputs['device_id'],$user->id);
		$image_local_path=$dstpath.'\\a6c_'.$lastImageName.'.jpg';
		//echo $image_local_path;
		if(file_exists($image_local_path))
		{		   
         //  unlink($image_local_path);      
		}  
				
		
		$image_local_path=$dstpath.'\\a6c_'.$image_name.'.jpg';
		//echo $image_local_path;
		if(file_exists($image_local_path))
		{		   
           unlink($image_local_path);      
		}        		
		
		//echo imageName2Imageid($image_name);		
		
        $response= $openAPI->app->ctrl_device($inputs['device_type'], $inputs['device_id'], $user->id, $services, $data);
		
		$json_array_data=json_decode($response,true);		
		
		if($json_array_data['error_code']==0)
		{	
	        //echo $json_array_data['error_code'];
			set_last_imageid($inputs['device_id'],$user->id,imageName2Imageid($image_name));
		}
		
		return $response;
    }
}
