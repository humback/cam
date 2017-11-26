<!Doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{$devicename}}模组测试面板</title>
    <style type="text/css">

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

        .title_area
        {
            position:absolute;
            left:600px;
            top:10px;
        }

        .text_area
        {
            position:absolute;
            left:30px;
            top:80px;
            outline:#FF0000 solid thick
        }

        .send_text_area
        {
            position:absolute;
            left:30px;
            top:560px;
            outline:#00FF00 solid thick
        }

        .serial_cfg_area
        {
            position:absolute;
            left:30px;
            top:700px;

            outline:#00FFFF solid thick
        }

        .open_btn_area
        {
            position:absolute;
            left:480px;
            top:700px;
            outline:#00FFFF solid thick
        }

        .test_button_area
        {
            position:absolute;
            left:840px;
            top:80px;
            outline:#FF00FF solid thick
        }
        .test_cam_button_area
        {
            z-index:3;
            position:absolute;
            left:840px;
            top:660px;
            outline:#FF00FF solid thick
        }

        .test_gps_button_area
        {
            z-index:3;
            position:absolute;
            left:1300px;
            top:660px;
            outline:#FF00FF solid thick
        }

        .help_area
        {
            z-index:3;
            position:absolute;
            left:1600px;
            top:80px;
            color:#ffffff;
            outline:#FF00FF solid thick;
            background-color:#0000FF
        }

        .test_button_style
        {
            width:30px;
            height:30px
        }

    </style>
</head>
<body>
<div class="title_area"><h2>{{$devicename}}模组测试面板</h2></div>
<div class="help_area">
    <h2> 注意事项:</h2>
   <h3> 1.只能使用IE浏览器，不支持360和Google浏览器；</h3>
   <h3> 2.需要安装MSCOMM控件；</h3>
   <h3> 3.需要把本站点加入安全区域,Internet属性-》安全-》可信站点；</h3>
    <h3>4.需要启用自定义级别里的"通过域访问数据源"；Internet属性-》安全-》可信站点-》自定义级别；</h3>
</div>
<div class="text_area">
    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;接收数据:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button"  id="text_clear_btn"  value="清除接收缓冲区" onclick="$('recv_text_area').innerText=''" />
        <input type="button"  id="text_clear_btn"  value="清除发送记录"  onclick="$('send_text_area').innerText=''"  />
        <input type="button"  id="text_clear_btn"  value="保存接收缓冲区"  onclick="save_recv_buffer()" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        发送历史：</h4>
    <textarea id="recv_text_area" rows="25" cols="60"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;
    <textarea id="send_text_area" rows="25" cols="30"></textarea>
</div>

<div class="send_text_area">
    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="hex_disp_cb"  type="checkbox"  onclick="hex_disp_cb_click()" />HEX显示    <input id="hex_send_cb" type="checkbox" />HEX发送 <input id="new_line_cb" checked type="checkbox" />自动换行<br><br><br>
        发送框： <input type="text" id="send_text" size="80"  value=""/>
        <input type="button"  id="send_btn"  value="发送"  onclick="send_btn()"/></h4>
</div>

<div class="serial_cfg_area">
    <h4> 串口：
        <select id="serial_option">
        </select>
        波特率：
        <select id="serial_speed">
            <option value="2400">2400</option>
            <option value="4800">4800</option>
            <option value="9600">9600</option>
            <option value="14400">14400</option>
            <option value="19200">19200</option>
            <option value="28800">28800</option>
            <option value="33600">33600</option>
            <option value="38400">38400</option>
            <option value="57600">57600</option>
            <option value="115200" selected>115200</option>
            <option value="230400">230400</option>
            <option value="460800">460800</option>
            <option value="921600">921600</option>
        </select>
        校验位：
        <select name="check_bits" id="check_bits" style="width:75px" >
            <option value="N" selected  >无NONE</option>
            <option value="O"  >奇ODD</option>
            <option value="E" >偶EVEN</option>
        </select>
        <br><br>
        <span>数据位:</span>
        <input type=text id="data_bits" name="data_bits" value=8 style="width:75px;height:20px">

        <span>停止位:</span>
        <input type=text id="stop_bits" name="stop_bits" value=1 style="width:75px;height:20px">
        <br/>
    </h4>
</div>

<div class="open_btn_area">
    <input type="button" id="open_serial_btn" value="打开串口" style="height:100px;width:120px;" onclick="open_serial_btn()"/>
    <input type="button" style="width:100px;height:100px"   value="自适应波特率" onclick="if(g_autoAdaptBaud==1) g_autoAdaptBaud=3;auto_set_baud();" />
</div>

