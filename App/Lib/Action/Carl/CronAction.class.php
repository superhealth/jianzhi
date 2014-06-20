<?php
/**
 * 状态检查模块
 * @author Carl
 *
 */
class CronAction extends Action{
	private $t = 1800;	//检查周期 半小时
	public static function checkCron(){
		
		$now = time();
		//检查会员续费是否到期
		$this->checkMemberActive($now);
		//检查保证金是否退回
		$this->checkDepositBack($now);
	}
	
	private function checkMemberActive($now){
		//上次检查时间
		if(!isset($_SESSION['member_check'])){
			$_SESSION['member_check'] = 0;
		}
		if($_SESSION['member_check']<$now-$this->t){
			M("member")->where("mem_state=1 AND mem_expiretime<={$now}")->setField("mem_state", 0);
			$_SESSION['member_check'] = $now;
		}
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