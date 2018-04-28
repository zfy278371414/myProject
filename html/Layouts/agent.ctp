<!DOCTYPE html>
<html>

<head>
    <?php echo $this->Html->charset(); ?>
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0" />
    <meta name="description" content="权盈金服">
    <meta name="keywords" content="权盈金服">
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <meta name="author" content="权盈金服">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="HandheldFriendly" content="true" />
    <title>
        <?php echo $this->fetch('title','权盈金服'); ?>
    </title>
    <?php
		echo $this->fetch('meta');
		echo $this->Html->meta('icon');
		echo $this->Html->css('bootstrap.min.css');
		echo $this->Html->script('jquery.1.11.1.js', array('inline'=>true));
		echo $this->Html->css("../vendor/admin/vendor/bootstrap/css/bootstrap.min.css");
		echo $this->Html->css("../vendor/admin/vendor/font-awesome/css/font-awesome.min.css");
		echo $this->Html->css("../vendor/admin/vendor/linearicons/style.css");
		echo $this->Html->css("../vendor/admin/vendor/chartist/css/chartist-custom.css");
		echo $this->Html->css("../vendor/admin/css/main.css");
		echo $this->Html->css("../vendor/admin/css/demo.css");

		echo $this->Html->script("../vendor/admin/vendor/jquery/jquery.min.js");
		echo $this->Html->script("../vendor/admin/vendor/bootstrap/js/bootstrap.min.js");
		echo $this->Html->script("../vendor/admin/vendor/jquery-slimscroll/jquery.slimscroll.min.js");
		echo $this->Html->script("../vendor/admin/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js");
		echo $this->Html->script("../vendor/admin/vendor/chartist/js/chartist.min.js");
		echo $this->Html->script("../vendor/admin/scripts/qrcode.min.js");
		echo $this->Html->script("../vendor/admin/scripts/klorofil-common.js");

		echo $this->Html->script('ueditor.config.js', array('inline'=>true));
		echo $this->Html->script('ueditor.all.min.js', array('inline'=>true));
		echo $this->fetch('css');
	?>
    <script src="https://cdn.bootcss.com/bootstrap-table/1.12.1/bootstrap-table.min.js"></script>
    <link href="https://cdn.bootcss.com/bootstrap-table/1.12.1/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/bootstrap-table/1.12.1/locale/bootstrap-table-zh-CN.min.js"></script>
    <script src="/js/qyjf/precheck.js?v=1"></script>
      <script>
          if (!Supports.letConst || !Supports.templateString) {
            alert('系统检查到当前浏览器存在兼容性问题，建议您尝试使用其他较新版本的浏览器进行体验');
          }
      </script> 
</head>

<body>
    <div id="wrapper">
        <!-- NAVBAR -->
        <nav style="height: 40px;" class="navbar navbar-default navbar-fixed-top">
            <div class="brand" style="padding: 5px 40px; ">
                <!-- <a href="#"> -->
                <img style="height: 40px;" src="/img/brucezhao10000qyjf02.png" alt="Klorofil Logo" class="img-responsive logo">
                <!-- </a> -->
            </div>
            <div class="text-right" style="padding: 5px 40px; ">
                <div class="block-center">
                    <button class="btn btn-danger" onclick="logout()">登出</button>
                </div>
            </div>
        </nav>
        <!-- END NAVBAR -->
        <!-- LEFT SIDEBAR -->
        <div id="sidebar-nav" class="sidebar">
            <div class="sidebar-scroll">
                <nav>
                    <ul class="nav">
                        <li>
                            <a href="/agent/first_login" class="<?=$action == 'commission' ? 'active' : ''?>">
								<i class="lnr lnr-user"></i> 
								<span>佣金系统</span>
							</a>
                            <ul class="nav">
                                <li>
                                    <a href="/agent/commissions" class="<?=$action == 'commissions' ? 'active' : ''?>">
										<i class="lnr lnr-pencil"></i> 
										<span>佣金管理</span>
									</a>
                                </li>
                                <li>
                                    <a href="/agent/brokers" class="<?=$action == 'brokers' ? 'active' : ''?>">
										<i class="lnr lnr-pencil"></i> 
										<span>代理管理</span>
									</a>
                                </li>
                                <li>
                                    <a href="/agent/clients" class="<?=$action == 'clients' ? 'active' : ''?>">
										<i class="lnr lnr-pencil"></i> 
										<span>客户管理</span>
									</a>
                                </li>
                                <li>
                                    <a href="/agent/tradings" class="<?=$action == 'tradings' ? 'active' : ''?>">
										<i class="lnr lnr-pencil"></i> 
										<span>交易管理</span>
									</a>
                                </li>
                                <li>
                                    <a href="/agent/withdraws" class="<?=$action == 'withdraws' ? 'active' : ''?>">
										<i class="lnr lnr-pencil"></i> 
										<span>提现管理</span>
									</a>
                                </li>
                                <li>
                                    <a href="/agent/new_agent" class="<?=$action == 'new_agent' ? 'active' : ''?>">
										<i class="lnr lnr-pencil"></i> 
										<span>任命新代理</span>
									</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <?php echo $this->fetch('content'); ?>
    </div>
    <?php echo $this->fetch('script');?>
    <script>
    function logout() {
        if (confirm(`是否登出？`))
        {
        	location.href = `/agent/sign_out`;
        }
    }
    </script>
</body>

</html>