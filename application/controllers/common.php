<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common extends WS_Controller {
	
	public function __construct()
	{   
		parent::__Construct();
		ob_start();		 
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('registration_model');
		$this->load->model('admin/user_model');
	}
	
	public function index()	{
		
	}
	
	public function checkemailexist()
	{
		$str = $this->user_model->checkDuplicateEmail($_POST);
		echo $str;exit;
	}
	
	public function checkcaptcha()
	{
		if($this->input->post('captcha')==$this->session->userdata('captchaWord')){
			echo "true";
		}else{
			echo "false";
		}
	}
	
	public function settabindex()
	{
		$this->session->set_userdata('tabindex', $this->input->post('str'));
		echo $this->input->post('str');
	}
	
}

?>