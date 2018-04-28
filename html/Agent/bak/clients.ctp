<style type="text/css">
.save-btn {
  padding: 0px 10px;
  background-color: #98191D;
  color: #FFF;
  width: 80px;
  text-align: center;
  cursor: pointer;
}

.save-btn.disable {
  background-color: #aaa;
}

</style>
<div class="main container">
  <h3><p class="text-center">客户管理</p></h3>
  <div class="main-content">
    <!-- <div class="">
      <h4>客户搜索</h4>
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon glyphicon glyphicon-search" aria-hidden="true"></span>
          <input type="text" class="form-control" id="inputGroupSuccess1" placeholder="搜索输入客户姓名">
        </div>
      </div>
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon glyphicon glyphicon-search" aria-hidden="true"></span>
          <input type="text" class="form-control" id="inputGroupSuccess1" placeholder="搜索输入客户手机号码">
        </div>
      </div>
    </div> -->
    <div class="user-list">
      <div class="panel">
        <div class="panel-heading">
          <h4 class="panel-title">客户列表</h4>
        </div>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>客户编号</th>
              <th>客户姓名</th>
              <th>客户等级</th>
              <th>手机号</th>
              <th>注册时间</th>
              <th>银行账户</th>
              <th>银行名称</th>
              <th>所属销售总监</th>
              <th>所属一级代理</th>
              <th>所属二级代理</th>
              <th>总认购交易额</th>
              <th>当前总市值</th>
              <th>当前可用金额</th>
            </tr>
          </thead>
          <tbody>
		    <?php if((is_array($user_list) || is_object($user_list))): ?>
            <?php foreach($user_list as $user):$user = $user['User'];?>
            <tr data-user-id="<?=$user['id'];?>">
              <td>
                <?=$user['id'];?>
              </td>
              <td>
                <?=$user['name'];?>
              </td>
              <td>
               <?=($user['agent_level']=='1'?'销售总监':($user['agent_level']=='2'?'一级代理':($user['agent_level']=='3'?'二级代理':$user['agent_level'])));?>
              </td>
              <!--level-->
              <td>
                <?=$user['tel'];?>
              </td>
              <td>
                <?=$user['created'];?>
              </td>
              <td>
                <?=$user['bank_info']['num'];?>
              </td>
              <td>
                <?=$user['bank_info']['bank_name'];?>
              </td>
              <td>
                <?=$user['1st_level_agent'];?>
              </td>
              <td>
                <?=$user['2nd_level_agent'];?>
              </td>
              <td>
                <?=$user['3rd_level_agent'];?>
              </td>
              <td>
                <a href="#" style="color:blue;" onclick="toTradePage('<?=$user['id'];?>');">
                  <?=round($user['total_trading_amt'],2);?>
                </a>
              </td>
              <td>
                <?=round($user['total_market_value'],2);?>
              </td>
              <td>
                <?=round($user['total_avl'],2);?>
              </td>
            </tr>
            <?php endforeach;?>
			<?php endif;?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
function toTradePage(id) {
  location.href = `/agent/tradings/${id}`;
}

</script>
