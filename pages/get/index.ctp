<!DOCTYPE html>
<!-- saved from url=(0053)http://framework7.taobao.org/examples/tab-bar/#view-2 -->
<html class="pixel-ratio-2 retina android android-6 android-6-0 watch-active-state">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <title>千惠资本</title>
  <!-- Path to Framework7 Library CSS-->
  <link rel="stylesheet" href="css/framework7.ios.min.css">
  <link rel="stylesheet" href="css/framework7.ios.colors.min.css">
  <link rel="stylesheet" href="css/framework7.css">
  <!-- Path to your custom app styles-->
  <link rel="stylesheet" href="css/my-app.css">
  <style type="text/css" abt="234"></style>
  <script>

  </script>
</head>

<body>
  <div id="app">
    <div class="panel panel-left panel-cover">
      <div class="view panel-view"></div>
    </div>
    <div class="views">
      <div class="view view-main" data-name="main">
        <!-- <div class="toolbar tabbar tabbar-labels">
          <div class="toolbar-inner">
            <a href="/page3" class="tab-link tab-link-active"> <i class="icon tabbar-demo-icon-3"></i><span class="tabbar-label">账户</span></a>
            <a href="/page1" class="tab-link"> <i class="icon tabbar-demo-icon-1"></i><span class="tabbar-label">询价</span></a>
            <a href="/page2" class="tab-link"> <i class="icon tabbar-demo-icon-2"></i><span class="tabbar-label">持仓</span></a>
            <a href="/page4" class="tab-link"> <i class="icon tabbar-demo-icon-4"></i><span class="tabbar-label">自选股</span></a>
          </div>
        </div> -->
      </div>
    
    </div>
    <div class="popup">
      <div class="view popup-view"></div>
    </div>
  </div>
  <!-- Path to Framework7 Library JS-->
  <script type="text/javascript" src="js/framework7.js"></script>
  <script>
  // Initialize your app
  var app = new Framework7({
    root: '#app',
    swipeBackPage: false,
    routes: [
      {
        path: '/tabPage',
        url: '/demo/tabPage.html',
      },
       {
        path: '/checkLogin',
        url: '/demo/checkLogin.html',
      },
      {
        path: '/checkPhone',
        url: '/demo/checkPhone.html',
      },
      {
        path: '/login',
        url: '/demo/login.html',
      },
      {
        path: '/page1',
        url: '/demo/page1.html',
      },
      {
        path: '/page2',
        url: '/demo/page2.html',
      },
      {
        path: '/page3',
        url: '/demo/page3.html',
      },
      {
        path: '/page4',
        url: '/demo/page4.html',
      }
    ],
  });

  // Export selectors engine
  var $$ = Dom7;
  var mainView = app.views.create('.view-main', {
    url: '/checkLogin'
  });


  </script>
</body>

</html>
