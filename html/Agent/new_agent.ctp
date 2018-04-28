<style type="text/css">
</style>
<div class="main container">
    <h3><p class="text-center">任命新代理</p></h3>
    <div class="main-content">
        <form class="form-horizontal" action="/agent/new_agent" method="POST">
            <div class="form-group">
                <div class="col-sm-3"></div>
                <div class="input-group1 col-sm-4">
                    <!-- <span class="input-group-addon glyphicon glyphicon-search" aria-hidden="true"></span> -->
                    <input type="text" id="name" name="name" value="<?=$search_name;?>" class="form-control" placeholder="搜索输入我推荐的客户姓名">
                </div>
                <button type="submit" class="btn btn-primary col-sm-2">姓名搜索</button>
                <div class="col-sm-3"></div>
            </div>
        </form>
        <form class="form-horizontal" action="/agent/new_agent" method="POST">
            <div class="form-group">
                <div class="col-sm-3"></div>
                <div class="input-group1 col-sm-4">
                    <!-- <span class="input-group-addon glyphicon glyphicon-search" aria-hidden="true"></span> -->
                    <input type="text" id="tel" name="tel" value="<?=$search_tel;?>" class="form-control" placeholder="搜索我推荐的客户手机号码">
                </div>
                <button type="submit" class="btn btn-primary col-sm-2">号码搜索</button>
                <div class="col-sm-3"></div>
            </div>
        </form>
        <div class="" style="height: 300px; ">
            <div>
                <!-- <p>您的邀请码链接为：<span id="inviteLink"></span></p> -->
                <div class="">
                    <blockquote>
                        <p>如此代理尚未开立交易账户，请发送此二维码给此代理，请其注册并实名认证。</p>
                    </blockquote>
                    <p></p>
                    <div id="qrCode" class="center-block" style="width: 200px;">
                    </div>
                </div>
            </div>
            <br>
        </div>
        <div class="user-list">
            <div class="panel" style="padding: 10px;">
                <table class="table table-striped" data-toggle="table" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="false" data-sort-name="id" data-sort-order="desc">
                    <thead>
                        <tr>
                            <th data-field="id" data-sortable="true" data-align="center" data-halign="center">ID</th>
                            <th data-sortable="true" data-align="center" data-halign="center">姓名</th>
                            <th data-sortable="true" data-align="center" data-halign="center">手机号码</th>
                            <th data-sortable="true" data-align="center" data-halign="center">注册时间</th>
                            <th data-sortable="true" data-align="center" data-halign="center">操作邀请</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php if(is_array($user_list) || is_object($user_list)):?>
                        <?php foreach($user_list as $user):$user = $user['User'];?>
                        <tr data-user-id="<?=$user['id'];?>">
                            <td>
                                <?=$user['id'];?>
                            </td>
                            <td>
                                <?=$user['name'];?>
                            </td>
                            <td>
                                <?=$user['tel'];?>
                            </td>
                            <td>
                                <?=$user['created'];?>
                            </td>
                            <td>
								<?php if($cur_user['agent_level']==1||$cur_user['agent_level']==2||$cur_user['agent_level']==NULL):?>
                                <div onclick="add_new_agent(this,'<?=$user['id'];?>')" class="btn btn-primary">添加为下一级代理</div>
								<?php endif;?>
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
$(function() {
    getInviteCode().then(function(data) {
        let msg = data['msg'];
        if (msg != null) {
            let inviteCode = data['msg'];
            let url = `${location.origin}?inviteCode=${inviteCode}`
            $("#inviteLink").text(url);
            let width = $("#qrCode").width();
            new QRCode($("#qrCode").get(0), {
                text: url,
                width: width,
                height: width
            });
        }
    })
})

function getInviteCode() {
    let url = `/users/get_inv_code`;
    return getJSON(url);
}

function getJSON(url) {
    return $.getJSON(url).then(function(data) {
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

function add_new_agent(obj, id) {
    if(confirm('是否确认任命该客户为新代理？'))
    {
        $.get('/agent/add_new_agent/' + id, function(ret) {
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