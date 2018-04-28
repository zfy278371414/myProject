<style type="text/css">
</style>
<div class="main container">
    <h3><p class="text-center">代理管理</p></h3>
    <div class="main-content">
        <div class="user-list">
            <div class="panel" style="padding: 10px;">
                <div class="panel-heading">
                    <h4 class="panel-title">代理列表</h4>
                </div>
                <table class="table table-striped table-hover" data-toggle="table" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-sort-name="id" data-sort-order="asc">
                    <thead>
                        <tr>
                            <th data-field="id" data-sortable="true" data-align="center" data-halign="center">代理编号</th>
                            <th data-field="name" data-sortable="true" data-align="center" data-halign="center">代理姓名</th>
                            <th data-field="level" data-sortable="true" data-align="center" data-halign="center">客户分类</th>
                            <th data-field="phone" data-sortable="true" data-align="center" data-halign="center">手机号</th>
                            <th data-field="joinTime" data-sortable="true" data-align="center" data-halign="center">加入时间</th>
                            <th data-align="center" data-halign="center">总佣金</th>
                            <th data-align="center" data-halign="center">已获取佣金</th>
                            <th data-align="center" data-halign="center">可获取佣金</th>
                            <th data-align="center" data-halign="center">名下代理总数</th>
                            <th data-align="center" data-halign="center">名下客户总数</th>
                            <th data-align="center" data-halign="center">总认购交易额</th>
                            <th data-align="center" data-halign="center">总入金金额</th>
                            <?php if($user_type=='admin'):?>
                            <!-- todo 总部才有 -->
                            <th>操作</th>
                            <?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($user_list) || is_object($user_list)):?>
                        <?php foreach($user_list as $user):$user = $user['User'];?>
                        <tr id="agent_<?=$user['id'];?>" data-user-id="<?=$user['id'];?>">
                            <td>
                                <?=$user['id'];?>
                            </td>
                            <td>
                                <div style="cursor: pointer;color: blue;" onclick="showAgentById('<?=$user['id'];?>','<?=$user['name'];?>');">
                                    <?=$user['name'];?>
                                </div>
                            </td>
                            <td>
                                <?=($user['agent_level']=='1'?'销售总监':($user['agent_level']=='2'?'一级代理':($user['agent_level']=='3'?'二级代理':$user['agent_level'])));?>
                            </td>
                            <td>
                                <?=$user['tel'];?>
                            </td>
                            <td>
                                <?=$user['created'];?>
                            </td>
                            <td>
                                <div style="cursor: pointer;color: blue;" onclick="toTradePage('<?=$user['id'];?>');">
                                    <?=$user['total_commission'];?>
                                </div>
                            </td>
                            <td>
                                <div style="cursor: pointer;color: blue;" onclick="toWithdrawPage();">
                                    <?=$user['commission_get'];?>
                                </div>
                            </td>
                            <td>
                                <div style="cursor: pointer;color: blue;" onclick="toWithdrawPage();">
                                    <?=$user['commission_avl'];?>
                                </div>
                            </td>
                            <td>
                                <div style="cursor: pointer;color: blue;" onclick="toProxyUserPage('<?=$user['id'];?>');">
                                    <?=$user['agent_count'];?>
                                </div>
                            </td>
                            <td>
                                <div style="cursor: pointer;color: blue;" onclick="toProxyUserPage('<?=$user['id'];?>');">
                                    <?=$user['client_count'];?>
                                </div>
                            </td>
                            <td>
                                <div style="cursor: pointer;color: blue;" onclick="toTradePage('<?=$user['id'];?>');">
                                    <?=$user['total_trading_amt'];?>
                                </div>
                            </td>
                            <td>
                                <?=$user['total_invest_amt'];?>
                            </td>
                            <?php if($user_type=='admin'):?>
                            <!-- todo 总部才有 -->
                            <td>
                                <button class="btn btn-danger" onclick="cancelAgent('<?=$user['id'];?>');">取消代理资格</button> 
                            </td>
                            <?php endif;?>
                        </tr>
                        <?php endforeach;?>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="subAgent">
        </div>
    </div>
