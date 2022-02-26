<?php

/*

 class Leave extends CI_Controller {
	
	protected $header;
	protected $data;
	protected $dataheader;
	protected $role;
	
	public function __construct() {
		
		parent::__Construct();
		$this->load->model('Holidays','hm');
		$this->load->model('Leave_model','lm');
		$this->load->model('Agency_model','ag');
		$this->load->library('form_validation');
		$this->load->model('Messages_model','mm');
		$this->load->model('ATD_model','atd');
		$this->header['messages'] = $this->mm->getMessages();
		$this->header['unreadm']=$this->mm->getCountMessages();
		$this->dataheader['header']=$this->header;
		$this->role=$this->session->userdata('role');
		$this->atd->checkloggedin();
	
	}
	
	
	public function index() {
		
		
		
		
	}
	
	
	public function leaveResponse(){
		
		$approve = $this->input->post('approve');
		$reject =$this->input->post('reject');
		if(isset($approve))  {
			
			$lid=$this->input->post('leaveID');
			$remarks=$this->input->post('remarks');
			$this->approve($lid,$remarks);
			
		} elseif (isset($reject)){
			
			$lid=$this->input->post('leaveID');
			$remarks=$this->input->post('remarks');
			$this->reject($lid,$remarks);
		}
		
		
	}
	
	public function approve($lid,$remarks){
		
		$this->lm->approve($lid,$remarks);
		$this->approvePending();
		
	}
	
	public function cancel($lid){
		
		$this->lm->cancelLeave($lid);
		$this->requestLeave();
		
	}
	
	public function reject($lid,$remarks){
		
		$this->lm->reject($lid,$remarks);
		$this->approvePending();
	}
	
	public function approvePending(){
		
		
		$pendingleave=$this->lm->pendingLeave();
		$data['pending']=$pendingleave;
		
		foreach($pendingleave->result() as $leave) {
			
			$userId=$leave->userId;
			$balance["$userId"]=$this->lm->leaveBalance($userId);
			//$balance[$counter]=$this->lm->leaveBalance($userId);
			
		}
		if(isset($balance)){
		$data['balance']=$balance;}
		$this->load->view('template/includeheader',$this->dataheader);
		$this->load->view('approveleave',$data);
		$this->load->view('template/includefooter');
	}
	
	
	public function requestLeave(){
		if($this->session->userdata('logged_in')=='1'){
			$role=$this->session->userdata('role');
			$cid=$this->session->userdata('cid');
			$pagency = $this->session->userdata('parentID');
			$agency = $this->session->userdata('agencyID');
			if($role=='2'||$role=='7'){
				$data['offtg']=$this->ag->listofftgMain();
				$data['bal']=$this->lm->leaveBalance($cid);
				$data['leaveTypes'] = $this->lm->listallType();
				$data['leavehistory'] = $this->lm->leaveHistory($cid);
				$this->load->view('template/includedheader',$this->dataheader);
				$this->load->view('admin/requestleave',$data);
				$this->load->view('template/includedfooter');
			} elseif($role=='3'||$role=='8'){
				$data['offtg']=$this->ag->listOfftgParent($pagency);
				$data['bal']=$this->lm->leaveBalance($cid);
				$data['leaveTypes'] = $this->lm->listallType();
				$data['leavehistory'] = $this->lm->leaveHistory($cid);
				$this->load->view('template/includedheader',$this->dataheader);
				$this->load->view('agency/requestleave',$data);
				$this->load->view('template/includedfooter');
				
			} elseif($role=='4'||$role=='9'){
				$data['offtg']=$this->ag->listOfftgAgency($agency);
				$data['bal']=$this->lm->leaveBalance($cid);
				$data['leaveTypes'] = $this->lm->listallType();
				$data['leavehistory'] = $this->lm->leaveHistory($cid);
				$this->load->view('template/includedheader',$this->dataheader);
				$this->load->view('division/requestleave',$data);
				$this->load->view('template/includedfooter');
				
			} else {
				$data['bal']=$this->lm->leaveBalance($cid);
				$data['leaveTypes'] = $this->lm->listallType();
				$data['leavehistory'] = $this->lm->leaveHistory($cid);
				$this->load->view('template/includedheader',$this->dataheader);
				$this->load->view('requestleave',$data);
				$this->load->view('template/includedfooter');
			}
		} else {
			
			redirect('ATD/login');
		}
		
		
	}
	
	public function countHolidays(){
		
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		
		
		$holidays=$this->hm->countHolidays($start,$end);
		
		foreach($holidays->result() as $row){
			echo $row->count;
		}
		
	}
	
	public function submitleave(){
		
		$start = $this->input->post('startdate');
		$end = $this->input->post('enddate');
		$division = $this->session->userdata('divName');
		$leavedays = $this->input->post('leavedays');
		$leavetype=$this->input->post('leavetype');
		$cid = $this->session->userdata('cid');
		$remarks = addslashes($this->input->post('remarks'));
		$agencyid=$this->session->userdata('agencyID');
		//echo $leavetype;
		if($this->lm->submitLeave($start,$end,$division,$leavedays,$leavetype,$cid,$remarks,$agencyid)) {
		 echo "1";
			
		} else {echo "0";	}
 		
		
		
	}
	
	public function submitleaveSupervisor(){
		$start = $this->input->post('startdate');
		$end = $this->input->post('enddate');
		$division = $this->session->userdata('divName');
		$leavedays = $this->input->post('leavedays');
		$leavetype=$this->input->post('leavetype');
		$cid = $this->session->userdata('cid');
		$offtg = $this->input->post('offtg');
		$offtgrole = $this->input->post('offtgrole');
		$headrole=$this->input->post('headrole');
		$remarks = $this->input->post('remarks');
		$agencyid=$this->session->userdata('agencyID');
		//echo $leavetype;
		if($this->lm->submitLeaveSupervisor($start,$end,$division,$leavedays,$leavetype,$cid,$remarks,$agencyid,$offtgrole,$headrole,$offtg)) {
		 	echo "1";
			
		} 	else {echo "0";	}
		
	}
	
	
	// function select_validate($leavetype)
		// {
// 		
		// if($leavetype=="none"){
		// $this->form_validation->set_message('select_validate', 'Please Select the leave type.');
		// return false;
		// } else{
		// // User picked something.
		// return true;
		// }
// }
	public function leaveToday(){
		
		$data['leaveToday']=$this->lm->getAllLeaveToday();
		$this->load->view('template/includeheader',$this->dataheader);
		$this->load->view('leavetoday',$data);
		$this->load->view('template/includefooter');
		
	}
	
	public function viewLeave($cid){
		
		$data['bal']=$this->lm->leaveBalance($cid);
		$data['leavehistory'] = $this->lm->leaveHistory($cid);
		$this->load->view('template/includeheader',$this->dataheader);
		$this->load->view('viewleave',$data);
		$this->load->view('template/includefooter');
		
	}
	
	public function approvedRecord(){
		
		$data['leaveRecord']=$this->lm->leaveRecord();
		$this->load->view('template/includeheader',$this->dataheader);
		$this->load->view('approvedrecord',$data);
		$this->load->view('template/includefooter');
		
	}	
	
}