<div class="test_button_area">
        <input type="button"  style="width:80px;height:40px"  value="读固件信息 " onclick="send_at_cmd('ATI\r\n')" /><input type="button" style="width:80px;height:40px"   value="  读CCID  "  onclick="send_at_cmd('AT+CCID\r\n')" />
        <input type="button"  style="width:80px;height:40px"  value="  读信号  " onclick="send_at_cmd('AT+CSQ\r\n')"/><input type="button"  style="width:100px;height:40px"  value="查询网络注册" onclick="send_at_cmd('AT+CREG?\r\n')" />
        <input type="button" style="width:80px;height:40px"   value=" 切换耳机 " onclick="send_at_cmd('AT+SNFS=1\r\n')"/><input type="button" style="width:80px;height:40px"   value=" 切换喇叭 " onclick="send_at_cmd('AT+SNFS=0\r\n')"/>
        <input type="button" style="width:100px;height:40px"   value="查询当前基站" onclick="send_at_cmd('AT+CCED=0,1\r\n')"/><input type="button" style="width:100px;height:40px"   value="查询所有基站" onclick="send_at_cmd('AT+CCED=0,2\r\n')"/>
        <br>
        <input type="button" style="width:80px;height:40px"   value="软复位" onclick="send_at_cmd('AT+RST=1\r\n')" />
        <input type="button"  style="width:80px;height:40px"  value="  读imei  " onclick="send_at_cmd('AT+EGMR=2,7\r\n')" /><input type="button" style="width:80px;height:40px"   value="  写imei  " onclick="write_imei()" />
        <input type="text"  id="imei" minlength="15" maxlength="15" />
        <input type="button" style="width:80px;height:40px"   value="启动安信可云" onclick="send_at_cmd('AT+CLDSTART\r\n')"/><input type="button" style="width:80px;height:40px"   value="停止安信可云" onclick="send_at_cmd('AT+CLDSTOP\r\n')"/>
        <input type="button" style="width:80px;height:40px"   value="启动微信云" onclick="send_at_cmd('AT+WXCLDSTART\r\n')"/><input type="button" style="width:80px;height:40px"   value="停止微信云" onclick="alert('目前该指令有问题');send_at_cmd('AT+WXCLDSTOP\r\n')"/>
        <br>

        <select id="gpio_cfg">
        </select>
        <input type="button" style="width:120px;height:40px"   value="设置GPIO为输出" onclick="gpio_dir(1)" /><input type="button" style="width:120px;height:40px"   value="设置GPIO为输入" onclick="gpio_dir(0)" />
        <input type="button" style="width:80px;height:40px"   value="读GPIO" onclick="gpio_read()" /><input type="button" style="width:110px;height:40px"   value="设置GPIO输出高" onclick="gpio_write(1)" /><input type="button" style="width:110px;height:40px"   value="设置GPIO输出低" onclick="gpio_write(0)" />
        <br>

        <select id="baud_cfg">
            <option value="2400">2400</option>
            <option value="4800">4800</option>
            <option value="9600">9600</option>
            <option value="14400">14400</option>
            <option value="19200">19200</option>
            <option value="28800">28800</option>
            <option value="33600">33600</option>
            <option value="38400">38400</option>
            <option value="57600">57600</option>
            <option value="115200" selected>115200</option>
            <option value="230400">230400</option>
            <option value="460800">460800</option>
            <option value="921600">921600</option>
        </select>
        <input type="button" style="width:80px;height:40px"   value="设置波特率" onclick="set_baud()" /><input type="button" style="width:110px;height:40px"   value="查询当前波特率" onclick="send_at_cmd('AT+IPR?\r\n')" /><input type="button" style="width:110px;height:40px"   value="查询所有波特率" onclick="send_at_cmd('AT+IPR=?\r\n')" />
        <br><br>
        号码：<input type="text" id="dial_number" size=30 value="10086" />短信内容：<input type="text"   id="sms_content" size="40" value="10086" /><br>
        <input type="button" style="width:80px;height:40px"  value="  打电话  " onclick="dial()"/><input type="button" style="width:80px;height:40px"  value="  挂断电话 " onclick="send_at_cmd('ath\r\n')" /><input type="button" style="width:80px;height:40px"  value="  接听电话 " onclick="send_at_cmd('ata\r\n')" />
        <input type="button" style="width:80px;height:40px" value="发TXT短信" onclick="send_txt_sms()"/><input type="button" style="width:80px;height:40px" id="sms_btn"  value=" 发PDU短信" /><input type="button" style="width:80px;height:40px" value=" 查看短信" /><input type="button" style="width:80px;height:40px" id="sms_btn"  value=" 删除短信" />
        <br><br>

        IP/域名:<input type="text"  id="ip_addr" size="40" value="121.41.97.28" />Port:<input type="text"  id="ip_port"  size=10 value="60000" /><br>
        <input type="button" style="width:100px;height:40px"  value="发起TCP连接" onclick="start_tcp()"/><input type="button" style="width:100px;height:40px"   value="发起UDP连接" onclick="start_ucp()"/>
        <input type="button"  id="close_btn" style="width:80px;height:40px"   value="关闭连接" onclick="send_at_cmd('at+cipclose\r\n')"/><input type="button"  style="width:75px;height:40px"  value="链路状态" onclick="send_at_cmd('at+cipstatus?\r\n')"/><input type="button"  style="width:80px;height:40px" value="本机IP" onclick="send_at_cmd('at+cifsr?\r\n')"/>
        <input type="button"  style="width:80px;height:40px"  value="启动透传" onclick="send_at_cmd('at+cipstatus?\r\n')"/><input type="button"  style="width:80px;height:40px"  value="退出透传" onclick="send_at_cmd('at+cipstatus?\r\n')"/><input type="button"  style="width:90px;height:40px"  value="查询透传配置" onclick="send_at_cmd('at+ciptcfg?\r\n')"/>
        <br>
        重传次数：<input type="text"  id="t_mode_count" size="1" value="10" /><input type="button"  style="width:150px;height:30px"  value="配置透传失败重传参数" onclick="t_mode_config(0)"/>
        重传延时ms:<input type="text"  id="t_mode_delay"  size="5" value="200" /><input type="button"  style="width:150px;height:30px"  value="配置透传失败重传延时" onclick="t_mode_config(1)"/>
        <br>
        包长度:<input type="text"  id="t_mode_pkt"  size=3 value="20" /><input type="button"  style="width:130px;height:30px"  value="配置透传包长度" onclick="t_mode_config(2)"/>
        自动发送时间秒:<input type="text"  id="t_mode_send_times"  size=1 value="2" /><input type="button"  style="width:150px;height:30px"  value="配置透传自动发送时间" onclick="t_mode_config(3)"/>
        <br><br>
        <input type="button"  style="width:100px;height:40px"  value="启用多路连接" onclick="g_cipmux_state=1;send_at_cmd('at+cipmux=1\r\n');"/><input type="button"  style="width:100px;height:40px"  value="停止多路连接" onclick="g_cipmux_state=2;send_at_cmd('at+cipmux=0\r\n')"/>
        <input type="button"  style="width:100px;height:40px"  value="查询多路连接" onclick="g_cipmux_state=3;send_at_cmd('at+cipmux?\r\n')"/>当前链路号:<input type="text"  disabled id="socket_id"  size=3 value="0" />
        <br>
        发送内容:<input type="text"  id="send_content" size="40" />
        <input type="button"  style="width:100px;height:40px"  id="send_txt_btn" value="发送字符数据" onclick="send_string_data()"/><input type="button"  style="width:110px;height:40px"  id="send_bin_btn"  value="发送二进制数据" onclick="send_binary_data()"/>
        <br>
        <input type="button"  style="width:80px;height:40px"  id="hb_start_btn" value="启动心跳包" onclick="send_at_cmd('at+ciphmode=1\r\n')"/><input type="button"  style="width:80px;height:40px" id="hb_stop_btn" value="停止心跳包" onclick="send_at_cmd('at+ciphmode=0\r\n')"/><input type="button"  style="width:80px;height:40px" id="hb_cfg_btn" value="查询心跳包配置" onclick="send_at_cmd('at+ciphcfg?\r\n')"/>
        时间(秒)：<input type="text"  id="hb_mode_times" size="1" value="10" /><input type="button"  style="width:80px;height:30px" id="hb_cfg0_btn" value="配置心跳包周期秒" onclick="hb_mode_config(0)"/>
        <br>
        16进制发送包:<input type="text"  id="hb_mode_send_pkt"  size="15" value="55FFEE" /><input type="button"  style="width:80px;height:30px" id="hb_cfg1_btn" value="配置心跳包发送内容" onclick="hb_mode_config(1)"/>
        16进制回应包:<input type="text"  id="hb_mode_response_pkt"  size=10 value="EEFF66" /><input type="button"  style="width:80px;height:30px" id="hb_cfg2_btn" value="配置回应心跳包内容" onclick="hb_mode_config(2)"/>
        <br>
        <br>
