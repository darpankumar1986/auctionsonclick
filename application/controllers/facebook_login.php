<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class facebook_login extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		//date_default_timezone_set('Asia/Kolkata');
	  	$this->load->library('facebook/fb','fb');
    }
	
	function index()
	{
		$data = array();
		$data['user_profile'] = array();
		$data['login_url'] = $this->fb->createLoginLink();
		$data['user_profile'] = $this->fb->initialize();
		$this->load->view('facebook_login', $data);
	}
	
	function facebook_logout()
	{
		$this->fb->facebookLogout();
		redirect('facebook_login');
	}
}
?>