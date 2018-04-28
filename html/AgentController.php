<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class AgentController extends AppController {
	public $helpers = array('Html', 'Form');
    var $uses = array('Capital','Article','Fund','File','Master','Trading', 'FundPrice','Bank','Comrate','Commissions','Withdraw');

	public function beforeFilter() { 
        parent::beforeFilter();
		
		if($this->action!='login'){
		
			$this->set('title_for_layout','代理系统-权盈金服');
			$this->layout = 'agent';
			if(!$this->_is_login()) {
				/*echo '此页面为代理系统，3秒后自动跳转至登录页面，或手动点击以下链接跳转：';
				echo '<br/><br/><br/>';
				echo '<a href=\'/agent/login\'>点击进入首页登录页面</a>';
				header('Refresh: 3; URL=/agent/login');*/
				$this->redirect('/agent/login');
			
			}else{
				//header('URL=/agent/login');
				if(!($this->_is_agent())){
				$this->autoRender = false;
				echo '权限不足';
				die;
				}
			}
		}else {
			/*if($this->_is_agent()){
				$this->autoRender = false;
				echo 权限不足
			}*/
		}
        // $this->layout = null;
    }
	
	function login(){
		$this->set('title_for_layout','代理系统-登陆-权盈金服');
		if(!($this->_is_login())) {
		$this->layout = '';
		}else{
			$this->redirect('/agent');
		}
	}

    function _is_agent() {
    	if($this->_is_login()) {
    		return $this->user['type'] == 2||!empty($this->user['agent_level']) ;
    	}
    	return false;
    }
	
	public function index() {
		$this->set('title_for_layout','佣金系统-权盈金服');
		if(empty($this->user['agent_login_times']) ||$this->user['agent_login_times']==0){
			$this->redirect('/agent/first_login');
		}else{
			$this->redirect('/agent/commissions');
		}
	}
	
	public function first_login(){
			$this->set('title_for_layout','首次登陆佣金系统-权盈金服');

			$cur_user = array();
			$cur_user['id'] = $this->user['id'];
			$cur_user['inv_user'] = ($this->user['type'] == 2? '总部':$this->User->get_user_name_by_id($this->user['inv_user']));
		    $cur_user['level'] = ($this->user['type'] == 2? '总部':$this->user['agent_level']);
			$cur_user['name'] = $this->user['name'];
			$cur_user['tel'] = $this->user['tel'];
			$cur_user['personal_code'] = $this->user['personal_code'];
			$bank_infomation =  $this->Bank->get_last_bank_info_with_user_id($this->user['id']);
			if(!empty($bank_infomation)){
				$cur_user['num'] =$bank_infomation['Bank']['num'];
				$cur_user['bank_name'] = $bank_infomation['Bank']['bank_name'];
				$cur_user['sub_bank'] = $bank_infomation['Bank']['sub_bank'];
			}else{
				$cur_user['num'] ='';
				$cur_user['bank_name'] = '';
				$cur_user['sub_bank'] = '';
			}
			
			
			$cur_user['info_complete'] = !empty($cur_user['num'])&& !empty($cur_user['bank_name']) && !empty($cur_user['sub_bank']) && !empty($cur_user['personal_code']);
			 
			$cur_user['message'] = $cur_user['info_complete']? "":"检测到银行信息未完整，请及时在权盈在线询价系统中补充";
			$this->set('cur_user', $cur_user);
	}
	
	public function confirm_info(){
		$this->autoRender = false;
		$this->User->add_agent_login_times($this->user['id']);
		echo 1;
	}
	
	public function commissions() {
        $this->set('title_for_layout','佣金系统-佣金管理-权盈金服');
		$cur_user = array();
		$user_type;
		$next_level_agents_list;
		$withdraw_list = array();
		$commission_list = array();
		$cur_commission = array();

		if($this->user['type']==2){
			$user_type = 'admin';
		}else if(!empty($this->user['agent_level'])){
			$user_type = 'agent';
		}
		
		$this->set('user_type', $user_type);
		
		$cur_user['id'] = $this->user['id'];
		$cur_user['name'] = $this->user['name'];
		$cur_user['level'] = $this->user['agent_level'];
		if(!empty($this->Bank->get_last_bank_info_with_user_id($this->user['id']))){
		$bank_account = $this->Bank->get_last_bank_info_with_user_id($this->user['id'])['Bank']['num'];
		$cur_user['bank_num'] = empty($bank_account)? '':$bank_account;
		}else{
			$cur_user['bank_num'] = '';
		}
		
		$cur_user_rate = $this->Comrate->get_cur_comrate($this->user['id']);
		if(!empty($cur_user_rate) && $this->user['type']!=2){
		
		    $cur_user['type_a_rate'] = $cur_user_rate['type_a'];
		    $cur_user['type_b_rate'] = $cur_user_rate['type_b'];
		    $cur_user['type_c_rate'] = $cur_user_rate['type_c'];
		    $cur_user['type_d_rate'] = $cur_user_rate['type_d'];
			$cur_user['type_e_rate'] = $cur_user_rate['type_e'];
		    $cur_user['type_f_rate'] = $cur_user_rate['type_f'];
		    $cur_user['type_g_rate'] = $cur_user_rate['type_g'];
		    $cur_user['type_h_rate'] = $cur_user_rate['type_h'];
		}else if(empty($cur_user_rate)&& !empty($this->user['agent_level'])){
			$cur_user['type_a_rate'] = 0;
			$cur_user['type_b_rate'] = 0;
			$cur_user['type_c_rate'] = 0;
			$cur_user['type_d_rate'] = 0;
			$cur_user['type_e_rate'] = 0;
			$cur_user['type_f_rate'] = 0;
			$cur_user['type_g_rate'] = 0;
			$cur_user['type_h_rate'] = 0;
			
		}else{
			$cur_user['type_a_rate'] = 50;
			$cur_user['type_b_rate'] = 50;
			$cur_user['type_c_rate'] = 50;
			$cur_user['type_d_rate'] = 50;
			$cur_user['type_e_rate'] = 50;
			$cur_user['type_f_rate'] = 50;
			$cur_user['type_g_rate'] = 50;
			$cur_user['type_h_rate'] = 50;
		}
		
		$this->set('cur_user', $cur_user);
		if($user_type=='admin'){
			$next_level_agents_list = $this->User->get_user_by_agent_level(1);
		}else if($user_type=='agent'){
			$next_level_agents_list = $this->User->get_only_next_level_agents($this->user['id'],$this->user['agent_level']);
			$withdraw_list = $this->Capital->get_withdraw_list($this->user['id']);
			
		}
		
		
		$this->set('withdraw_list', $withdraw_list);
		$this->set('withdraw_status',array(3=>'转现申请中',4=>'转现成功',-2=>'转现失败'));
		
		if($user_type=='admin'){
			$cur_commission = $this->Commissions->get_commissions_as_admin();

			//$cur_commission['withdraw_comm'] = $this->Capital->get_total_withdraw_amt();
			//$cur_commission['withdraw_comm'] = $this->Capital->get_total_withdraw_amt();
			$cur_commission['withdraw_comm'] = 0;
			
			$cur_commission['total'] = $this->Commissions->get_commissions_as_admin()['comm_total'];
			$cur_commission['withdraw_avl'] = $cur_commission['total']-$cur_commission['comm_assigned']-$cur_commission['comm_to_assign'];
			
			$this->set('cur_commission', $cur_commission);
		}else if($user_type=='agent'){
			$cur_commission = $this->Commissions->get_commissions_by_user_id($this->user['id'],$this->user['agent_level']);

			$cur_commission['withdraw_comm'] = $this->Capital->get_total_withdraw_com_value($this->user['id']);
			$cur_commission['withdraw_avl'] = $cur_commission['comm_received']-$cur_commission['withdraw_comm'];
			$cur_commission['total'] = $cur_commission['comm_to_assign'] +$cur_commission['comm_assigned']+$cur_commission['withdraw_comm']+$cur_commission['withdraw_avl'];
			
			$this->set('cur_commission', $cur_commission);
			
		}
		
		
		
		
		if($user_type=='admin' &&(is_array($next_level_agents_list) || is_object($next_level_agents_list))){
		
		  foreach ($next_level_agents_list as $key => $value) {
			$this_agent_comrate = $this->Comrate->get_cur_comrate($next_level_agents_list[$key]['User']['id']);
		   if(!empty($this_agent_comrate)){
			    $next_level_agents_list[$key]['User']['rate_array'] = $this_agent_comrate ;
			}else {
				$next_level_agents_list[$key]['User']['rate_array'] = array('type_a'=>0,'type_b'=>0,'type_c'=>0,'type_d'=>0,
				'type_e'=>0,'type_f'=>0,'type_g'=>0,'type_h'=>0);
			}
			
			$pending_amount = $this->Commissions->get_pending_amount($next_level_agents_list[$key]['User']['id'],
			$next_level_agents_list[$key]['User']['agent_level']);
			
			
		   	$next_level_agents_list[$key]['User']['type_a_amt'] = $pending_amount['typeA'];
		   	$next_level_agents_list[$key]['User']['type_b_amt'] = $pending_amount['typeB'];
		   	$next_level_agents_list[$key]['User']['type_c_amt'] = $pending_amount['typeC'];
		   	$next_level_agents_list[$key]['User']['type_d_amt'] = $pending_amount['typeD'];
			$next_level_agents_list[$key]['User']['type_e_amt'] = $pending_amount['typeE'];
		   	$next_level_agents_list[$key]['User']['type_f_amt'] = $pending_amount['typeF'];
		   	$next_level_agents_list[$key]['User']['type_g_amt'] = $pending_amount['typeG'];
		   	$next_level_agents_list[$key]['User']['type_h_amt'] = $pending_amount['typeH'];
           }
			
		}else if($user_type=='agent' && (is_array($next_level_agents_list) || is_object($next_level_agents_list))){
		   foreach ($next_level_agents_list as $key => $value) {
			$this_agent_comrate = $this->Comrate->get_cur_comrate($next_level_agents_list[$key]['User']['id']);
		   if(!empty($this_agent_comrate)){
			    $next_level_agents_list[$key]['User']['rate_array'] = $this_agent_comrate ;
			}else {
				$next_level_agents_list[$key]['User']['rate_array'] = array('type_a'=>0,'type_b'=>0,'type_c'=>0,'type_d'=>0,
				'type_e'=>0,'type_f'=>0,'type_g'=>0,'type_h'=>0);
			}
			
			
		   	$pending_amount = $this->Commissions->get_pending_amount($next_level_agents_list[$key]['User']['id'],$next_level_agents_list[$key]['User']['agent_level']);
        
		   	$next_level_agents_list[$key]['User']['type_a_amt'] = $pending_amount['typeA'];
		   	$next_level_agents_list[$key]['User']['type_b_amt'] = $pending_amount['typeB'];
		   	$next_level_agents_list[$key]['User']['type_c_amt'] = $pending_amount['typeC'];
		   	$next_level_agents_list[$key]['User']['type_d_amt'] = $pending_amount['typeD'];
			$next_level_agents_list[$key]['User']['type_e_amt'] = $pending_amount['typeE'];
		   	$next_level_agents_list[$key]['User']['type_f_amt'] = $pending_amount['typeF'];
		   	$next_level_agents_list[$key]['User']['type_g_amt'] = $pending_amount['typeG'];
		   	$next_level_agents_list[$key]['User']['type_h_amt'] = $pending_amount['typeH'];
			
		   }
			
        
		}
        
		$this->set('next_level_agents_list', $next_level_agents_list);
		
		if($this->user['type']==2){
			$agent_level = 0;
		}
		$agent_level = $this->user['agent_level'];
		$commission_list = $this->Commissions->get_commission_list($this->user['id'],$agent_level);
		
		if(!empty($commission_list)){
		foreach ($commission_list as $key => $value) {
			 
			if($agent_level==1){
				if($commission_list[$key]['Commissions']['status']==2){
					$commission_list[$key]['Commissions']['assign_id']=$commission_list[$key]['Commissions']['2nd_level_agent'];
					$commission_list[$key]['Commissions']['assign_amt']=$commission_list[$key]['Commissions']['2nd_lvl_com_amount'];
				}else if($$commission_list[$key]['Commissions']['status']==3){
					$commission_list[$key]['Commissions']['assign_id']=$commission_list[$key]['Commissions']['2nd_level_agent'];
					$commission_list[$key]['Commissions']['assign_amt']=$commission_list[$key]['Commissions']['2nd_lvl_com_amount']+
					$commission_list[$key]['Commissions']['3rd_lvl_com_amount'];
				}else{
					$commission_list[$key]['Commissions']['assign_id']=$commission_list[$key]['Commissions']['1st_level_agent'];
					$commission_list[$key]['Commissions']['assign_amt']=$commission_list[$key]['Commissions']['1st_lvl_com_amount']+
					$commission_list[$key]['Commissions']['2nd_lvl_com_amount']+$commission_list[$key]['Commissions']['3rd_lvl_com_amount'];
				}
			}else if($agent_level==2){
				
				//if($commission_list[$key]['Commissions']['status']==3){
					$commission_list[$key]['Commissions']['assign_id']=$commission_list[$key]['Commissions']['2nd_level_agent'];
					$commission_list[$key]['Commissions']['assign_amt']=empty($commission_list[$key]['Commissions']['2nd_lvl_com_amount'])?0:$commission_list[$key]['Commissions']['2nd_lvl_com_amount'];
					$commission_list[$key]['Commissions']['created'] = $commission_list[$key]['Commissions']['created_3rd'];
				//}else if($commission_list[$key]['Commissions']['status']==2){
				//	$commission_list[$key]['Commissions']['assign_id']=$commission_list[$key]['Commissions']['2nd_level_agent'];
				//	$commission_list[$key]['Commissions']['assign_amt']= $commission_list[$key]['Commissions']['2nd_lvl_com_amount'];
				//}
			}else if($agent_level==0){
				if($commission_list[$key]['Commissions']['status']==1){
					$commission_list[$key]['Commissions']['assign_id']=$commission_list[$key]['Commissions']['1st_level_agent'];
					$commission_list[$key]['Commissions']['assign_amt']=$commission_list[$key]['Commissions']['1st_lvl_com_amount']+
					$commission_list[$key]['Commissions']['2nd_lvl_com_amount']+$commission_list[$key]['Commissions']['3rd_lvl_com_amount'];
				}else if($commission_list[$key]['Commissions']['status']==2){
					$commission_list[$key]['Commissions']['assign_id']=$commission_list[$key]['Commissions']['2nd_level_agent'];
					$commission_list[$key]['Commissions']['assign_amt']=$commission_list[$key]['Commissions']['2nd_lvl_com_amount'];
				}else if($commission_list[$key]['Commissions']['status']==3){
					$commission_list[$key]['Commissions']['assign_id']=$commission_list[$key]['Commissions']['2nd_level_agent'];
					$commission_list[$key]['Commissions']['assign_amt']=$commission_list[$key]['Commissions']['2nd_lvl_com_amount']+
					$commission_list[$key]['Commissions']['3rd_lvl_com_amount'];
				}else{
					$commission_list[$key]['Commissions']['assign_id']=$commission_list[$key]['Commissions']['1st_level_agent'];
					$commission_list[$key]['Commissions']['assign_amt']=$commission_list[$key]['Commissions']['1st_lvl_com_amount']+
					$commission_list[$key]['Commissions']['2nd_lvl_com_amount']+$commission_list[$key]['Commissions']['3rd_lvl_com_amount'];
				}
			}
			$commission_list[$key]['Commissions']['agent_name'] = $this->User->get_user_name_by_id($commission_list[$key]['Commissions']['assign_id']);
			$commission_list[$key]['Commissions']['agent_level'] = $this->User->get_agent_level($commission_list[$key]['Commissions']['assign_id']);
			
		
		
			}
		}

		
		$this->set('commission_list', $commission_list);
		
		
		
    }
	

	function new_agent() {
        $this->set('title_for_layout','佣金系统-任命新代理-权盈金服');
		$user_list = array();
		$this->set('search_tel','');
		$this->set('search_name','');
		if(empty($this->request->data['tel'])&&empty($this->request->data['name'])){
			if(!empty($this->user['agent_level'])){
				$user_list = $this->User->find('all', array('conditions'=>array('inv_user'=>$this->user['id'],'agent_level' => null,'type'=>1)));
			}else{
				$user_list = $this->User->find('all', array('conditions'=>array('not' => array('id'=>($this->user['id'])),'agent_level' => null,'type'=>1)));
			}
		}else if(!empty($this->request->data['tel'])&& empty($this->request->data['name'])){
			$tmp_tel = trim($this->request->data['tel']);
			if(!empty($this->user['agent_level'])){
				$user_list = $this->User->find('all', array('conditions'=>array('inv_user'=>$this->user['id'],'tel'=>$tmp_tel,'agent_level' => null,'type'=>1)));
			}else{
				$user_list = $this->User->find('all', array('conditions'=>array('not' => array('id'=>($this->user['id'])),'tel'=>$tmp_tel,'agent_level' => null,'type'=>1)));
			}
			$this->set('search_tel',$tmp_tel);
			
		}else if(!empty($this->request->data['name'])){
			$tmp_name = trim($this->request->data['name']);
			if(!empty($this->user['agent_level'])){
				$user_list = $this->User->find('all', array('conditions'=>array('inv_user'=>$this->user['id'],'name'=>$tmp_name,'agent_level' => null)));
			}else{
				$user_list = $this->User->find('all', array('conditions'=>array('not' => array('id'=>($this->user['id'])),'name'=>$tmp_name,'agent_level' => null)));
			}
			$this->set('search_name',$tmp_name);
		}
		$this->set('user_list', $user_list);
		$this->set('cur_user',$this->user);
    }
	
	function add_new_agent($user_id) {
        $this->autoRender = false;
        $add_user = $this->User->findById($user_id);
		$cur_agent = $this->User->findById($this->user['id']);
		if(!empty($cur_agent['User']['agent_level']) && $cur_agent['User']['agent_level']<3 && $add_user['User']['inv_user']==$cur_agent['User']['id']){
		    $next_agent_level = ($cur_agent['User']['agent_level']+1);
		}else if($cur_agent['User']['type']==2){
			$next_agent_level=1;
		}else{
			return false;
			die;
		}
		$this->User->add_new_agent($user_id,$next_agent_level);
		echo 1;
    }
	
	function update_comrate($id,$type_a,$type_b,$type_c,$type_d,$type_e,$type_f,$type_g,$type_h) {
        $this->autoRender = false;
        $comrate = $this->Comrate->findByUserId($id);
        $data = array();
		$data['user_id'] = $id;
		if(!empty($comrate)){
		$data['id'] = $comrate['Comrate']['id'];
		}
        $data['type_a'] = $type_a;
        $data['type_b'] = $type_b;
        $data['type_c'] = $type_c;
		$data['type_d'] = $type_d;
		$data['type_e'] = $type_e;
        $data['type_f'] = $type_f;
        $data['type_g'] = $type_g;
		$data['type_h'] = $type_h;
        $this->Comrate->save($data);
		
		$this->Commissions->update_commission($id,$this->User->get_agent_level($id),$type_a,$type_b,$type_c,$type_d,
		$type_e,$type_f,$type_g,$type_h);
		
		
		
        echo 1;
    }
	
	function cancel_agent($id) {
        $this->autoRender = false;
        $agent = $this->User->findById($id);
        $data = array();
		$data['id'] = $id;
		$ret;
		if(!empty($agent) && $this->user['type']==2){
			$data['id'] = $agent['User']['id'];
			$data['agent_level'] = NULL;
			$this->User->save($data);
			//set dummy agent_level
			$dummy_agent_array = array(208,207,209);
			$replaced_agents = $this->User->find('all', array('conditions'=>array('inv_user'=>$id)));
			
			
			foreach ($replaced_agents as $key=>$value) {
				$replaced_agents[$key]['User']['total_com'] = 0;
			
				$ret = array();
				$ret['id'] = $replaced_agents[$key]['User']['id'];
				if($this->User->get_agent_level($id)==2){
					$ret['inv_user'] = $dummy_agent_array[0];
					$ret['inv_user_nick'] = $this->User->get_user_nick_by_id($dummy_agent_array[0]);
				}else if($this->User->get_agent_level($id)==3){
					$ret['inv_user'] =  $dummy_agent_array[1];
					$ret['inv_user_nick'] = $this->User->get_user_nick_by_id($dummy_agent_array[1]);
				}else if(empty($this->User->get_agent_level($id))){
					$ret['inv_user'] =  $dummy_agent_array[2];
					$ret['inv_user_nick'] = $this->User->get_user_nick_by_id($dummy_agent_array[2]);
				}
				$this->User->save($ret);
			}	
			
			$ret = array('status'=>true, 'msg'=>'操作成功');
		}else{
			$ret = array('status'=>false, 'msg'=>'操作失败');
		}
        	
        echo json_encode($ret);
    }
	
	function brokers($search_user_id=NULL) {
        $this->set('title_for_layout','佣金系统-代理管理-权盈金服');
		$user_list = array();	
		if(!empty($this->user['agent_level'])){
			$user_list = $this->User->get_only_next_level_agents($this->user['id'],$this->user['agent_level']);
		}else {
			$user_list = $this->User->find('all',array('conditions'=>array('agent_level'=>1)));
		}
		if((is_array($user_list) || is_object($user_list))){
			foreach ($user_list as $key => $value) {
				$user_list[$key]['User']['type'] = $this->User->type_name[$value['User']['type']];
				$cur_commission = $this->Commissions->get_commissions_by_user_id($user_list[$key]['User']['id'],$user_list[$key]['User']['agent_level']);
				$cur_commission['withdraw_comm'] = $this->Capital->get_total_withdraw_com_value($user_list[$key]['User']['id']);
				$cur_commission['withdraw_avl'] = $cur_commission['comm_received']-$cur_commission['withdraw_comm'];
				$cur_commission['total'] = $cur_commission['comm_to_assign'] +$cur_commission['comm_assigned']+$cur_commission['withdraw_comm']+$cur_commission['withdraw_avl'];
				$user_list[$key]['User']['total_commission'] = $cur_commission['total'];
				$user_list[$key]['User']['commission_get'] = $cur_commission['comm_assigned'];
				$user_list[$key]['User']['commission_avl'] = $cur_commission['comm_to_assign'];
				$user_list[$key]['User']['agent_count'] = $this->User->get_all_agent_count_belong_to($user_list[$key]['User']['id'])['agents_no'];
				$user_list[$key]['User']['client_count'] = $this->User->get_all_agent_count_belong_to($user_list[$key]['User']['id'])['clients_no'];
				$agent_and_client_list = array_merge(array($user_list[$key]['User']['id']),$this->User->get_all_agents_belong_to($user_list[$key]['User']['id']));
				$total_trading_amount = 0;
				$total_investment_amount = 0;
				for($i=0;$i<count($agent_and_client_list);$i++){
					$total_trading_amount += $this->Trading->get_all_trading_amt($agent_and_client_list[$i]);
					$total_investment_amount += $this->Capital->get_total_deposit_value($agent_and_client_list[$i]);
				}
				$user_list[$key]['User']['total_trading_amt'] = $total_trading_amount;
				$user_list[$key]['User']['total_invest_amt'] = $total_investment_amount;			
				$user_id = $user_list[$key]['User']['id'];
			}
		}
		$this->set('user_list', $user_list);
		if($this->user['type']==2){
			$user_type = 'admin';
		}else if(!empty($this->user['agent_level'])){
			$user_type = 'agent';
		}
		
		$this->set('user_type', $user_type);
    }
	
	function clients($search_user_id=NULL) {
        $this->set('title_for_layout','佣金系统-客户管理-权盈金服');
		$user_list = array();
		$bank_list = array();
		if($search_user_id==NULL){
			if(!empty($this->user['agent_level'])){
			$user_list = $this->User->get_sub_clients($this->user['id']);
			$bank_list = $this->Bank->get_bank_info_with_user_id();
			}else {
				$user_list = $this->User->find('all');
				$bank_list = $this->Bank->get_bank_info_with_user_id();
			}
		}else{
			$user_list = $this->User->get_sub_clients($search_user_id);
			$bank_list = $this->Bank->get_bank_info_with_user_id();
		}
		
		if((is_array($user_list) || is_object($user_list))){
		foreach ($user_list as $key => $value) {
			$user_list[$key]['User']['total_trading_amt'] = $this->Trading->get_all_trading_amt($user_list[$key]['User']['id']) ;
			$user_list[$key]['User']['total_market_value'] =$this->get_total_market_value_by_user_id($user_list[$key]['User']['id'])['total'];
			$user_list[$key]['User']['total_avl'] =$this->get_total_market_value_by_user_id($user_list[$key]['User']['id'])['unlocked'] ;
            $user_id = $user_list[$key]['User']['id'];
			//$user_list[$key]['User']['bank_info'] =isset($bank_list[$user_id]);
            if(isset($bank_list[$user_id])) {
                $user_list[$key]['User']['bank_info'] = $bank_list[$user_id];
            }else{
				$user_list[$key]['User']['bank_info']['num'] = 'N/A';
				$user_list[$key]['User']['bank_info']['bank_name'] = 'N/A';
			}
			$user_list[$key]['User']['1st_level_agent'] = $this->User->get_n_levels_agent_by_user_id($user_id,1);
			$user_list[$key]['User']['2nd_level_agent'] = $this->User->get_n_levels_agent_by_user_id($user_id,2);
			$user_list[$key]['User']['3rd_level_agent'] = $this->User->get_n_levels_agent_by_user_id($user_id,3);
			
			//$user_list[$key]['User']['3rd_level_agent']
			
        }
		}
		$this->set('user_list', $user_list);
		
		
    }
	
	function get_client_trading($user_id){
		
	}
	
	
	function agent_test(){
		 $this->autoRender = false;
		 //$user_id_array = array($id);
		 //$user_id_array = array_merge($user_id_array,$this->User->get_all_agents_belong_to($id));
		 //echo json_encode($user_id_array);
		 echo json_encode($this->Commissions->get_commissions_by_trading_id(10));
		
		
	}
	
	function get_agents_info_belong_to($user_id){
		$this->autoRender = false;
		if(empty($this->user)) {
            echo $this->output(false, '请登录');die;
        }
		$agent_id_list = $this->User->get_all_agents_belong_to($user_id);
        
		$user_list = $this->User->find('all', array('conditions' => array('id' => $agent_id_list,'not' => array('agent_level'=>null))));
		//$user_list = $user_list['User'];
		
		foreach ($user_list as $key=>$value) {
			$user_list[$key]['User']['total_com'] = 0;
			$user_list[$key]['User']['avl_com'] = 0;
			$user_list[$key]['User']['get_com'] = 0;
			$user_list[$key]['User']['agents_under'] = 0;
			$user_list[$key]['User']['clients_under'] = 0;
			$user_list[$key]['User']['total_trading_amt'] = 0;
			$user_list[$key]['User']['total_paid'] = 0;
			
			$cur_commission = $this->Commissions->get_commissions_by_user_id($user_list[$key]['User']['id'],$user_list[$key]['User']['agent_level']);
			$cur_commission['withdraw_comm'] = $this->Capital->get_total_withdraw_com_value($user_list[$key]['User']['id']);
			$cur_commission['withdraw_avl'] = $cur_commission['comm_received']-$cur_commission['withdraw_comm'];
			$cur_commission['total'] = $cur_commission['comm_to_assign'] +$cur_commission['comm_assigned']
			+$cur_commission['withdraw_comm']+$cur_commission['withdraw_avl'];
			
			$user_list[$key]['User']['total_com'] = $cur_commission['total'];
			$user_list[$key]['User']['get_com'] = $cur_commission['comm_assigned'];
			$user_list[$key]['User']['avl_com'] = $cur_commission['comm_to_assign'];
			
			$user_list[$key]['User']['agents_under'] = $this->User->get_all_agent_count_belong_to($user_list[$key]['User']['id'])['agents_no'];
			$user_list[$key]['User']['clients_under'] = $this->User->get_all_agent_count_belong_to($user_list[$key]['User']['id'])['clients_no'];
			
			$agent_and_client_list = array_merge(array($user_list[$key]['User']['id']),$this->User->get_all_agents_belong_to($user_list[$key]['User']['id']));
			$total_trading_amount = 0;
			$total_investment_amount = 0;
			
			for($i=0;$i<count($agent_and_client_list);$i++){
				$total_trading_amount += $this->Trading->get_all_trading_amt($agent_and_client_list[$i]);
				$total_investment_amount += $this->Capital->get_total_deposit_value($agent_and_client_list[$i]);
 			}
			
			//$user_list[$key]['User']['total_trading_amt'] = $this->Trading->get_all_trading_amt($user_list[$key]['User']['id']);
			//$user_list[$key]['User']['total_invest_amt'] = $this->Capital->get_total_deposit_value($user_list[$key]['User']['id']);
			
			$user_list[$key]['User']['total_trading_amt'] = $total_trading_amount;
			$user_list[$key]['User']['total_paid'] = $total_investment_amount;
			
			
			
			
		}
		
		echo $this->output(true, json_encode($user_list));
	}
	
	function tradings($cur_user_id=NULL) {
        $this->set('title_for_layout','佣金系统-交易管理-权盈金服');
		$user_id_array = array();
		$trading_list = array();
		$comm_status_arr = array('0'=>'总部未分配','1'=>'分配至销售总监','2'=>'分配至一级代理','3'=>'分配至二级代理');
		//case 1: agent
		if(!empty($this->user['agent_level'])){
			//case 1.1: show 
			if(empty($cur_user_id)){
				$user_id_array = array($this->user['id']);
				$user_id_array = array_merge($user_id_array,$this->User->get_all_agents_belong_to($this->user['id']));
				$trading_list = $this->Trading->find('all', array('conditions' => array('user_id' => $user_id_array)));
			//case 1.2: show all tradings for specific id:
			}else{
				$user_id_array = array($cur_user_id);
				$user_id_array = array_merge($user_id_array,$this->User->get_all_agents_belong_to($cur_user_id));
				$trading_list = $this->Trading->find('all', array('conditions' => array('user_id' => $user_id_array)));
			}
		//case 2: admin
		}else {
			//case 2.1: show all for admin
			if(empty($cur_user_id)){
				$trading_list = $this->Trading->find('all');
			//case 2.2: show all tradings for specific id:
			}else{
				$user_id_array = array($cur_user_id);
				$user_id_array = array_merge($user_id_array,$this->User->get_all_agents_belong_to($cur_user_id));
				$trading_list = $this->Trading->find('all', array('conditions' => array('user_id' => $user_id_array)));
			}
		}
		foreach ($trading_list as $key => $value) {
            $trading_list[$key]['Trading']['name'] = $this->User->get_user_name_by_id($trading_list[$key]['Trading']['user_id']);
			$cur_price = $this->get_detail_by_code_no_render($trading_list[$key]['Trading']['fund_code'], 'buy', true);
			$trading_list[$key]['Trading']['stock_name'] =  $this->get_detail_by_code_no_render($trading_list[$key]['Trading']['fund_code'], 'json', true);
			$trading_list[$key]['Trading']['notional'] =$trading_list[$key]['Trading']['buy_amount']/ $trading_list[$key]['Trading']['quotation_price']*100;
			$trading_list[$key]['Trading']['tel'] = $this->User->get_tel_by_id($trading_list[$key]['Trading']['user_id']);
			$trading_list[$key]['Trading']['trd_status'] = ($trading_list[$key]['Trading']['status']=='结算'? '已结算':'未结算/持仓中');
			if($trading_list[$key]['Trading']['status']=='结算'){
				$trading_list[$key]['Trading']['price2'] = $trading_list[$key]['Trading']['fund_price2'];
			}else {
				$trading_list[$key]['Trading']['price2'] = $cur_price;
			}
			$trading_list[$key]['Trading']['mkt_value'] = $this->Trading->get_market_value_by_id($trading_list[$key]['Trading']['id'],$trading_list[$key]['Trading']['price2']);
			$trading_list[$key]['Trading']['profit'] = $trading_list[$key]['Trading']['mkt_value']-$trading_list[$key]['Trading']['buy_amount'];		
			$trading_list[$key]['Trading']['total'] = !empty($this->Commissions->findByTradingId($trading_list[$key]['Trading']['id']))? $this->Commissions->findByTradingId($trading_list[$key]['Trading']['id'])['Commissions']['com_amount']:0;
			$tmp_comm = $this->Commissions->get_commissions_by_trading_id($trading_list[$key]['Trading']['id']);
			$trading_list[$key]['Trading']['comm_assign'] = !empty($tmp_comm['comm_assign'])? $tmp_comm['comm_assign']:0;
			$trading_list[$key]['Trading']['comm_withdraw'] = !empty($tmp_comm['comm_withdraw'])?$tmp_comm['comm_withdraw']:0;
			$tmp_status;
			if(!empty($this->Commissions->findByTradingId($trading_list[$key]['Trading']['id']))){
				$tmp_status = $this->Commissions->findByTradingId($trading_list[$key]['Trading']['id'])['Commissions']['status'];
			}
			
			$trading_list[$key]['Trading']['comm_status'] = !empty($tmp_status)? $comm_status_arr[$tmp_status]:'N/A';
			
			//$comm_status_arr[$this->Commissions->findById($trading_list[$key]['Trading']['id'])['Commissions']['status']];
		
		}		
		$this->set('trading_list', $trading_list);
		if($this->user['type']==2){
			$user_type = 'admin';
		}else if(!empty($this->user['agent_level'])){
			$user_type = 'agent';
		}
		
		$this->set('user_type', $user_type);
    }
	
	function withdraws() {
        $this->set('title_for_layout','佣金系统-客户管理-权盈金服');
		$withdraw_list = array();
		//$agents_array = array($this->user['id']);
		$agents_array = $this->User->get_all_agents_belong_to($this->user['id']);
		
		$withdraw_list =array(); 
		if(!empty($this->user['agent_level'])){
			$withdraw_list=$this->Capital->find('all', array('conditions' => array('user_id' => $agents_array,'status'=> array(3,4,-2))));
		}else {
			$withdraw_list=$this->Capital->find('all',array('conditions' => array('status'=>array(3,4,-2))));
		}
		
		foreach ($withdraw_list as $key => $value) {
			 $withdraw_list[$key]['Capital']['agent_name'] = $this->User->get_user_name_by_id($withdraw_list[$key]['Capital']['user_id']);
			 $withdraw_list[$key]['Capital']['agent_level'] = $this->User->get_agent_level($withdraw_list[$key]['Capital']['user_id']);
			 $withdraw_list[$key]['Capital']['type'] = '转投资账户';
		}
		
		$this->set('withdraw_list', $withdraw_list);
		$this->set('withdraw_status',array(3=>'转现申请中',4=>'转现成功',-2=>'转现失败'));
		
		
    }
	
	function get_all_agents() {
        $this->autoRender = false;
        if(empty($this->user)) {
            echo $this->output(false, '请登录');
			die;
        }
        $list = $this->User->get_all_agents_belong_to($this->user['id']);
        //echo $this->output(true, $list);
		return $list;
    }
	
	function get_all_agents_id() {
		$this->autoRender = false;
        $agent_id_list = $this->User->get_all_agents_belong_to($this->user['id']);
        return $agent_id_list;
    }
	
	/*function get_all_tradings_under_agent(){
		$this->autoRender = false;
		$user_id_array = $this->get_all_agents();
		$all_trading_list = $this->Trading->find('all', array('conditions' => array('Trading.user_id' => $user_id_array)));
		
		return $user_id_array;
	}*/
	
	function get_total_market_value_by_user_id($user_id) {

        $cash_amount = $this->Capital->get_current_amount($user_id);
		
        $list = $this->Trading->get_all_by_user($user_id);
        $ret = array('total'=>0, 'locked'=>0, 'unlocked'=>$cash_amount);
		$ret['locked'] = $this->Capital->get_locked_cash($user_id);

        foreach ($list as $value) {
			$buyOnePrice = $this->get_detail_by_code_no_render($value['fund_code'], 'buy', true);
            if($value['op_type'] == '申购'){
                if($value['status'] == '审核中'){
					if(max(0,($buyOnePrice-$value['fund_price'])/$value['fund_price']-($value['right_price']/100-100/100))>0){
						$ret['unlocked'] = $ret['unlocked']-$value['buy_amount'];
					}else{
						$ret['unlocked'] -=$value['buy_amount'];
					}
                }elseif($value['status'] == '通过') {
					if(max(0,($buyOnePrice-$value['fund_price'])/$value['fund_price']-($value['right_price']/100-100/100))>=0){
						$ret['locked'] = $ret['locked']+max(0,($buyOnePrice-$value['fund_price'])/$value['fund_price']-($value['right_price']/100-100/100))
						*($value['buy_amount']/$value['quotation_price']*100);
						$ret['unlocked'] = $ret['unlocked']-$value['buy_amount'];
					}else{
						$ret['unlocked'] -=$value['buy_amount'];
					}
                }
            }elseif($value['op_type'] == '赎回') {
                if($value['status'] == '审核中'||$value['status']=='拒绝赎回'){
					if(max(0,($buyOnePrice-$value['fund_price'])/$value['fund_price']-($value['right_price']/100-100/100))>=0){
						$ret['locked'] = $ret['locked']+max(0,($buyOnePrice-$value['fund_price'])/$value['fund_price']-($value['right_price']/100-100/100))
						*($value['buy_amount']/$value['quotation_price']*100);
						$ret['unlocked'] = $ret['unlocked']-$value['buy_amount'];
					}else{
						$ret['unlocked'] -=$value['buy_amount'];;
					}
                }elseif($value['status'] == '结算') {
					$ret['unlocked'] = $ret['unlocked']+max(0,($value['fund_price2']-$value['fund_price'])/$value['fund_price']-($value['right_price']/100-100/100))
						*($value['buy_amount']/$value['quotation_price']*100)-$value['buy_amount'];
                }
            }
        }

        $ret['total'] = $ret['locked']+$ret['unlocked'] ;
        return $ret;
    }
	
	
	 function do_withdraw($amount=null) {
		 
		if(!empty($this->user['agent_level'])){
		$this->autoRender = false;
		if($amount<=0 ||empty($amount)){
			echo 101;
			die;
		}
		
		$cur_commission = $this->Commissions->get_commissions_by_user_id($this->user['id'],$this->user['agent_level']);
		$cur_commission['withdraw_comm'] = $this->Capital->get_total_withdraw_com_value($this->user['id']);
		$cur_commission['withdraw_avl'] = $cur_commission['comm_received']-$cur_commission['withdraw_comm'];
		
		if($amount>$cur_commission['withdraw_avl']){
			echo 101;
			die;
		}
		
        $data = array();
        $data['amount'] = $amount;
        $data['user_id'] = $this->user['id'];
        $data['status'] = 3;
		$data['remark'] = '申请转现';
        $this->Capital->create();
        $ret = $this->Capital->save($data);
        if(isset($ret['Capital'])) {
			if($_SERVER['HTTP_HOST']=='uat.fintgroup.com'){

			}elseif($_SERVER['HTTP_HOST']=='prod.fintgroup.com'){

			}
        }else {

        }
		echo 1;
		}
    }
	
	function confirm_withdraw($id,$reason=NULL) {
        $this->autoRender = false;
        $one = $this->Capital->findById($id);
        if(empty($one)) {
            echo 101;
			die;
        }
        $data = array();
        $data['id'] = $one['Capital']['id'];
        $data['status'] = 4;
        $data['check_time'] = date('Y-m-d H:i:s', time());
        $data['remark'] = $reason;
        $this->Capital->save($data);
		echo 1;
    }
	
	function reject_withdraw($id,$reason=NULL) {
        $this->autoRender = false;
        $one = $this->Capital->findById($id);
        if(empty($one)) {
            echo 101;
        }
        $data = array();
        $data['id'] = $one['Capital']['id'];
        $data['status'] = -2;
        $data['check_time'] = date('Y-m-d H:i:s', time());
        $data['remark'] = $reason;
        $this->Capital->save($data);
		echo 1;
		die;
    }
	
	function sign_out() {
        setcookie("option_nick", '', time()-1000, '/');
        setcookie("option_timespan", '', time()-1000, '/');
        setcookie("option_token", '', time()-1000, '/');
        $this->redirect('/agent');
	}
	
	function process_previous_commissions(){
		$this->autoRender = false;
		$trading_list = $this->Trading->find('all');
		$first_agent = NULL;
		foreach ($trading_list as $key => $value) {
				$first_agent = $this->User->get_n_levels_agent_id_by_user_id($trading_list[$key]['Trading']['user_id'],1);
				if(!empty($first_agent)){
				$com_ret = array();
				$com_ret['deadline_type'] = $trading_list[$key]['Trading']['deadline_type'];
				$com_ret['user_id'] = $trading_list[$key]['Trading']['user_id'];
				$com_ret['trading_id'] = $trading_list[$key]['Trading']['id'];
				
				$second_agent = $this->User->get_n_levels_agent_id_by_user_id($trading_list[$key]['Trading']['user_id'],2);
				$third_agent = $this->User->get_n_levels_agent_id_by_user_id($trading_list[$key]['Trading']['user_id'],3);
				$com_ret['1st_level_agent'] = $first_agent=='N/A'?NULL:$first_agent;
				$com_ret['2nd_level_agent'] = $second_agent=='N/A'?NULL:$second_agent;
				$com_ret['3rd_level_agent'] = $third_agent=='N/A'?NULL:$third_agent;

				$com_ret['com_amount'] = $trading_list[$key]['Trading']['buy_amount']/$trading_list[$key]['Trading']['quotation_price']*100 * 
				($trading_list[$key]['Trading']['quotation_price']/100- max(0,100/100-$trading_list[$key]['Trading']['right_price']/100));
				$com_ret['right_price'] = $trading_list[$key]['Trading']['right_price'];
				
				$com_tmp = $this->Commissions->findByTradingId($trading_list[$key]['Trading']['id']);
				
				if(($first_agent!='N/A') && empty($com_tmp)){
					$this->Commissions->create();
					$com_ret['status'] = 0;
					$ret = $this->Commissions->save($com_ret);
				}/*else if(($first_agent!='N/A') && !empty($com_tmp)){
					$com_ret['id']=$com_tmp['Commissions']['id'];
					$ret = $this->Commissions->save($com_ret);
				}*/
			}
		}
	}
    
		
	
}
