<?php


	class TelDirectory extends CI_Controller {
	
	protected $header;
	protected $data;
	protected $dataheader;
	public function __construct(){
		parent::__Construct();
		$this->load->library('session');
		$this->load->model('Staff_model','sm');
		$this->load->model('Agency_model','ag');
		$this->load->model('Messages_model','mm');
		$this->load->model('ATD_model','atd');
		$this->header['messages'] = $this->mm->getMessages();
		$this->header['unreadm']=$this->mm->getCountMessages();
		$this->dataheader['header']=$this->header;
		$this->atd->checkloggedin();
		
		
	}
	
	
	public function viewDirectory(){
		$data['parent']=$this->ag->getParentAgencyList();
		$this->load->view('template/includeheader',$this->dataheader);
		$this->load->view('viewdirectory',$data);
		$this->load->view('template/includefooter');
		
	}
	
	public function search() {
		
		
			//$this->pagination->initialize($config);
    	$keyword = $this->input->post('search');
		$query=$this->ag->getEmployeesKeyword($keyword);
		$counter=1;
		foreach($query->result() as $row){
			
		echo "<tr>";
		echo "<td>$counter</td>";
		echo "<td>$row->name</td>";
		echo "<td>$row->Agency</td>";
		echo "<td>$row->ParentAgency</td>";
		echo "<td>$row->PositionTitle</td>";
		echo "<td>$row->Telephone</td>";
		echo "<td>$row->Mobile</td>";
		echo "<td>$row->Email</td>";
		
		echo "</tr>";
		$counter++;
		
		}
		
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
	
	public function getAgencyEmployees() {
		
		
		$this->load->library('pagination');

		$config['base_url'] = 'http://localhost/index.php/TelDirectory/getAgencyEmployees/';
		
		
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
				echo "<td>$row->name</td>";
				echo "<td>$row->Agency</td>";
				echo "<td>$row->ParentAgency</td>";
				echo "<td>$row->PositionTitle</td>";
				echo "<td>$row->Telephone</td>";
				echo "<td>$row->Mobile</td>";
				echo "<td>$row->Email</td>";
				
				echo "</tr>";
				$counter++;
			}
		
	
	}
}