</div>

<div class="test_cam_button_area">
    <input type="button"  style="width:80px;height:40px" value="获取照片" onclick="start_camera()"/><input type="button"  style="width:180px;height:40px"  value="获取WXCAMERA LICENSE" onclick="send_at_cmd('AT+WXCAMGETLIC\r\n')" />
    <input type="button"  style="width:80px;height:40px" value="启动微信摄像头" onclick="send_at_cmd('at+wxcamstart\r\n')"/><input type="button"  style="width:80px;height:40px" value="停止微信摄像头" onclick="send_at_cmd('at+wxcamstop\r\n')"/>
    <br>
    <input type="button"  style="width:80px;height:40px" value="启动相机" onclick="send_at_cmd('at+camstart=1\r\n')"/><input type="button"  style="width:80px;height:40px" value="拍照" onclick="send_at_cmd('at+camcap\r\n')"/>
    <input type="button"  style="width:80px;height:40px" value="读取" onclick="send_at_cmd('at+camrd=0\r\n')"/><input type="button"  style="width:80px;height:40px" value="上传" onclick="alert('使用AT+CAMPOST=<url>,<port>，具体见指令集')")/>
    <input type="button"  style="width:80px;height:40px" value="关闭相机" onclick="send_at_cmd('at+camstop\r\n')"/>
    <br>
    <image id="photo" border=2      width=320 height=240 />
</div>

