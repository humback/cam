<!Doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>家庭卫士</title>
    <link rel="stylesheet" href="//res.wx.qq.com/open/libs/weui/0.4.1/weui.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style type="text/css">
        body{
            overflow-x: hidden;
            background-color: #fbf9fe;
        }
        .bd {
            margin-top: 5em;
        }
        .mb {
            margin-bottom: 3em;
        }
        .text-center{
            text-align: center;
        }
        #lockButton>i{
            font-size: 52px;
            width: 104px;
            height: 104px;
            line-height: 104px;
            color: #FFFFFF;
            border-radius: 100%;
            background-color: #c9c9c9;
        }
        #lockButton>i.on{
            background-color: #09BB07;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="bd">
            <h3 class="text-center">手机号</h3>
            <div class="weui_cells mb">
                <div class="weui_cell weui_cell_primary">
                    <input id="mobileField" class="weui_input" type="number" placeholder="13800000000">
                </div>
            </div>
            <div class="text-center mb">
                <a id="lockButton" href="#"><i class="fa fa-power-off"></i></a>
            </div>
        </div>
        <div>
            device_id:{{$device_id}} <br/>
            device_type:{{$device_type}} <br/>
            open_id:{{$user->id}}<br/>
            result:<span id="result"></span>
        </div>
    </div>
    <script src="//cdn.bootcss.com/jquery/2.2.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            var data = {};
            data.device_id = "{{$device_id}}";
            data.device_type = "{{$device_type}}";
            data.openid = "{{$user->id}}";

            $('#mobileField').blur(function () {
                var mobile = $(this).val();
                mobile.length == 11 && ajax('mobile', mobile);

                $('#result').html('sending mobile=' + mobile);
            });

            $('#lockButton').on('click touchstart', change);

            function change (e) {
                e.stopPropagation();
                e.preventDefault();

                var status = $('.fa', this).toggleClass('on').hasClass('on');
                ajax('status', status);

                $('#result').html('sending status=' + status);
            }

            function ajax(type, content){
                var values = {type: type, content:content};
                var $data = $.extend({}, data, values);
                {{--$.post("{{$target_url}}", $data, function(data){--}}
                    {{--$('#result').html(JSON.stringify(data));--}}
                {{--}, 'json');--}}
                $.ajax({
                    url: "{{$target_url}}",
                    type: 'post',
                    dataType: "json",
                    data: $data,
                    success: function (data) {
                        $('#result').html(JSON.stringify(data));
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