<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
    <meta name="description" content="代理系统">
    <meta name="keywords" content="代理系统">
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <meta name="author" content="代理系统">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <title>
        代理系统-登录
    </title>
    <link href="/favicon.ico" type="image/x-icon" rel="icon">
    <link href="/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <script type="text/javascript" src="/js/jquery.1.11.1.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/../vendor/admin/vendor/bootstrap/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="/css/../vendor/admin/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/css/../vendor/admin/vendor/linearicons/style.css">
    <link rel="stylesheet" type="text/css" href="/css/../vendor/admin/vendor/chartist/css/chartist-custom.css">
    <link rel="stylesheet" type="text/css" href="/css/../vendor/admin/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/../vendor/admin/css/demo.css"> -->
    <script src="/js/qyjf/precheck.js?v=1"></script>
      <script>
          if (!Supports.letConst || !Supports.templateString) {
            alert('系统检查到当前浏览器存在兼容性问题，建议您尝试使用其他较新版本的浏览器进行体验');
          }
      </script> 
    <body>
        <div class="container">
            <div>
                <img class="center-block" src="/img/qyjf/loginlogonew.png" height="200" width="200">
            </div>
            <div>
                <div class="form-group">
                    <label for="exampleInputEmail1">手机号码</label>
                    <input type="number" name="phoneNo" class="form-control" id="phoneNo" placeholder="请输入手机号码">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">短信验证码</label>
                    <input type="number" name="phonePin" class="form-control" id="phonePin" placeholder="请输入短信验证码">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary center-block" onclick="sendSmsCode();">发送验证码</button>
                </div>
                <div class="form-group">
                    <button class="btn btn-default center-block" onclick="login();">登陆</button>
                </div>
            </div>
        </div>
        <script>
        function loginInto() {
            location.href = "/agent";
        }

        function sendSmsCode() {
            let phoneNo = $('[name=phoneNo]').val();
            if ($.trim(phoneNo) == "") {
                qAlert("请输入手机号码");
                return;
            }
            if ($.trim(phoneNo).length!=11 && $.trim(phoneNo).length!=6) {
                qAlert("手机号码仅支持11位");
                return;
            }
            sendSMS($.trim(phoneNo)).then(function(data) {
                let msg = (data && data['msg']) ? data['msg'] : '验证码已发送，请耐心等待';
                qAlert(msg);
            }, function(data) {
                let msg = (data && data['msg']) ? data['msg'] : '服务器正忙，请稍后重试';
                qAlert(msg);
            })
        }

        function login() {
            let phoneNo = $('[name=phoneNo]').val();
            let phonePin = $('[name=phonePin]').val();
            // let agreeSts = $('#agreeSts');
            if ($.trim(phoneNo) == "") {
                qAlert("请输入手机号码");
                return;
            }
            if ($.trim(phoneNo).length!=11 && $.trim(phoneNo).length!=6) {
                qAlert("手机号码仅支持11位");
                return;
            }
            if ($.trim(phonePin) == "") {
                qAlert("请输入短信验证码");
                return;
            }
            // if (agreeSts[0].checked === false) {
            //     qAlert('请先阅读投资协议')
            //     return;
            // }
            validSMS($.trim(phonePin)).then(function() {
                loginInto();
                // mainView.router.navigate('/tabPage');
            }, function(data) {
                qAlert('服务器正忙，请稍后重试')
            })

        }

        function qAlert(str) {
            return alert(str);
        }

        function sendSMS(phoneNo) {
            let url = `/users/send_sms_code/${phoneNo}`;
            return getJSON(url).then(function(data) {
                let d = $.Deferred();
                if (data == null) d.reject();
                else {
                    if (data && data['status'] == true) {
                        d.resolve(data);
                    } else {
                        d.reject(data);
                    }
                }
                return d.promise();
            }, function(error) {
                console.error('sendSMS', 'error', error);
            })
        }

        function validSMS(phonePin) {
            let url = `/users/check_tel/${phonePin}`;
            return getJSON(url).then(function(data) {
                let d = $.Deferred();
                if (data == null) d.reject();
                else {
                    if (data && data['status'] == true) {
                        d.resolve(data);
                    } else {
                        d.reject(data);
                    }
                }
                return d.promise();
            }, function(error) {
                console.error('validSMS', 'error', error);
            })
        }

        function getJSON(url) {
            return $.getJSON(url).then(function(data) {
                console.log('CALL API', url, data);
                var d = $.Deferred();
                data = parseAPIJSONStr(data);
                d.resolve(data);
                return d.promise();
            }, function(error) {
                console.error('CALL API', url, error);
                var d = $.Deferred();
                d.reject({ status: false, "msg": "系统繁忙，请稍后重试" });
                return d.promise();
            })
        }

        function parseAPIJSONStr(data) {
            var obj = {};
            if (typeof data === "string") {
                try {
                    obj = $.parseJSON(data);
                } catch (e) {
                    obj = {};
                }
            } else {
                obj = data;
            }
            return obj;
        }
        </script>
    </body>

</html>