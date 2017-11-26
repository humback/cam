<!Doctype html>
<html>
<head>
    <meta charset="utf-8">
	<METAHTTP-EQUIV="Cache-Control" CONTENT="no-cache">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>微信摄像头</title>
    <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/0.4.1/weui.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style type="text/css">
        body{
            overflow-x: hidden;
            background-color: #fbf9fe;
        }
        .mt{
            margin-top: 2em;
			background-color: #fbf9fe;
        }
        .mb{
            margin-bottom: 3em;
        }
		.ml{
            margin-left: 5em;
        }
		.preview{            
			background-color: #fbf9fe;
			transform:rotate(0deg);
        }
        .text-center{
            text-align: center;
        }
        .rotate_relative{
		position: relative;
		left: 60px;
		top: 30px;
		height:40px;
		width:100px;
		}			
		 .open_relative {
		position: relative;
		left: 180px;
		top: -10px;
		height:40px;
		width:100px;
		}	
		
		 .result_relative {
		position: relative;
		left: 0px;
		top: 0px;		
		}	
    </style>
	
<script type="text/javascript">
function check(value)
  {
    document.getElementById("image_format").value=value;
  }
</script>

</head>
<body>
   
        <div class="mt">
		  
				<div class="weui_cells_title">
					<h3>图像尺寸:</h3>
				</div>			
				<div class="ml">
					<input type="radio"  name="radio"  value="1" onclick="check(this.value);"/>VGA(640*480)<br/>
					<input type="radio"  name="radio"  checked value="0"  onclick="check(this.value);"/>QVGA(320*240)<br/>
					<input type="radio"  name="radio"  value="2" onclick="check(this.value);" />QQVGA(160*120)<br/>
					<input  type="hidden"  id="image_format" value="0"/>
					<br/>				
				</div>		
			
				<div class="text-center">             
					<a id="capture" href="javascript:;" class="weui_btn weui_btn_primary" >远程拍照</a>					
				</div>			
				
				<div class="weui_cells_title"> 
					<h3>照片预览:</h3><br/>
				</div>
				<div class="preview" >
					<center><image id="photo" src="http://mp.ai-thinker.com/Modules/A6C/a6c_{{$device_id}}_{{$user->id}}_{{$image_id}}.jpg" border=2 width=160 height=160 /></center>
				</div>
				
				<div class="rotate_relative">
					<a id="rotate" href="javascript:;" class="weui_btn weui_btn_primary">旋转</a>										
				</div>		
				<div class="open_relative">
					<a id="open" href="javascript:;" class="weui_btn weui_btn_primary">打开</a>										
				</div>										
				<div>           
					状态:<span id="result"></span>
				</div>
					
        </div>         
	
	<script src="//cdn.bootcss.com/jquery/2.2.1/jquery.min.js"></script>
    <script>
	      var g_count=10;
		  var g_CanCapture=1;
		  var g_currentAngle=0;
		  var g_imageId={{$image_id}};	          	  
		  
		  function query()
		  {
			var data={};			
			
			data.query=0;
			data.image_name="{{$device_id}}_{{$user->id}}_"+g_imageId;		
			
			$.ajax({
            url: "{{$target_url}}",
            type: 'post',
            dataType: "json",
            data: data,
            success: function (response) 
				{ 
					var json_data=JSON.stringify(response);
					var json=JSON.parse(json_data);								
					
					//alert(json.query);
					if(json.query==2)
					{
						document.getElementById("photo").src="";
						document.getElementById("capture").innerHTML="正在下载中..."+g_count;			
						
						$('#result').html("下载中...");	
					}
					else
					{
						document.getElementById("photo").src="http://mp.ai-thinker.com/Modules/A6C/Camera/a6c_"+data.image_name;		
						document.getElementById("capture").innerHTML="远程拍照";
						g_CanCapture=1;	
                        g_count=0;						
						
						$('#result').html("成功");
					}				
				},
				error: function (data)
				{
					$('#result').html(JSON.stringify(data));
				}					
			});
		
			if(g_CanCapture==0)
			{
				g_count--;		    
				if(g_count<0)
				{
				   g_count=10;
				}

				setTimeout('query()',2000);	
			}	
		}		
			
        $(document).ready(function(){
            var data = {};			
            data.device_id = "{{$device_id}}";
			//data.device_id="gh_0c8c62eb016b_d9654130d1120f3c";
            data.device_type = "{{$device_type}}";
            data.openid = "{{$user->id}}";			
		
            $('#capture').on('click touchstart', capture_touchstart);			
			$('#open').on('click touchstart', open_touchstart);
			$('#rotate').on('click touchstart', rotate_touchstart);
			$('#photo').on('click touchstart', photo_touchstart);
			
			function photo_touchstart(e) {
				var curImage;
				var imgs = [];  
				
                e.stopPropagation();
                e.preventDefault();				
				
			//	document.getElementById("photo").width=photo.naturalWidth;
			//	document.getElementById("photo").height=photo.naturalHeight;					  
		       
			    curImage=document.getElementById("photo").src;
				
				imgs.push(curImage);
				//alert(curImage);
				for(var i = 1; i <5 && (g_imageId-i)>=0; i++)
				{  
					imgs.push('http://mp.ai-thinker.com/Modules/A6C/a6c_{{$device_id}}_{{$user->id}}_'+(g_imageId-i)+'.jpg');
                  //  alert(imgs[i]);					
				}		 		  
		  
			    
			    WeixinJSBridge.invoke('imagePreview', {
					'current': curImage,
					'urls': imgs  
					}); 
				
				//window.open(document.getElementById("photo").src);
            }
			
			function rotate_touchstart(e) {
                e.stopPropagation();
                e.preventDefault();
				
				g_currentAngle=(g_currentAngle+90)%360;				
				document.getElementById("photo").style.transform = 'rotate('+g_currentAngle+'deg)';								
            }
			
            function capture_touchstart(e) {
                e.stopPropagation();
                e.preventDefault();

                if(g_CanCapture==0)	
				{
					document.getElementById("capture").innerHTML="下载中,请稍候...";
					return;
				}					
				
				g_imageId++;
				
				data.image_size=document.getElementById("image_format").value;											
				data.image_name ="{{$device_id}}_{{$user->id}}_"+g_imageId;
				
				g_CanCapture=0;
				
				ajax();							                
				
				//g_count=30;
				//document.getElementById("capture").innerHTML="正在下载"+g_count;
				//g_count--;
				//setTimeout('query()',5000); //指定1秒刷新一次
            }
			
			function open_touchstart(e) {
						 photo_touchstart(e);	
            }
			
			 function ajax(){                                
                $.ajax({
                    url: "{{$target_url}}",
                    type: 'post',
                    dataType: "json",
                    data: data,
                    success: function (response) {
						var json_data=JSON.stringify(response);	
						var json=JSON.parse(json_data);							
                        
						$('#result').html(JSON.stringify(json_data));
						
						//alert(json.error_code);
						if(json.error_code==0)
						{
							g_count=10;
							document.getElementById("photo").src="";
							document.getElementById("capture").innerHTML="准备下载";
							setTimeout('query()',3000);							
						}
						else
						{
							document.getElementById("photo").src="http://mp.ai-thinker.com/Modules/A6C/a6c_{{$device_id}}_{{$user->id}}_"+g_imageId;		
							document.getElementById("capture").innerHTML="远程拍照";
							g_CanCapture=1;	
							g_count=0;
							 
							g_imageId--;
							if(g_imageId<0)
								g_imageId=0;

							
						}
                    },
                    error: function (data) {
                        $('#result').html(JSON.stringify(data));
                    }
                });
            }           
        });
    </script>
</body>
</html>