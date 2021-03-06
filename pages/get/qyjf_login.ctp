<template>
  <div class="page no-toolbar">
    <!-- page-content has additional login-screen content -->
    <div class="page-content login-screen-content">
      <div class="login-screen-title"><img src="/img/qyjf/loginlogonew.png" height="210" width="210"></div>
      <!-- Login form -->
      <div class="list">
        <ul>
          <li class="item-content item-input">
            <div class="item-inner">
              <div class="item-title item-label">手机号码</div>
              <div class="item-input-wrap">
                <input type="number" name="phoneNo" placeholder="请输入手机号码">
                <span class="input-clear-button"></span>
              </div>
            </div>
          </li>
          <li class="item-content item-input">
            <div class="item-inner">
              <div class="item-title item-label">短信验证码</div>
              <div class="item-input-wrap">
                <input type="number" name="phonePin" placeholder="请输入短信验证码">
                <span class="input-clear-button"></span>
              </div>
            </div>
          </li>
          <li class="item-content item-input">
          </li>
        </ul>
      </div>
      <div class="list">
        <ul>
          <li>
            <a  href='#' class="item-link list-button time" @click="sendSMS" style='background:none;border:none;font-size:17px;outline:none' >发送验证码</a>
          </li>
        </ul>
        <ul>
          <li>
            <a href="#" class="item-link list-button" @click="login">登陆</a>
          </li>
        </ul>
        <div class="block-footer text-align-center">
          <label class="checkbox">
            <!-- checkbox input -->
            <input type="checkbox" id="agreeSts">
            <!-- checkbox icon -->
            <i class="icon-checkbox"></i>
          </label>
          <a href="/investDoc"><u>我已阅读并同意投资协议</u></a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
return {
  methods: {
    sendSMS: function(e) {
      var sec = 59;   //定义倒计时变量；
      const self = this;
      const phoneNo = self.$el.find('[name=phoneNo]').val();
      if ($.trim(phoneNo) == "") {
        qAlert("请输入手机号码");
        return;
      }
      if ($.trim(phoneNo).length!=11 && $.trim(phoneNo).length!=6) {
        qAlert("手机号码仅支持11位");
        return;
      }
      
      sendSMS($.trim(phoneNo)).then(function(data) {
        var msg = (data && data['msg']) ? data['msg'] : '验证码已发送，请耐心等待';
        qAlert(msg);
        //短信验证码倒计时
        localStorage.setItem('time', Date.parse( new Date() ) ); 
        self.interval(sec);
        
      }, function(data) {
        var msg = (data && data['msg']) ? data['msg'] : '验证码发送失败，请稍后重试';
        qAlert(msg);
      })
    },
    login: function() {
      const self = this;
      let phoneNo = self.$el.find('[name=phoneNo]').val();
      let phonePin = self.$el.find('[name=phonePin]').val();
      let agreeSts = self.$el.find('#agreeSts');
      console.log(agreeSts[0].checked);
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
      if (agreeSts[0].checked === false) {
        qAlert('请先阅读投资协议')
        return;
      }
      validSMS($.trim(phonePin)).then(function() {
        needUpdateInfo().then(function(data) {
          app.loginScreen.close('.login-screen');
          let status = data['status'];
          if (status === false) {
            mainView.router.navigate('/firstLogin');
          } else {
            mainView.router.navigate('/tabPage', { animate: false });
          }
        }, function() {
          qAlert('服务器正忙，请稍后重试');
        })
        // mainView.router.navigate('/tabPage');
      }, function(data) {
        var msg = (data && data['msg']) ? data['msg'] : '服务器正忙，请稍后重试';
        qAlert(msg);
      })
    },
    interval:function(sec){
       //短信验证码倒计时    
       $('.time').html(sec+'秒后再次获取');
          $('.time').attr('disabled',true);
          $('.time').css('pointer-events','none');
          $('.time').css('color','gray');
          var time = setInterval(function(){
            if(sec==1){
              $('.time').attr('disabled',false);
              $('.time').css('pointer-events','auto');
              $('.time').html('发送验证码');
              $('.time').css('color','#007aff')
              clearInterval(time);
              
            }else{
              
              sec--;
              $('.time').html(sec+'秒后再次获取');
              
            }
          },1000);
    }
  },
  on: {
    pageInit: function() {
      
      if(localStorage.getItem('time')){
        var cha = Date.parse( new Date() )-localStorage.getItem('time');//比较页面打开时间和localStorage里的时间差是否大于60；
        if(cha<=60000){
          var sec = (59000-cha)/1000;
          this.interval(sec);
         
        }
      }
      
    }
  }
}

</script>
