<?php
$role=$this->session->userdata('role');
if($role=='1') {
$this->load->view('include/dheader');
$this->load->view('superadmin/navheader',$header);
$this->load->view('superadmin/navsidebar');

} elseif($role=='2'||$role=='7'){
	
	$this->load->view('include/dheader');
	$this->load->view('admin/navheader',$header);
	$this->load->view('admin/navsidebar');
} elseif($role=='3'||$role=='8'){
	
	$this->load->view('include/dheader');
	$this->load->view('agency/navheader',$header);
	$this->load->view('agency/navsidebar');
} elseif($role=='4'||$role=='9'){
	$this->load->view('include/dheader');
	$this->load->view('division/navheader',$header);
	$this->load->view('division/navsidebar');
	} elseif($role=='6'){
		$this->load->view('include/dheader');
	$this->load->view('hr/navheader',$header);
	$this->load->view('hr/navsidebar');
		
	} 
	else {
	$this->load->view('include/dheader');
	$this->load->view('user/navheader',$header);
	$this->load->view('user/navsidebar');
}
