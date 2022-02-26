<?php


class Settings extends CI_Controller {
	
	protected $header;
	protected $data;
	protected $dataheader;
	protected $role;
	
	public function __construct() {
	
	parent::__Construct();
	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
	$this->load->model('Staff_model','sm');
	$this->load->model('Agency_model','ag');
	$this->load->model('Holidays','hm');
	$this->load->model('Messages_model','mm');
	$this->load->model('ATD_model','atd');
	$this->header['messages'] = $this->mm->getMessages();
	$this->header['unreadm']=$this->mm->getCountMessages();
	$this->dataheader['header']=$this->header;
	$this->role=$this->session->userdata('role');
	$this->atd->checkloggedin();
	}
	
	
	public function viewUsers() {
		
		$data['parent']=$this->ag->getParentAgencyList();
		$this->load->view('template/includeheader',$this->dataheader);
		// if($this->role!='1') {
		// $this->load->view('viewusers',$data);
		// } else {
			// $this->load->view('norights');
		// }
		$this->load->view('viewusers',$data);
		$this->load->view('template/includefooter');
	}
	
	public function agencyFromParent() {
		
		 $parent=$this->input->post('parent');
                $query=$this->ag->getAgencyList();
	        echo "<option class='searchdropdown' value='#'>Select Agency </option>";
                foreach($query->result() as $row)
                { 
                 echo "<option class='searchdropdown' value='".$row->AgencyID."'>".$row->name."</option>";
                }
		
	}
	
	public function search() {
		
		
			//$this->pagination->initialize($config);
    	$keyword = $this->input->post('search');
		$query=$this->ag->getEmployeesKeyword($keyword);
		$counter=1;
		foreach($query->result() as $row){
			
		echo "<tr>";
		echo "<td>$counter</td>";
		echo "<td><a href='".base_url()."index.php/Settings/editFullEmployee/$row->CID/'>$row->name</td>";
		echo "<td>$row->EmpNo</td>";
		echo "<td>$row->CID</td>";
		echo "<td>$row->Agency</td>";
		echo "<td>$row->ParentAgency</td>";
		echo "<td>$row->MainParentAgency</td>";
		echo "<td>$row->PositionTitle</td>";
		echo "<td>$row->Grade</td>";
		echo "<td>$row->Gender</td>";
		echo "<td>$row->Email</td>";
		echo "<td>$row->Telephone</td>";
		echo "<td>$row->Mobile</td>";
		echo "</tr>";
		$counter++;
		
		}
		
	}
	
	public function getAgencyEmployees() {
		
		
		$this->load->library('pagination');

		$config['base_url'] = base_url().'/index.php/Settings/getAgencyEmployees/';
		
		
		$this->pagination->initialize($config);
    	$agency = $this->input->post('agency');
		$query = $this->ag->getEmployees($agency);
		$num_rows=$query->num_rows();
		$config['total_rows'] = $num_rows;
		$config['per_page'] = 10;
		echo $this->pagination->create_links();
		$counter=1;
		foreach($query->result() as $row){
			
		echo "<tr>";
		echo "<td>$counter</td>";
		echo "<td><a href='".base_url()."index.php/Settings/editFullEmployee/$row->CID/'>$row->name</td>";
		echo "<td>$row->EmpNo</td>";
		echo "<td>$row->CID</td>";
		echo "<td>$row->Agency</td>";
		echo "<td>$row->ParentAgency</td>";
		echo "<td>$row->MainParentAgency</td>";
		echo "<td>$row->PositionTitle</td>";
		echo "<td>$row->Grade</td>";
		echo "<td>$row->Gender</td>";
		echo "<td>$row->Email</td>";
		echo "<td>$row->Telephone</td>";
		echo "<td>$row->Mobile</td>";
		echo "</tr>";
		$counter++;
		}
		

	
		
	}
	
	public function bulkimport(){
		
		
		$this->sm->import();	
		
	}
	
	

