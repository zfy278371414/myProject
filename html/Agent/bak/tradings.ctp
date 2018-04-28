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
  <h3><p class="text-center">交易管理</p></h3>
  <div class="main-content">
    <!-- <div class="">
      <h4>交易记录搜索</h4>
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
          <h4 class="panel-title">交易记录列表</h4>
        </div>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>
                <h5>交易编号</h5></th>
              <th>
                <h5>买入日期</h5></th>
              <th>
                <h5>客户姓名</h5></th>
              <th>
                <h5>手机号</h5></th>
              <th>
                <h5>股票代号</h5></th>
              <th>
                <h5>股票名称</h5></th>
              <th>
                <h5>到期日</h5></th>
              <th>
                <h5>名义本金</h5></th>
              <th>
                <h5>认购金额</h5></th>
              <th>
                <h5>行使价</h5></th>
              <th>
                <h5>初始股价</h5></th>
              <th>
                <h5>结算（现）股价</h5></th>
              <th>
                <h5>结算现市值</h5></th>
              <th>
                <h5>当前盈亏</h5></th>
			  <th>
                <h5>交易状态</h5></th>
              <th>
                <h5>总佣金提成</h5></th>
              <th>
                <h5>总分配佣金</h5></th>
              <th>
                <h5>总提现佣金</h5></th>
              <th>
                <h5>佣金分配状态</h5></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($trading_list as $trading):$trading = $trading['Trading'];?>
            <tr data-user-id="<?=$trading['id'];?>">
              <td>
                <h5><?=$trading['id'];?></h5></td>
              <td>
                <h5><?=$trading['created'];?></h5></td>
              <td>
                <h5><?=$trading['name'];?></h5></td>
              <td>
                <h5><?=$trading['tel'];?></h5></td>
              <td>
                <h5><?=$trading['fund_code'];?></h5></td>
              <td>
                <h5><?=$trading['stock_name'];?></h5></td>
              <td>
                <h5><?=$trading['deadline'];?></h5></td>
              <td>
                <h5><?=round($trading['notional'],2);?></h5></td>
              <td>
                <h5><?=$trading['buy_amount'];?></h5></td>
              <td>
                <h5><?=$trading['right_price'];?></h5></td>
              <td>
                <h5><?=$trading['fund_price'];?></h5></td>
              <td>
                <h5 style="color: blue;"><?=$trading['price2'];?></h5></td>
              <td>
                <h5><?=round($trading['mkt_value'],2);?></h5></td>
              <td>
                <h5><?=round($trading['profit'],2);?></h5></td>
              <td>
                <h5><?=$trading['status'];?></h5></td>
			  <td>
                <h5><?=$trading['total'];?></h5></td>
              <td>
                <h5></h5></td>
              <td>
                <h5></h5></td>
              <td>
                <h5></h5></td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>


</script>
