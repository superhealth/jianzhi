<?php
class EmptyAction extends Action {
    public function index(){
    	send_http_status("404");
    	$this->display("Empty:404");exit;
    }
    public function _empty(){
    	send_http_status("404");
    	$this->display("Empty:404");exit;
    }
}