</div>
<script>
function cancelAgent(id) {
    if(confirm('是否确认取消该客户的代理资格？'))
    {
        let url = `/agent/cancel_agent/${id}`;
        getJSON(url).then(function(data) {
            if (data && data['status']) {
                let msg = data['msg'] || '代理取消成功';
                alert(msg);
                location.reload();
                return;
            } else {
                alert('操作失败，请稍后重试');
            }
        }, function() {
            alert('操作失败，请稍后重试');
        })
    }
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

function toProxyUserPage(id) {
    location.href = "/agent/clients" + "/" + id;
}

function toTradePage(id) {
    location.href = "/agent/tradings" + "/" + id;
}

function toWithdrawPage() {
    location.href = "/agent/withdraws";
}

function loadingWrap(promise) {
    if (promise && promise.then) {
        // app.preloader.show();
        promise.always(function() {
            // app.preloader.hide();
        })
    }
    return promise;
}

function getAgentInfoById(id) {
    let url = `/agent/get_agents_info_belong_to/${id}`;
    return getJSON(url).then(function(returnObj) {
        let status = returnObj['status'];
        let d = $.Deferred();
        if (status === true) {
            let msg = returnObj['msg'];
            let obj = $.parseJSON(msg);
            d.resolve(obj);
        } else {
            d.reject();
        }
        return d.promise();
    });
}

function showAgentById(id, name) {
    let _id = id;
    let _name = name;
    let d = $.Deferred();
    getAgentInfoById(id)
        .then(function(returnObj) {
            let obj = null;
            if (returnObj != null) {
                obj = returnObj;
            }
            highlightAgent(_id);
            showResult(obj, _name);
        }, function() {
            let obj = null;
            highlightAgent(_id);
            showResult(obj, _name);
        })
        .always(function() {
            d.resolve();
        })
    return loadingWrap(d.promise());
}

function highlightAgent(id) {
    let idName = `agent_${id}`;
    let el = $(`#${idName}`);
    el.parent().children().removeClass('warning');
    el.addClass('warning');
}

function showResult(obj, name) {
    let subAgent = $("#subAgent");
    subAgent.empty();
    subAgent.append(getAgentTableTpl(obj, name));
}

function getLevelLabel(level) {
    switch (level) {
        case "1":
            return "销售总监";
        case "2":
            return "一级代理";
        case "3":
            return "二级代理";
        default:
            return level;
    }
}

function getAgentTableTpl(obj, name) {
    console.log('getAgentTableTpl', obj);
    let temp = ``;
    let dataResult = ``;
    let trs = [];
    if (obj != null) {
        for (let i = 0; i < obj.length; i++) {
            let data = obj[i]['User'];
            console.log(data);
            let tr = `
      <tr>
                <td>${data['id']}</td>
                <td>${data['name']}</td>
                <td>${getLevelLabel(data['agent_level'])}</td>
                <td>${data['tel']}</td>
                <td>${data['created']}</td>
                <td>${data['total_com']}</td>
                <td>${data['avl_com']}</td>
                <td>${data['get_com']}</td>
                <td>${data['agents_under']}</td>
                <td>${data['clients_under']}</td>
                <td>${data['total_trading_amt']}</td>
                <td>${data['total_paid']}</td>
            </tr>
      `;
            trs.push(tr);
        }
    }
    if (trs.length > 0) {
        dataResult = `
      <div class="user-list">
        <div class="panel">
        <table class="table table-striped">
          <thead>
                  <tr>
                      <th>代理编号</th>
                      <th>代理姓名</th>
                      <th>客户分类</th>
              <th>手机号</th>
                      <th>加入时间</th>
              <th>总佣金</th>
              <th>已获取佣金</th>
              <th>可获取佣金</th>
              <th>名下代理总数</th>
              <th>名下客户总数</th>
              <th>总认购交易额</th>
              <th>总入金金额</th>
                  </tr>
              </thead>
              <tbody>
                  ${trs.join('')}
              </tbody>
                
        </table>
        </div>
      </div>
    `;
        temp += `
      <h4><p class="text-info">${name}的下属代理详情</p></h4>
      ${dataResult}
    `;
    } else {
        temp += `
      <h4><p class="text-info">${name}当前无下属代理</p></h4>
    `;
    }
    return temp;
}
</script>