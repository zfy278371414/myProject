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
      <div class="panel" style="padding: 10px;">
        <div class="panel-heading">
          <h4 class="panel-title">客户列表</h4>
		  <form action="/agent/outexcel/clients" method="POST">
              <input type="hidden" id="user_list" name="user_list" value='<?=json_encode($user_list);?>'>
			  <input type="submit" value="导出至csv"/>
          </form>
        </div>
        <table class="table table-striped" data-toggle="table" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-sort-name="id" data-sort-order="asc">
          <thead>
            <tr>
              <th data-field="id" data-sortable="true" data-align="center" data-halign="center">客户编号</th>
              <th data-field="name" data-sortable="true" data-align="center" data-halign="center">客户姓名</th>
              <th data-field="level" data-sortable="true" data-align="center" data-halign="center">客户等级</th>
              <th data-field="phone" data-sortable="true" data-align="center" data-halign="center">手机号</th>
              <th data-field="regTime" data-sortable="true" data-align="center" data-halign="center">注册时间</th>
              <th data-align="center" data-halign="center">银行账户</th>
              <th data-align="center" data-halign="center">银行名称</th>
              <th data-align="center" data-halign="center">所属销售总监</th>
              <th data-align="center" data-halign="center">所属一级代理</th>
              <th data-align="center" data-halign="center">所属二级代理</th>
              <th data-align="center" data-halign="center">总认购交易额</th>
              <th data-align="center" data-halign="center">当前总市值</th>
              <th data-align="center" data-halign="center">当前可用金额</th>
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
