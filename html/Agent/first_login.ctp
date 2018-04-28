<style type="text/css">


</style>
<div class="main">
  <div class="main-content">
    <div class="">
      <div class="btn-block">
        <a href="/agent/commissions" class="btn btn-default btn-block">佣金管理</a>
        <a href="/agent/brokers" class="btn btn-default btn-block">代理管理</a>
        <a href="/agent/clients" class="btn btn-default btn-block">客户管理</a>
        <a href="/agent/tradings" class="btn btn-default btn-block">交易管理</a>
        <a href="/agent/withdraws" class="btn btn-default btn-block">提现管理</a>
        <a href="/agent/new_agent" class="btn btn-default btn-block">任命新代理</a>
      </div>
    </div>
    <blockquote>
      <p>请确认以下资料是否正确，如有误，请联系您的上级代理或总部客服</p>
    </blockquote>
    <div class="user-list">
      <table class="table table-striped">
        <!--  <thead>
          <tr>
            <td>
              <blockquote>
                <p>系统检测到您是初次登陆代理系统，请确认以下资料是否正确，如有误，请联系您的上级代理或总部客服</p>
              </blockquote>
            </td>
          </tr>
        </thead> -->
        <tbody>
          <tr>
            <td>代理ID：
              <?=$cur_user['id'];?>
            </td>
          </tr>
          <tr>
            <td>上级代理：
              <?=$cur_user['inv_user'];?>
            </td>
          </tr>
          <tr>
            <td>客户分类：
              <?=($cur_user['level']=='1'?'销售总监':($cur_user['level']=='2'?'一级代理':($cur_user['level']=='3'?'二级代理':$cur_user['level'])));?>
            </td>
          </tr>
          <tr>
            <td>姓名：
              <?=$cur_user['name'];?>
            </td>
          </tr>
          <tr>
            <td>手机号码：
              <?=$cur_user['tel'];?>
            </td>
          </tr>
          <tr>
            <td>身份证号：
              <?=$cur_user['personal_code'];?>
            </td>
          </tr>
          <tr>
            <td>银行账户：
              <?=$cur_user['num'];?>
            </td>
          </tr>
          <tr>
            <td>开户行：
              <?=$cur_user['bank_name'];?>
            </td>
          </tr>
          <tr>
            <td>开户支行：
              <?=$cur_user['sub_bank'];?>
            </td>
          </tr>
          <tr>
            <td>
              <blockquote>
                <p>
                  <?=$cur_user['message'];?>
                </p>
              </blockquote>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
   <!--  <div>
      <button onclick="confirmInfo()" class="btn btn-primary center-block">确认资料正确无误</button>
    </div> -->
  </div>
</div>
<script>
function confirmInfo() {
  $.get('/agent/confirm_info', function(ret) {
    if (ret < 100) {
      alert('确认成功，即将刷新页面');
      window.location.href = '/agent/index';
    } else {
      alert('确认失败，请重试(Error:' + ret + ')');
      window.location.reload();
    }
  });
}

</script>
