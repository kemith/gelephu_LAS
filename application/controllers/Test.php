<?php


class Test extends CI_Controller {
	
	
	/*public function index(){
		
		
		$ipAddress=$_SERVER['REMOTE_ADDR'];
		$macAddr=false;

		
		$arp=`arp -n $ipAddress`;
		$lines=explode("\n", $arp);

		
		 foreach($lines as $line)
		 {
		 	
   		 $cols=preg_split('/\s+/', trim($line));
		   print_r($cols);
  			 if (isset($cols[1])==trim($ipAddress,'()')){
   				      $macAddr=$cols[3];
   				   
   				 }
		 }
  		echo "Your mac address ".$macAddr;
		//echo "my mac address".$macAddr;

		

	}*/
	
	public function testemail() {

	$this->load->model('Email_model','em');
	$this->em->test();
	


	}	
}
