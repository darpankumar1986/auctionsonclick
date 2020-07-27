<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller{
	
	public function __Construct() {
		parent::__Construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->database();
		}
	function index() {
		$loginPath	=	base_url()."superadmin/login";
		//echo $this->session->userdata('adminid');die;
		$this->db->where('id', $this->session->userdata('adminid'));		
		$this->db->update('tbl_user', array('user_sess_val'=>'')); 
		$this->session->sess_destroy();
				
		redirect('superadmin/login');
		//redirect('registration/login');
		exit;
			
	}	
}
