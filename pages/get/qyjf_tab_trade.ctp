<template>
  <div data-page="tradeTab" class="page">
    <div class="page-content">
      <div class="searchbar-backdrop"></div>
      <div class="searchbar">
        <div class="searchbar-inner">
          <div class="searchbar-input-wrap">
            <input type="search" placeholder="请搜索股票，如000001.SZ或平安银行">
            <i class="searchbar-icon"></i>
            <span class="input-clear-button"></span>
          </div>
          <!-- <span class="searchbar-disable-button">取消</span> -->
        </div>
      </div>
      <div class="block searchbar-not-found">
        <div class="block-inner">未找到</div>
      </div>
      <div class="list searchbar-found search-advice" style="display: none;margin-top: 0;">
        <ul>
          {{#each quotationList}}
          <li class="item-content">
            <div class="item-inner">
              <div class="item-title" @click="showoptiondetail" data-price="{{this[0].price}}" data-id="{{this[0].id}}" data-code='{{@key}}' data-step="{{this[0].step}}">{{this[0].name}} ({{this[0].code}})</div>
            </div>
          </li>
          {{/each}}
        </ul>
      </div>
      <div class="showWhenHasStock" style="display: none;">
        <div class="block" style="margin: 12px 0;">
          <div class="row">
            <div class1="col-50">
              <strong><span class="stock-name">--</span> <span class="stock-price">--</span> (<span class="percentChange">--</span>)</strong>
            </div>
          </div>
        </div>
        <div id="detailBlock">
        </div>
        <div class="block" style="margin: 10px;">
          <div id="price-filter" class="range-slider range-slider-init color-green" data-label="true" data-min="1000" data-max="80000" data-step="500"></div>
        </div>
        <!-- <div class="block">
          <div class="list">
            <ul>
              <li class="item-content item-input">
                <div class="item-inner">
                  <div class="item-title item-label">认购金额</div>
                  <div class="item-input-wrap">
                    <input type="number" name="inputMoney" id="inputMoney" @keyup=inputMoneyHandle>
                    <span class="input-clear-button"></span>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div> -->
        <div class="block" style="margin: 12px 0;">
          <!-- <div class="row">
            <div class1="col-50">
              股票价格: &nbsp <strong><span class="stock-price">--</span></strong>
            </div>
          </div> -->
          <div class="row">
            <div class1="col-50">
              <i class='icon stocks-icon-1 popover-open' data-popover=".popover-purchaseamount"></i>认购金额: &nbsp <strong><span class="price-value">--</span></strong>
            </div>
          </div>
          <div class="row">
            <div class1="col-50">
              <i class='icon stocks-icon-1 popover-open' data-popover=".popover-bookvalue"></i>名义本金: &nbsp <span class="book-value">--</span>
            </div>
          </div>
          <div class="row">
            <div class1="col-50">
              <i class='icon stocks-icon-1 popover-open' data-popover=".popover-tradetype"></i>成交方式：
              <input type="radio" name="ordertype" checked="checked"> 市价成交
            </div>
          </div>
          <div class="row">
            <div class1="col-50">
              <i class='icon stocks-icon-1 popover-open' data-popover=".popover-rightType"></i>期权类型：
              <input type="radio" name="optiontype" checked="checked"> 美式期权
            </div>
          </div>
        </div>
        <div class="block" style="margin: 12px 0;">
          <div class="row">
            <a href="#" class="col button button-fill" @click="confirm_order">
            {{#if isTradeTime}}
            认购
            {{else}}
            预约认购
            {{/if}}
            </a>
            <a class="col button popup-open1" @click=showCalc href="#" data-popup1=".popup-about">收益测算</a>
          </div>
          <div class="popup popup-about">
            <div class="block">
              <p><a class="link popup-close" href="#">返回</a></p>
              <!-- <h4>收益测算</h4> -->
              <div class="row">
                <div class1="col-50">
                  购买金额: &nbsp <strong><span class="price-value">$1000</span></strong>
                  <br>
                </div>
              </div>
              <div class="card data-table" id="ratetable">
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="block">
          <div class="col-sm-3"></div>
          <div class="col-sm-3"><a class="link popover-open" href="#" data-popover=".popover-about">实例说明和交易须知</a></div>
          <div class="col-sm-3"></div>
          <div class="col-sm-3"></div>
          <div class="popover popover-about">
            <div class="popover-inner">
              <div class="block">
                <p>实例说明和交易须知</p>
                <p>如平安银行期权费为3%，投资者于周日认购10万名义本金并投资3000元作为期权费（3%乘以100000），行权价为100%，期限为一周，星期一首个交易日开盘价为10元。如周五收盘平安银行收盘价为12元（即涨幅20%），投资者回报为100000*20% - 3000 = 17000元，相当于本金翻了6.7倍；如周五平安银行收盘价为8元（即跌幅20%），投资者最大亏损为3000元期权费投入。
                </p>
              </div>
            </div>
          </div>
        </div> -->
      </div>
      <div id="all-popover">
        <div class="popover popover-rightPrice">
          <div class="popover-inner">
            <div class="block">
              <p>行权价</p>
              <p>
                客户可行权价格（例：如平安银行首个交易日开盘价为10元，行权价100%，到期日结算时，如平安银行涨了10%到11元，客户仍可用10元买入平安银行）
              </p>
            </div>
          </div>
        </div>
        <div class="popover popover-code">
          <div class="popover-inner">
            <div class="block">
              <p>标的代码</p>
              <p>
                沪深股票代码（例：000001.SZ，平安银行）
              </p>
            </div>
          </div>
        </div>
        <div class="popover popover-deadline">
          <div class="popover-inner">
            <div class="block">
              <p>期限
              </p>
              <p>
                期权有限期限（例，一周：期权可于一周后行使）
              </p>
            </div>
          </div>
        </div>
        <div class="popover popover-rightType">
          <div class="popover-inner">
            <div class="block">
              <p>期权类型
              </p>
              <p>
                美式期权：买方在到期日前可以行使权力
              </p>
              <p>欧式期权：买方在到期日前不可行使权力</p>
            </div>
          </div>
        </div>
        <div class="popover popover-optionPrice">
          <div class="popover-inner">
            <div class="block">
              <p>期权价格
              </p>
              <p>
                购买期权价格，如某股票期权价格为3%，首个交易日开盘价为10元，即购买10万本金股票的期权费为3000元
              </p>
            </div>
          </div>
        </div>
        <div class="popover popover-invalidDate">
          <div class="popover-inner">
            <div class="block">
              <p>期权报价有效期至
              </p>
              <p>
                此期权价格有效期，即在此日期前皆可以此价格购买
              </p>
            </div>
          </div>
        </div>
        <div class="popover popover-bookvalue">
          <div class="popover-inner">
            <div class="block">
              <p>名义本金</p>
              <p>
                您所认购的期权费对应的名义本金
              </p>
            </div>
          </div>
        </div>
        <div class="popover popover-purchaseamount">
          <div class="popover-inner">
            <div class="block">
              <p>认购金额
              </p>
              <p>
                您所认购的期权费 </p>
            </div>
          </div>
        </div>
        <div class="popover popover-tradetype">
          <div class="popover-inner">
            <div class="block">
              <p>成交方式
              </p>
              <p>市价成交：市价成交是指不限定价格的、按照当时市场上可执行的最优报价成交的成交方式
              </p>
              <p>限价成交：限价成交是指定一个价格，当市场价格低于这个价格时买进；或者指定一个价格，当市场价格高于这个价格时卖出。特点是可以按客户的预期价格成交，成交速度相对较慢，有时无法成交。限价指令以价格优先，时间优先的原则排序。</p>
            </div>
          </div>
        </div>
        <div class="popover popover-optionratio">
          <div class="popover-inner">
            <div class="block">
              <p>期权费率
              </p>
              <p>
                期权费（例，如期权费率为5%，即代表购买100万名义本金的对应股票，需要交付5万元的期权费） </p>
            </div>
          </div>
        </div>
      </div>
      <div class="block" style="margin: 12px 0;">
        <div class="text-align-center">
          当前可用余额：{{money}}
        </div>
        <div class="text-align-left">
          <h4>交易须知</h4>
          <ol>
            <li>首个交易日为下单确认时的交易日，到期日为订单确认日 + 周期日</li>
            <li>首个交易日不可为节假日</li>
            <li>首个交易日开盘期权对应股票出现涨跌幅超过9%或停牌情况，交易可能会被拒绝</li>
            <li>到期日涨跌幅计算方式为：到期日收盘价除以初始股票价格</li>
            <li>到期日期权对应股票停牌或者涨跌停，照常结算</li>
            <li>到期日若为假期，按照到期日前最后一个交易日收盘价结算</li>
          </ol>
          <h4>股票限制：</h4>
          <ol>
            <li>不可为ST股票</li>
            <li>前一个交易日涨跌停的股票不能购买</li>
            <li>上市未满三个月的股票不能购买</li>
            <li>复牌不超过5天的股票不能购买</li>
          </ol>
        </div>
      </div>
      <div id="confirmBook" style="display: none;">
        <div>
          <div class="block-title">股票收益互换交易确认书</div>
          <div class="block text-align-left">
            <div class="data-table">
              <table>
                <tbody>
                  <tr>
                    <td style="padding:0px;width:80px;">期权类型</td>
                    <td style="padding:0px;">美式认购期权</td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">标的证券（代码）</td>
                    <td style="padding:0px;">标的证券（代码） 当前股票，标的资产代码：当前股票代码</td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">交易达成日</td>
                    <td style="padding:0px;">订单确认日</td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">合约起始日</td>
                    <td style="padding:0px;">订单确认日</td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">合约到期日</td>
                    <td style="padding:0px;">订单确认日+周期日</td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">合约终止日</td>
                    <td style="padding:0px;">若期权合约行权，则为行权日；若未行权，则为合约到期日</td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">行权期</td>
                    <td style="padding:0px;">
                      <p>从合约起始日（不含）起至合约到期日（含）的交易日和营业日的共同日的标的交易时段。</p>
                      <p>期权买入（T日）之后第【T+1】个交易日（含）之后才能提出赎回申请</p>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">结算金额支付日</td>
                    <td style="padding:0px;">合约终止日后【2】个营业日内</td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">交易货币</td>
                    <td style="padding:0px;">人民币</td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">结算货币</td>
                    <td style="padding:0px;">人民币</td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">期初价格（以交易货币计价）</td>
                    <td style="padding:0px;">市价交易以反馈价格为准；限价交易即所限价格</td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">行权价格（以交易货币计价）</td>
                    <td style="padding:0px;">以行权价为准</td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">到期结算价格（以交易货币计价） 以行权价为准</td>
                    <td style="padding:0px;">以行权价为准</td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">行权结算价格（以交易货币计价）</td>
                    <td style="padding:0px;">以行权价为准</td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">合约名义本金额（以交易货币计价）</td>
                    <td style="padding:0px;">名义本金</td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">期权费（以交易货币计价）</td>
                    <td style="padding:0px;">认购期权金</td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">收益结算金额（以交易货币计价）</td>
                    <td style="padding:0px;">
                      <p>期权合约发生行权的，收益结算金额根据如下公式计算：</p>
                      <p>每份合约的期权合约结算金额 = 合约名义本金额 *（行权价格 – 期初价格）/ 期初价格。</p>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:0px;width:80px;">甲方有权提前终止期权交易的情形</td>
                    <td style="padding:0px;">
                      <ol>
                        <li>交易所对标的证券、构成标的证券的任一股票或股票指数有价格涨跌幅限制的，若其连续【3】个交易日收盘价格达到所规定的当日涨停价格时，甲方有权提前终止期权交易，并将上述第【3】个交易日作为该笔期权合约的到期日，以该日收盘价格作为到期结算价格，与乙方进行收益结算。</li>
                        <li>交易所对标的证券、构成标的证券的任一股票或股票指数无价格涨跌幅限制的，若本交易确认书下某一笔交易对应的标的证券、构成标的证券的任一股票或指数收盘价格单日涨幅超过【30】%，甲方有权提前终止该笔交易，并将该日作为该笔期权合约的到期日，以该日其的收盘价格作为结算价格与乙方进行收益结算。</li>
                      </ol>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="block-title">风险揭示书</div>
          <div class="block text-align-left">
            <p>尊敬的投资者</p>
            <p>投资有风险，在您/贵司争取获得投资收益的同时也面临着承担投资风险。您/贵司在做出投资决策之前，请仔细阅读本风险揭示书，充分认识投资风险，认真考虑各项风险因素，并充分考虑自身的风险承受能力，理性判断并谨慎做出投资决策。</p>
            <p>在决定进行股票期权交易之前，您应当充分了解以下事项：</p>
            <ol>
              <li>请您充分理解股票期权客户应当具备的经济能力、专业知识和投资经验，全面评估自身的经济承受能力、投资经历、产品认知能力、风险控制能力、身体及心理承受能力（仅对自然人客户而言）等，审慎决定是否参与股票期权业务。</li>
              <li>请您了解应当了解期权的基础知识、相关法律、法规、规章、上海证券交易所（以下简称“交易所”）业务规则和各类公告信息、中国证券登记结算有限责任公司（以下简称“中国结算”）业务规则和各类公告信息以及期权经营机构的相关法律文件。</li>
              <li>请您充分了解股票期权业务的风险特点。股票期权不同于股票交易业务，是具有杠杆性、跨期性、联动性、高风险性等特征的金融衍生工具。股票期权业务采用保证金交易方式，潜在损失可能成倍放大，损失的总额可能超过全部保证金。</li>
              <li>股票期权业务实行客户适当性管理制度，客户应当满足中国证监会、证券交易所及证券公司关于客户适当性标准的规定。客户适当性制度对客户的各项要求以及依据制度规定对客户的综合评价结果，不构成对客户的投资建议，也不构成对客户的获利保证。您应根据自身判断做出投资决定，不得以不符合适当性标准为由拒绝承担股票期权交易结果。</li>
              <li>请您知晓，参与机构对个人客户参与期权交易的权限进行分级管理。个人客户开立衍生品合约账户后，其期权交易权限将根据分级结果确定。期权经营机构可以根据相关规定自行调低个人客户的交易权限级别，个人客户只能根据调整后的交易权限参与期权交易。</li>
              <li>请您知晓，在与公司的合同关系存续期间，如提供给公司的身份证明文件过期、身份信息发生变更的，应及时向公司提供新的相关材料。否则，公司有权拒绝客户开仓和出金指令，并有权进一步限制客户的交易权限。客户在开户时提供的其他信息发生变更时，也应及时向公司更新。如因客户未能及时提供更新信息而导致的后果、风险和损失由客户承担。</li>
              <li>期权合约标的由交易所根据相关规则选择，并非由合约标的发行人自行决定。交易所及合约标的发行人对期权合约的上市、挂牌、合约条款以及期权市场表现不承担任何责任。期权的买方在行权交收前不享有作为合约标的持有人应当享有的权利。</li>
              <li>在进行股票期权买入交易时，可选择将股票期权合约平仓、持有至到期行权或者任由期权合约到期但不行权；客户选择持有期权至到期行权的，应当确保其相应账户内有行权所需的足额合约标的或者资金。</li>
              <li>卖出股票期权交易的风险一般高于买入股票期权交易的风险。卖方虽然能获得权利金，但也因承担行权履约义务而面临由于合约标的价格波动，可能承受远高于该笔权利金的损失。</li>
              <li>在进行股票期权交易时，应关注合约标的价格波动、期权价格波动及其他市场风险及其可能造成的损失，包括但不限于以下情形：由于期权标的价格波动导致期权不具行权价值，期权买方将损失付出的所有权利金；期权卖方由于需承担行权履约义务，因合约标的价格波动导致的损失可能远大于其收取的权利金。</li>
              <li>您应当关注期权的涨跌幅限制，期权的涨跌幅限制的计算方式与现货涨跌幅计算方式不同，您应当关注期权合约的每日涨跌停价格。</li>
              <li>在进行股票期权交易时，请您关注当合约标的发生分红、派息、送股、公积金转增股本、配股、份额拆分或者合并等情况时，会对合约标的进行除权除息处理，交易所将对尚未到期的期权合约的合约单位、行权价格进行调整，合约的交易与结算事宜将按照调整后的合约条款进行。</li>
              <li>请您关注期权合约存续期间，合约标的停牌的，对应期权合约交易也停牌；当期权交易出现异常波动或者涉嫌违法违规等情形时，交易所可能对期权合约进行停牌。</li>
              <li>请您在进行股票期权交易时，应当严格遵守交易所相关业务规则、市场公告中有关限仓、限购、限开仓的规定，并在交易所要求时，在规定时间内及时报告。客户的持仓量超过规定限额的，将导致其面临被限制卖出开仓、买入开仓以及强行平仓的风险。</li>
              <li>请您关注期权合约可能难以或无法平仓的风险及其可能造成的损失，当市场交易量不足或者连续出现单边涨跌停价格时，期权合约持有者可能无法在市场上找到平仓机会。</li>
              <li>请您关注组合策略持仓不参加每日日终的持仓自动对冲，组合策略持仓存续期间，如遇1个以上成分合约已达到交易所及中国结算规定的自动解除触发日期，该组合策略于当日日终自动解除。除交易所规定的组合策略类型之外，客户不得对组合策略对应的成分合约持仓进行单边平仓</li>
              <li>请您知悉交易所以结算参与人为单位，对结算参与人负责结算的衍生品合约账户的卖出开仓、买入开仓等申报进行前端控制。无论客户的保证金是否足额，如果结算参与人日间保证金余额小于卖出开仓申报对应的开仓保证金额度或者买入开仓申报对应的权利金额度的，相应卖出开仓或者买入开仓申报无效。</li>
              <li>请您知悉如使用合约标的除权、除息情形下因送股、转增等公司行为形成的无限售流通股作为备兑证券，如行权结算时尚未上市的，将不可用于行权交割，不足部分您须及时补足，否则将面临合约标的行权交割不足的风险。</li>
              <li>请您知悉股票期权行权原则上进行实物交割，但在出现公司未能完成向中国结算的合约标的行权交割义务、期权合约行权日或交收日合约标的交易出现异常情形以及交易所、中国结算规定的其他情形时，期权行权交割可能全部或者部分以现金结算的方式进行，客户须承认行权现金结算的交收结果。</li>
              <li>请您知悉以现金结算方式进行行权交割时，合约标的应付方将面临按照交易所或者中国结算公布的价格进行现金结算而不能以实物交割方式进行行权交割的风险；合约标的应收方则存在无法取得合约标的并可能损失一定本金的风险。</li>
              <li>请您知悉如果到期日遇合约标的全天停牌或者盘中临时停牌的，则期权合约的交易同时停牌，但行权申报照常进行。无论合约标的是否在收盘前复牌，期权合约的最后交易日、到期日以及行权日都不作顺延。</li>
              <li>请您知悉在期权合约的最后交易日，有可能因期权合约交易停牌而无法进行正常的开仓与平仓。</li>
              <li>请您知悉当合约标的发生暂停或终止上市，交易所有权将未平仓的期权合约提前至合约标的暂停或终止上市前最后交易日的前一交易日，期权合约于该日到期并行权。</li>
              <li>请您关注衍生品合约账户内的期权合约通过该账户对应的证券账户完成合约标的交割。客户衍生品合约账户内存在未平仓合约或清算交收责任尚未了结前，客户衍生品合约账户的销户及对应证券账户的撤销指定交易及销户将受到限制。</li>
              <li>请您关注当发生不可抗力、意外事件、技术故障、重大差错、市场操纵等异常情况影响股票期权业务正常进行，或者您违反股票期权业务规则并且对市场产生或者将产生重大影响的，交易所及中国结算可以按照相关规则决定采取包括但不限于调整保证金、调整涨跌停价格、调整客户持仓限额、限制交易、取消交易、强行平仓等风险控制措施，由此造成的损失，由客户自行承担。</li>
              <li>请您知悉因不可抗力、意外事件、技术故障或者重大差错等原因，导致交易所、中国结算因不可抗力、意外事件、技术故障或者重大差错等原因，导致期权合约条款、结算价格、涨跌停价格、行权现金结算价格、保证金标准以及与期权交易相关的其他重要数据发生错误时，交易所、中国结算可以决定对相关数据进行调整，并向市场公告。</li>
              <li>请您关注股票期权业务可能面临各种操作风险、技术系统风险、不可抗力及意外事件并承担由此可能造成的损失，包括但不限于：期权经营机构、结算参与人、交易所或者中国结算因电力、通讯失效、技术系统故障或重大差错等原因而不能及时完成相关业务或影响交易正常进行等情形。</li>
              <li>请您知悉利用互联网进行股票期权交易时将存在但不限于以下风险并承担由此导致的损失：由于系统故障、设备故障、通讯故障、电力故障、网络故障、受到网络黑客和计算机病毒攻击及其他因素，可能导致网上交易及行情出现延迟、中断、数据错误或不完全；由于客户未充分了解期权交易及行情软件的实际功能、信息来源、固有缺陷和使用风险，导致对软件使用不当，造成决策和操作失误；客户网络终端设备及软件系统与期权经营机构提供的网上交易系统不兼容，可能导致无法下达委托指令或委托失败；客户缺乏网上交易经验，可能因操作不当造成交易失败或交易失误；客户密码失密或被盗用。</li>
              <li>请您关注交易所、中国结算以及期权经营机构发布的公告、通知以及其他形式的提醒，了解包括但不限于期权交易相关业务规则、保证金标准、证券保证金范围及折算率、持仓限额等方面的调整和变化。</li>
              <li>请您关注股票期权业务中面临的各种政策风险，以及由此可能造成的损失，包括但不限于因法律法规及政策变动须作出重大调整或者终止该业务。</li>
            </ol>
            <p>本风险揭示书的揭示事项仅为列举性质，未能详尽列明股票期权业务的所有风险。客户在参与股票期权业务前，应认真阅读相关业务规则及协议条款，对股票期权业务所特有的规则有所了解和掌握，并确信自己已做好足够的风险评估与财务安排，避免因参与股票期权业务而遭受难以承受的损失。</p>
          </div>
          <div class="block-title">
            免责条款
          </div>
          <div class="block text-align-left">
            <p>对于因下列任一情形而引起投资人所遭受的任何损失或所承担的任何责任，我司均不承担任何补偿、赔偿或其他责任：</p>
            <ol>
              <li>股票收益互换交易按本协议的约定予以执行（到期终止）或提前终止，而导致投资人预期收益未能实现及/或发生损失；</li>
              <li>任何适用于本协议的法律、法规、规章、监管制度的颁布、适用、变化或失效，而导致本协议相关条款或内容失效、被变更、被撤销、被中止/终止、无效或不可执行；</li>
              <li>与任何挂钩事项（具体挂钩事项见每一笔具体交易所涉及的具体协议文本的约定）及/或金融信息（包括利率、价格等）有关的事实，包括挂钩事项及/或金融信息的产生、存在、消灭、变化、确认错误、信息传递错误、错误更正等（但是，甲方有故意欺诈或重大过失而导致出现本款项情形时，甲方不应免除相应的责任）；</li>
              <li>任何国家风险、政治风险、战争风险、自然风险；</li>
              <li>非因甲方的故意或重大过失而引致的任何事件或行为；</li>
              <li>甲方根据仲裁机构、法院、金融监管机构、税务机关或/及其他国家行政/司法机关（包括上列机关的派出机构或分支机构）的规定、命令、裁决或要求而做出的行为。</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
  <style scoped>
    #detailBlock .tabbar .toolbar-inner .tab-link-active{
      background: #007aff;
      color: white;
    }
  </style>
</template>
<script>
return {
  methods: {
    isServiceTime: function() {
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
    },
    
    inputMoneyHandle: function(e) {
      let input = $(e.target);
      let range = app.range.get("#price-filter");
      let value = input.val();
      if (value > 80000) {
        value = 80000;
      } else if (value < 1000) {
        value = 1000;
      }
      range.setValue(value);
    },
    buyStock: function(code, num, id) {
      if (arguments.length != 3) return;
      return this.invokeBuyStock(code, num, id);
    },
    invokeBuyStock: function(code, num, id) {
      let url = `${_apiHost}/users/buy_fund/${code}/${num}/${id}`;
      return getJSON(url);
    },
    stockQuote: function(code) {
      return this.invokeStockQuote(code);
    },
    invokeStockQuote: function(code) {
      let url = `${_apiHost}/app/get_detail_by_code/${code}`;
      return getJSON(url);
    },
    showoptiondetail: function(e) {
      console.log('函数执行')
      let self = this;
      let el = self.$el;
      let clickDom = $(e.target)
      let detailBlock = $('#detailBlock');
      let code = clickDom.data('code');
      let detail = self.$root.quotationList[code];
      self.currentStockCode = code;
      self.currentStockId = clickDom.data('id');
      self.buyFee = clickDom.data('price');
      app.searchbar.disable();
      let stock = detail[0];
      $(".stock-name").text(`${stock.name} (${stock.code})`);
      $(".showWhenHasStock").show();
      let step = clickDom.data('step');
      let min = 1000;
      if (step > 1000) min = step;
      app.range.get("#price-filter").calcSize()
      app.range.get("#price-filter").layout()
      app.range.get("#price-filter").min = min;
      app.range.get("#price-filter").step = step;
      app.range.get("#price-filter").setValue(min);
      detailBlock.empty().append(self.getDetailTemplate(detail));
      self.stockQuote(stock.code)
        .done(function(data) {
          if (data != null) {
            let status = data['status'];
            let msg = JSON.parse(data['msg']);
            if (status === true) {
              let buyPrice = msg['buyOnePri'];
              let increPer = msg['increPer'];
              let perFloat = parseFloat(increPer);
              buyPrice = accounting.formatNumber(buyPrice,2);
              $(".stock-price").text(buyPrice);
              if (perFloat > 0) {
                $(".percentChange").text(`+${increPer}%`)
                  .css('color', 'red');
              } else {
                $(".percentChange").text(`${increPer}%`)
                  .css('color', 'green');
              }
            }
          }
        })
    },
    showoptiondetail2: function(e) {
      let self = this;
      let el = self.$el;
      let clickDom = $(e.target)
      let detailBlock = $('#detailBlock');
      let code = clickDom.data('code');
      let detail = self.$root.quotationList[code];
      self.currentStockCode = code;
      self.currentStockId = clickDom.data('id');
      self.buyFee = clickDom.data('price');
      let step = clickDom.data('step');
      let right_price = clickDom.data('rightprice');
      let max = 80000;
      if(parseFloat(right_price)==90)
      {
        max = 500000;
      }
      console.log(`right_price:${right_price} set max = ${max}`);
      let min = 1000;
      if (step > 1000) min = step;
      app.range.get("#price-filter").min = min;
      app.range.get("#price-filter").max = max;
      app.range.get("#price-filter").step = step;
      app.range.get("#price-filter").setValue(min);
    },
    getSingleTemp: function(detailAry) {
      let trTemplate = '';
      for (let i = 0; i < detailAry.length; i++) {
        let detail = detailAry[i];
        let right_price = detail['right_price'];
        console.log('baiawxk detail',detail);
        trTemplate += `
        <tr>
          <td class="text-align-center" >
            <label class="item-radio1 item-content1 radio">
              <input type="radio" name="stockIdRadio" value="${detail.id}" />
              <i class="icon icon-radio" style="left:0" data-id="${detail.id}" data-price="${detail.price}" data-code="${detail.code}" data-step="${detail.step}" data-rightprice="${right_price}"></i>
            </label>
          </td>
          <td class="text-align-center">${detail.right_price}%</td>
          <td class="text-align-center">${detail.last_time}</td>
          <td class="text-align-center">${detail.price}%</td>
        </tr>
        `;
      }
      let template = `
    <div class="card data-table">
      <table>
        <thead>
          <tr>
            <th class="text-align-center">选择</th>
            <th class="text-align-center"><i class='icon stocks-icon-1 popover-open' data-popover=".popover-rightPrice"></i>行权价</th>
            <th class="text-align-center"><i class='icon stocks-icon-1 popover-open' data-popover=".popover-deadline"></i>期限</th>
            <th class="text-align-center"><i class='icon stocks-icon-1 popover-open' data-popover=".popover-optionratio"></i>期权费率</th>
          </tr>
        </thead>
        <tbody>
          ${trTemplate}
        </tbody>
      </table>
    </div>
      `;
      return template;
    },
    getDetailTemplate: function(detailAry) {
      let self = this;
      let groupAry = _.groupBy(detailAry, function(detail) {
        let p = parseFloat(detail.right_price);
        return p;
      });
      groupAry = _.sortBy(groupAry,function(a,b,c) {
        let right = -parseFloat(b);
        if(right==-100)right = -999;
        return right;
      })
      console.log(groupAry);
      let template = '';
      let tablinks = ``;
      let tabCtx = ``;
      var arrayTest = [1000,10000];
      for (let i in groupAry) {

        let tempStr = "";
        let ary = groupAry[i];
        let d = ary[0];
        let p = d.right_price;

        let titleLabel = `实值期权${p}%`;
        if(p==100)
        {
          titleLabel = `平值期权`;
        }
        else if(p==110)
        {
          titleLabel = `虚值期权110%`;
        }

        tablinks += `
            <a href="#tab-${i}" style="font-size:14px;" class="tab-link" minMoney=${arrayTest[i]}>${titleLabel}</a>
          `;

        tabCtx += `
            <div class="tab" id="tab-${i}">
              ${self.getSingleTemp(ary)}
            </div>
          `;
      }
      let header = `
           <div class="toolbar tabbar">
              <div class="toolbar-inner">
                ${tablinks}
              </div>
            </div>
        `;
      let body = `
          <div class="tabs">
            ${tabCtx}
          </div>
        `;
      template += `
        ${header}
        ${body}
      `;
      let t = $(template);
      // t.find(":radio").eq(0).prop("checked",true);
      t.find('.icon-radio').click(self.showoptiondetail2).eq(0).click();
      t.find('.tab').eq(0).addClass('tab-active');
      t.find('.tab-link').eq(0).addClass('tab-link-active');
      t.find('.tab-link').click(function(e){
        
        let min =$(this).attr('minMoney');
        app.range.get('#price-filter').min = min;
        console.log(min);
        
        app.range.get('#price-filter').setValue(min);
        
      })
      return t;
    },
    showCalc: function() {
      let self = this;
      let el = self.$el;
      let t = self.updateCalcTemplate();
      el.find('#ratetable').html(t);
      app.popup.open(".popup-about");
    },
    updateCalcTemplate: function() {
      let self = this;
      let calcAry = [-0.2, -0.1, 0, 0.05, 0.1, 0.2, 0.3, 0.4];
      let code = self.currentStockCode;
      let currentStockId = self.currentStockId;
      let stocks = self.$root.quotationList[code];
      let detail = null;
      for (let i = 0; i < stocks.length; i++) {
        let s = stocks[i];
        let id = s['id'];
        if (id == currentStockId) {
          detail = s;
          break;
        }
      }
      let buyFee = detail['price'];
      let right_price = detail['right_price'];
      let currentMoney = self.currentMoney;
      let normalMoney = currentMoney / (buyFee * 0.01);
      let trTemplate = "";
      console.log('baiawxk detail', detail);
      for (let i = 0; i < calcAry.length; i++) {
        let pValue = calcAry[i];
        let newpValue = (100 - right_price + pValue * 100) / 100;
        console.log('baiawxk newpValue', pValue, 100 - right_price, newpValue);
        let pValueLabel = (pValue * 100) + "%";
        let pay1 = -currentMoney;
        let pay2 = normalMoney * newpValue - currentMoney;
        let finalPay = Math.max(pay1, pay2);
        let finalPayPercent = finalPay / currentMoney * 100
        let finalPayLabel = accounting.formatMoney(finalPay);
        let finalPayPercentLabel = accounting.formatNumber(finalPayPercent, 2) + "%";
        if (finalPay > 0) {
          finalPayLabel = `<span style="color:red">${finalPayLabel}</span>`
          finalPayPercentLabel = `<span style="color:red">${finalPayPercentLabel}</span>`
        } else if (finalPay < 0) {
          finalPayLabel = `<span style="color:green">${finalPayLabel}</span>`
          finalPayPercentLabel = `<span style="color:green">${finalPayPercentLabel}</span>`
        }
        trTemplate += `
        <tr>
          <td class="text-align-center">${pValueLabel}</td>
          <td class="text-align-center">${finalPayLabel}</td>
          <td class="text-align-center">${finalPayPercentLabel}</td>
        </tr>
        `;
      }
      let template = `
    <table>
      <thead>
        <tr>
          <th class="text-align-center">所选标的<br/>到期日<br/>涨跌幅</th>
          <th class="text-align-center">盈亏</th>
          <th class="text-align-center">盈亏%</th>
        </tr>
      </thead>
      <tbody>
        ${trTemplate}
      </tbody>
    </table>
      `;
      return template;
    },

    confirm_order: function() {
      let self = this;
      let currentStockCode = self.currentStockCode;
      let currentStockId = self.currentStockId;
      let stocks = self.$root.quotationList[currentStockCode];
      let stock = null;
      for (let i = 0; i < stocks.length; i++) {
        let s = stocks[i];
        let id = s['id'];
        if (id == currentStockId) {
          stock = s;
          break;
        }
      }
      let money = self.currentMoney || "1000";
      let normalMoney = self.normalMoney || "1000";
      let moneyFmt = accounting.formatMoney(money);
      let normalMoneyFmt = accounting.formatMoney(normalMoney);
      let buyPrice = '---';
      let confirmMsg1 = self.getConfirmMsg();
      let confirmMsg2 = '';
      loadingWrap(self.isServiceTime())
        .then(function() {
          confirmMsg2 = '请确认以下认购信息:<br>';
        }, function() {
          confirmMsg2 = '请确认以下预约认购信息:<br>';
        })
        .always(function() {
          loadingWrap(self.stockQuote(currentStockCode))
            .done(function(data) {
              if (data != null) {
                let status = data['status'];
                let msg = JSON.parse(data['msg']);
                if (status === true) {
                  buyPrice = msg['buyOnePri'];
                  buyPrice = accounting.formatNumber(buyPrice,2);
                  app.dialog.confirm(confirmMsg1, '权盈', function() {
                    app.dialog.confirm(
                      `${confirmMsg2}
                  标的代码: ${stock.name} (${stock.code}) <br> 
                  到期日: ${stock.deadline} <br> 
                  认购金额:${moneyFmt} <br> 
                  名义本金:${normalMoneyFmt}<br>
                   期权费: ${stock.price}% <br>
                   参考买入价 ${buyPrice} <br>
                   参考行权价:${stock.right_price}% <br>
                   <br>注：具体价格以成交价为准`, '权盈',
                      function() {
                        self.buyStock(stock.code, money, stock.id).then(function(data) {
                          if (data != null) {
                            let status = data['status'];
                            let msg = data['msg'];
                            if (status === true) {
                              qAlert('您的订单已提交').on('close', function() {
                                // mainView.router.navigate('/tradeIndex', { animate: false });
                                mainView.router.refreshPage();
                              })
                            } else {
                              qAlert(msg);
                            }
                          } else {
                            qAlert('下单失败');
                          }
                        }, function(data) {
                          qAlert('下单失败');
                        })
                      });
                  });
                }
              }
            })
            .fail(function(data) {
              let msg = data['msg'] || '系统繁忙，请稍后重试';
              qAlert('msg');
            })
        })
    },
    getConfirmMsg: function() {
      let self = this;
      let height = self.el.clientHeight * 1 / 2;
      let confirmBook = self.$el.find('#confirmBook').html();
      return `
      <div style="height:${height}px;overflow-y:auto;">
        ${confirmBook}
      </div>
      `;
    },
    
  },
  on: {


    tabInit: function() {
      $$('.popup-about').on('popup:open', function(e, popup) {
        console.log('About popup open');
      });
      $$('.popup-about').on('popup:opened', function(e, popup) {
        console.log('About popup opened');
      });

      var searchbar = app.searchbar.create({
        el: '.searchbar',
        searchContainer: '.list',
        searchIn: '.item-title',
        on: {
          clear: function() {
            console.log('search clear');
          },
          enable: function() {
            console.log('search enable');
            $(".showWhenHasStock").hide();
          },
          disable: function() {
            $(".search-advice").hide();
          },
          search: function(t, query) {
            console.log('search', arguments);
            if ($.trim(query) === "") {
              $(".search-advice").hide();
            }
          }
        }
      });
    },
   
    rangeChange: function(e, e, value) {
      console.log('rangeChange',value);
      
      let self = this;
      let el = self.$el;
      let buyFee = parseFloat(self.buyFee);
      self.currentMoney = value;
      let pay = value / (buyFee * 0.01);
      self.normalMoney = pay;
      el.find('.price-value').text(accounting.formatNumber(value));
      el.find('.book-value').text(accounting.formatNumber(pay));
      // if(parseFloat(value)>1000)el.find('#inputMoney').val(value);
    }
  }

}

</script>
