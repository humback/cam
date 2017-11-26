<!Doctype html>
<html>
<head>
    <meta charset="utf-8">
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
            left:400px;
            top:680px;

            outline:#00FFFF solid thick
        }

     .test_button_area
         {
            position:absolute;
            left:820px;
            top:80px;
            width:500px;
            outline:#FF00FF solid thick
         }
    </style>
</head>
<body>
<div class="title_area"><h2>A6模组测试面板</h2></div>


<div class="text_area">
    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;文本框:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button"  id="text_clear_btn"  value="清除缓冲区"  /><input type="button"  id="text_clear_btn"  value="保存缓冲区"  /></h4>
    <textarea id="text" rows="25" cols="90"></textarea>
</div>

<div class="send_text_area">
    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" />HEX显示    <input type="checkbox" />HEX发送<br><br>
    发送框： <input type="text" id="send_text" size="80"  />
    <input type="button"  id="send_btn"  value="发送" /></h4>
</div>

<div class="serial_cfg_area">
   <h4> 串口：
    <select id="serial">
        <option value ="COM1">COM1</option>
        <option value ="COM2">COM2</option>
        <option value="COM3">COM3</option>
        <option value="COM4">COM4</option>
    </select>
      波特率:
    <select id="serial_speed">
        <option value ="4800">4800</option>
        <option value ="9600">9600</option>
        <option value="115200">115200</option>
    </select>
   </h4>
</div>

<div class="open_btn_area">
    <input type="button" value="打开串口" style="height:100px;width:120px;" />
</div>

<div class="test_button_area">
    <h4>
    <input type="button"  id="dial"  value="  打电话  " />  <input type="text"  id="dial_number"  value="10086" /><br><br>
    <input type="button"  id="sms"  value="  发短信  " />  <input type="text"  id="dial_number"  value="10086" /><br><br>
    <input type="button"  id="imei"  value="  写imei  " />  <input type="text"  id="dial_number"  value="10086" /><br><br>
    <input type="button"  id="sms"  value="  读imei  " />  <input type="text"  id="dial_number"  value="10086" /><br><br>
    <input type="button"  id="sms"  value="  读CCID  " />  <input type="text"  id="dial_number"  value="10086" /><br><br>
    <input type="button"  id="sms"  value="  读信号  " />  <input type="text"  id="dial_number"  value="10086" /><br><br>
    <input type="button"  id="sms"  value="查询网络注册" />  <input type="text"  id="dial_number"  value="10086" /><br><br>
    <input type="button"  id="sms"  value=" 切换声音 " />  <input type="text"  id="dial_number"  value="10086" /><br><br>
    </h4>
</div>
<div class="result_relative">

</div>

</body>
</html>