<div class="test_gps_button_area">
    <input type="button"  style="width:80px;height:40px" value="开启GPS" onclick="send_at_cmd('AT+GPS=1\r\n')"/><input type="button"  style="width:80px;height:40px"  value="关闭GPS" onclick="send_at_cmd('AT+GPS=0\r\n')" />
    <br>
    <input type="button"  style="width:80px;height:40px" value="开启AGPS" onclick="send_at_cmd('AT+AGPS=1\r\n')"/><input type="button"  style="width:80px;height:40px"  value="关闭AGPS" onclick="send_at_cmd('AT+AGPS=0\r\n')" />
    <br>
    <input type="button"  style="width:120px;height:40px" value="AT口输出NEMA" onclick="send_at_cmd('AT+GPSRD=1\r\n')"/>
</div>

<OBJECT ID="mscomm" WIDTH=100 HEIGHT=51 type="application/x-oleobject"
        CLASSID="CLSID:648A5600-2C6E-101B-82B6-000000000014"
        CODEBASE="MSCOMM32.OCX">
    <PARAM NAME="DTREnable" VALUE="1">
    <PARAM NAME="CTSHolding" VALUE="0">
    <PARAM NAME="RTSEnable" VALUE="0">
    <PARAM NAME="RThreshold" VALUE="1">
    <PARAM NAME="SThreshold"  VALUE="0">
    <PARAM NAME="EOFEnable" value="0">
    <PARAM NAME="Handshaking" value="0">
    <PARAM NAME="InputMode"   VALUE="1">
    <PARAM NAME="InBufferSize"   VALUE="1024">
    <PARAM NAME="InputLen" value="0">
    <param name="NullDiscard" value="0">
    <param name="ParityReplace" value="?">
    <param name="DataBits" value="8">
    <param name="StopBits" value="1">
    <param name="BaudRate" value="115200">
    <param name="Settings" value="115200,N,8,1">
</OBJECT>

<script type="text/vbscript">
<!--
function str2asc(strstr)
    str2asc   =   hex(asc(strstr))
 end function

function   asc2str(ascasc)
    asc2str   =   chr(ascasc)
end function

function     byte2hexstr(bytes)
    Dim xmldoc, node

    Set xmldoc = CreateObject("Msxml2.DOMDocument")
    Set node = xmldoc.CreateElement("binary")

    node.DataType = "bin.hex"
    node.Text = "64656D6F6E2E7477"
    node.NodeTypedValue=bytes
   ' MsgBox(node.Text)
    byte2hexstr=node.Text
end function

function     hexstr2byte(str)
    Dim xmldoc, node

    Set xmldoc = CreateObject("Msxml2.DOMDocument")
    Set node = xmldoc.CreateElement("binary")

    node.DataType = "bin.hex"
    node.Text = str
    hexstr2byte=node.NodeTypedValue
end function

function mscomm_send_binary(str)
  Dim buf, size

  buf=hexstr2byte(str)
  size=Len(str)
  'MsgBox(str&";len="&size)
  mscomm.Output=buf
End function

function SavePhoto(path,str)
  Dim i, buf, size, bStream,start
  Dim string,index

  buf=hexstr2byte(str)
  size=Len(str)
  'MsgBox(str&";len="&size)

  Set bStream = CreateObject("ADODB.Stream")
  bStream.Type = 1: bStream.Open
  With CreateObject("ADODB.Stream")
    .Type = 2 : .Open: .WriteText buf
    .Position = 2: .CopyTo bStream: .Close
  End With
  bStream.SaveToFile path, 2: bStream.Close
  Set bStream = Nothing

End function
-->
</script>

<script language="javascript" for="mscomm" event="OnComm">
    OnMyCommEvent();

    function   OnMyCommEvent()
    {
        if(mscomm.CommEvent==1)//如果是发送事件
        {
            //alert("发送");
        }
        else if(mscomm.CommEvent==2)//如果是接收事件
        {
            //alert(12);
           // return ;
            var element,i,code;
            var string,tmp;
            var input_bytes;

            if($("hex_disp_cb").checked){
                mscomm.InputMode=1;
            }
            else {
                mscomm.InputMode=0;
            }
            input_bytes=mscomm.Input;

            if($("hex_disp_cb").checked){
                var bytes;
                string="";

                if(typeof(input_bytes)=='string') {
                    string=bin2hex(input_bytes);
                }
                else{
                    tmp=byte2hexstr(input_bytes);
                    string="";
                    for (var i = 0; i < tmp.length; i+=2) {
                        string += tmp[i].toUpperCase();
                        string += tmp[i+1].toUpperCase()+" ";
                    }
                }
            }
            else {
                if(typeof(input_bytes)=='string') {
                    string="\n"+input_bytes.toString();
                }
                else{
                    tmp=byte2hexstr(input_bytes);
                    alert(tmp);
                    string="";
                    for (var i = 0; i < tmp.length; i+=2) {
                        alert(parseInt(tmp[i],10)&0x00ff);
                        string += String.fromCharCode(parseInt(tmp[i],10)&0x00ff);
                        string += String.fromCharCode(parseInt(tmp[i+1],10)&0x00ff)+" ";
                    }
                }
            }

            if(g_autoAdaptBaud==1)
            {
                if(string.indexOf("OK")>=0 || string.indexOf("4F 4B")>=0)
                    g_autoAdaptBaud=2;
            }

            if(g_cipsend_string_state==1)
            {
                if(string.indexOf(">")>=0) {
                    g_cipsend_string_state = 2;
                    setTimeout('send_string_data()',1000);
                }
            }

            if(g_cipsend_binary_state==1){
                if(string.indexOf(">")>=0) {
                    g_cipsend_binary_state = 2;
                    setTimeout('send_binary_data()',1000);
                }
            }

            if(g_cipmux_state==1) {
                if (string.indexOf("OK") >= 0) {
                    g_bMux = 1;
                    g_cipmux_state = 0;
                    $("socket_id").disabled=false;
                    mux_btn_config(1);
                }
            }
            if(g_cipmux_state==2) {
                if (string.indexOf("OK") >= 0) {
                    g_bMux = 0;
                    g_cipmux_state = 0;
                    $("socket_id").disabled=true;
                    mux_btn_config(0);
                }
            }
            if(g_cipmux_state==3) {
                if(string.indexOf("+CIPMUX:1")>=0) {
                    g_bMux=1;
                    g_cipmux_state = 0;
                    $("socket_id").disabled=false;
                    mux_btn_config(1);
                }
                else  if(string.indexOf("+CIPMUX:0")>=0) {
                    g_bMux=0;
                    $("socket_id").disabled=true;
                    g_cipmux_state = 0;
                    mux_btn_config(0);
                }
            }

            $("recv_text_area").innerText =$("recv_text_area").innerText +string;
            $("recv_text_area").scrollTop = $("recv_text_area").scrollHeight;
        }
        else {
            alert("serial event error CommEvent="+mscomm.CommEvent);
        }
        return false;
    }

