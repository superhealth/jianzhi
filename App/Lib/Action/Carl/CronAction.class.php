<?php
/**
 * 状态检查模块
 * @author dapianzi
 *
 */
class CronAction extends Action{
	/**
	 * 
	 */
	public function index(){
		if(!per_check('cron_update'))
		//检查会员续费是否到期
		D("Member")->updateMemberActive();
		//检查保证金是否退回
		//D("Memeber")>updateDepositStatus();
		//检查项目开标
		D("Project")->updatePorjectStatus();
	}
	
	public function updateCache(){
		if(!per_check("cache_update")){
			$this->error("无此权限！");
		}
		
		//地区更新
		D("Area")->updateCache();
		//广告更新
		D("Advs")->updateCache();
		//首页区块更新
		D("Block")->updateCache();
		//类别更新
		D("Sort")->updateCache();
		D("Enumsort")->updateCache();
		//生产属性更新
		D("Property")->updateCache();
		//友情链接更新
		D("Links")->updateCache();
		//地区更新
		D("Sysconf")->updateCache();
		//地区更新
		D("Taxes")->updateCache();
		//地区更新
		D("Tips")->updateCache();
		//地区更新
		D("Area")->updateCache();
		
	}

	private function checkDepositBack($now){
		//上次坚持时间
		if(!isset($_SESSION['deposit_check'])){
			$_SESSION['deposit_check'] = 0;
		}
		if($_SESSION['member_check']<$now-$this->t){
			//检查过期项目;
			$expireProjects = M("project")->where("pro_opentime<={$now} AND pro_status=1")->getField("pro_id", true);
		}
	}
	
}