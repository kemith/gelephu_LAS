<?php
$role=$this->session->userdata('role');
if($role=='1') {
$this->load->view('superadmin/header');
$this->load->view('superadmin/navheader',$header);
$this->load->view('superadmin/navsidebar');

} elseif($role=='2'||$role=='7'){
	
	$this->load->view('admin/header');
	$this->load->view('admin/navheader',$header);
	$this->load->view('admin/navsidebar');
} elseif($role=='3'||$role=='8'){
	
	$this->load->view('agency/header');
	$this->load->view('agency/navheader',$header);
	$this->load->view('agency/navsidebar');
} elseif($role=='4'||$role=='9'){
	$this->load->view('division/header');
	$this->load->view('division/navheader',$header);
	$this->load->view('division/navsidebar');
	} elseif($role=='6'){
		$this->load->view('hr/header');
	$this->load->view('hr/navheader',$header);
	$this->load->view('hr/navsidebar');
		
	} 
	else {
	$this->load->view('user/header');
	$this->load->view('user/navheader',$header);
	$this->load->view('user/navsidebar');
}
if($role=='6'){
	$this->load->view('superadmin/header');
$this->load->view('superadmin/navheader',$header);
$this->load->view('superadmin/navsidebar');
}