</script>

<script>
var count=0;
var g_sms_state=0;
var g_camera_state=0;
var g_at_ok=0;
var g_autoAdaptBaud=0;
var  g_cipsend_string_state=0;
var  g_cipsend_binary_state=0;
var   g_cipsend_string_timeoutId=0;
var   g_cipsend_bingary_timeoutId=0;
var   g_bMux=0;
var   g_cipmux_state=0;

init_load();

function init_load() {
    var index;
    var devicename="{{$devicename}}";
    var gpio_array=new Array();

    search_serial_port();

    if (devicename.localeCompare("A7") == 0) {
      //  alert("A7");
        gpio_array[0]=6;
        gpio_array[1]=7;
        gpio_array[2]=14;
        gpio_array[3]=15;
        gpio_array[4]=16;
    }
    else if (devicename.localeCompare("A6C") == 0){
      //  alert('A6C');
        gpio_array[0]=3;
        gpio_array[1]=5;
        gpio_array[2]=7;
    }
    else{
      //  alert('A6');
        gpio_array[0]=3;
        gpio_array[1]=5;
        gpio_array[2]=6;
        gpio_array[3]=7;
        gpio_array[4]=14;
        gpio_array[5]=15;
        gpio_array[6]=16;
    }

    for(index=0;gpio_array.length;index++)
    {
        var option=document.createElement("option");
            option.text="GPIO"+gpio_array[index].toString();
            option.value=gpio_array[index].toString();
            $("gpio_cfg").add(option,null);
    }


}

function mux_btn_config(mode)
{
    if(mode==1)   {
        alset($("close_btn").style.background.toString());
        $("close_btn").style.background='#ff0000';
        $("send_txt_btn").style.background='#ff0000';
        $("send_bin_btn").style.background='#ff0000';
        $("hb_cfg0_btn").style.background='#ff0000';
        $("hb_cfg1_btn").style.background='#ff0000';
        $("hb_cfg2_btn").style.background='#ff0000';
        $("hb_start_btn").style.background='#ff0000';
        $("hb_stop_btn").style.background='#ff0000';
        $("hb_cfg_btn").style.background='#ff0000';
    }
    else{
        $("close_btn").style.background='';
        $("send_txt_btn").style.background='';
        $("send_bin_btn").style.background='#ff0000';
        $("hb_cfg0_btn").style.background='#ff0000';
        $("hb_cfg1_btn").style.background='#ff0000';
        $("hb_cfg2_btn").style.background='#ff0000';
        $("hb_start_btn").style.background='#ff0000';
        $("hb_stop_btn").style.background='#ff0000';
        $("hb_cfg_btn").style.background='#ff0000';
    }
}

function gpio_read()
{
    var cmd;
    var index=$('gpio_cfg').selectedIndex;
    var gpio=$('gpio_cfg').options[index].value;

    cmd="AT+IORD="+gpio+"\r\n";
    send_at_cmd(cmd);
}

function gpio_write(mode)
{
    var cmd;
    var index=$('gpio_cfg').selectedIndex;
    var gpio=$('gpio_cfg').options[index].value;

    cmd="AT+IOWR="+gpio+","+mode+"\r\n";
    send_at_cmd(cmd);
}

function gpio_dir(mode)
{
    var cmd;
    var index=$('gpio_cfg').selectedIndex;
    var gpio=$('gpio_cfg').options[index].value;

    cmd="AT+IODIR="+gpio+","+mode+"\r\n";
    send_at_cmd(cmd);
}


function hex_disp_cb_click()
{
    if($("hex_disp_cb").checked)
        mscomm.InputMode=1;
    else
        mscomm.InputMode=0;
}

