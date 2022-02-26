<?php



class Training extends CI_Controller {
	
	protected $header;
	protected $data;
	protected $dataheader;
	
	public function __construct(){
		
		parent::__Construct();
		date_default_timezone_set("Asia/Thimphu");
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('Training_model','tm');
		$this->load->model('Messages_model','mm');
		$this->load->model('Staff_model','sm');
		$this->load->model('Agency_model','ag');
		$this->load->model('ATD_model','atd');
		$this->header['messages'] = $this->mm->getMessages();
		$this->header['unreadm']=$this->mm->getCountMessages();
		$this->dataheader['header']=$this->header;
		$this->atd->checkloggedin();
		
		
	}
	
	
	public function addTraining(){
		
		$header['messages'] = $this->mm->getMessages();
		$header['unreadm']=$this->mm->getCountMessages();
		$this->load->view('include/dheader');
		$this->load->view('superadmin/navheader',$header);
		$this->load->view('superadmin/navsidebar');
		$this->load->view('addtraining');
		$this->load->view('include/dfooter');
		
		
		
	}
	
	public function add(){
		
		
		$cid=$this->input->post('cid');
		$title=$this->input->post('title');
		$ttype=$this->input->post('trainingtype');
		$country=$this->input->post('country');
		$funding=$this->input->post('funding');
		$reportandcert=$this->input->post('reportandcert');
		$approvalletter=$this->input->post('approvalletter');
		$status=$this->input->post('status');
		$startdate=$this->input->post('startdate');
		$enddate=$this->input->post('enddate');
		$appdate=$this->input->post('appDate');
		$university=$this->input->post('university');
		if($this->tm->addTraining($cid,$title,$ttype,$country,$university,$funding,$reportandcert,$approvalletter,$status,$startdate,$enddate,$appdate)){
			echo "1";
			
		} else echo "0";
		
		
	}
	
	public function viewTraining() {
		$header['messages'] = $this->mm->getMessages();
		$header['unreadm']=$this->mm->getCountMessages();
		$data['parent']=$this->ag->getParentAgencyList();
		$this->load->view('superadmin/header');
		$this->load->view('superadmin/navheader',$header);
		$this->load->view('superadmin/navsidebar');
		$this->load->view('viewtraining', $data);
		$this->load->view('superadmin/footer');
	
	}
	
	
	public function populateRecords(){
		
		
		$agency=$this->input->post('agency');
		$records= $this->tm->getRecords($agency);
		$count=1;
		$employee[] = array();
		$employee[1]=null;
		 
		foreach($records->result() as $record){
			
			$name=$record->name;
			$position=$record->positiontitle;
			$grade=$record->Grade;
			$cid=$record->cid;
			$agency=$record->division;
			$title=$record->title;
			$startdate=$record->startdate;
			$enddate=$record->enddate;
			$country=$record->country;
			$university=$record->university;
			$funding=$record->funding;
			$status=$record->trainingStatus;
			$cert=$record->reportandcert;
			$aletter=$record->approvalLetter;
			$adate=$record->approvalDate;
			
			if($employee[$count]==$cid) {
				echo "<tr>";
			echo "<td colspan=6> </td>";
			
			echo "<td>".$title."</td>";
			echo "<td>".$startdate."</td>";
			echo "<td>".$enddate."</td>";
			echo "<td>".$university."</td>";
			echo "<td>".$country."</td>";
			echo "<td>".$funding."</td>";
			echo "<td>".$status."</td>";
			echo "<td>".$cert."</td>";
			echo "<td>".$aletter."</td>";
			echo "<td>".$adate."</td>";
			echo "</tr>";
				
			} elseif($employee[$count]==null) {
				$employee[$count]=$cid;
				echo "<tr>";
			echo "<td>".$count."</td>";
			echo "<td>".$cid."</td>";
			echo "<td>".$name."</td>";
			echo "<td>".$grade."</td>";
			echo "<td>".$position."</td>";
			echo "<td>".$agency."</td>";
			echo "<td>".$title."</td>";
			echo "<td>".$startdate."</td>";
			echo "<td>".$enddate."</td>";
			echo "<td>".$university."</td>";
			echo "<td>".$country."</td>";
			echo "<td>".$funding."</td>";
			echo "<td>".$status."</td>";
			echo "<td>".$cert."</td>";
			echo "<td>".$aletter."</td>";
			echo "<td>".$adate."</td>";
			echo "</tr>";
			} else {
				$count+=1;
				$employee[$count]=$cid;
				echo "<tr>";
			echo "<td>".$count."</td>";
			echo "<td>".$cid."</td>";
			echo "<td>".$name."</td>";
			echo "<td>".$grade."</td>";
			echo "<td>".$position."</td>";
			echo "<td>".$agency."</td>";
			echo "<td>".$title."</td>";
			echo "<td>".$startdate."</td>";
			echo "<td>".$enddate."</td>";
			echo "<td>".$university."</td>";
			echo "<td>".$country."</td>";
			echo "<td>".$funding."</td>";
			echo "<td>".$status."</td>";
			echo "<td>".$cert."</td>";
			echo "<td>".$aletter."</td>";
			echo "<td>".$adate."</td>";
			echo "</tr>";
			}
			
						
		}
		
		
		
	}
}
