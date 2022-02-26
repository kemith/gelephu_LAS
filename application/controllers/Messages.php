<?php

class Messages extends CI_Controller {
	protected $header;
	protected $data;
	protected $dataheader;
		public function __construct(){
		
			parent::__Construct();
			date_default_timezone_set("Asia/Thimphu");
			$this->load->library('session');
			$this->load->model('Messages_model','mm');
			$this->load->model('ATD_model','atd');
			$this->header['messages'] = $this->mm->getMessages();
		$this->header['unreadm']=$this->mm->getCountMessages();
		$this->dataheader['header']=$this->header;
		$this->atd->checkloggedin();
	}
	
	
	public function index() {
		
		
		
	}
	
	public function viewAll(){
		
		$data['message']=$this->mm->allMessages();
		
			$role = $this->session->userdata('role');
			$header['messages'] = $this->mm->getMessages();
			$header['unreadm']=$this->mm->getCountMessages();
			
			
			if($role=='1'){			
				
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('message',$data);
				$this->load->view('superadmin/footer');
			} elseif ($role=='2'||$role=='7') {//Secretary
				
				
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('message',$data);
				$this->load->view('admin/footer');
				
			} elseif($role=='3'||$role=='8'){//Director
				
				
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('message',$data);
				$this->load->view('agency/footer');
				
			}  elseif($role=='4'||$role=='9'){//Division Heads
				
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('message',$data);
				$this->load->view('division/footer');
			} elseif($role=='5'){//Users
				
			$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('message',$data);
				$this->load->view('user/footer');
				
			} elseif ($role=='6') { //Offtg Secretary
				
				
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('message',$data);
				$this->load->view('admin/footer');
				
			}
		
	}
	
	public function message($messageID){
		
			$data['message']=$this->mm->singlemessage($messageID);
		
			$role = $this->session->userdata('role');
			$header['messages'] = $this->mm->getMessages();
			$header['unreadm']=$this->mm->getCountMessages();
			
			
			if($role=='1'){			
				
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('message',$data);
				$this->load->view('superadmin/footer');
			} elseif ($role=='2'||$role=='7') {//Secretary
				
				
			$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('message',$data);
				$this->load->view('admin/footer');
				
			} elseif($role=='3'||$role=='8'){//Director
				
				
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('message',$data);
				$this->load->view('agency/footer');
				
			}  elseif($role=='4'||$role=='9'){//Division Heads
				
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('message',$data);
				$this->load->view('division/footer');
			} elseif($role=='5'){//Users
				
				$this->load->view('template/includeheader',$this->dataheader);
				$this->load->view('message',$data);
				$this->load->view('user/footer');
				
			} 
	}
	
}