function bin2hex(str) {
    var result = "";
    var high,low;
    for (i = 0; i < str.length; i++ ) {
        var c = str.charCodeAt(i);

        high=c>>8 & 0xff;
        if(high>0)
            result += byte2Hex(high); // 高字节

        result += byte2Hex(c & 0xff);	// 低字节
        result+=" ";
    }
    return result;
}

function byte2Hex(b) {

    if(b < 0x10)
        return "0" + b.toString(16).toUpperCase();
    else
        return b.toString(16).toUpperCase();
}

function save_recv_buffer()
{
    var datetime=new Date();
    var path = "D:\\ModulesTest\\{{$devicename}}_recv_"+datetime.getFullYear()+(datetime.getMonth()+1)+datetime.getDate()+"_"+datetime.getHours()+"_"+datetime.getMinutes()+"_"+datetime.getSeconds()+"_"+".txt";
    //alert(path);
    try {
        var fso = new ActiveXObject("Scripting.FileSystemObject");

        if(!fso.FolderExists("D:\\ModulesTest"))
            fso.CreateFolder("D:\\ModulesTest");

        var file = fso.CreateTextFile(path, true);
        var string = $("recv_text_area").innerText;

        file.WriteLine(string);
        //file.WriteLine("1234567890");

        file.Close();

        alert("保存文件:"+path+"  成功");
    }
    catch(e)
    {
        alert(e.message);
    }
};

function save_photo_buffer()
{
    var datetime=new Date();
    var path = "D:\\ModulesTest\\camera_"+datetime.getFullYear()+(datetime.getMonth()+1)+datetime.getDate()+"_"+datetime.getHours()+"_"+datetime.getMinutes()+"_"+datetime.getSeconds()+"_"+".jpg";
    //SavePhoto(path);
   // return;
    //alert(path);
    var fso = new ActiveXObject("Scripting.FileSystemObject");

    if(!fso.FolderExists("D:\\ModulesTest"))
        fso.CreateFolder("D:\\ModulesTest");

    try {
        //var fso = new ActiveXObject("Scripting.FileSystemObject");
     //   var file = fso.CreateBinaryFile(path, true);
        var string = $("recv_text_area").innerText;
        var image_bytes=new Array();
        var i,index,high,low;
        var str="";

        //alert(1);
       // return;

        i=string.indexOf("FF D8 FF E0 00 10 4A 46 49 46");
        if(i<0)
        {
            alert("保存照片失败，没有数据");
            return;
        }
        index=0;
        for(;i<string.length;i+=3)
        {
            if(string.charCodeAt(i)>=0x30&& string.charCodeAt(i)<=0x39)
            {
                high=string.charCodeAt(i)-0x30;
            }
            else   if(string.charCodeAt(i)>=0x41 && string.charCodeAt(i)<=0x46)
            {
                high=string.charCodeAt(i)-0x41+10;
            }
            else
            {
                alert("保存照片失败，high数据 error");
                high=0;
                break;
            }

            if(string.charCodeAt(i+1)>=0x30&& string.charCodeAt(i+1)<=0x39)
            {
                low=string.charCodeAt(i+1)-0x30;
            }
            else   if(string.charCodeAt(i+1)>=0x41 && string.charCodeAt(i+1)<=0x46)
            {
                low=string.charCodeAt(i+1)-0x41+10;
            }
            else
            {
                alert("保存照片失败，low数据 error");
                low=0;
                break;
            }

            image_bytes[index]=((high<<4)&0xf0)|(low&0x0f);
            str+=byte2Hex(image_bytes[index]);
            index++;
        }
        /*
        var Stream = new ActiveXObject("ADODB.Stream");
        Stream.Type = 1;
        Stream.CharSet = "iso-8859-1";
        Stream.Open();
         Stream.Write(image);
        Stream.SaveToFile(path, 2);
         Stream.Close();
         Stream = null;*/
        //WriteBinary(path,string);
        SavePhoto(path,str);
        //file.Write();
        //file.WriteLine("1234567890");
       // file.Close();
        $("photo").src=path;
        //alert("保存照片:"+path+"  成功");
    }
    catch(e)
    {
        alert(e.message);
    }
};

function t_mode_config(mode)
{
    var cmd;

    if(mode==0) {
        if ($("t_mode_count").value.length > 0) {
            cmd = "AT+CIPTCFG=0," + $("t_mode_count").value + "\r\n";
            send_at_cmd(cmd);
        }
    }
    else if(mode==1) {
        if ($("t_mode_delay").value.length > 0) {
            cmd = "AT+CIPTCFG=1," + $("t_mode_delay").value + "\r\n";
            send_at_cmd(cmd);
        }
    }
    else if(mode==2) {
        if ($("t_mode_pkt").value.length > 0) {
            cmd = "AT+CIPTCFG=2," + $("t_mode_pkt").value + "\r\n";
            send_at_cmd(cmd);
        }
    }
    else if(mode==3) {
        if ($("t_mode_send_times").value.length > 0) {
            cmd = "AT+CIPTCFG=3," + $("t_mode_send_times").value + "\r\n";
            send_at_cmd(cmd);
        }
    }
}

