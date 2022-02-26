<?php
$role=$this->session->userdata('role');
if($role=='1') {
$this->load->view('include/dfooter');


} elseif($role=='2'||$role=='7'){
	
	$this->load->view('include/dfooter');
	
	
} elseif($role=='3'||$role=='8'){
	
	$this->load->view('include/dfooter');

} elseif($role=='4'||$role=='9'){
	$this->load->view('include/dfooter');
	
	} elseif($role=='6'){
		
		$this->load->view('include/dfooter');
	}
	else {
	$this->load->view('include/dfooter');
	
}
