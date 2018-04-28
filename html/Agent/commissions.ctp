<style type="text/css">
</style>
<div class="main container">
    <h3><p class="text-center">佣金管理</p></h3>
    <div class="main-content">
        <?php if($user_type=='agent'):?>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">我的佣金</h4>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>姓名</th>
                        <th>等级</th>
                        <th>银行卡</th>
                        <th>佣金比例上限</th>
                    </tr>
                </thead>
                <tbody>
                    <td>
                        <?=$cur_user['id'];?>
                    </td>
                    <td>
                        <?=$cur_user['name'];?>
                    </td>
                    <td>
                        <?=($cur_user['level']=='1'?'销售总监':($cur_user['level']=='2'?'一级代理':($cur_user['level']=='3'?'二级代理':$cur_user['level'])));?>
                    </td>
                    <td>
                        <?=$cur_user['bank_num'];?>
                    </td>
                    <td>
                        <?=$cur_user['type_a_rate'];?>
                            /
                            <?=$cur_user['type_b_rate'];?>
                                /
                                <?=$cur_user['type_c_rate'];?>
                                    /
                                    <?=$cur_user['type_d_rate'];?>
                                        /
                                        <?=$cur_user['type_e_rate'];?>
                                            /
                                            <?=$cur_user['type_f_rate'];?>
                                                /
                                                <?=$cur_user['type_g_rate'];?>
                                                    /
                                                    <?=$cur_user['type_h_rate'];?>
                    </td>
                </tbody>
            </table>
        </div>
        <br>
        <br>
        <?php endif;?>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">佣金明细</h4>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>历史佣金总额</th>
                        <th>当前可分配佣金额</th>
                        <th>已分配佣金总额</th>
                        <th>可提现佣金总额</th>
                        <th>已提现佣金总额</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?=($cur_commission['total']==0? 0:$cur_commission['total']);?>
                        </td>
                        <td>
                            <?=($cur_commission['comm_to_assign']==0? 0:$cur_commission['comm_to_assign']);?>
                        </td>
                        <td>
                            <?=($cur_commission['comm_assigned']==0? 0:$cur_commission['comm_assigned']);?>
                        </td>
                        <td>
                            <?=($cur_commission['withdraw_avl']==0? 0:$cur_commission['withdraw_avl']);?>
                        </td>
                        <td>
                            <?=($cur_commission['withdraw_comm']==0? 0:$cur_commission['withdraw_comm']);?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <br>
        <?php if($user_type=='agent'):?>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">佣金转现</h4>
            </div>
            <div class="container">
                <form class="form-inline">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="number" class="form-control" id="exampleInputAmount" placeholder="请输入金额">
                        </div>
                    </div>
                    <button onclick="return do_withdraw()" type="submit" class="btn btn-primary">申请转投资账户</button>
                    <br>
                    <br>
                </form>
            </div>
        </div>
        <br>
        <br>
        <div class="panel" style="padding: 10px;">
            <div class="panel-heading">
                <h4 class="panel-title">我的转现记录</h4>
            </div>
            <table class="table table-striped" data-toggle="table" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-sort-name="id" data-sort-order="desc">
                <thead>
                    <tr>
                        <th data-field="id" data-sortable="true" data-align="center" data-halign="center">佣金申请号</th>
                        <th data-sortable="true" data-align="center" data-halign="center">申请时间</th>
                        <th data-sortable="true" data-align="center" data-halign="center">佣金额</th>
                        <th data-sortable="true" data-align="center" data-halign="center">状态</th>
                        <th data-sortable="true" data-align="center" data-halign="center">备注</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($withdraw_list) || is_object($withdraw_list)):?>
                    <?php foreach($withdraw_list as $withdraw):$withdraw = $withdraw['Capital'];?>
                    <tr data-user-id="<?=$withdraw['id'];?>">
                        <td>
                            <?=$withdraw['id'];?>
                        </td>
                        <td>
                            <?=$withdraw['created'];?>
                        </td>
                        <td>
                            <?=$withdraw['amount'];?>
                        </td>
                        <td>
                            <?=$withdraw_status[$withdraw['status']];?>
                        </td>
                        <td>
                            <?=$withdraw['remark'];?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
        <br>
        <?php endif;?>
        <br>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                  <p>佣金分配比例及审批</p>
                  <br>
                  <ul class="nav nav-pills" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#agentCom100" aria-controls="agentCom100" role="tab" data-toggle="tab">平值期权</a>
                    </li>
                    <li role="presentation">
                        <a href="#agentCom90" aria-controls="agentCom90" role="tab" data-toggle="tab">实值期权90%</a>
                    </li>
                    <li role="presentation">
                        <a href="#agentCom110" aria-controls="agentCom110" role="tab" data-toggle="tab">虚值期权110%</a> 
                    </li>
                  </ul>
                </h4>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="agentCom100">
                    <table class="table table-striped" id="agentComTable100" name="agentTable">
                        <thead>
                            <tr class="alert alert-info">
                                <th>
                                    <h5>代理<br/>ID</h5></th>
                                <th>
                                    <h5>代理<br/>姓名</h5></th>
                                <th>
                                    <h5>客户<br/>分类</h5></th>
                                <th>
                                    <h5>待处理<br/>佣金额<br/>1周<br/>100%</h5></th>
                                <th>
                                    <h5>待处理<br/>佣金额<br/>2周<br/>100%</h5></th>
                                <th>
                                    <h5>待处理<br/>佣金额<br/>4周<br/>100%</h5></th>
                                <th>
                                    <h5>待处理<br/>佣金额<br/>8周<br/>100%</h5></th>
                                <th>
                                    <h5>佣金<br/>比例<br/>1周<br/>100%</h5></th>
                                <th>
                                    <h5>佣金<br/>比例<br/>2周<br/>100%</h5></th>
                                <th>
                                    <h5>佣金<br/>比例<br/>4周<br/>100%</h5></th>
                                <th>
                                    <h5>佣金<br/>比例<br/>8周<br/>100%</h5></th>
                                <th class="alert alert-success">
                                    <h5>佣金<br/>计算</h5></th>
                                <th class="alert alert-success">
                                    <h5>操作</h5></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (is_array($next_level_agents_list) || is_object($next_level_agents_list)):?>
                            <?php foreach($next_level_agents_list as $agent):$agent = $agent['User'];?>
                            <tr name="agentId_<?=$agent['id'];?>" data-id="<?=$agent['id'];?>">
                                <td>
                                    <h6><?=$agent['id'];?></h6></td>
                                <td>
                                    <h6><?=$agent['name'];?></h6></td>
                                <td>
                                    <h6><?=($agent['agent_level']=='1'?'销售总监':($agent['agent_level']=='2'?'一级代理':($agent['agent_level']=='3'?'二级代理':$agent['agent_level'])));?></h6></td>
                                <td id="aValue">
                                    <h6><?=$agent['type_a_amt'];?></h6></td>
                                <td id="bValue">
                                    <h6><?=$agent['type_b_amt'];?></h6></td>
                                <td id="cValue">
                                    <h6><?=$agent['type_c_amt'];?></h6></td>
                                <td id="dValue">
                                    <h6><?=$agent['type_d_amt'];?></h6></td>
                                <td>
                                    <select class="form-control" id="typeA">
                                        <?php 
          for($i=0; $i<=$cur_user['type_a_rate']; $i+=1){
    
          echo "<option value=\"$i\" ".($agent['rate_array']['type_a'] == $i ? 'selected="selected"' : '').">$i</option>";
          }
        ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="typeB">
                                        <?php 
          for($i=0; $i<=$cur_user['type_b_rate']; $i+=1){
    
          echo "<option value=\"$i\" ".($agent['rate_array']['type_b'] == $i ? 'selected="selected"' : '').">$i</option>";
          }
        ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="typeC">
                                        <?php 
          for($i=0; $i<=$cur_user['type_c_rate']; $i+=1){
    
          echo "<option value=\"$i\" ".($agent['rate_array']['type_c'] == $i ? 'selected="selected"' : '').">$i</option>";
          }
        ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="typeD">
                                        <?php 
          for($i=0; $i<=$cur_user['type_d_rate']; $i+=1){
    
          echo "<option value=\"$i\" ".($agent['rate_array']['type_d'] == $i ? 'selected="selected"' : '').">$i</option>";
          }
        ?>
                                    </select>
                                </td>
                                <td id="totalValue" class="alert alert-success">
                                    <h6>&nbsp;</h6></td>
                                <td class="alert alert-success">
                                    <div onclick="update_comrate(this,'<?=$agent['id'];?>')" class="btn btn-success">更新比例及审批</div>
                                </td>
                            </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="agentCom90">
                    <table class="table table-striped" id="agentComTable90" name="agentTable">
                        <thead>
                            <tr class="alert alert-info">
                                <th>
                                    <h5>代理<br/>ID</h5></th>
                                <th>
                                    <h5>代理<br/>姓名</h5></th>
                                <th>
                                    <h5>客户<br/>分类</h5></th>
                                <th>
                                    <h5>待处理<br/>佣金额<br/>1周<br/>90%</h5></th>
                                <th>
                                    <h5>待处理<br/>佣金额<br/>2周<br/>90%</h5></th>
                                <th>
                                    <h5>待处理<br/>佣金额<br/>4周<br/>90%</h5></th>
                                <th>
                                    <h5>待处理<br/>佣金额<br/>8周<br/>90%</h5></th>
                                <th>
                                    <h5>佣金<br/>比例<br/>1周<br/>90%</h5></th>
                                <th>
                                    <h5>佣金<br/>比例<br/>2周<br/>90%</h5></th>
                                <th>
                                    <h5>佣金<br/>比例<br/>4周<br/>90%</h5></th>
                                <th>
                                    <h5>佣金<br/>比例<br/>8周<br/>90%</h5></th>
                                <th class="alert alert-success">
                                    <h5>佣金<br/>计算</h5></th>
                                <th class="alert alert-success">
                                    <h5>操作</h5></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (is_array($next_level_agents_list) || is_object($next_level_agents_list)):?>
                            <?php foreach($next_level_agents_list as $agent):$agent = $agent['User'];?>
                            <tr name="agentId_<?=$agent['id'];?>" data-id="<?=$agent['id'];?>">
                                <td>
                                    <h6><?=$agent['id'];?></h6></td>
                                <td>
                                    <h6><?=$agent['name'];?></h6></td>
                                <td>
                                    <h6><?=($agent['agent_level']=='1'?'销售总监':($agent['agent_level']=='2'?'一级代理':($agent['agent_level']=='3'?'二级代理':$agent['agent_level'])));?></h6></td>
                                <td id="eValue">
                                    <h6><?=$agent['type_e_amt'];?></h6></td>
                                <td id="fValue">
                                    <h6><?=$agent['type_f_amt'];?></h6></td>
                                <td id="gValue">
                                    <h6><?=$agent['type_g_amt'];?></h6></td>
                                <td id="hValue">
                                    <h6><?=$agent['type_h_amt'];?></h6></td>
                                <td>
                                    <select class="form-control" id="typeE">
                                        <?php 
          for($i=0; $i<=$cur_user['type_e_rate']; $i+=1){
    
          echo "<option value=\"$i\" ".($agent['rate_array']['type_e'] == $i ? 'selected="selected"' : '').">$i</option>";
          }
        ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="typeF">
                                        <?php 
          for($i=0; $i<=$cur_user['type_f_rate']; $i+=1){
    
          echo "<option value=\"$i\" ".($agent['rate_array']['type_f'] == $i ? 'selected="selected"' : '').">$i</option>";
          }
        ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="typeG">
                                        <?php 
          for($i=0; $i<=$cur_user['type_g_rate']; $i+=1){
    
          echo "<option value=\"$i\" ".($agent['rate_array']['type_g'] == $i ? 'selected="selected"' : '').">$i</option>";
          }
        ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="typeH">
                                        <?php 
          for($i=0; $i<=$cur_user['type_h_rate']; $i+=1){
    
          echo "<option value=\"$i\" ".($agent['rate_array']['type_h'] == $i ? 'selected="selected"' : '').">$i</option>";
          }
        ?>
                                    </select>
                                </td>
                                <td id="totalValue" class="alert alert-success">
                                    <h6>&nbsp;</h6></td>
                                <td class="alert alert-success">
                                    <div onclick="update_comrate(this,'<?=$agent['id'];?>')" class="btn btn-success">更新比例及审批</div>
                                </td>
                            </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="agentCom110">
                    <table class="table table-striped" id="agentComTable110" name="agentTable">
                        <thead>
                            <tr class="alert alert-info">
                                <th>
                                    <h5>代理<br/>ID</h5></th>
                                <th>
                                    <h5>代理<br/>姓名</h5></th>
                                <th>
                                    <h5>客户<br/>分类</h5></th>
                                <th>
                                    <h5>待处理<br/>佣金额<br/>1周<br/>110%</h5></th>
                                <th>
                                    <h5>待处理<br/>佣金额<br/>2周<br/>110%</h5></th>
                                <th>
                                    <h5>待处理<br/>佣金额<br/>4周<br/>110%</h5></th>
                                <th>
                                    <h5>待处理<br/>佣金额<br/>8周<br/>110%</h5></th>
                                <th>
                                    <h5>佣金<br/>比例<br/>1周<br/>110%</h5></th>
                                <th>
                                    <h5>佣金<br/>比例<br/>2周<br/>110%</h5></th>
                                <th>
                                    <h5>佣金<br/>比例<br/>4周<br/>110%</h5></th>
                                <th>
                                    <h5>佣金<br/>比例<br/>8周<br/>110%</h5></th>
                                <th class="alert alert-success">
                                    <h5>佣金<br/>计算</h5></th>
                                <th class="alert alert-success">
                                    <h5>操作</h5></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (is_array($next_level_agents_list) || is_object($next_level_agents_list)):?>
                            <?php foreach($next_level_agents_list as $agent):$agent = $agent['User'];?>
                            <tr name="agentId_<?=$agent['id'];?>" data-id="<?=$agent['id'];?>">
                                <td>
                                    <h6><?=$agent['id'];?></h6></td>
                                <td>
                                    <h6><?=$agent['name'];?></h6></td>
                                <td>
                                    <h6><?=($agent['agent_level']=='1'?'销售总监':($agent['agent_level']=='2'?'一级代理':($agent['agent_level']=='3'?'二级代理':$agent['agent_level'])));?></h6></td>
                                <td id="iValue">
                                    <h6><?=$agent['type_i_amt'];?></h6></td>
                                <td id="jValue">
                                    <h6><?=$agent['type_j_amt'];?></h6></td>
                                <td id="kValue">
                                    <h6><?=$agent['type_k_amt'];?></h6></td>
                                <td id="lValue">
                                    <h6><?=$agent['type_l_amt'];?></h6></td>
                                <td>
                                    <select class="form-control" id="typeI">
                                        <?php 
          for($i=0; $i<=$cur_user['type_i_rate']; $i+=1){
    
          echo "<option value=\"$i\" ".($agent['rate_array']['type_i'] == $i ? 'selected="selected"' : '').">$i</option>";
          }
        ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="typeJ">
                                        <?php 
          for($i=0; $i<=$cur_user['type_j_rate']; $i+=1){
    
          echo "<option value=\"$i\" ".($agent['rate_array']['type_j'] == $i ? 'selected="selected"' : '').">$i</option>";
          }
        ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="typeK">
                                        <?php 
          for($i=0; $i<=$cur_user['type_k_rate']; $i+=1){
    
          echo "<option value=\"$i\" ".($agent['rate_array']['type_k'] == $i ? 'selected="selected"' : '').">$i</option>";
          }
        ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="typeL">
                                        <?php 
          for($i=0; $i<=$cur_user['type_l_rate']; $i+=1){
    
          echo "<option value=\"$i\" ".($agent['rate_array']['type_l'] == $i ? 'selected="selected"' : '').">$i</option>";
          }
        ?>
                                    </select>
                                </td>
                                <td id="totalValue" class="alert alert-success">
                                    <h6>&nbsp;</h6></td>
                                <td class="alert alert-success">
                                    <div onclick="update_comrate(this,'<?=$agent['id'];?>')" class="btn btn-success">更新比例及审批</div>
                                </td>
                            </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="panel" style="padding: 10px;">
            <div class="panel-heading">
                <h4 class="panel-title">已分配佣金记录</h4>
            </div>
            <table class="table table-striped" data-toggle="table" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-sort-name="createTime" data-sort-order="desc">
                <thead>
                    <tr>
                        <th data-field="id" data-sortable="true" data-align="center" data-halign="center">代理ID</th>
                        <th data-sortable="true" data-align="center" data-halign="center">客户分类</th>
                        <th data-sortable="true" data-align="center" data-halign="center">代理姓名</th>
                        <th data-field="createTime" data-sortable="true" data-align="center" data-halign="center">分配时间</th>
                        <th data-sortable="true" data-align="center" data-halign="center">佣金总额</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if((is_array($commission_list) || is_object($commission_list))): ?>
                    <?php foreach($commission_list as $commission):$commission = $commission['Commissions'];?>
                    <tr>
                        <td>
                            <?=$commission['assign_id'];?>
                        </td>
                        <td>
                            <?=($commission['agent_level']=='1'?'销售总监':($commission['agent_level']=='2'?'一级代理':($commission['agent_level']=='3'?'二级代理':$commission['agent_level'])));?>
                        </td>
                        <td>
                            <?=$commission['agent_name'];?>
                        </td>
                        <td>
                            <?=$commission['created'];?>
                        </td>
                        <td>
                            <?=$commission['assign_amt'];?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
        <br>
        <br>
        <script type="text/javascript">
        $(function() {
            //select init
            $("select", "[name=agentTable]").on('change', function() {
                let tr = $(this).parents("tr");
                let id = tr.data('id');
                let name = `agentId_${id}`;
                tr = $(`tr[name=${name}]`);
                let a = tr.find("#aValue").text() / 100;
                let b = tr.find("#bValue").text() / 100;
                let c = tr.find("#cValue").text() / 100;
                let d = tr.find("#dValue").text() / 100;
                let e = tr.find("#eValue").text() / 100;
                let f = tr.find("#fValue").text() / 100;
                let g = tr.find("#gValue").text() / 100;
                let h = tr.find("#hValue").text() / 100;
                let i = tr.find("#iValue").text() / 100;
                let j = tr.find("#jValue").text() / 100;
                let k = tr.find("#kValue").text() / 100;
                let l = tr.find("#lValue").text() / 100;
                let aC = tr.find("#typeA").val();
                let bC = tr.find("#typeB").val();
                let cC = tr.find("#typeC").val();
                let dC = tr.find("#typeD").val();
                let eC = tr.find("#typeE").val();
                let fC = tr.find("#typeF").val();
                let gC = tr.find("#typeG").val();
                let hC = tr.find("#typeH").val();
                let iC = tr.find("#typeI").val();
                let jC = tr.find("#typeJ").val();
                let kC = tr.find("#typeK").val();
                let lC = tr.find("#typeL").val();
                let total = a * aC + b * bC + c * cC + d * dC + e * eC + f * fC + g * gC + h * hC + i * iC + j * jC + k * kC + l * lC;
                tr.find("#totalValue h6").text(total);
            });
            $("tr", "[name=agentTable]").each(function() {
                $(this).find("select").eq(0).trigger("change");
            });
        });

        function update_comrate(obj, id) {
            let name = `agentId_${id}`;
            let tr = $(`tr[name=${name}]`);
            var typeA = tr.find('#typeA').val();
            var typeB = tr.find('#typeB').val();
            var typeC = tr.find('#typeC').val();
            var typeD = tr.find('#typeD').val();
            var typeE = tr.find('#typeE').val();
            var typeF = tr.find('#typeF').val();
            var typeG = tr.find('#typeG').val();
            var typeH = tr.find('#typeH').val();
            var typeI = tr.find('#typeI').val();
            var typeJ = tr.find('#typeJ').val();
            var typeK = tr.find('#typeK').val();
            var typeL = tr.find('#typeL').val();
            if (confirm('确认更新佣金比例?')) {

                $.get('/agent/update_comrate/' + id 
                    + '/' + typeA + '/' + typeB + '/' + typeC + '/' + typeD 
                    + '/' + typeE + '/' + typeF + '/' + typeG + '/' + typeH
                    + '/' + typeI + '/' + typeJ + '/' + typeK + '/' + typeL
                    ,
                    function(ret) {
                        if (ret < 100) {
                            alert('更新成功，即将刷新页面');
                            window.location.reload();
                        } else {
                            alert('更新失败，请重试(Error:' + ret + ')');
                            window.location.reload();
                        }
                    });
            }
        }

        function do_withdraw() {
            var withdraw_amt = $('#exampleInputAmount').val();
            if ($.trim(withdraw_amt) == "") {
                alert("请输入金额")
                return false;
            }
            if (parseFloat(withdraw_amt) <= 0) {
                alert("请输入有效的金额")
                return false;
            }
            if (confirm('确认转现?')) {
                $.get('/agent/do_withdraw/' + withdraw_amt)
                    .done(function(ret) {
                        if (ret < 100) {
                            alert('更新成功，即将刷新页面');
                            window.location.reload();
                        } else {
                            alert("余额不足或系统繁忙");
                            // alert('更新失败，请重试(Error:' + ret + ')');
                            // window.location.reload();
                        }
                    })
                    .fail(function() {
                        alert('系统繁忙，请稍后重试')
                    })
            }
            return false;
        }
        </script>