function hb_mode_config(mode)
{
    var cmd;

    if(mode==0) {
        if ($("hb_mode_times").value.length > 0) {
            cmd = "AT+CIPHCFG=0," + $("hb_mode_times").value + "\r\n";
            send_at_cmd(cmd);
        }
    }
    else if(mode==1) {
        if ($("hb_mode_send_pkt").value.length > 0) {
            cmd = "AT+CIPHCFG=1," + $("hb_mode_send_pkt").value + "\r\n";
            send_at_cmd(cmd);
        }
    }
    else if(mode==2) {
        if ($("hb_mode_response_pkt").value.length > 0) {
            cmd = "AT+CIPHCFG=2," + $("hb_mode_response_pkt").value + "\r\n";
            send_at_cmd(cmd);
        }
    }
}

function  start_tcp()
{
   var cmd;

    cmd="AT+CIPSTART=\"TCP\",\""+$("ip_addr").value+"\","+$("ip_port").value+"\r\n";
   // alert(cmd);
    send_at_cmd(cmd);
}

function  start_ucp()
{
    var cmd;

    cmd="AT+CIPSTART=\"UDP\",\""+$("ip_addr").value+"\","+$("ip_port").value+"\r\n";
   // alert(cmd);
    send_at_cmd(cmd);
}
function  send_string_data()
{
    var cmd;
    var str=$("send_content").value;

    if(str.length==0)
        return;

    if(g_cipsend_string_state==0) {
        cmd = "AT+CIPSEND\r\n";
        send_at_cmd(cmd);
        g_cipsend_string_state=1;
        g_cipsend_string_timeoutId=setTimeout('send_string_data()',5000);
    }
    else if(g_cipsend_string_state==1) {
        g_cipsend_string_state=0;
    }
    else if(g_cipsend_string_state==2){
        send_at_cmd(str);
        mscomm_send_binary("1A");
        g_cipsend_string_state=0;

        clearTimeout(g_cipsend_string_timeoutId);
        g_cipsend_string_timeoutId=0;
    }
}

function  send_binary_data()
{
    var cmd;
    var str=$("send_content").value;

    if(str.length==0)
        return;

    if (str.length % 2) {
        alert("16进制数长度错误");
        return;
    }

    if(g_cipsend_binary_state==0) {
            cmd = "AT+CIPSEND=" + str.length/2 + "\r\n";
        //alert(cmd);
        send_at_cmd(cmd);
        g_cipsend_binary_state=1;
        g_cipsend_bingary_timeoutId=setTimeout('send_binary_data()',5000);
    }
    else if(g_cipsend_binary_state==1) {
        g_cipsend_binary_state=0;
    }
    else if(g_cipsend_binary_state==2){
        mscomm_send_binary(str);
        g_cipsend_binary_state=0;

        clearTimeout(g_cipsend_bingary_timeoutId);
        g_cipsend_bingary_timeoutId=0;
    }
}

function  start_camera()
{
    var cmd;
    //save_photo_buffer();
   // return;
    if(g_camera_state==0)
    {
        cmd="AT+CAMSTART=1\r\n";
        // alert(cmd);
        send_at_cmd(cmd);
        g_camera_state=1;

        $("photo").src="";
        setTimeout('start_camera()',1000);
    }
    else if(g_camera_state==1)
    {
        cmd="AT+CAMCAP\r\n";
        // alert(cmd);
        send_at_cmd(cmd);
        g_camera_state=2;

        setTimeout('start_camera()',3000);
    }
    else if(g_camera_state==2)
    {
        cmd="AT+CAMRD=0\r\n";
        // alert(cmd);
        $("hex_disp_cb").checked=true;
        $("recv_text_area").innerText="";

        send_at_cmd(cmd);
        g_camera_state=3;

        setTimeout('start_camera()',5000);
    }
    else if(g_camera_state==3)
    {
        cmd="AT+CAMSTOP\r\n";
        send_at_cmd(cmd);

        save_photo_buffer();
        g_camera_state=0;
    }
}

function  write_imei()
{
    var cmd;
    cmd="AT+EGMR=1,7,"+$("imei").value+"\r\n";
    //alert(cmd);
    send_at_cmd(cmd);
}

function  dial()
{
    var cmd;
    cmd="ATD"+$("dial_number").value+"\r\n";
   // alert(cmd);
    send_at_cmd(cmd);
}

function  send_txt_sms()
{
    var cmd;

    //alert(g_sms_state);
    if(g_sms_state==0)
    {
        cmd="AT+CMGF=1\r\n";
        send_at_cmd(cmd);

        g_sms_state=1;
        setTimeout('send_txt_sms()',1000);
    }
    else if(g_sms_state==1)
    {
        cmd="AT+CMGS="+$("dial_number").value+"\r\n";
       // alert(cmd);
        send_at_cmd(cmd);

        g_sms_state=2;
        setTimeout('send_txt_sms()',3000);
    }
    else if(g_sms_state==2)
    {
        cmd=$("sms_content").value;
      //  alert(cmd);
        send_at_cmd(cmd);
        mscomm.Output=0x1A;
        g_sms_state=3;
        setTimeout('send_txt_sms()',2000);
    }
    else if(g_sms_state==3)
    {
       // alert(g_sms_state);
        g_sms_state=0;
    }
}