	public function updateMainParentAgency() {
		
		$this->ag->updateMainParentAgency();
		
	}
	public function updateParentAgency() {
		
		$this->ag->updateParentAgency();
		
	}
	public function updateAgency() {
		
		$this->ag->updateAgency();
		
	}
	
	public function updateSupervisorAgency() {
		
		if($this->ag->updateSupervisorAgency()=='1'){
				echo "Update success";
			
		} else echo "Update failed";
		
		
	}
	
	public function updateSupervisorAgencyParent() {
		
		if($this->ag->updateSupervisorParentAgency()=='1'){
				
			echo "directors successfully updated";	
		}
		else echo "failed";
		
	}
	
	public function updateSupervisorAgencyMainParent(){
		
		if($this->ag->updateSupervisorMainParentAgency()=='1'){
			
			echo "secretary successfully updated";
		}
			else echo "failed";
	}
	
	public function updateEmployee($cid) {
		
		$this->form_validation->set_rules('fname','Fname','required|trim');
		$this->form_validation->set_rules('mname','Mname','trim');
		$this->form_validation->set_rules('lname','Lname','trim');
		$this->form_validation->set_rules('agencyid','Agency','required|trim');
		$this->form_validation->set_rules('agencyparentid','AgencyParent','required|trim');
		$this->form_validation->set_rules('agencymainparentid','AgencyMainParent','required|trim');
		$this->form_validation->set_rules('empno','EmpNo','required|trim');
		$this->form_validation->set_rules('grade','Grade','required|trim');
		$this->form_validation->set_rules('Gender','Gender','required|trim');
		$this->form_validation->set_rules('dob','DOB','required|trim');
		$this->form_validation->set_rules('etype','EmpType','required|trim');
		$this->form_validation->set_rules('estatus','EmpStatus','required|trim');
		$this->form_validation->set_rules('positiontitle','PositionTitle','required|trim');
		$this->form_validation->set_rules('telephone','Telephone','trim');
		$this->form_validation->set_rules('email','Email','trim');
		$this->form_validation->set_rules('mobile','Mobile','trim');
		$this->form_validation->set_rules('appdate','AppDate','trim');
		
		if($this->form_validation->run()){
			$echo="form success";
		if($this->sm->updateEmployee($cid)) {
			
			$data['statusupdate']="Success";
			$this->editFullEmployee($cid);
			
		}
			
			
		} else {
			echo "form error";
			echo validation_errors();
			$this->editFullEmployee($cid);
		}
		
	}
	public function editFullEmployee($cid){
			
		
					$data['employee']=$this->sm->editFullEmployee($cid);
					$this->load->view('template/includeheader',$this->dataheader);
				    $this->load->view('editfullemployee',$data);
				    $this->load->view('template/includefooter');
			
		
	}
	
	public function assignAgencies() {
		
		$data['agencies']=$this->ag->listFullAgencies();
		$this->load->view('template/includeheader',$this->dataheader);
		$this->load->view('assignagencies',$data);
		$this->load->view('template/includefooter');
		
	}
	
	public function assignParentAgencies(){
		
		$data['parentagencies']=$this->ag->listFullParentAgencies();
		$this->load->view('template/includeheader',$this->dataheader);
		$this->load->view('assignparentagencies',$data);
		$this->load->view('template/includefooter');
	}
	
