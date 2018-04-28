<style type="text/css">
</style>
<div class="main container">
    <h3><p class="text-center">提现管理</p></h3>
    <div class="main-content">
        <div class="panel" style="padding: 10px;">
            <div class="panel-heading">
                <h4 class="panel-title">未处理的提现申请</h4>
            </div>
            <table class="table table-striped" data-toggle="table" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-sort-name="id" data-sort-order="desc">
                <thead>
                    <tr>
                        <th data-field="id" data-sortable="true" data-align="center" data-halign="center">佣金申请号</th>
                        <th data-sortable="true" data-align="center" data-halign="center">代理ID</th>
                        <th data-sortable="true" data-align="center" data-halign="center">客户分类</th>
                        <th data-sortable="true" data-align="center" data-halign="center">申请人姓名</th>
                        <th data-sortable="true" data-align="center" data-halign="center">申请时间</th>
                        <th data-sortable="true" data-align="center" data-halign="center">佣金额</th>
                        <!--<th data-sortable="true" data-align="center" data-halign="center">历史总佣金</th>
                        <th data-sortable="true" data-align="center" data-halign="center">总分配佣金</th>
                        <th data-sortable="true" data-align="center" data-halign="center">总提现佣金</th>-->
                        <th data-sortable="true" data-align="center" data-halign="center">备注</th>
                        <th data-sortable="true" data-align="center" data-halign="center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($withdraw_list as $withdraw):$withdraw = $withdraw['Capital'];?>
                    <?php if($withdraw['status']==3):?>
                    <tr data-withdrawid="<?=$withdraw['id'];?>">
                        <td>
                            <?=$withdraw['id'];?>
                        </td>
                        <td>
                            <?=$withdraw['user_id'];?>
                        </td>
                        <td>
                            <?=($withdraw['agent_level']=='1'?'销售总监':($withdraw['agent_level']=='2'?'一级代理':($withdraw['agent_level']=='3'?'二级代理':$withdraw['agent_level'])));?>
                        </td>
                        <td id="name">
                            <?=$withdraw['agent_name'];?>
                        </td>
                        <td>
                            <?=$withdraw['created'];?>
                        </td>
                        <!--<td></td>
                        <td></td>
                        <td></td>-->
                        <td>
                            <?=$withdraw['amount'];?>
                        </td>
                        <td>
                            <input type="text" name="remark" class="form-control" placeholder="请输入备注" value="佣金提现">
                        </td>
                        <td> 
                            <button type="button" class="btn btn-sm btn-primary" onclick="withdrawsConfirm(this);">确认</button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="withdrawReject(this);">驳回</button>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <div class="panel" style="padding: 10px;">
            <div class="panel-heading">
                <h4 class="panel-title">申请记录</h4>
            </div>
            <table class="table table-striped" data-toggle="table" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-sort-name="id" data-sort-order="desc">
                <thead>
                    <tr>
                        <th data-field="id" data-sortable="true" data-align="center" data-halign="center">佣金申请号</th>
                        <th data-sortable="true" data-align="center" data-halign="center">代理ID</th>
                        <th data-sortable="true" data-align="center" data-halign="center">客户分类</th>
                        <th data-sortable="true" data-align="center" data-halign="center">申请人姓名</th>
                        <th data-sortable="true" data-align="center" data-halign="center">申请时间</th>
                        <th data-sortable="true" data-align="center" data-halign="center">申请类型</th>
                        <th data-sortable="true" data-align="center" data-halign="center">佣金额</th>
                        <th data-sortable="true" data-align="center" data-halign="center">状态</th>
                        <th data-sortable="true" data-align="center" data-halign="center">备注</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($withdraw_list as $withdraw):$withdraw = $withdraw['Capital'];?>
                    <tr>
                        <td>
                            <?=$withdraw['id'];?>
                        </td>
                        <td>
                            <?=$withdraw['user_id'];?>
                        </td>
                        <td>
                            <?=($withdraw['agent_level']=='1'?'销售总监':($withdraw['agent_level']=='2'?'一级代理':($withdraw['agent_level']=='3'?'二级代理':$withdraw['agent_level'])));?>
                        </td>
                        <td>
                            <?=$withdraw['agent_name'];?>
                        </td>
                        <td>
                            <?=$withdraw['created'];?>
                        </td>
                        <td>
                            <?=$withdraw['type'];?>
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
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
function withdrawsConfirm(e) {
    let td = $(e);
    let tr = td.parents('tr');
    let remark = tr.find('[name=remark]').val();
    let withdrawid = tr.data('withdrawid');
    let name = tr.find("#name").text();
    name = $.trim(name);
    // alert(`Confirm:remark:${remark}   withdrawid:${withdrawid}`);
    let msg = `是否确认${name}的提现申请`;
    if (confirm(msg)) {
        $.get('/agent/confirm_withdraw/' + withdrawid + '/' + remark, function(ret) {
            if (ret < 100) {
                alert('更新成功，即将刷新页面');
                window.location.reload();
            } else {
               alert("余额不足或系统繁忙"); 
                // alert('更新失败，请重试(Error:' + ret + ')');
                // window.location.reload();
            }
        });
    }
}

function withdrawReject(e) {
    let td = $(e);
    let tr = td.parents('tr');
    let remark = tr.find('[name=remark]').val();
    let withdrawid = tr.data('withdrawid');
    // alert(`Reject:remark:${remark}   withdrawid:${withdrawid}`);
    let name = tr.find("#name").text();
    name = $.trim(name);
    let msg = `是否驳回${name}的提现申请`;
    if (confirm(msg)) {
        $.get('/agent/reject_withdraw/' + withdrawid + '/' + remark, function(ret) {
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
</script>