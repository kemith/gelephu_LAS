<?php


class Notification extends CI_Controller {
	
	public function __construct(){
		
			parent::__Construct();
			date_default_timezone_set("Asia/Thimphu");
			$this->load->library('session');
			$this->load->model('Notification_model','nm');
		
	}
	
	
	public function index() {
		
		
		
	}
	
	
	
}
