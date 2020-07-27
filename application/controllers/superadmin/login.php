<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{
	
	public function __Construct() {
		ob_start();
		parent::__Construct();
		$this->load->helper('url');
				
	}
	
	function index($msg='') {
		
		$data['msg'] = $msg;
		$this->load->view('superadmin/login_view', $data);
		
		//redirect('registration/login'); 
	}
	
	public function process(){
        // Load the model
        //$this->load->model('login_model');
        $this->load->model('superadmin/superadmin_model');
        // Validate the user can login
        $result = $this->superadmin_model->validate();
        // Now we verify the result
        if(! $result){ 
            // If user did not validate, then show them login page again
			$msg = '<font color=red>Invalid username and/or password.</font><br />';
            $this->index($msg);
			//echo 'hello';
        }else{
			echo "Loading...";
            // If user did validate, 
            // Send them to members area
            redirect(base_url().'superadmin/home');
			
        }        
    }
        
}
