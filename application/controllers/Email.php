<?php



class Email extends CI_Controller {
	
	
	
	public function __construct() {
		
		parent::__Construct();
	//	$this->load->library('email');
		$this->load->model('Email_model','em');
		$this->load->model('ATD_model','atd');
		
		
	}
	
	
	public function index() {
		
		
	
	}
	
	
	public function config(){
		
		
	
	}
	
	
	
	public function reminderEmail() {
		$date=date('Y/m/d');
		
		if(!$this->input->is_cli_request())
		     {
		         echo "this function can only be accessed form the command line ";
		         return;
		     }
		else {
			if(!($this->atd->checkholiday($date))){
			$this->em->getReminderEmails();
			} else {
				echo $date." is holiday\n";
			}
			
		}		
		
		
	}
	
	public function leaveEndReminder() {
		
		$this->em->leaveEndReminder();
		
	}
	
	public function mail(){
		
		$this->sendMail();
	}
	public function sendMail(){	
   
/*$config['protocol'] = 'smtp';
    $config['smtp_crypto'] = 'ssl';
    $config['smtp_host'] = 'smtp.gmail.com';
    $config['smtp_port'] = 465;
    $config['smtp_user'] = 'las@moic.gov.bt';
    $config['smtp_pass'] = 'las@2016';
    $config['mailtype'] = 'html';
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['wordwrap'] = TRUE;
    $config['smtp_timeout'] = 30;
    $this->email->initialize($config);
    $this->email->from('las@moic.gov.bt', 'LAS admin');
    $this->email->to('dthapa@dit.gov.bt');
    $this->email->subject('LAS email success');
    $message = "Testing";
    $this->email->message($message);
    if ( ! $this->email->send()) {
        show_error($this->email->print_debugger());
    }*/

    }
}