function set_baud()
{
    var speed=$("baud_cfg").value.toString();
    send_at_cmd("AT+IPR="+speed+"\r\n");
}

function auto_set_baud()
{
    var i=0;
    var input_bytes;

    if(g_autoAdaptBaud==0 || g_autoAdaptBaud==1) {
        send_at_cmd("AT\r\n");
        g_autoAdaptBaud=1;

        setTimeout("auto_set_baud()",1500);
    }
    else if(g_autoAdaptBaud==2){
        g_autoAdaptBaud=0;
        alert("Baud rate adjust OK");
    }
    else if(g_autoAdaptBaud==3){
        //alert("Baud rate adjust STOP");
        g_autoAdaptBaud=-1;
    }
    else if(g_autoAdaptBaud==-1){
        g_autoAdaptBaud=0;
    }
}

function search_serial_port()
{
    var index;
    for(index=1;index<=10;index++)
    {
        try
          {
              mscomm.CommPort = index;
              mscomm.PortOpen = true;
              mscomm.PortOpen = false;

              var option=document.createElement("option");
              option.text="COM"+index;
              option.value=index;
              $("serial_option").add(option,null);
           }
           catch (e) {
             //alert("index="+index+";name="+e.name+";number="+e.number+";msg="+e.message);
            }
    }
}

function open_serial_btn()
{
    //document.getElementById('mscomm').CommPort=document.getElementById('serial_option').selectedIndex+1;
    if(mscomm.PortOpen==false)
    {
        try
        {
            //mscomm.CommPort=$('serial_option').selectedIndex;
            var index=$('serial_option').selectedIndex;
            mscomm.CommPort=$('serial_option').options[index].value;
            mscomm.Settings=$("serial_speed").value.toString()+
                    ","+$("check_bits").value.toString()+
                    ","+$("data_bits").value.toString()+
                    ","+$("stop_bits").value.toString();
            mscomm.OutBufferCount =0;           //清空发送缓冲区
            mscomm.InBufferCount = 0;           //滑空接收缓冲区
           //alert("已配置串口COM"+mscomm.CommPort+"\n 参数:"+mscomm.Settings);

            mscomm.PortOpen=true;
            $("open_serial_btn").value="关闭串口";
        }
        catch(ex)
        {
            alert(ex.message);
        }
    }
    else
    {
        try
        {
            mscomm.PortOpen=false;
            $("open_serial_btn").value="打开串口";
        }
        catch(ex)
        {
            alert(ex.message);
        }
    }
}

function $(id)
{
    return document.getElementById(id);
}


function send_at_cmd(cmd_str)
{
  //  alert(cmd_str);
    try
    {
        mscomm.InBufferCount=0;
        mscomm.Output = cmd_str;

        $("send_text_area").value =$("send_text_area").innerText + "\n" + cmd_str;
        $("send_text_area").scrollTop = $("send_text_area").scrollHeight;
    }
    catch(ex)
    {
        alert(ex.message);
    }
}

function stringToHex(inputstr)
{
    var i,high,low,index;
    var str,result,value;

    if(inputstr.length%2)
    {
        alert("输入的16进制数错误");
        return;
    }

    str=inputstr.toUpperCase();
    result=new Array();

    index=0;
    for(i=0;i<str.length;i+=2)
    {
        high=str.charCodeAt(i);
        low=str.charCodeAt(i+1);
        if(high<0x30 || (high>0x39 && high<0x41) || high>0x46)
        {
            alert("输入的16进制数错误");
            return 0;
        }

        if(low<0x30 || (low>0x39 &&  low<0x41) || low>0x46)
        {
            alert("输入的16进制数错误");
            return 0;
        }

      //  alert(high);
        if(high>=0x30 && high<=0x39)
        {
            value=((high-0x30)<<4)&0xf0;
        }
        else
        {
            value=((high-0x41+10)<<4)&0xf0;
        }
      //  alert(value);

        if(low>=0x30 && low<=0x39)
        {
            value|=((low-0x30)&0x0f);
        }
        else
        {
            value|=((low-0x41+10)&0x0f);
        }

        result[index++]=value;
     //  alert(value);
    }

    return result;
}

function send_btn()
{
    //alert(document.getElementById("txtSend").value);
    var str=$("send_text").value;
    var send_buffer;

    if(str=="")
       return;
    try
    {
        if($("hex_send_cb").checked) {
            mscomm_send_binary(str);
        }
        else {
            send_buffer=str.split();
            for(var i=0;i<send_buffer.length;i++) {
                mscomm.Output = send_buffer[i];
            }
        }

        if($("new_line_cb").checked)
        {
            mscomm.Output="\r\n";
        }

        $("send_text_area").value =$("send_text_area").innerText + "\n" + str;
        $("send_text_area").scrollTop = $("send_text_area").scrollHeight;
    }
    catch(ex)
    {
        alert(ex.message);
    }
}
</script>
</body>
</html>

