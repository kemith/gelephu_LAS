<?php
$role=$this->session->userdata('role');
if($role=='1') {
$this->load->view('superadmin/footer');


} elseif($role=='2'||$role=='7'){
	
	$this->load->view('admin/footer');
	
	
} elseif($role=='3'||$role=='8'){
	
	$this->load->view('agency/footer');

} elseif($role=='4'||$role=='9'){
	$this->load->view('division/footer');
	
	} elseif($role=='6'){
		
		$this->load->view('hr/footer');
	}
	else {
	$this->load->view('user/footer');
	
}