	public function singleParentAgencyUpdate($pagency){
		
		
		$data['pagency']=$this->ag->listSingleParentAgency($pagency);
		$data['supervisors']=$this->ag->listParentSupervisors($pagency);
		$this->load->view('template/includeheader',$this->dataheader);
		$this->load->view('singleparentagencyupdate',$data);
		$this->load->view('template/includefooter');
		
	}
	public function singleAgencyUpdate($agency) {
		
		$data['agency']=$this->ag->listSingleAgency($agency);
		$data['supervisors']=$this->ag->listSupervisors($agency);
		$this->load->view('template/includeheader',$this->dataheader);
		$this->load->view('singleagencyupdate',$data);
		$this->load->view('template/includefooter');
		
		
	}
	
	
	public function addHoliday(){
		
		$this->form_validation->set_rules('holidayname','HolidayName','trim|required');
		$this->form_validation->set_rules('startdate','StartDate','trim|required');
		$this->form_validation->set_rules('enddate','EndDate','trim|required');
		
		if($this->form_validation->run()){
			
			$name=addslashes($this->input->post('holidayname'));
			$startdate=strtotime($this->input->post('startdate'));
			$enddate=strtotime($this->input->post('enddate'));
			
			$this->hm->insertHoliday($startdate,$enddate,$name);
			$this->viewHolidays();
			
		} else {
			$this->viewHolidays();
		}
		
	}
	public function viewHolidays(){
		
		$data['holidays']=$this->hm->listHolidays();
		$this->load->view('template/includedheader',$this->dataheader);
		if($this->session->userdata('role')=='1'){
			$this->load->view('superadmin/viewholidays',$data); } else{
		$this->load->view('viewholidays',$data);}
		$this->load->view('template/includedfooter');
		
	}
	
	public function updateSingleSupervisor() {
		
		$supervisor = $this->input->post('supervisor');
		$agency = $this->input->post('agency');
		
		if($this->ag->updateSingleSupervisor($supervisor,$agency)){
			
			echo "1";
		} else echo "0";
	}	
	public function viewRoles() {
		
		$data['sadmins']=$this->sm->getSadmin();
		$data['admins']=$this->sm->getAdmin();
		$data['agencyheads']=$this->sm->getAgencyhead();
		$data['divisionheads']=$this->sm->getDivisionhead();
		
		$this->load->view('template/includeheader',$this->dataheader);
		$this->load->view('superadmin/viewroles',$data);
		$this->load->view('template/includefooter');
		
	}
	
	public function profile(){
		
		$cid=$this->session->userdata('cid');
		$data['user']=$this->sm->getprofile($cid);
		
		$this->load->view('template/includeheader',$this->dataheader);
		$this->load->view('profile',$data);
		$this->load->view('template/includefooter');
		
		
	}
	
	public function updateContact() {
		
		$tel=$this->input->post('tel');
		$mob=$this->input->post('mob');
		$email=$this->input->post('email');
		if($this->sm->updateContact($tel,$mob,$email)) {
			
			echo "1";
			
		} else echo "0";
	}

	public function changePassword() {
		
		$old=$this->input->post('old');
		$new=$this->input->post('newpass');
		if($this->sm->checkold($old)) {
			
			if($this->sm->changepass($new)) {
				echo "1";
			} else echo "0";
		} else echo "2";
		
		
	}

	public function uploadpic(){
		
		$cid=$this->session->userdata('cid');
		$data['user']=$this->sm->getprofile($cid);
		
		$config['upload_path'] = "./assets/img/profile/";
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']     = '100';
		$config['max_width'] = '8000';
		$config['max_height'] = '5000';
		$config['overwrite'] = true;
		$config['file_name'] = $cid;
		//$pic=$config['file_name'];
		$this->load->library('upload', $config);
		
		if(!$this->upload->do_upload('userfile')){
			
			$data['error']=$this->upload->display_errors();
				
			
		} else {
			
			$filedata = $this->upload->data();
			$pic=$filedata['raw_name'].$filedata['file_ext'];
			
			$data['success_msg']="Successfully uploaded";
			if($this->sm->updateprofilepic($pic)) {
					
				$data['user']=$this->sm->getprofile($cid);
				redirect('Settings/profile');
				
			}
			$this->load->view('template/includeheader',$this->dataheader);
			$this->load->view('profile',$data);
			$this->load->view('template/includefooter');
		}
	}
	
}