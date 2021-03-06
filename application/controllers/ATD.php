<?php


 class ATD extends CI_Controller {
	
	protected $header;
	protected $data;
	protected $dataheader;
	
	public function __construct(){
		
		
		parent::__Construct();
		date_default_timezone_set("Asia/Thimphu");
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('Staff_model','sm');
		$this->load->model('ATD_model','atd');
		$this->load->model('Agency_model','ag');
		$this->load->model('Leave_model','lm');
		$this->load->model('Holidays','hm');
		$this->load->model('Messages_model','mm');
		$this->header['messages'] = $this->mm->getMessages();
		$this->header['unreadm']=$this->mm->getCountMessages();
		$this->dataheader['header']=$this->header;
		//$this->lm->activateOfftg();
		
		
	}
	
	public function index(){
		
		$this->login();
		
		
				
	}
	
	
	public function login(){
		
		if($this->session->userdata('logged_in')!='1'){
			$this->load->view('login');
			
		} else {
			
			$this->dashboard();
			
		}
		
	}
	
	
	public function login_validate(){
		
		
		$this->form_validation->set_rules('cid','CID','required|trim|callback_validate_credentials');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		
				
		if($this->form_validation->run()){
			$cid=$this->input->post('cid');
			
				$data = array (
				'cid' => $cid,
				'logged_in' => 1
				
				
			);
			
			$this->session->set_userdata($data);
			
			redirect('ATD/dashboard');
		}   elseif($this->session->userdata('logged_in')==2){
			$cid=$this->input->post('cid');
			
				$data = array (
				'cid' => $cid,
							
			);
			
			$this->session->set_userdata($data);
			$this->load->view('regmac');
			
			
		} 
		
		else {
			
			$this->login();
		}
		
		
	}
	
	
	
	public function validate_credentials(){
		
		
		$cid=$this->input->post('cid');
		$passwordmd=md5($this->input->post('password'));
		$mac=$this->getMac();
		$result=$this->sm->can_log_in($mac);
		
		
		switch($result){
			
			case 1 : return true;
					break;
			case 2 : $this->form_validation->set_message ('validate_credentials','You need to login from your registered PC/Phone');
					return false;
					break;
			case 3 : $this->form_validation->set_message ('validate_credentials','Both your mac addresses are null');
			$data = array (
				'device'=> 0,
				'logged_in' => 2,
				'macstatus'=>$mac
							
			);
			$this->session->set_userdata($data);
			return false;
					break;
			case 4 : $this->form_validation->set_message ('validate_credentials','One of your mac addresses is null');
			$data = array (
				'device'=>1,
				'logged_in' => 2,
				'macstatus' => $mac
				
				
			);
			$this->session->set_userdata($data);
			return false;
				break;
				
			case 5 : $this->form_validation->set_message ('validate_credentials','Incorrect Username/Password');
			return false;
				break;
		} 
		
		
		
	}
	
	public function getMac(){
		
		
		$ipAddress=$_SERVER['REMOTE_ADDR'];
		$macAddr=false;

		
		$arp=`arp -n $ipAddress`;
		$lines=explode("\n", $arp);

		
		foreach($lines as $line)
		{
   			$cols=preg_split('/\s+/', trim($line));
  			if (isset($cols[1])==$ipAddress){
   				    // $macAddr=$cols[3];
					$macAddr='';
   				}
		}
		
		return $macAddr;
		
	}
	
	public function atdchangestatus() {
		
		if($this->session->userdata('logged_in')=='1') {
			
			$status=$this->input->post('status');
			$remarks=addslashes($this->input->post('statusremarks'));
			if($this->atd->userstatus($status,$remarks)){
			redirect('ATD/dashboard');
			}
			
		} else {
			
			redirect('ATD/logout');
		}
		
		
		
	}
	
	public function dashboard() {
		
		
		if($this->session->userdata('logged_in')=='1'){
		
			if($this->getattendance()==1) {
				$this->sm->sessionInitiate();
			} else {$this->sm->weekendSession();}
			$role = $this->session->userdata('role');
			
			if(($this->session->userdata('telephone')!='')&&($this->session->userdata('email')!='')&&($this->session->userdata('mobile')!='')){
			if($role=='1'){			
				$data['leavecount']=$this->atd->leaveCountAll();
				$data['latecount']=$this->atd->lateCount();
				$data['notused']=$this->atd->notUsedAll();
				$data['divisions']=$this->ag->listDivisions();
				$data['reports']=$this->atd->dailyAttendance();
				$data['supervisor']=$this->sm->getSupervisor();
				$data['pendingLeave']=$this->lm->pendingCount();
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('superadmin/dashboard',$data);
				$this->load->view('template/includefooter');
			} elseif ($role=='2'||$role=='7') {//Secretary
				
				$data['leavecount']=$this->atd->leaveCountAll();
				$data['latecount']=$this->atd->lateCount();
				$data['notused']=$this->atd->notUsedAll();
				$data['divisions']=$this->ag->listDivisions();
				$data['reports']=$this->atd->dailyAttendance();
				$data['supervisor']=$this->sm->getSupervisor();
				$data['pendingLeave']=$this->lm->pendingCount();
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('admin/dashboard',$data);
				$this->load->view('template/includefooter');
				
			} elseif($role=='3'||$role=='8'){//Director
				
				$data['leavecount']=$this->atd->leaveCountAll();
				$data['latecount']=$this->atd->lateCount();
				$data['notused']=$this->atd->notUsedAll();
				$data['divisions']=$this->ag->listDivisions();
				$data['reports']=$this->atd->dailyAttendance();
				$data['supervisor']=$this->sm->getSupervisor();
				$data['pendingLeave']=$this->lm->pendingCount();
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('agency/dashboard',$data);
				$this->load->view('template/includefooter');
				
			}  elseif($role=='4'||$role=='9'){//Division Heads
				$data['leavecount']=$this->atd->leaveCountAll();
				$data['latecount']=$this->atd->lateCount();
				$data['notused']=$this->atd->notUsedAll();
				$data['divisions']=$this->ag->listDivisions();
				$data['reports']=$this->atd->dailyAttendance();
				$data['supervisor']=$this->sm->getSupervisor();
				$data['pendingLeave']=$this->lm->pendingCount();
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('division/dashboard',$data);
				$this->load->view('template/includefooter');
			} elseif($role=='5'){//Users
				$data['leavecount']=$this->atd->leaveCountAll();
				$data['divisions']=$this->ag->listDivisions();
				$data['reports']=$this->atd->dailyAttendance();
				$data['supervisor']=$this->sm->getSupervisor();
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('user/dashboard',$data);
				$this->load->view('template/includefooter');
				
			} elseif ($role=='6') { //HR
				
				$data['leavecount']=$this->atd->leaveCountAll();
				$data['latecount']=$this->atd->lateCount();
				$data['notused']=$this->atd->notUsedAll();
				$data['divisions']=$this->ag->listDivisions();
				$data['reports']=$this->atd->dailyAttendance();
				$data['supervisor']=$this->sm->getSupervisor();
				$data['pendingLeave']=$this->lm->pendingCount();
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('superadmin/dashboard',$data);
				$this->load->view('template/includefooter');
				}
			// } elseif($role=='8'){//Offtg Director
// 				
				// $data['leavecount']=$this->am->leaveCountAll();
				// $data['latecount']=$this->am->lateCount();
				// $data['notused']=$this->am->notUsedAll();
				// $data['divisions']=$this->ag->listDivisions();
				// $data['reports']=$this->am->dailyAttendance();
				// $data['supervisor']=$this->sm->getSupervisor();
				// $data['pendingLeave']=$this->lm->pendingCount();
				// $this->load->view('agency/header');
				// $this->load->view('agency/navheader',$header);
				// $this->load->view('agency/navsidebar');
				// $this->load->view('agency/dashboard',$data);
				// $this->load->view('agency/footer');
// 				
			// } elseif($role=='9'){//Offtg Division Heads
				// $data['leavecount']=$this->am->leaveCountAll();
				// $data['latecount']=$this->am->lateCount();
				// $data['notused']=$this->am->notUsedAll();
				// $data['divisions']=$this->ag->listDivisions();
				// $data['reports']=$this->am->dailyAttendance();
				// $data['supervisor']=$this->sm->getSupervisor();
				// $data['pendingLeave']=$this->lm->pendingCount();
				// $this->load->view('division/header');
				// $this->load->view('division/navheader',$header);
				// $this->load->view('division/navsidebar');
				// $this->load->view('division/dashboard',$data);
				// $this->load->view('division/footer');
			// }
			} else {
				$cid=$this->session->userdata('cid');
				$data['user']=$this->sm->getprofile($cid);
				$this->load->view('completedetails',$data);
			}
		} else {
			$this->login();
			
		}
		
	}
	
	public function monthlyatd() {
	
		if($this->session->userdata('logged_in')=='1'){
			if($this->session->userdata('role')=='5'){
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('user/monthlyatd');
				$this->load->view('template/includefooter');
				
			} else {
		$data['parent']=$this->ag->getParentAgencyList();
		$this->load->view('template/includeheader',$this->dataheader);
		$this->load->view('monthlyatd',$data);
		$this->load->view('template/includefooter');
			}
		} else $this->login();
	
	}

	public function getMonthlyAll(){
		
		if($this->session->userdata('logged_in')=='1'){
			
			$month = $this->input->post('month');
			$year = $this->input->post('year');
		if($this->session->userdata('role')!='5'){
			$cid=$this->session->userdata('cid');
			$monthlydata=$this->atd->monthreportall($month,$year);
		} else {
			$this->getMonthlyATD();
		}
   		
		$holidays=$this->hm->holidaysMonth($month,$year);
		//print_r($monthlydata);
		// $date = date('Y/m/d');
		// $month = date('m',strtotime($date));
		// $year = date('Y',strtotime($date));
		$days=$monthlydata[0][0];
		$empcount=$monthlydata[0][1];
		$startdate = "01-".$month."-".$year;
		$starttime=strtotime($startdate);
		$endtime =strtotime("+1 month", $starttime);
		$weekends = array();
		echo "<tr><th>Name";
		//echo "Agency:";
		//print_r($monthlydata);
		echo "</th>";
	
		function isWeekend($date) {
    		return (date('N', $date) >= 6);
		} 
		for($i=$starttime;$i<$endtime;$i+=86400){
	
			if(isWeekend($i)){
		
			echo "<th class='blue'>".date('d',$i)."</th>";
			$weekends[] = date('d',$i);
		} else {
			echo "<th>".date('d',$i)."</th>";
		}

		
   
		} 
		echo "</tr>";

    	for($i=1;$i<$empcount;$i++){
   			echo "<tr>";
   			echo "<td>".$monthlydata[$i][1]->name."</td>";
	
	   	for($j=1;$j<$days;$j++){
	   		
			if(in_array($j, $weekends)){
				echo "<td class='blue'> </td>";
			} else if(in_array($j,$holidays)){
				
				echo "<td class='blue'>Ho</td>";
			} else {
				
				switch($monthlydata[$i][$j]->Late) {
					
					
					case NULL : echo "<td class='red'> </td>";
								break;
					case '1'  : echo "<td class='yellow'> </td>";
								break;
					case '2'  : echo "<td class='green'> </td>";
								break;
					case '11' : echo "<td>EOL </td>";
								break;
					case '12' : echo "<td>SL </td>";
								break;
					case '13' : echo "<td>EL</td>";
								break;
					case '14' : echo "<td>CL </td>";
								break;
					case '15' : echo "<td>MaL </td>";
								break;
					case '16' : echo "<td>PaL </td>";
								break;
					case '17' : echo "<td>BL </td>";
								break;
					case '18' : echo "<td>ML </td>";
								break;
					case '19' : echo "<td>Tr </td>";
								break;
					case '20' : echo "<td>To </td>";
								break;
					case '21' : echo "<td>Me </td>";
								break;
					case '22' : echo "<td>Sem </td>";
								break;
					case '23' : echo "<td>Wo </td>";
								break;
					case '24' : echo "<td>Dep </td>";
								break;			
					default  :  echo "<td class='red'> </td>";
								break;
					
					}
					
				}
 			} 
 		echo "</tr>";
   }
  
  } else $this->login();
		
		
	}
	public function getMonthlyATD(){
	
		if($this->session->userdata('logged_in')=='1'){
			
			$month = $this->input->post('month');
			$year = $this->input->post('year');
		if($this->session->userdata('role')=='5'){
			$cid=$this->session->userdata('cid');
			$monthlydata=$this->atd->monthreportsingle($month,$year,$cid);
		} else {
		
		$agency = $this->input->post('agency');
		$monthlydata=$this->atd->monthreport($month,$year,$agency);
		}
   		
		$holidays=$this->hm->holidaysMonth($month,$year);
		//print_r($monthlydata);
		// $date = date('Y/m/d');
		// $month = date('m',strtotime($date));
		// $year = date('Y',strtotime($date));
		$days=$monthlydata[0][0];
		$empcount=$monthlydata[0][1];
		$startdate = "01-".$month."-".$year;
		$starttime=strtotime($startdate);
		$endtime =strtotime("+1 month", $starttime);
		$weekends = array();
		echo "<tr><th>Name";
		//echo "Agency:";
		//print_r($monthlydata);
		echo "</th>";
	
		function isWeekend($date) {
    		return (date('N', $date) >= 6);
		} 
		for($i=$starttime;$i<$endtime;$i+=86400){
	
			if(isWeekend($i)){
		
			echo "<th class='blue'>".date('d',$i)."</th>";
			$weekends[] = date('d',$i);
		} else {
			echo "<th>".date('d',$i)."</th>";
		}

		
   
		} 
		echo "</tr>";

    	for($i=1;$i<$empcount;$i++){
   			echo "<tr>";
   			echo "<td>".$monthlydata[$i][1]->name."</td>";
	
	   	for($j=1;$j<$days;$j++){
	   		
			if(in_array($j, $weekends)){
				echo "<td class='blue'> </td>";
			} else if(in_array($j,$holidays)){
				
				echo "<td class='blue'>Ho</td>";
			} else {
				
				switch($monthlydata[$i][$j]->Late) {
					
					
					case NULL : echo "<td class='red'> </td>";
								break;
					case '1'  : echo "<td class='yellow'> </td>";
								break;
					case '2'  : echo "<td class='green'> </td>";
								break;
					case '11' : echo "<td>EOL </td>";
								break;
					case '12' : echo "<td>SL </td>";
								break;
					case '13' : echo "<td>EL</td>";
								break;
					case '14' : echo "<td>CL </td>";
								break;
					case '15' : echo "<td>MaL </td>";
								break;
					case '16' : echo "<td>PaL </td>";
								break;
					case '17' : echo "<td>BL </td>";
								break;
					case '18' : echo "<td>ML </td>";
								break;
					case '19' : echo "<td>Tr </td>";
								break;
					case '20' : echo "<td>To </td>";
								break;
					case '21' : echo "<td>Me </td>";
								break;
					case '22' : echo "<td>Sem </td>";
								break;
					case '23' : echo "<td>Wo </td>";
								break;
					case '24' : echo "<td>Dep </td>";
								break;			
					default  :  echo "<td class='red'> </td>";
								break;
					
					}
					
				}
 			} 
 		echo "</tr>";
   }
  
  } else $this->login();
  
}
 


	public function cancelreg() {
		
		$this->session->sess_destroy();
		redirect('ATD/index');
		
	}

	public function devicereg(){
		
		$mac=$this->session->userdata('macstatus');
		$registerone=false;
		$registertwo=false;
		 if($this->session->userdata('device')==0){
			 $registerone=$this->sm->registermacone($mac);
		 } elseif($this->session->userdata('device')==1){
			 $registertwo=$this->sm->registermactwo($mac);
		 }
// 		
		if($registerone||$registertwo) {
			
			
			$data = array (
				
				'logged_in' => 1,
				
				
				
			);
			$this->session->set_userdata($data);
			//$macreg = 1;
			redirect('ATD/dashboard');
		} else {
			$this->session->sess_destroy();
			$this->load->view('macnotunique');
			
		}
		
		
	}
	
	public function divfeedchange($div){
		$decodediv = urldecode($div);
		$data = array (
				
			
			'divFeed' => $decodediv

				);
				
				$this->session->set_userdata($data);
				
				redirect('ATD/dashboard');
				
		
	}
	
	
	public function logout(){
		
		
		$this->session->sess_destroy();
		redirect('ATD/index');
	}
	
	
	
	public function getattendance() {
		
		$cid = $this->session->userdata('cid');
		
		$time = date("h:i:sa");
		$date = date("Y/m/d");
		 if(!(date('N', strtotime($date)) >=6)) {
				if(!($this->atd->checkHoliday($date))){
							if(!($this->atd->checkAttendance($date,$cid))) {
							
						if($this->atd->putAttendance($date,$cid,$time)) {
							
							$data = array (
							
							'atd_time' => $time
							
							);
							$this->session->set_userdata($data);
							return 1;
						} else {
							
							
							
						}
				
				
				} else {
					return 1;
				}
			
			} else {
				
			 	return 2;
			}
		} else return 0;
			
	}
	
	public function lateToday(){
		
		if($this->session->userdata('logged_in')=='1'){
		$data['late']=$this->atd->lateOfficials();
		$header['messages'] = $this->mm->getMessages();
		$header['unreadm']=$this->mm->getCountMessages();
		// $this->load->view('superadmin/header');
		// $this->load->view('superadmin/navheader',$header);
		// $this->load->view('superadmin/navsidebar');
		$dataheader['header']=$header;
		$this->load->view('template/includeheader',$dataheader);
		$this->load->view('lateofficials',$data);
		$this->load->view('template/includefooter',$dataheader);
		
		} else $this->login();
		
	}
	
	
	
	
	
	
}
