
<?php



 class DailyChore extends CI_Controller {
 
 	public function __construct() {
 
 		parent::__Construct();
 		$this->load->model('Leave_model','lm');
 
 	}
 
 
 	public function updateOfficiatingRoles() {
 		
		
		if(!$this->input->is_cli_request())
		     {
		         echo "this function can only be accessed form the command line ";
		         return;
		     } else {
		     	
				$this->lm->activateOfftg();
				echo "\nOfficiating roles updated for the date".date('Y/m/d');
		     }
 	}
 
 
 
}
