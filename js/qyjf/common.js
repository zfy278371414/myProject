let _appTitle = '权盈';
let _apiHost = null;
accounting.settings.currency.symbol = '￥';
Template7.registerHelper('formatMoney', accounting.formatMoney);
switch (location.hostname) {
  case "localhost":
    _apiHost = '';
    break;
  case "uat.fintgroup.com":
    _apiHost = '';
    break;
  case "option.fintgroup.com":
    _apiHost = '';
    break;
  case "prod.fintgroup.com":
    _apiHost = '';
    break;
  default:
    _apiHost = 'http://uat.fintgroup.com';
    break;
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

function postJSON(url, data) {
  return $.post(url, { data: data }).then(function(data) {
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

function isLogin() {
  return getJSON(`${_apiHost}/users/need_tel`).then(function(data) {
    var d = $.Deferred();
    if (data == null) d.reject();
    else {
      if (data && data['status'] == false) {
        d.resolve(data);
      } else {
        d.reject(data);
      }
    }
    return d.promise();
  }, function(error) {
    var d = $.Deferred();
    d.reject({ status: false, "msg": "系统繁忙，请稍后重试" });
    return d.promise();
  })
}

function getLoginTimes() {
  var url = `${_apiHost}/users/get_login_times`;
  return getJSON(url);
}

function needUpdateInfo() {
  var url = `${_apiHost}/users/need_update_info`;
  return getJSON(url);
}

function getOrderInfo() {
  var url = `${_apiHost}/users/get_trading_list`;
  return getJSON(url);
}

function sellStock(id) {
  var url = `${_apiHost}/users/sell_fund/${id}`;
  return getJSON(url);
}

function refreshStockPage(){
  app.preloader.show();
  var curValueInPos = Number(0);
  var curProfitInPos = Number(0);
  var totalCurProfitInPos = Number(0);
  
  var totalAmtInPos = Number(0);
  var totalCurProfitClear = Number(0);
  var totalAmtClear = Number(0);
  getOrderInfo().then(function(data) {
    console.log('refresh');
    //$("#tab-2").append('盈亏');
    let msg = data['msg'];
    if (msg != null) {
    msg = JSON.parse(msg);
    }
    console.log('msg:',msg);
    var len = msg.length;
    //console.log(len);
    var stock;
    var stockName = '';
    var stockType2 = "<table width='100%'>"
    +"<tr><th width='25%' class='begin'>标的名称</th>"
    +"<th width='24%' class='begin'>到期日</th>"
    //+"<th width='33%' class='begin'>认购金额</th>"
    +"<th width='25%' class='begin'>当前盈亏<br/>(元)</th>"
    //+"<th width='19%' class='begin'>当前盈亏<br/>(%)</th>"
    +"<th width='25%' class='begin'>认购金额<br/>(元)</th>"
    +"</tr>";
    var stockType3 = "<table width='100%'>"
		+"<tr><th width='25%' class='begin'>标的名称</th>"
		+"<th width='24%' class='begin'>结算日</th>"
		//+"<th width='18%' class='begin'>结算金额</th>"
		+"<th width='25%' class='begin'>实现盈亏<br/>(元)</th>"
		//+"<th width='19%' class='begin'>实现盈亏<br/>(%)</th>
		+"<th width='25%' class='begin'>认购金额<br/>(元)</th>"
		+"</tr>";;
    
    
    for (var i = 0;i<len;i++){
    stock = msg[i];
    status = stock['status'];
    if(status=='通过'){
      curValueInPos = (Math.max(0,(stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']-(stock['right_price']/100-100/100))* (stock['buy_amount']/stock['quotation_price']*100)).toFixed(2);
    curProfitInPos = (Math.max(-stock['quotation_price']/100,(stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']-stock['quotation_price']/100
    - (stock['right_price']/100-100/100))* (stock['buy_amount']/stock['quotation_price']*100));
    console.log(curProfitInPos);
    totalCurProfitInPos +=curProfitInPos;
    totalAmtInPos = totalAmtInPos+Number(stock['buy_amount']);
    stockType2 = stockType2
    +"<tr><td class='inter'>"
    +stock['stock_name']
    +"<i class='icon down-arrow'></i>"
    +"</td>"
    +"<td class='inter'>"
    +stock['deadline'].substring(0,stock['deadline'].indexOf(" "))
    +"</td>"
    //+"<td class='inter'>"
    //+stock['buy_amount']
    //+"</td>"
    +"<td class='inter'>"
    + "<font color='"
    +(curProfitInPos>=0? "red":"green")
    +"'>"
    +curProfitInPos.toFixed(2)
    +"</font>"
    +"</td>"
    +"<td class='inter'>"
    +stock['buy_amount']
    +"</td>"
      //+"<td class='inter'>"
    //+ "<font color='"
    //+(curProfitInPos>=0? "red":"green")
    //+"'>"
    //+(curProfitInPos/stock['buy_amount']*100).toFixed(2)
    //+"%</font>"		
    //+"</td>"
    +"</tr>"
    +"<tr class='subcategory'><td colspan='5' width = '100%'>"
    +"<div class='card stock-card-footer'>"
    +"<div class='card-content'>"
    +"<table width='100%'>"
    +"<tr><td width='30%'><i class='icon stocks-icon-1'></i>标的名称</td>"
    +"<td width='70%'>"
    + stock['stock_name']
    + "&nbsp;"
    + stock['fund_code']
    +"</td></tr><tr><td><i class='icon stocks-icon-1'></i>"
    +"初始价格"
    +"</td><td>"
    + stock['fund_price']
    +"</td></tr><tr><td><i class='icon stocks-icon-1'></i>"
    + "行权价"
    +"</td><td>"
    + stock['right_price']
    +"%"
    +"</td></tr>"
    +"<tr><td><i class='icon stocks-icon-1'></i>买入日期</td>"
    +"<td>"
    +stock['buy_time'].substring(0,stock['buy_time'].indexOf(" "))
    +"</td></tr>"
    +"<tr><td><i class='icon stocks-icon-1'></i>到期日</td><td>"
    + stock['deadline'].substring(0,stock['deadline'].indexOf(" "))
    +"</td></tr>"
    +"<tr><td><i class='icon stocks-icon-1'></i>名义本金</td><td>"
    + (stock['buy_amount']/stock['quotation_price']*100).toFixed(2)
    +"</td></tr>"
    +"<tr><td>"
    +"<i class='icon stocks-icon-1'></i>认购金额"
    +"</td><td>"
    +stock['buy_amount']
    +"</td></tr>"
    +"<tr><td><i class='icon stocks-icon-1'></i>现市值</td>"
      +"<td>"
    +curValueInPos
    +"</td></tr><tr><td><i class='icon stocks-icon-1'></i>现股价</td>"
          +"<td>"
    +stock['buyOnePrice']
    +"</td></tr>"
    +"</table>"
    +"</div>"
    +"<div class='card-footer'><table width='100%'>"
    +"<tr><td width = '95%'>"
    +"当前盈亏: <font color='"
    +(curProfitInPos>=0? "red":"green")
    +"'>"
    + (curProfitInPos/stock['buy_amount']*100).toFixed(2)
    +"%"
    +(curProfitInPos>=0? "↑":"↓")
    +"</font></td><td rowspan='2' style='text-align:right;vertical-align:middle;'>"
    +"<button class='button button-fill "
    //+"color-red"
    +(curProfitInPos>=0? "color-red":"color-green")
    +" open-confirm' style='color:white' onclick=\"confirmSell("
    + stock['id']
    +','+'\''+stock['buy_time'].substring(0,stock['buy_time'].indexOf(" "))+'\''
    +")\">行权</button>"
      +"</td></tr>"
      +"<tr><td width = '95%'>"
      +"股价变动: <font color='"
    +((stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']>0? "red":"green")
    +"'>"
    +((stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']*100).toFixed(2)
    +"% "
    +((stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']>0? "↑":"↓")
    +"</font>"
    +"</td></tr>"
    +"</table>"
    +"</div>"
    +"</div>"
    +"</td></tr>";	
    }
    else if(status=='拒绝赎回'){
    curValueInPos = (Math.max(0,(stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']-(stock['right_price']/100-100/100))* (stock['buy_amount']/stock['quotation_price']*100)).toFixed(2);
    curProfitInPos = (Math.max(-stock['quotation_price']/100,(stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']-stock['quotation_price']/100
    - (stock['right_price']/100-100/100))* (stock['buy_amount']/stock['quotation_price']*100));
    totalCurProfitInPos +=curProfitInPos;
    totalAmtInPos = totalAmtInPos+Number(stock['buy_amount']);
    
    
    
    stockType2 = stockType2
    +"<tr><td class='inter'>"
    +stock['stock_name']
    +"(赎回申请被拒绝)"
    +"<i class='icon down-arrow'></i>"
    +"</td>"
    +"<td class='inter'>"
    +stock['deadline'].substring(0,stock['deadline'].indexOf(" "))
    
    +"</td>"
    //+"<td class='inter'>"
    //+stock['buy_amount']
    //+"</td>"
    +"<td class='inter'>"
    + "<font color='"
    +(curProfitInPos>=0? "red":"green")
    +"'>"
    +curProfitInPos.toFixed(2)
    +"</font>"
    +"</td>"
    +"<td class='inter'>"
    +stock['buy_amount']
    +"</td>"
      //+"<td class='inter'>"
    //+ "<font color='"
    //+(curProfitInPos>=0? "red":"green")
    //+"'>"
    //+(curProfitInPos/stock['buy_amount']*100).toFixed(2)
    //+"%</font>"		
    //+"</td>"
    +"</tr>"
    +"<tr class='subcategory'><td colspan='5' width = '100%'>"
    +"<div class='card stock-card-footer'>"
    +"<div class='card-content'>"
    +"<table width='100%'>"
    +"<tr><td width='30%'><i class='icon stocks-icon-1'></i>标的名称</td>"
    +"<td width='70%'>"
    + stock['stock_name']
    + "&nbsp;"
    + stock['fund_code']
    +"</td></tr><tr><td><i class='icon stocks-icon-1'></i>"
    +"初始价格"
    +"</td><td>"
    + stock['fund_price']
    +"</td></tr><tr><td><i class='icon stocks-icon-1'></i>"
    + "行权价"
    +"</td><td>"
    + stock['right_price']
    +"%"
    +"</td></tr>"
    +"<tr><td><i class='icon stocks-icon-1'></i>买入日期</td>"
    +"<td>"
    +stock['buy_time'].substring(0,stock['buy_time'].indexOf(" "))
    +"</td></tr>"
    +"<tr><td><i class='icon stocks-icon-1'></i>到期日</td><td>"
    + stock['deadline'].substring(0,stock['deadline'].indexOf(" "))
    +"</td></tr>"
    +"<tr><td><i class='icon stocks-icon-1'></i>名义本金</td><td>"
    + (stock['buy_amount']/stock['quotation_price']*100).toFixed(2)
    +"</td></tr>"
    +"<tr><td>"
    +"<i class='icon stocks-icon-1'></i>认购金额"
    +"</td><td>"
    +stock['buy_amount']
    +"</td></tr>"
    +"<tr><td><i class='icon stocks-icon-1'></i>现市值</td>"
      +"<td>"
    +curValueInPos
    +"</td></tr><tr><td><i class='icon stocks-icon-1'></i>现股价</td>"
          +"<td>"
    +stock['buyOnePrice']
    +"</td></tr>"
    +"</table>"
    +"</div>"
    +"<div class='card-footer'><table width='100%'>"
    +"<tr><td width = '95%'>"
    +"当前盈亏: <font color='"
    +(curProfitInPos>=0? "red":"green")
    +"'>"
    + (curProfitInPos/stock['buy_amount']*100).toFixed(2)
    +"%"
    +(curProfitInPos>=0? "↑":"↓")
    +"</font></td><td rowspan='2' style='text-align:right;vertical-align:middle;'>"
    +"<button class='button button-fill "
    //+"color-red"
    +(curProfitInPos>=0? "color-red":"color-green")
    +" open-confirm' style='color:white' onclick=\"confirmSell("
    + stock['id']
    +','+'\''+stock['buy_time'].substring(0,stock['buy_time'].indexOf(" "))+'\''
    +")\">行权</button>"
      +"</td></tr>"
      +"<tr><td width = '95%'>"
      +"股价变动: <font color='"
    +((stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']>0? "red":"green")
    +"'>"
    +((stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']*100).toFixed(2)
    +"% "
    +((stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']>0? "↑":"↓")
    +"</font>"
    +"</td></tr>"
    +"</table>"
    +"</div>"
    +"</div>"
    +"</td></tr>";	
    }
    else if(status=='结算'){
			curValueClear = (Math.max(0,(stock['fund_price2']-stock['fund_price'])/stock['fund_price']-(stock['right_price']/100-100/100) )* (stock['buy_amount']/stock['quotation_price']*100)).toFixed(2);
			curProfitClear = (Math.max(-stock['quotation_price']/100,(stock['fund_price2']-stock['fund_price'])/stock['fund_price']-stock['quotation_price']/100
			- (stock['right_price']/100-100/100))* (stock['buy_amount']/stock['quotation_price']*100));
			totalCurProfitClear +=curProfitClear;;
			totalAmtClear = totalAmtClear+Number(stock['buy_amount']);
			
			
			var currentMkValue = (Math.max(0,(stock['fund_price2']-stock['fund_price'])/stock['fund_price']-(stock['right_price']/100-100/100))* (stock['buy_amount']/stock['quotation_price']*100)).toFixed(2);
			var totalProfit = (Math.max(-stock['quotation_price']/100,(stock['fund_price2']-stock['fund_price'])/stock['fund_price']-stock['quotation_price']/100
			- (stock['right_price']/100-100/100))* (stock['buy_amount']/stock['quotation_price']*100));
			var stockDiff = (stock['fund_price2']-stock['fund_price'])/stock['fund_price'];
			stockType3 = stockType3
			+"<tr><td class='inter'>"
			+stock['stock_name']
			+"&nbsp;"
			+"<i class='icon down-arrow'></i>"
			+"</td>"
			+"<td class='inter'>"
			+stock['sell_time'].substring(0,stock['sell_time'].indexOf(" "))
			+"</td>"
			/*+"<td class='inter'>"
			+stock['buy_amount']
			+"</td>"*/
			+"<td class='inter'>"
			+ "<font color='"
			+(curProfitClear>=0? "red":"green")
			+"'>"
			+curProfitClear.toFixed(2)
			+"</font>"
			+"</td>"
			+"<td class='inter'>"
			+stock['buy_amount']
			+"</td>"
		    /*+"<td class='inter'>"
			+ "<font color='"
			+(curProfitClear>=0? "red":"green")
			+"'>"
			+(curProfitClear/stock['buy_amount']*100).toFixed(2)
			+"%</font>"		
			+"</td>*/
			+"</tr>"
			+"<tr class='subcategory'><td colspan='5' width = '100%'>"
			
			
			+"<div class='card'>"
			+"<div class='card-content'>"
			+"<table width='100%'>"
			+"<tr><td width='30%'><i class='icon stocks-icon-1'></i>标的名称</td><td width='70%'>"
			+ stock['stock_name']
			+ "&nbsp;"
			+ stock['fund_code']
			+"</td></tr><tr><td>"
			+"<i class='icon stocks-icon-1'></i>初始价格"
			+"</td><td>"
			+ accounting.formatNumber(stock['fund_price'],2)
			+"</td></tr><tr><td>"
			+ "<i class='icon stocks-icon-1'></i>行权价"
			+"</td><td>"
			+ "100%"
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>买入日期</td>"
			+"<td>"
			+stock['buy_time'].substring(0,stock['buy_time'].indexOf(" "))
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>到期日</td><td>"
			+ stock['deadline'].substring(0,stock['deadline'].indexOf(" "))
			+"</td></tr>"
			+"</tr><tr><td><i class='icon stocks-icon-1'></i>名义本金</td><td>"
			+ (stock['buy_amount']/stock['quotation_price']*100).toFixed(2)
			+"</td></tr>"
			+"<tr><td>"
			+"</tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>认购金额"
			+"</td><td>"
			+stock['buy_amount']
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>结算时间</td>"
			+"<td>"
			+stock['sell_time']
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>结算价格</td>"
			+"<td>"
			+ accounting.formatNumber(stock['fund_price2'],2)
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>结算市值</td>"
			+"<td>"
			+currentMkValue
			+"</td></tr>"
			+"</table>"
			+"</div>"
			+"<div class='card-footer'><table width='100%'>"
			+"<tr><td width = '70%'>"
			+"结算盈亏: <font color='"
			+(totalProfit>0? "red":"green")
			+"'>"
			+((totalProfit/stock['buy_amount'])*100).toFixed(2)
			+"%"
			+(totalProfit>0? "↑":"↓")
			+"</font></td><td width = '30%' rowspan='2' style='text-align:right;vertical-align:middle;'>"
			+"交易号<br/>"
			+stock['id']
			//+ 10000
		    +"</td></tr>"
		    +"<tr><td>"
		    +"结算股价变动: <font color='"
			+ (stockDiff>=0?"red":"green")
			+"'>"
			+ (stockDiff*100).toFixed(2)
			+"% "
			+(stockDiff>=0?"↑":"↓")
			+"</font>"
			+"</table>"
			+"</div>"
			+"</div>"
			+"</td></tr>";;	
			
			
			
			}

  }
    
  stockType2 = stockType2
  +"<tr><td class='inter' colspan = '2'>"
  +"总盈亏"
  +"</td>"
  //+"<td class='inter'>"
  //+Number(totalAmtInPos)
  //+"</td>"
  +"<td class='inter'>"
  //+totalCurProfitInPos
  + "<font color='"
  +(totalCurProfitInPos>=0? "red":"green")
  +"'>"
  +totalCurProfitInPos.toFixed(2)
  +"</font>"
  +"</td>"
 
  /*+"<td class='inter'>"
  + "<font color='"
  +((totalCurProfitInPos/totalAmtInPos)>=0? "red":"green")
  +"'>"
  +((totalCurProfitInPos/totalAmtInPos)*100).toFixed(2)
  +"%</font>"
  +"</td>"*/
  +"</tr>"
  +"<tr><td colspan='5'>"
  +"<font size='2'><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;***点击个股名称或相应持仓记录可查阅详细记录"
  +"</font>"
  +"</td></tr>"
  +"</table>";
    
  stockType3 = stockType3
  +"<tr><td class='inter' colspan = '2'>"
  +"总盈亏"
  +"</td>"
  /*+"<td class='inter'>"
  +Number(totalAmtClear)
  +"</td>"*/
  +"<td class='inter'>"
  + "<font color='"
  +(totalCurProfitClear>=0? "red":"green")
  +"'>"
  +totalCurProfitClear.toFixed(2)
  +"</font>"
  +"</td>"
  
  /*+"<td class='inter'>"
  + "<font color='"
  +((totalCurProfitClear/totalAmtClear)>=0? "red":"green")
  +"'>"
  +((totalCurProfitClear/totalAmtClear)*100).toFixed(2)
  +"%</font>"
  +"</td>"*/
  +"</tr>"
  +"<tr><td colspan='5'>"
  +"<font size='2'><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;***点击个股名称或相应持仓记录可查阅详细记录"
  +"</font>"
  +"</td></tr>"
  +"</table>"; 
    
    
  $("#tab-2").empty();	
  $("#tab-2").append(stockType2);
  $("#tab-3").empty();	
  $("#tab-3").append(stockType3);
  $("#tab-2").append('<div class="row"><div class="col"></div><div class="col"><a href="#" onclick="refreshStockPage()">刷新最新盈亏</a></div><div class="col"></div></div>');
  $('tr:not(.subcategory)').click(function(){
    
  $(this).nextUntil('tr:not(.subcategory)').toggle()
  });
  app.preloader.hide();
    }, function(error) {
      
    })			
}

function confirmSell(id,buy_time) {
  console.log("test" + this.router);
  
  //格式化时间
  Date.prototype.Format = function(formatStr)   
{   
    var str = formatStr;   
    var Week = ['日','一','二','三','四','五','六'];  
   
    str=str.replace(/yyyy|YYYY/,this.getFullYear());   
    str=str.replace(/yy|YY/,(this.getYear() % 100)>9?(this.getYear() % 100).toString():'0' + (this.getYear() % 100));   
   
    str=str.replace(/MM/,this.getMonth()>9?this.getMonth().toString():'0' + ( Number(this.getMonth())+1).toString() );   
    str=str.replace(/M/g,( Number(this.getMonth())+1).toString());   
   
    str=str.replace(/w|W/g,Week[this.getDay()]);   
   
    str=str.replace(/dd|DD/,this.getDate()>9?this.getDate().toString():'0' + this.getDate());   
    str=str.replace(/d|D/g,this.getDate());   
   
    str=str.replace(/hh|HH/,this.getHours()>9?this.getHours().toString():'0' + this.getHours());   
    str=str.replace(/h|H/g,this.getHours());   
    str=str.replace(/mm/,this.getMinutes()>9?this.getMinutes().toString():'0' + this.getMinutes());   
    str=str.replace(/m/g,this.getMinutes());   
   
    str=str.replace(/ss|SS/,this.getSeconds()>9?this.getSeconds().toString():'0' + this.getSeconds());   
    str=str.replace(/s|S/g,this.getSeconds());   
   
    return str;   
}   
var dateNow = new Date().Format('YYYY-MM-dd');
if(buy_time.indexOf(dateNow)>-1){
  qAlert('当天无法赎回')
  return ;
}

  app.dialog.confirm(
    "请确认行权信息", '权盈',

    function() {

      self.sellStock(id).then(function(data) {
        if (data != null) {
          let status = data['status'];
          let msg = data['msg'];
          if (status === true) {
            qAlert('您的行权申请已经提交');
            //window.location.href = 'new url'; //for external link
            //window.open(''); // the same as target=_blank
            console.log(mainView.router);
            mainView.router.navigate('/tabPage'); // to load internal page
          } else {
            qAlert(msg);
          }
        } else {
          qAlert('您的行权申请已经提交');
        }
      }, function(data) {
        qAlert('您的行权申请已经提交');
      })
    });
}

function sendSMS(phoneNo) {
  var url = `${_apiHost}/users/send_sms_code/${phoneNo}`;
  return getJSON(url).then(function(data) {
    var d = $.Deferred();
    if (data == null) d.reject();
    else {
      if (data && data['status'] == true) {
        d.resolve(data);
      } else {
        d.reject(data);
      }
    }
    return d.promise();
  }, function(error) {
    console.error('sendSMS', 'error', error);
  })
}

function addCapital(value, remark) {
  var url = `${_apiHost}/users/add_capital/${value}/${remark}`;
  return getJSON(url).then(function(data) {
    var d = $.Deferred();
    if (data == null) d.reject();
    else {
      if (data && data['status'] == true) {
        d.resolve(data);
      } else {
        d.reject(data);
      }
    }
    return d.promise();
  }, function(error) {
    console.error('addCapital', 'error', error);
  })
}

function validSMS(phonePin) {
  var url = `${_apiHost}/users/check_tel/${phonePin}`;
  return getJSON(url).then(function(data) {
    var d = $.Deferred();
    if (data == null) d.reject();
    else {
      if (data && data['status'] == true) {
        d.resolve(data);
      } else {
        d.reject(data);
      }
    }
    return d.promise();
  }, function(error) {
    console.error('validSMS', 'error', error);
  })
}

function getPersonInfo() {
  var url = `${_apiHost}/users/amount_info`;
  return getJSON(url);
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

function getBankInfo() {
  var url = `${_apiHost}/users/get_bank_info`;
  return getJSON(url);
}

function qAlert(msg) {
  return app.dialog.alert(msg, _appTitle);
}

function qConfirm(msg1, msg2) {
  return app.dialog.confirm(msg1, _appTitle, function() {
    app.dialog.alert(msg2, _appTitle);
  });
}

function getPayRecord() {
  return getPersonInfo().then(function(data) {
    var d = $.Deferred();
    let msg = data['msg'];
    if (msg != null) {
      msg = JSON.parse(msg);
    }
    let amount_list = msg['amount_list'];
    if (amount_list == null || amount_list.length == 0) {
      d.reject();
    } else {
      d.resolve(amount_list);
    }
    return d.promise();
  });
}

function getRechargeRec() {
  return getPayRecord().then(function(data) {
    let d = $.Deferred();
    if (data != null && data.length > 0) {
      let newData = $.grep(data, function(v, i) {
        let amount = v['amount'];
        let status = v['status']
        switch (status) {
          case "undone":
            v['status'] = '待确认';
            break;
          case "done":
            v['status'] = '充值成功';
            break;
          default:
            break;
        }
        return parseInt(amount, 10) > 0;
      });
      d.resolve(newData);
    } else {
      d.reject();
    }
    return d.promise();
  });
}

function getReflectRec() {
  return getPayRecord().then(function(data) {
    let d = $.Deferred();
    if (data != null && data.length > 0) {
      let newData = $.grep(data, function(v, i) {
        let amount = v['amount'];
        let status = v['status'];
        amount = parseInt(amount, 10);
        v['amount'] = v['amount'].replace('-', '');
        switch (status) {
          case "undone":
            v['status'] = '待确认';
            break;
          case "done":
            v['status'] = '已确认';
            break;
          default:
            break;
        }
        return amount < 0;
      });
      d.resolve(newData);
    } else {
      d.reject();
    }
    return d.promise();
  });
}

function tabIndexAsyncRoute(routeTo, routeFrom, resolve, reject) {
  var router = this;
  var app = router.app;
  app.preloader.show();
  let ctx = {
    userName: "",
    totalMarketValue: "--",
    hasLastLoginInfo: false,
    lastIp: "--",
    lastTime: '--',
    lastChannel: "--",
    photoSrc: '/img/qyjf/testphoto.png'
  };
  let routeInfo = { componentUrl: routeTo.route.tab.componentUrlAlias };
  let customSpec = {
    context: ctx
  }
  $.when(fetchTotalMarketValue(), fetchAccountInfo(), fetchWechatPhoto())
    .done(function(data) {
      let userInfo = app.data.userInfo;
      let accountInfo = app.data.accountInfo;
      let loginInfo = app.data.loginInfo;
      let marketAccountInfo = app.data.marketAccountInfo;
      if (userInfo != null) {
        ctx['userName'] = userInfo['name'] || userInfo['nick'];
      }
      if (marketAccountInfo != null) {
        let total = marketAccountInfo['total'];
        ctx['totalMarketValue'] = accounting.formatMoney(total);
      }
      if (loginInfo != null && loginInfo.length > 0) {
        let lastLoign = loginInfo[0];
        ctx['hasLastLoginInfo'] = true;
        ctx['lastIp'] = lastLoign['ip'];
        let symbol = ctx['lastIp'].indexOf('&');
        if (symbol != -1) {
          ctx['lastIp'] = ctx['lastIp'].substring(0, symbol);
        }
        ctx['lastTime'] = lastLoign['created'];
        ctx['lastChannel'] = lastLoign['msg'];
      }
      if (app.data.wechatPhoto != null) {
        ctx['photoSrc'] = app.data.wechatPhoto;
      }
    })
    .always(function() {
      resolve(routeInfo, customSpec);
      app.preloader.hide();
    })
}

function tabAccountAsyncRoute(routeTo, routeFrom, resolve, reject) {
  var router = this;
  var app = router.app;
  app.preloader.show();
  let ctx = {
    money: "--",
    hasBankCard: false,
    showIdCardFunc: true
  };
  let routeInfo = { componentUrl: routeTo.route.tab.componentUrlAlias };
  let customSpec = {
    context: ctx
  }
  $.when(fetchBankInfo(), fetchAccountInfo())
    .done(function(data) {
      let accountInfo = app.data.accountInfo;
      let bankInfo = app.data.bankInfo;
      let userInfo = app.data.userInfo;
      if (accountInfo != null) {
        ctx['money'] = accounting.formatMoney(accountInfo['total']);
      }
      if (bankInfo != null && bankInfo.length > 0) {
        ctx['hasBankCard'] = true;
      }
      if (userInfo['status'] === "2") {
        ctx['showIdCardFunc'] = false;
      }
    })
    .always(function() {
      resolve(routeInfo, customSpec);
      app.preloader.hide();
    })
}

function tabTradeAsyncRoute(routeTo, routeFrom, resolve, reject) {
  var router = this;
  var app = router.app;
  app.preloader.show();
  let ctx = {
    isTradeTime: false,
    money: "--",
    quotationList: []
  };
  let routeInfo = { componentUrl: routeTo.route.tab.componentUrlAlias };
  let customSpec = {
    context: ctx
  }
  let fetchAry = [fetchAccountInfo()];
  if (app.data.quotationList == null) fetchAry.push(fetchQuotations());
  $.when.apply(null, fetchAry)
    .done(function(data) {
      let quotationList = app.data.quotationList;
      let accountInfo = app.data.accountInfo;
      if (quotationList != null) {
        ctx['quotationList'] = quotationList;
      }
      if (accountInfo != null) {
        ctx['money'] = accounting.formatMoney(accountInfo['total']);
      }
    })
    .always(function() {
      isServiceTime().then(function() {
          ctx['isTradeTime'] = true;
        }, function() {
          ctx['isTradeTime'] = false;
        })
        .always(function() {
          resolve(routeInfo, customSpec);
          app.preloader.hide();
        })
    })
}

function rechargeAsyncRoute(routeTo, routeFrom, resolve, reject) {
  var router = this;
  var app = router.app;
  //check idCard
  if (isIdCardConfirming()) {
    reject();
    qAlert('实名认证审核中');
    return;
  }
  if (!isIdCardConfirm()) {
    reject();
    qAlert('您尚未进行实名认证，请先进行认证。').on('close', function() {
      router.navigate('/idConfirm', { history: false });
    })
    return;
  }
  app.preloader.show();
  let ctx = {
    hasRechargeRec: false,
    rechargeRec: []
  };
  let routeInfo = { componentUrl: routeTo.route.componentUrlAlias };
  let customSpec = {
    context: ctx
  }
  let rechargeList = app.data.rechargeList;
  ctx['hasRechargeRec'] = (rechargeList != null && rechargeList.length > 0);
  ctx['rechargeRec'] = rechargeList;
  resolve(routeInfo, customSpec);
  app.preloader.hide();
}

function reflectAsyncRoute(routeTo, routeFrom, resolve, reject) {
  var router = this;
  let app = router.app;
  //check idCard
  if (isIdCardConfirming()) {
    reject();
    qAlert('实名认证审核中');
    return;
  }
  if (!isIdCardConfirm()) {
    reject();
    qAlert('您尚未进行实名认证，请先进行认证。').on('close', function() {
      router.navigate('/idConfirm', { history: false });
    })
    return;
  }
  //check bankCard
  if (app.data.bankInfo == null || app.data.bankInfo.length == 0) {
    reject();
    qAlert('您尚未绑定银行卡，请先进行绑定。').on('close', function() {
      router.navigate('/addBankInfo', { history: false });
    })
    return;
  }
  app.preloader.show();
  let ctx = {
    hasRechargeRec: false,
    hasBankCard: false,
    bankCard: {},
    rechargeRec: []
  };
  let routeInfo = { componentUrl: routeTo.route.componentUrlAlias };
  let customSpec = {
    context: ctx
  }
  let reflectList = app.data.reflectList;
  let bankInfo = app.data.bankInfo;
  ctx['hasRechargeRec'] = (reflectList != null && reflectList.length > 0);
  ctx['rechargeRec'] = reflectList;
  if (bankInfo != null && bankInfo.length > 0) {
    ctx['hasBankCard'] = true;
    ctx['bankCard'] = bankInfo[bankInfo.length - 1]['Bank'];
  }
  resolve(routeInfo, customSpec);
  app.preloader.hide();
}

function addBankInfoAsyncRoute(routeTo, routeFrom, resolve, reject) {
  var router = this;
  var app = router.app;
  //check idCard
  if (isIdCardConfirming()) {
    reject();
    qAlert('实名认证审核中');
    return;
  }
  if (!isIdCardConfirm()) {
    reject();
    qAlert('您尚未进行实名认证，请先进行认证。').on('close', function() {
      router.navigate('/idConfirm', { history: false });
    })
    return;
  }
  app.preloader.show();
  let ctx = {
    money: "--",
    hasIdCard: false,
    hasBankCard: false,
    hasBankAccountName: false,
    name: '',
    idCard: "",
    bankCard: {}
  };
  let routeInfo = { componentUrl: routeTo.route.componentUrlAlias };
  let customSpec = {
    context: ctx
  }
  let bankInfo = app.data.bankInfo;
  let userInfo = app.data.userInfo;
  let accountInfo = app.data.accountInfo;
  if (bankInfo != null && bankInfo.length > 0) {
    ctx['hasBankCard'] = true;
    ctx['bankCard'] = bankInfo[bankInfo.length - 1]['Bank'];
  }
  if (userInfo != null) {
    if (userInfo['personal_code'] != null) {
      ctx['hasIdCard'] = true;
      ctx['idCard'] = userInfo['personal_code'];
      if (userInfo['name'] != null && $.trim(userInfo['name'] !== "")) {
        ctx['hasBankAccountName'] = true;
        ctx['name'] = userInfo['name'];
      }
    }
  }
  if (accountInfo != null) {
    ctx['money'] = accounting.formatMoney(accountInfo['total']);
  }
  resolve(routeInfo, customSpec);
  app.preloader.hide();
}

function idConfirmAsyncRoute(routeTo, routeFrom, resolve, reject) {
  var router = this;
  var app = router.app;
  //check idCard
  if (isIdCardConfirming()) {
    reject();
    qAlert('实名认证审核中');
    return;
  }
  app.preloader.show();
  let ctx = {
    name: ''
  };
  let routeInfo = { componentUrl: routeTo.route.componentUrlAlias };
  let customSpec = {
    context: ctx
  }
  let userInfo = app.data.userInfo;
  if (userInfo != null && $.trim(userInfo['name']) !== "") {
    ctx['name'] = userInfo['name'];
  }
  resolve(routeInfo, customSpec);
  app.preloader.hide();
}

function inviteCodeAsyncRoute(routeTo, routeFrom, resolve, reject) {
  var router = this;
  var app = router.app;
  //check idCard
  if (isIdCardConfirming()) {
    reject();
    qAlert('实名认证审核中');
    return;
  }
  if (!isIdCardConfirm()) {
    reject();
    qAlert('您尚未进行实名认证，请先进行认证。').on('close', function() {
      router.navigate('/idConfirm', { history: false });
    })
    return;
  }

  app.preloader.show();
  let ctx = {
    inviteCode:"---",
    inviteLink: location.origin,
  };
  let routeInfo = { componentUrl: routeTo.route.componentUrlAlias };
  let customSpec = {
    context: ctx
  }
  if (app.data.inviteCode == null) {
    $.when(fetchInviteCode())
      .done(function() {
        ctx['inviteCode'] = app.data.inviteCode;
        ctx['inviteLink'] = `${location.origin}?inviteCode=${app.data.inviteCode}`;
      })
      .always(function() {
        resolve(routeInfo, customSpec);
        app.preloader.hide();
      })
  } else {
    ctx['inviteCode'] = app.data.inviteCode;
    ctx['inviteLink'] = `${location.origin}?inviteCode=${app.data.inviteCode}`;
    resolve(routeInfo, customSpec);
    app.preloader.hide();
  }
}

function tradeDetailAsyncRoute(routeTo, routeFrom, resolve, reject) {
  var router = this;
  var app = router.app;
  app.preloader.show();
  let ctx = {
    code: "----",
    detailAry: [],
    currentStock: null,
    price: '----',
    money: '----'
  };
  ctx['code'] = routeTo['params']['code'];
  ctx['detailAry'] = app.data.quotationList[ctx['code']];
  ctx['currentStock'] = ctx['detailAry'][0];
  let routeInfo = { componentUrl: routeTo.route.componentUrlAlias };
  let customSpec = {
    context: ctx
  }
  let accountInfo = app.data.accountInfo;
  if (accountInfo != null) {
    ctx['money'] = accounting.formatMoney(accountInfo['total']);
  }
  stockQuote(ctx['code'])
    .done(function(data) {
      let status = data['status'];
      let msg = JSON.parse(data['msg']);
      if (status === true) {
        ctx['price'] = msg['buyOnePri'];
      }
    })
    .always(function(arguments) {
      resolve(routeInfo, customSpec);
      app.preloader.hide();
    })
}

function stockQuote(code) {
  let url = `${_apiHost}/app/get_detail_by_code/${code}`;
  return getJSON(url);
}

function fetchInviteCode() {
  let d = $.Deferred();
  getInviteCode().then(function(data) {
      let msg = data['msg'];
      if (msg != null) {
        app.data.inviteCode = data['msg'];
      }
    })
    .always(d.resolve)
  return d.promise();
}

function getInviteCode() {
  let url = `${_apiHost}/users/get_inv_code`;
  return getJSON(url);
}

function setActiveTabLink(index) {
  let _index = index || 0;
  $('.view-main .main-tab-link')
    .removeClass('tab-link-active')
    .eq(_index)
    .addClass('tab-link-active');
}

function fetchAccountInfo() {
  return getPersonInfo().then(function(data) {
    let d = $.Deferred();
    let msg = data['msg'];
    try {
      if (msg != null) {
        msg = JSON.parse(msg);
        app.data.userInfo = msg['user_info'];
        app.data.loginInfo = msg['logs'];
        app.data.accountInfo = msg['amount'];
        let amountList = msg['amount_list'];
        if (amountList != null && amountList.length > 0) {
          amountList = amountList.reverse();
          let amountList1 = _.cloneDeep(amountList);
          let amountList2 = _.cloneDeep(amountList);
          app.data.reflectList = $.grep(amountList1, function(v, i) {
            let amount = v['amount'];
            let status = v['status'];
            amount = parseInt(amount, 10);
            if (amount < 0) {
              v['amount'] = v['amount'].replace('-', '');
              switch (status) {
                case "undone":
                  v['statusLabel'] = '待确认';
                  break;
                case "done":
                  v['statusLabel'] = '提现成功';
                  break;
                case "reject":
                  v['statusLabel'] = '提现失败';
                  break;
                default:
                  v['statusLabel'] = v['status'];
                  break;
              }
            }
            if (v['remark'] == null) {
              v['remark'] = '----';
            }
            return amount < 0;
          });
          app.data.rechargeList = $.grep(amountList2, function(v, i) {
            let amount = v['amount'];
            let status = v['status'];
            amount = parseInt(amount, 10);
            if (amount > 0) {
              switch (status) {
                case "undone":
                  v['statusLabel'] = '待确认';
                  break;
                case "done":
                  v['statusLabel'] = '充值成功';
                  break;
                case "reject":
                  v['statusLabel'] = '充值失败';
                  break;
                case "withdraw_done":
                  v['statusLabel'] = '代理提现成功';
                  break;
                case "withdraw_reject":
                  v['statusLabel'] = '代理提现失败';
                  break;
                case "withdraw_undone":
                  v['statusLabel'] = '代理提现审批中';
                  break;
                default:
                  v['statusLabel'] = v['status'];
                  break;
              }
            }
            if (v['remark'] == null) {
              v['remark'] = '----';
            }
            return amount > 0;
          });
        }
      }
    } catch (e) {
      console.error('===fetchAccountInfo===', e);
    } finally {
      d.resolve();
    }
    return d.promise();
  }, function(error) {
    console.error('fali', error);
  })
}

function fetchBankInfo() {
  let d = $.Deferred();
  getBankInfo().then(function(data) {
      let msg = data['msg'];
      if (msg != null) {
        app.data.bankInfo = data['msg'];
      }
    })
    .always(d.resolve)
  return d.promise();
}

function fetchTotalMarketValue() {
  let d = $.Deferred();
  getJSON(`${_apiHost}/users/get_total_market_value`).then(function(data) {
      let msg = data['msg'];
      if (msg != null) {
        app.data.marketAccountInfo = msg;
      }
    })
    .always(d.resolve)
  return d.promise();
}

function fetchQuotations() {
  let d = $.Deferred();
  getJSON(`${_apiHost}/users/get_quotations`).then(function(data) {
      let msg = data['msg'];
      if (msg != null) {
        app.data.quotationList = data['msg'];
      }
    })
    .always(d.resolve)
  return d.promise();
}

function isIdCardConfirm() {
  let isConfirm = false;
  if (app.data != null && app.data.userInfo != null) {
    let status = app.data.userInfo['status'];
    isConfirm = (status === "2");
  }
  return isConfirm;
}

function isIdCardConfirming() {
  let isConfirm = false;
  if (app.data != null && app.data.userInfo != null) {
    let status = app.data.userInfo['status'];
    isConfirm = (status === "1");
  }
  return isConfirm;
}

function loadingWrap(promise) {
  if (promise && promise.then) {
    app.preloader.show();
    promise.always(function() {
      app.preloader.hide();
    })
  }
  return promise;
}

function fetchWechatPhoto() {
  let d = $.Deferred();
  if (app.data.wechatPhoto != null) {
    d.resolve();
  } else {
    getJSON(`${_apiHost}/users/get_wechat_photo`).then(function(data) {
        let status = data['status'];
        if (status === true) {
          let msg = data['msg'];
          if (msg != null) {
            app.data.wechatPhoto = data['msg'];
          }
        }

      })
      .always(d.resolve)
  }
  return d.promise();
}

function isServiceTime() {
  let url = `${_apiHost}/users/trading_time`;
  return getJSON(url).then(function(data) {
    let d = $.Deferred();
    if (data != null && data['status'] === true) {
      let msg = data['msg'];
      if (msg === true) {
        d.resolve();
      } else {
        d.reject();
      }
    } else {
      d.reject();
    }
    return d.promise();
  })
}
